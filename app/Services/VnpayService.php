<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;

class VnpayService
{
    private string $tmnCode;
    private string $hashSecret;
    private string $url;

    public function __construct()
    {
        $this->tmnCode    = config('vnpay.tmn_code');
        $this->hashSecret = config('vnpay.hash_secret');
        $this->url        = config('vnpay.pay_url');
    }

    /**
     * VNPay yêu cầu đơn vị nhỏ nhất (VND * 100)
     */
    public function formatAmount(int $amountVnd): int
    {
        return $amountVnd * 100;
    }

    /**
     * Tạo URL thanh toán
     */
    public function createPaymentUrl(array $params): string
    {
        $vnpParams = [
            'vnp_Version'   => '2.1.0',
            'vnp_Command'   => 'pay',
            'vnp_TmnCode'   => $this->tmnCode,
            'vnp_TxnRef'    => $params['vnp_TxnRef'],
            'vnp_OrderInfo' => $params['vnp_OrderInfo'],
            'vnp_OrderType' => 'other',
            'vnp_Amount'    => $params['vnp_Amount'],
            'vnp_CurrCode'  => 'VND',
            'vnp_Locale'    => 'vn',
            'vnp_ReturnUrl' => route('vnpay.return'),
            'vnp_IpAddr'    => $params['vnp_IpAddr'],
            'vnp_CreateDate'=> date('YmdHis'),
            'vnp_ExpireDate'=> date('YmdHis', strtotime('+15 minutes')),
        ];

        ksort($vnpParams);

        $hashData = [];
        $query    = [];

        foreach ($vnpParams as $key => $value) {
            $hashData[] = $key . '=' . urlencode($value);
            $query[]    = urlencode($key) . '=' . urlencode($value);
        }

        $hashString = implode('&', $hashData);
        $secureHash = hash_hmac('sha512', $hashString, $this->hashSecret);

        Log::info('VNPay Create URL', [
            'hash_data' => $hashString,
            'secure_hash' => $secureHash,
        ]);

        return $this->url . '?' . implode('&', $query) . '&vnp_SecureHash=' . $secureHash;
    }

    /**
     * Verify chữ ký VNPay (Return + IPN)
     */
    public function verifyHash(array $data): bool
    {
        $secureHash = $data['vnp_SecureHash'] ?? null;

        unset($data['vnp_SecureHash'], $data['vnp_SecureHashType']);

        ksort($data);

        $hashData = [];
        foreach ($data as $key => $value) {
            $hashData[] = $key . '=' . urlencode($value);
        }

        $hashString = implode('&', $hashData);
        $checkHash  = hash_hmac('sha512', $hashString, $this->hashSecret);

        return hash_equals($checkHash, $secureHash);
    }

    /**
     * Message VNPay
     */
    public function getResponseMessage(string $code): string
    {
        return match ($code) {
            '00' => 'Giao dịch thành công',
            '07' => 'Trừ tiền thành công. Giao dịch bị nghi ngờ',
            '09' => 'Thẻ chưa đăng ký InternetBanking',
            '10' => 'Sai thông tin thẻ',
            '11' => 'Hết hạn thanh toán',
            default => 'Thanh toán không thành công',
        };
    }
}
