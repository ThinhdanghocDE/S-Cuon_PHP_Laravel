<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Services\VnpayService;
use App\Mail\PaymentMail;

class VnpayController extends Controller
{
    protected VnpayService $vnpayService;

    public function __construct(VnpayService $vnpayService)
    {
        $this->vnpayService = $vnpayService;
    }

    /**
     * Tạo URL thanh toán VNPay
     */
    public function createPayment(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $total = Session::get('total');

        if (!$total || $total <= 0) {
            return redirect()->route('cart')
                ->with('wrong', 'Giỏ hàng của bạn đang trống!');
        }

        // Generate invoice
        do {
            $invoice = substr(str_shuffle('0123456789abcdefghijklmnopqrstuvwxyz'), 0, 8);
        } while (DB::table('orders')->where('transaction_id', $invoice)->exists());

        // $total từ session đã bao gồm phí bổ sung và đã chia 1000
        // Cần nhân lại 1000 để có giá trị VNĐ thực tế
        $grandTotalInVND = $total * 1000;

        // Create order (pending) - lưu giá trị đã chia 1000 vào database
        DB::table('orders')->insert([
            'transaction_id' => $invoice,
            'name'    => Auth::user()->name,
            'email'   => Auth::user()->email,
            'phone'   => Auth::user()->phone ?? '',
            'amount'  => $total, // Lưu giá trị đã chia 1000
            'currency'=> 'VND',
            'status'  => 'pending',
            'address' => Session::get('sub_address') ?? 'N/A',

        ]);

        Session::put('invoice', $invoice);

        // VNPay yêu cầu số tiền ở đơn vị nhỏ nhất (đồng), nên nhân 100
        // $grandTotalInVND đã là VNĐ (256000), formatAmount sẽ nhân 100 = 25600000
        $params = [
            'vnp_TxnRef'    => $invoice,
            'vnp_OrderInfo'=> 'Don hang ' . $invoice . ' - ' . Auth::user()->name,
            'vnp_Amount'   => $this->vnpayService->formatAmount($grandTotalInVND),
            'vnp_IpAddr'   => $request->ip(),
        ];

        $paymentUrl = $this->vnpayService->createPaymentUrl($params);

        return redirect($paymentUrl);
    }

    /**
     * Return URL – user quay về từ VNPay
     */
    public function return(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $data = $request->all();

        Log::info('VNPay Return', $data);

        if (!$this->vnpayService->verifyHash($data)) {
            return redirect()->route('cart')
                ->with('wrong', 'Chữ ký VNPay không hợp lệ!');
        }

        $txnRef   = $data['vnp_TxnRef'] ?? null;
        $rspCode  = $data['vnp_ResponseCode'] ?? null;
        $amount   = $data['vnp_Amount'] ?? null;

        $order = DB::table('orders')->where('transaction_id', $txnRef)->first();

        if (!$order) {
            return redirect()->route('cart')
                ->with('wrong', 'Không tìm thấy đơn hàng!');
        }

        // Check amount
        // $order->amount đã chia 1000, cần nhân lại 1000 để có VNĐ
        $orderAmountInVND = $order->amount * 1000;
        if ($amount != $this->vnpayService->formatAmount($orderAmountInVND)) {
            return redirect()->route('cart')
                ->with('wrong', 'Số tiền không khớp!');
        }

        if ($rspCode === '00') {
            // Lưu invoice và flag VNPay vào session để form điền địa chỉ biết
            // KHÔNG set order_success để form hiển thị form điền địa chỉ (không phải form "đã đặt hàng")
            Session::put('invoice', $txnRef);
            Session::put('vnpay_payment_success', true);

            return redirect()
                ->route('mails.shipped', $order->amount)
                ->with('success', 'Thanh toán VNPay thành công! Vui lòng điền địa chỉ giao hàng.');
        }

        return redirect()->route('cart')
            ->with('wrong', 'Thanh toán thất bại: ' . $this->vnpayService->getResponseMessage($rspCode));
    }

    /**
     * IPN – xử lý chính thức từ VNPay
     */
    public function ipn(Request $request)
    {
        $data = $request->all();

        Log::info('VNPay IPN', $data);

        if (!$this->vnpayService->verifyHash($data)) {
            return response('RspCode=97&Message=Invalid signature', 200);
        }

        $txnRef  = $data['vnp_TxnRef'];
        $amount  = $data['vnp_Amount'];
        $rspCode = $data['vnp_ResponseCode'];

        $order = DB::table('orders')->where('transaction_id', $txnRef)->first();

        if (!$order) {
            return response('RspCode=01&Message=Order not found', 200);
        }

        // Check amount
        // $order->amount đã chia 1000, cần nhân lại 1000 để có VNĐ
        $orderAmountInVND = $order->amount * 1000;
        if ($amount != $this->vnpayService->formatAmount($orderAmountInVND)) {
            return response('RspCode=04&Message=Invalid amount', 200);
        }

        if ($order->status === 'processing') {
            return response('RspCode=00&Message=Already processed', 200);
        }

        if ($rspCode === '00') {
            // Chỉ cập nhật status của order
            // KHÔNG cập nhật carts ở đây vì carts chưa có invoice_no (chưa điền địa chỉ)
            // Carts sẽ được cập nhật sau khi user điền địa chỉ trong ShipmentController@send
            DB::table('orders')
                ->where('transaction_id', $txnRef)
                ->update(['status' => 'processing']);

            // KHÔNG cập nhật carts ở IPN - để form điền địa chỉ xử lý
            // DB::table('carts')
            //     ->where('invoice_no', $txnRef)
            //     ->update([
            //         'product_order' => 'approve',
            //         'pay_method' => 'VNPay',
            //     ]);

            // Send mail (optional)
            try {
                Mail::to($order->email)->send(
                    new PaymentMail([
                        'title' => 'Thanh toán thành công',
                        'body'  => 'Đơn hàng ' . $txnRef . ' đã được xác nhận.',
                    ])
                );
            } catch (\Exception $e) {
                Log::error('Mail error: ' . $e->getMessage());
            }

            return response('RspCode=00&Message=Confirm Success', 200);
        }

        return response('RspCode=99&Message=Payment Failed', 200);
    }
}
