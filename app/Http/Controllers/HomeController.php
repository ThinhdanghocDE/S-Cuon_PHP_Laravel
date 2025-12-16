<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Hash;


use Session;




class HomeController extends Controller
{
    /**
     * Tính rating cho một product (optimized - không dùng nữa, dùng addRatingToProductsOptimized)
     */
    private function calculateRating($productId)
    {
        $total_rate = DB::table('rates')->where('product_id', $productId)->sum('star_value');
        $total_voter = DB::table('rates')->where('product_id', $productId)->count();
        
        if($total_voter > 0) {
            $per_rate = $total_rate / $total_voter;
        } else {
            $per_rate = 0;
        }
        
        $per_rate = number_format($per_rate, 1);
        $whole = floor($per_rate);
        $fraction = $per_rate - $whole;
        
        return [
            'per_rate' => $per_rate,
            'whole' => $whole,
            'fraction' => $fraction,
            'total_rate' => $total_rate,
            'total_voter' => $total_voter
        ];
    }

    /**
     * Thêm rating data vào collection products (optimized - tránh N+1 query)
     */
    private function addRatingToProductsOptimized($products)
    {
        if ($products->isEmpty()) {
            return $products;
        }

        // Lấy tất cả product IDs
        $productIds = $products->pluck('id')->toArray();

        // Query một lần để lấy tất cả ratings (tránh N+1)
        $ratings = DB::table('rates')
            ->whereIn('product_id', $productIds)
            ->select('product_id', DB::raw('SUM(star_value) as total_rate'), DB::raw('COUNT(*) as total_voter'))
            ->groupBy('product_id')
            ->get()
            ->keyBy('product_id');

        // Map ratings vào products
        return $products->map(function($product) use ($ratings) {
            $rating = $ratings->get($product->id);
            
            if ($rating && $rating->total_voter > 0) {
                $per_rate = $rating->total_rate / $rating->total_voter;
            } else {
                $per_rate = 0;
            }
            
            $per_rate = number_format($per_rate, 1);
            $whole = floor($per_rate);
            $fraction = $per_rate - $whole;
            
            $product->rating_per_rate = $per_rate;
            $product->rating_whole = $whole;
            $product->rating_fraction = $fraction;
            $product->rating_total_rate = $rating->total_rate ?? 0;
            $product->rating_total_voter = $rating->total_voter ?? 0;
            
            return $product;
        });
    }

    /**
     * Thêm rating data vào collection products (deprecated - dùng addRatingToProductsOptimized)
     */
    private function addRatingToProducts($products)
    {
        return $this->addRatingToProductsOptimized($products);
    }

    public function index(){

        $menu=DB::table('products')->where('catagory','regular')->get();

        // Combo theo số người (session = combo_size)
        $combo1=DB::table('products')->where('catagory','special')->where('session',0)->get(); // 1 người
        $combo2=DB::table('products')->where('catagory','special')->where('session',1)->get(); // 2 người
        $combo3=DB::table('products')->where('catagory','special')->where('session',2)->get(); // 3 người
        // Có thể thêm combo 4, 5, 6 nếu có dữ liệu trong DB
        
        // Giữ tên biến cũ để không phá vỡ view
        $breakfast = $combo1;
        $lunch = $combo2;
        $dinner = $combo3;

        // Thêm rating data vào các collections
        $menu = $this->addRatingToProducts($menu);
        $breakfast = $this->addRatingToProducts($breakfast);
        $lunch = $this->addRatingToProducts($lunch);
        $dinner = $this->addRatingToProducts($dinner);

        $chefs=DB::table('chefs')->get();

        // Lấy bài viết nổi bật (is_featured = 1, status = published)
        $featured_posts = DB::table('posts')
            ->where('is_featured', 1)
            ->where('status', 'published')
            ->orderBy('published_at', 'desc')
            ->limit(3) // Hiển thị tối đa 3 bài viết
            ->get();

        if(Auth::user())
        {

            $cart_amount=DB::table('carts')->where('user_id',Auth::user()->id)->where('product_order','no')->count();


        }
        else
        {

            $cart_amount=0;

        }

        $about_us=DB::table('about_us')->get();
        $banners=DB::table('banners')->get();



        return view("home",compact('menu','breakfast','lunch','dinner','chefs','cart_amount','about_us','banners','featured_posts'));
    }

    public function redirects(){


        if(!Auth::user())
        {

            return redirect()->route('login');


        }

        
        $menu=DB::table('products')->where('catagory','regular')->get();

        // Combo theo số người
        $combo1=DB::table('products')->where('catagory','special')->where('session',0)->get();
        $combo2=DB::table('products')->where('catagory','special')->where('session',1)->get();
        $combo3=DB::table('products')->where('catagory','special')->where('session',2)->get();
        
        $breakfast = $combo1;
        $lunch = $combo2;
        $dinner = $combo3;

        // Thêm rating data vào các collections
        $menu = $this->addRatingToProducts($menu);
        $breakfast = $this->addRatingToProducts($breakfast);
        $lunch = $this->addRatingToProducts($lunch);
        $dinner = $this->addRatingToProducts($dinner);

        $chefs=DB::table('chefs')->get();


        if(Auth::user())
        {

            $cart_amount=DB::table('carts')->where('user_id',Auth::user()->id)->where('product_order','no')->count();


        }
        else
        {

            $cart_amount=0;

        }

      

        $about_us=DB::table('about_us')->get();
        $banners=DB::table('banners')->get();


        $usertype= Auth::user()->usertype;
        if($usertype!='0')
    	{

            // Đếm số đơn theo invoice_no (đúng hơn groupBy()->count() và nhanh hơn)
            $pending_order = DB::table('carts')
                ->where('product_order', 'yes')
                ->distinct('invoice_no')
                ->count('invoice_no');

            $processing_order = DB::table('carts')
                ->where('product_order', 'approve')
                ->distinct('invoice_no')
                ->count('invoice_no');

            $cancel_order = DB::table('carts')
                ->where('product_order', 'cancel')
                ->distinct('invoice_no')
                ->count('invoice_no');

            $complete_order = DB::table('carts')
                ->where('product_order', 'delivery')
                ->distinct('invoice_no')
                ->count('invoice_no');

            // Tổng doanh thu/giá trị giao dịch: chỉ tính đơn đã đặt/đang xử lý/đã giao (không tính giỏ "no" và không tính hủy)
            $total = DB::table('carts')
                ->whereIn('product_order', ['yes', 'approve', 'delivery'])
                ->sum('subtotal');

            $cash_on_payment = DB::table('carts')
                ->whereIn('product_order', ['yes', 'approve', 'delivery'])
                ->where('pay_method', 'Cash On Delivery')
                ->sum('subtotal');

            $online_payment = max(0, $total - $cash_on_payment);


            $customer=DB::table('users')->where('usertype','0')->count();


            $delivery_boy=DB::table('users')->where('usertype','2')->count();


            $user=DB::table('users')->count();


            $admin=$user-($customer + $delivery_boy);


            $rates = DB::table('rates')->get();

            // Default an toàn khi chưa có rating
            $product = [];
            $voter = [];
            $per_rate = [];


            foreach($rates as $rate)
            {


                $product[$rate->product_id]=0;
                $voter[$rate->product_id]=0;
                $per_rate[$rate->product_id]=0;



            }



            foreach($rates as $rate)
            {


                $product[$rate->product_id]=$product[$rate->product_id]+ $rate->star_value;


                $voter[$rate->product_id]=$voter[$rate->product_id]+ 1;

                if($voter[$rate->product_id] > 0)
                {

                    $per_rate[$rate->product_id]=$product[$rate->product_id] / $voter[$rate->product_id];

                }
                else
                {


                    $per_rate[$rate->product_id]=$product[$rate->product_id];


                }

                $per_rate[$rate->product_id]=number_format($per_rate[$rate->product_id], 1);




            }
            
            $copy_product=$per_rate;

            arsort($per_rate);


            // return $per_rate;


            $product_get=array();


            // Không cần truy vấn $product_get tại đây (view đang tự truy vấn lại)


            $carts = DB::table('carts')
                ->where('product_order', '!=', 'no')
                ->where('product_order', '!=', 'cancel')
                ->get();

            $cart = [];
            $product_cart = [];


            foreach($carts as $cart)
            {


                $product_cart[$cart->product_id]=0;
               



            }



            foreach($carts as $cart)
            {


                $product_cart[$cart->product_id]=$product_cart[$cart->product_id]+ $cart->quantity;



            }
            
            $copy_cart=$product_cart;

            arsort($product_cart);



    		return view('admin.dashboard',compact('pending_order','product_cart','copy_cart','total','copy_product','per_rate','product','cash_on_payment','online_payment','customer','delivery_boy','admin','processing_order','cancel_order','complete_order'));
    	}
        else{
            
            return view("home",compact('menu','breakfast','lunch','dinner','chefs','cart_amount','about_us','banners'));
        }
    }


    public function reservation_confirm(Request $req)
    {
        // Validation - không cần đăng nhập
        $validated = $req->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'no_guest' => 'required|string|max:10',
            'date' => 'required|string|max:50',
            'time' => 'required|string|max:50',
            'message' => 'nullable|string|max:1000',
        ], [
            'name.required' => 'Vui lòng nhập họ và tên',
            'email.required' => 'Vui lòng nhập email',
            'email.email' => 'Email không hợp lệ',
            'phone.required' => 'Vui lòng nhập số điện thoại',
            'no_guest.required' => 'Vui lòng chọn số người',
            'date.required' => 'Vui lòng chọn ngày',
            'time.required' => 'Vui lòng chọn giờ',
        ]);

        $name = $validated['name'];
        $email = $validated['email'];
        $phone = $validated['phone'];
        $no_guest = $validated['no_guest'];
        $date = $validated['date'];
        $time = $validated['time'];
        $message = $validated['message'] ?? '';

        $data = array();
        $data['name'] = $name;
        $data['email'] = $email;
        $data['no_guest'] = $no_guest;
        $data['phone'] = $phone;
        $data['date'] = $date;
        $data['time'] = $time;
        $data['message'] = $message; // Giữ nguyên tên cho database
        
        // Tạo array riêng cho email template để tránh conflict với $message trong Mail closure
        $emailData = $data;
        $emailData['reservation_message'] = $message; // Thêm key mới cho template


        $confirm_reservation=DB::table('reservations')->Insert($data);

        // Thêm title và body vào emailData
        $emailData["title"] = "Thông Báo Từ S-Cuốn";
        $emailData["body"] = "Đặt bàn của bạn đã được đặt thành công";


        /*
        $files = [
            public_path('file/sample.pdf'),
        ];
  
        
        \Mail::send('mails.ReserveMail', $data, function($message)use($data, $files, $email) {
            $message->to($email)
                    ->subject('Thông Báo Từ S-Cuốn');
 
            foreach ($files as $file){
                $message->attach($file);
            }
            
        });

        */

        // Gửi email xác nhận đặt bàn (không cần đăng nhập)
        $emailSent = false;
        $emailError = null;
        
        if (!empty($email)) {
            try {
                // Log thông tin trước khi gửi
                \Log::info('Bắt đầu gửi email đặt bàn', [
                    'email' => $email,
                    'name' => $name,
                    'mailer' => config('mail.default')
                ]);
                
                $pdf = Pdf::loadView('mails.Reserve', $emailData);
        
                \Mail::send('mails.Reserve', $emailData, function($mailMessage)use($emailData, $pdf, $email, $name) {
                    $mailMessage->to($email, $name ?? 'Khách hàng')
                            ->subject($emailData["title"])
                            ->attachData($pdf->output(), "Reservation Copy.pdf");
                });
                
                $emailSent = true;
                \Log::info('Email đặt bàn đã được gửi thành công', ['email' => $email]);
                
            } catch (\Exception $e) {
                // Log lỗi gửi email nhưng vẫn cho phép đặt bàn thành công
                $emailError = $e->getMessage();
                \Log::error('Lỗi gửi email đặt bàn', [
                    'email' => $email,
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString()
                ]);
            }
        } else {
            \Log::warning('Không thể gửi email đặt bàn: Email trống');
        }

        // Truyền thông tin để hiển thị trong view
        return view('Reserve_order', [
            'reservation' => $data,
            'emailSent' => $emailSent,
            'emailError' => $emailError,
            'mailer' => config('mail.default')
        ]);



    }

    public function rate($id)
    {


        if(!Auth::user())
        {

            return redirect()->route('login');

        }

        $already_rate=DB::table('rates')->where('product_id',$id)->where('user_id',Auth::user()->id)
        ->count();


        $find_rate=DB::table('rates')->where('product_id',$id)->where('user_id',Auth::user()->id)
        ->value('star_value');


        $products=DB::table('products')->where('id',$id)->first();


        $total_rate=DB::table('rates')->where('product_id',$id)
        ->sum('star_value');


        $total_voter=DB::table('rates')->where('product_id',$id)
        ->count();

        if($total_voter>0)
        {

            $per_rate=$total_rate/$total_voter;

        }
        else
        {

            $per_rate=0;


        }

        $per_rate=number_format($per_rate, 1);


        

        if($already_rate>0)
        {

             
           return view('rate_view',compact('products','find_rate','already_rate','total_rate','total_voter','per_rate'));


        }

  


        return view('rate',compact('products','find_rate','already_rate','total_rate','total_voter','per_rate'));


    }

    public function store_rate($value)
    {


        $product_id=Session::get('product_id');




        $user_id=Auth::user()->id;


        $star_value=$value;




        $data=array();

        $data['user_id']=$user_id;
        $data['product_id']=$product_id;
        $data['star_value']=$value;

        $rate=DB::table('rates')->where('product_id',$product_id)->where('user_id',$user_id)->count();


        if($rate>0)
        {

            $edit_rate=DB::table('rates')->where('product_id',$product_id)->where('user_id',$user_id)->update($data);


        }

        else
        {

            $add=DB::table('rates')->Insert($data);


        }


        return view('Place_rate');




    }


    public function delete_rate()
    {
      
       $product_id=Session::get('product_id');
       $user_id=Auth::user()->id;
       $rate=DB::table('rates')->where('product_id',$product_id)->where('user_id',$user_id)->delete();





       return view('delete_rate_confirm');
  


    }

    public function edit_rate($id)
    {


        if(!Auth::user())
        {

            return redirect()->route('login');

        }

  


        $find_rate=DB::table('rates')->where('product_id',$id)->where('user_id',Auth::user()->id)
        ->value('star_value');


        $products=DB::table('products')->where('id',$id)->first();


        $total_rate=DB::table('rates')->where('product_id',$id)
        ->sum('star_value');


        $total_voter=DB::table('rates')->where('product_id',$id)
        ->count();

        if($total_voter>0)
        {

            $per_rate=$total_rate/$total_voter;

        }
        else
        {

            $per_rate=0;


        }

        $per_rate=number_format($per_rate, 1);

    


        return view('rate',compact('products','find_rate','total_rate','total_voter','per_rate'));


    }
    public function top_rated()
    {

        $products = DB::table('rates') 
                            ->get();


        $data=array();

        
        foreach($products as $product)
        {


            $data[$product->product_id]=0;




        }




        $max_product=array();

        foreach($products as $product)
        {


            $data[$product->product_id]=$data[$product->product_id]+$product->star_value;





        }
                          
        rsort($data);

        

         dd($data);




    }
    public function register(Request $req)
    {

        $data=array();
        $data['name']=$req->name;
        $data['phone']=$req->phone;
        $data['email']=$req->email;
        $data['password']=Hash::make($req->password);

        $email=DB::table('users')->where('email',$req->email)->count();


        if($email > 0)
        {

            session()->flash('wrong','Email already registered !');
            return back();


        }

        $phone=DB::table('users')->where('phone',$req->phone)->count();


        if($phone > 0)
        {

            session()->flash('wrong','Phone already registered !');
            return back();


        }
        if(strlen($req->password)<8)
        {

            session()->flash('wrong','Password lenght at least 8 words!');
            return back();



        }

        if($req->password!=$req->password_confirmation)
        {

            
            session()->flash('wrong','Password do not match !');
            return back();


        }

        $insert=DB::table('users')->Insert($data);


        return redirect('/redirects');





    }
  

}
