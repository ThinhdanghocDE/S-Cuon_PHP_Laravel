<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\User;
use App\Mail\OrderShipped;
use App\Models\Order;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Auth;
use PDF;
use QrCode;

use DB;
use Session;




class ShipmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $carts = Cart::all();
        return view("cart", compact('carts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $order = Cart::all();
 
        // Ship the order...
 
        Mail::to($request->user())->send(new OrderShipped($order));
    }
    public function place_order($total)
    {
        // Guest vẫn được đặt hàng (COD). Giỏ guest lấy từ session.
        if(!Auth::user())
        {
            // Nếu vừa đặt hàng xong (order_success) thì load lại từ DB theo invoice
            if (Session::has('order_success') && Session::has('invoice') && !Session::has('vnpay_payment_success')) {
                $invoice = Session::get('invoice');
                $cart_items = DB::table('carts')
                    ->leftJoin('products', 'carts.product_id', '=', 'products.id')
                    ->where('carts.product_order', 'yes')
                    ->where('carts.invoice_no', $invoice)
                    ->select(
                        'carts.*',
                        DB::raw('COALESCE(products.name, carts.name) as product_name'),
                        'products.image as product_image',
                        'products.price as product_price'
                    )
                    ->get();

                // Nếu không join được image thì fallback (tránh lỗi view)
                $cart_items = $cart_items->map(function ($item) {
                    if (empty($item->product_image)) {
                        $item->product_image = 'default-food.jpg';
                    }
                    return $item;
                });

                // Tổng lấy từ session (đã cộng extra_charge ở bước send)
                $total = Session::get('total', $total);
                return view('place_order', compact('total', 'cart_items'));
            }

            $guestCart = Session::get('guest_cart', []);
            // Enrich dữ liệu để view `place_order` dùng được product_name/product_image/product_price
            $cart_items = collect($guestCart)->map(function ($item) {
                $product = DB::table('products')->where('id', $item['product_id'])->first();

                return (object) array_merge($item, [
                    'product_name' => $product->name ?? $item['name'] ?? 'Sản phẩm',
                    'product_image' => $product->image ?? 'default-food.jpg',
                    'product_price' => $product->price ?? $item['price'] ?? 0,
                ]);
            });

            // Nếu guest cart rỗng thì quay lại giỏ
            if ($cart_items->count() === 0) {
                session()->flash('wrong', 'Giỏ hàng của bạn đang trống!');
                return redirect()->route('cart');
            }

            return view('place_order', compact('total', 'cart_items'));
        }

        // Nếu có thông báo thành công VÀ KHÔNG phải VNPay đang chờ điền địa chỉ
        // thì lấy sản phẩm từ đơn hàng đã đặt
        if(Session::has('order_success') && Session::has('invoice') && !Session::has('vnpay_payment_success'))
        {
            $invoice = Session::get('invoice');
            $cart_items = DB::table('carts')
                ->join('products', 'carts.product_id', '=', 'products.id')
                ->where('carts.user_id', Auth::user()->id)
                ->where('carts.product_order', 'yes')
                ->where('carts.invoice_no', $invoice)
                ->select('carts.*', 'products.name as product_name', 'products.image as product_image', 'products.price as product_price')
                ->get();
        }
        else
        {
            // Lấy danh sách sản phẩm trong giỏ hàng chưa đặt
            $cart_items = DB::table('carts')
                ->join('products', 'carts.product_id', '=', 'products.id')
                ->where('carts.user_id', Auth::user()->id)
                ->where('carts.product_order', 'no')
                ->select('carts.*', 'products.name as product_name', 'products.image as product_image', 'products.price as product_price')
                ->get();
        }

        return view('place_order', compact('total', 'cart_items'));
    }


    public function send(Request $request,$total)
    {    

        $data=array();
        $allowedHanoiDistricts = [
            'Ba Dinh','Hoan Kiem','Hai Ba Trung','Dong Da','Tay Ho','Cau Giay','Thanh Xuan',
            'Hoang Mai','Long Bien','Ha Dong','Bac Tu Liem','Nam Tu Liem',
        ];

        // Guest checkout (COD): tạo / lấy user theo phone/email rồi lưu carts vào DB
        if(!Auth::user())
        {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'phone' => 'required|string|max:20',
                'address' => 'required|string|max:255',
                'district' => 'required|string|in:'.implode(',', $allowedHanoiDistricts),
            ], [
                'name.required' => 'Vui lòng nhập họ tên',
                'email.required' => 'Vui lòng nhập email',
                'phone.required' => 'Vui lòng nhập số điện thoại',
                'address.required' => 'Vui lòng nhập địa chỉ',
                'district.required' => 'Vui lòng chọn quận nội thành Hà Nội',
                'district.in' => 'Hiện tại chỉ hỗ trợ giao hàng nội thành Hà Nội',
            ]);

            $phone = $validated['phone'];
            $email = $validated['email'];

            $user = User::where('phone', $phone)->orWhere('email', $email)->first();
            if (!$user) {
                $user = User::create([
                    'name' => $validated['name'],
                    'email' => $email,
                    'phone' => $phone,
                    'password' => Hash::make(Str::random(24)),
                    'usertype' => '0',
                ]);
            }

            // Tạo invoice cho guest
            $invoice = substr(str_shuffle("0123456789abcdefghijklmnopqrstvwxyz"), 0, 8);
            $data['pay_method'] = "Cash On Delivery";
            $data['shipping_address'] = $validated['address'] . ', ' . $validated['district'] . ', Hà Nội, Việt Nam';
            $data['product_order'] = "yes";
            $data['invoice_no'] = $invoice;
            $data['delivery_time'] = "3 hours";
            $data['purchase_date'] = date("Y-m-d");

            $guestCart = Session::get('guest_cart', []);
            if (empty($guestCart)) {
                session()->flash('wrong', 'Giỏ hàng của bạn đang trống!');
                return redirect()->route('cart');
            }

            foreach ($guestCart as $item) {
                DB::table('carts')->insert([
                    'product_id' => $item['product_id'],
                    'user_id' => $user->id,
                    'product_order' => $data['product_order'],
                    'shipping_address' => $data['shipping_address'],
                    'invoice_no' => $data['invoice_no'],
                    'pay_method' => $data['pay_method'],
                    'delivery_time' => $data['delivery_time'],
                    'purchase_date' => $data['purchase_date'],
                    'name' => $item['name'],
                    'price' => $item['price'],
                    'quantity' => $item['quantity'],
                    'subtotal' => $item['subtotal'],
                ]);
            }

            // Clear guest cart + guest coupon
            Session::forget('guest_cart');
            Session::forget('guest_coupon_id');

            // Tính tổng đơn
            $total = DB::table('carts')->where('invoice_no', $invoice)->sum('subtotal');
            $extra_charge=DB::table('charges')->get();
            $total_extra_charge=DB::table('charges')->sum('price');
            $total = $total + $total_extra_charge;

            Session::put('invoice',$invoice);
            Session::put('total',$total);
            Session::put('extra_charge',$extra_charge);
            Session::put('discount_price',0);
            Session::put('without_discount_price',$total);
            Session::put('date',date("Y-m-d"));
            Session::put('order_success', true);

            return redirect()->route('mails.shipped', ['total' => $total])->with('success', 'Đặt hàng thành công!');
        }

        // Logged-in (COD/VNPay): validate quận nội thành Hà Nội
        $request->validate([
            'address' => 'required|string|max:255',
            'district' => 'required|string|in:'.implode(',', $allowedHanoiDistricts),
        ], [
            'address.required' => 'Vui lòng nhập địa chỉ',
            'district.required' => 'Vui lòng chọn quận nội thành Hà Nội',
            'district.in' => 'Hiện tại chỉ hỗ trợ giao hàng nội thành Hà Nội',
        ]);

        // Nếu đã thanh toán VNPay, dùng invoice từ session
        if(Session::has('vnpay_payment_success') && Session::has('invoice'))
        {
            $invoice = Session::get('invoice');
            $data['pay_method'] = 'VNPay';
        }
        else
        {
            $invoice = substr(str_shuffle("0123456789abcdefghijklmnopqrstvwxyz"), 0, 8);
            $data['pay_method'] = "Cash On Delivery";
        }
        /*
        $order_list = DB::table('carts')->where('product_order','yes')->get();


        foreach($order_list as $order)
        {

            while($order->invoice_no != $invoice)
            {

                $invoice = substr(str_shuffle("0123456789abcdefghijklmnopqrstvwxyz"), 0, 8);


            }


        }
        */
        //return $invoice;
        
        
        $data['shipping_address']=$request->address . ', ' . $request->district . ', Hà Nội, Việt Nam';
        $data['product_order']="yes";
        $data['invoice_no']=$invoice;
        // $data['pay_method'] đã được set ở trên (VNPay hoặc COD)
        $data['delivery_time']="3 hours";
        $data['purchase_date']=date("Y-m-d");


      


        $products = DB::table('carts')->where('user_id',Auth::user()->id)->where('product_order','no')->get();

        $total = DB::table('carts')->where('user_id',Auth::user()->id)->where('product_order','no')->sum('subtotal');
        
        $total = DB::table('carts')->where('user_id',Auth::user()->id)->where('product_order','no')->sum('subtotal');
        $carts_amount = DB::table('carts')->where('user_id',Auth::user()->id)->where('product_order','no')->count();
        $without_discount_price=$total;
        $discount_price=0;
        $coupon_code=NULL;
        
        if($carts_amount>0)
        {
            foreach($products as $cart)
            {
                if($cart->coupon_id) {
                    // Lấy code từ coupon_id (id)
                    $coupon_code = DB::table('coupons')->where('id', $cart->coupon_id)->value('code');
                    break;
                }
            }

         }

         if($coupon_code!=NULL)
         {


            $total = DB::table('carts')->where('user_id',Auth::user()->id)->where('product_order','no')->sum('subtotal');

            
            $coupon_code_price=DB::table('coupons')->where('code',$coupon_code)->value('percentage');

            $coupon_code_price=floor($coupon_code_price);

            $discount_price=(($total*$coupon_code_price)/100);
            $discount_price=floor($discount_price);


            $total = $total - $discount_price;
      


         }
         else
         {

            $total = DB::table('carts')->where('user_id',Auth::user()->id)->where('product_order','no')->sum('subtotal');


         }

        // Cập nhật carts với thông tin đơn hàng
        $carts = DB::table('carts')
            ->where('user_id', Auth::user()->id)
            ->where('product_order', 'no')
            ->update($data);
        
        // Log để debug (có thể xóa sau)
        \Log::info('ShipmentController@send - Updated carts', [
            'user_id' => Auth::user()->id,
            'invoice' => $invoice,
            'pay_method' => $data['pay_method'],
            'updated_count' => $carts,
        ]);
        /*
        $details = [
            'title' => 'Thông Báo Từ S-Cuốn',
            'body' => 'Đơn hàng của bạn đã được đặt thành công. Mã hóa đơn - '.$invoice,
        ];
       
        \Mail::to(Auth::user()->email)->send(new \App\Mail\PaymentMail($details));

        */

        $data["title"] = "Thông Báo Từ S-Cuốn";
        $data["body"] = "Đặt bàn của bạn đã được đặt thành công";
 
 
         /*
         $files = [
             public_path('file/sample.pdf'),
         ];
   
         
         \Mail::send('mails.ReserveMail', $data, function($message)use($data, $files) {
             $message->to(Auth::user()->email)
                     ->subject('Thông Báo Từ S-Cuốn');
  
             foreach ($files as $file){
                 $message->attach($file);
             }
             
         });
 
         */

        $extra_charge=DB::table('charges')->get();
        $total_extra_charge=DB::table('charges')->sum('price');


        $total=$total+$total_extra_charge;
        $without_discount_price=$total+$total_extra_charge;

         Session::put('products',$products);
         Session::put('invoice',$invoice);
         Session::put('total',$total);
         Session::put('extra_charge',$extra_charge);
         Session::put('discount_price',$discount_price);
         Session::put('without_discount_price',$without_discount_price);
         Session::put('date',date("Y-m-d"));


         if($invoice==NULL)
         {
  
              $invoice="RMS";
  
  
         }


        // return $invoice;
  

         $qrcode = base64_encode(QrCode::format('svg')->size(100)->errorCorrection('H')->generate('RMS Verified'));
         $pdf = PDF::loadView('mails.PaymentMail', $data);

         Session::put('qrcode',$qrcode);

        
        //
        //return view('mails.PaymentMail');

        if($carts)
        {

            \Mail::send('mails.PaymentMail', $data, function($message)use($data, $pdf) {
                $message->to(Auth::user()->email,Auth::user()->email)
                        ->subject($data["title"])
                        ->attachData($pdf->output(), "Order Copy.pdf");
            });

        }
   
        // Cập nhật đơn hàng trong bảng orders với địa chỉ giao hàng (nếu là VNPay)
        if(Session::has('vnpay_payment_success'))
        {
            DB::table('orders')
                ->where('transaction_id', $invoice)
                ->update([
                    'address' => $request->address,
                    'status' => 'processing',
                ]);
            
            // Xóa session VNPay sau khi xử lý xong
            Session::forget('vnpay_payment_success');
        }
        
        // Trả về trang đặt hàng với thông báo thành công
        Session::flash('order_success', true);
        Session::flash('invoice', $invoice);
        
        return redirect()->route('mails.shipped', ['total' => $total])->with('order_success', true)->with('invoice', $invoice);
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function my_order()
    {

        if(!Auth::user())
        {

            return redirect()->route('login');

        }

        
        $carts = Cart::all()->where('user_id',Auth::user()->id)->where('product_order','!=','no');
        $total_price = DB::table('carts')->where('user_id',Auth::user()->id)->where('product_order','!=','no')->sum('subtotal');
        return view("my_order", compact('carts','total_price'));

        

    }
    public function trace()
    {
        // Cho phép KHÔNG đăng nhập vẫn vào trang tra cứu (chỉ hiển thị form)
        $carts = collect(); // giữ biến để không phá view cũ
        $total_price = 0;
        return view("trace", compact('carts','total_price'));
    }

    public function trace_confirm(Request $req)
    {
        // Cho phép KHÔNG đăng nhập vẫn tra cứu nếu có SĐT + mã hóa đơn
        $invoice = trim((string) $req->invoice);
        $phone = trim((string) $req->phone);
        $isAdminOrStaff = Auth::user() ? ((string) Auth::user()->usertype !== '0') : true;

        if ($invoice === '' || $phone === '') {
            session()->flash('wrong','Vui lòng nhập mã hóa đơn và số điện thoại!');
            return back();
        }

        $baseQuery = DB::table('carts')
            ->where('product_order','!=','no')
            ->whereRaw('LOWER(invoice_no) = LOWER(?)', [$invoice]);

        if(Auth::user() && !$isAdminOrStaff) {
            $baseQuery->where('user_id', Auth::user()->id);
        }

        $carts = (clone $baseQuery)->count();

        if($carts==0)
        {

            session()->flash('wrong','Invaild Invoice no !');
            return back();

        }

        // Đối chiếu SĐT theo chủ đơn (theo user_id trong carts của invoice đó)
        $orderUserId = (clone $baseQuery)->value('user_id');
        $orderUserPhone = $orderUserId ? DB::table('users')->where('id', $orderUserId)->value('phone') : null;

        if(!$orderUserId || !$orderUserPhone || $phone !== (string) $orderUserPhone) {
            session()->flash('wrong','Sai số điện thoại hoặc mã hóa đơn!');
            return back();
        }

        
        // Load carts theo invoice + user_id (tránh lộ dữ liệu nếu invoice trùng hiếm gặp)
        $carts = Cart::query()
            ->where('user_id', $orderUserId)
            ->where('product_order','!=','no')
            ->whereRaw('LOWER(invoice_no) = LOWER(?)', [$invoice])
            ->get();

        $total_price = DB::table('carts')
            ->where('user_id', $orderUserId)
            ->where('product_order','!=','no')
            ->whereRaw('LOWER(invoice_no) = LOWER(?)', [$invoice])
            ->sum('subtotal');

        $carts_amount = $carts->count();
        $without_discount_price=$total_price;
        $discount_price=0;
        $coupon_code=NULL;
        
        if($carts_amount>0)
        {
            foreach($carts as $cart)
            {
                if($cart->coupon_id) {
                    // Lấy code từ coupon_id (id)
                    $coupon_code = DB::table('coupons')->where('id', $cart->coupon_id)->value('code');
                    break;
                }
            }

         }

         if($coupon_code!=NULL)
         {


            $total_price = (clone $baseQuery)->sum('subtotal');

            
            $coupon_code_price=DB::table('coupons')->where('code',$coupon_code)->value('percentage');

            $coupon_code_price=floor($coupon_code_price);

            $discount_price=(($total_price*$coupon_code_price)/100);
            $discount_price=floor($discount_price);


            $total_price = $total_price - $discount_price;
      


         }
         else
         {

            $total_price = (clone $baseQuery)->sum('subtotal');


         }
         $extra_charge=DB::table('charges')->get();
         $total_extra_charge=DB::table('charges')->sum('price');

         $total_price=$total_price+$total_extra_charge;
         $without_discount_price=$without_discount_price+$total_extra_charge;

        return view("trace_confirm", compact('carts','total_price','extra_charge','discount_price','without_discount_price'));



    }
    

    public function coupon_apply(Request $req)
    {


        $coupon_code=DB::table('coupons')->where('code',$req->code)->count();

        if($coupon_code == 0)
        {

            session()->flash('wrong','Wrong Coupon Code !');
            return back();

        }
        $validate=DB::table('coupons')->where('code',$req->code)->value('validate');

        $today=date("Y-m-d");

        if($validate < $today)
        {
            session()->flash('wrong','Mã khuyến mãi đã hết hạn!');
            session()->flash('coupon_expired', true);
            return back();
        }

        // Guest: lưu coupon vào session (không cần đăng nhập)
        if(!Auth::user())
        {
            $coupon_id = DB::table('coupons')->where('code', $req->code)->value('id');
            if (!$coupon_id) {
                session()->flash('wrong','Coupon không tồn tại!');
                return back();
            }

            Session::put('guest_coupon_id', $coupon_id);
            return redirect('/cart');
        }

        // Lấy ID của coupon từ code
        $coupon_id = DB::table('coupons')->where('code', $req->code)->value('id');
        
        if (!$coupon_id) {
            session()->flash('wrong','Coupon không tồn tại!');
            return back();
        }

        $data=array();

        $data['coupon_id']=$coupon_id;

        $update_coupon=DB::table('carts')->where('user_id',Auth::user()->id)->where('product_order','no')->update($data);

        if($update_coupon)
        {



           return redirect('/cart');

        }
        else
        {

            session()->flash('wrong','Mã khuyến mãi này đã được áp dụng rồi!');
            session()->flash('coupon_already_applied', true);
            return back();


        }
        

    }

}
