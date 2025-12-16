<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;


class AdminController extends Controller
{
    

    public function home()
    {

        if(!Auth::user())
        {

            return redirect()->route('login');


        }
        $usertype= Auth::user()->usertype;
        if($usertype!='1')
    	{
    		return redirect('/');
    	}

        return redirect('redirects');



    }
    public function food_menu()
    {

        if(!Auth::user())
        {

            return redirect()->route('login');


        }
        $usertype= Auth::user()->usertype;
        if($usertype!='1')
    	{
    		return redirect('/');
    	}


        $total_products=DB::table('products')->count();

        $fraction=$total_products % 3;

        $products=DB::table('products')->get();


        $fraction_products=DB::table('products')->latest()->get();

 
        return view('admin.menu',compact('products','fraction','total_products','fraction_products'));



    }
    
    public function chefs()
    {

        if(!Auth::user())
        {

            return redirect()->route('login');


        }
        $usertype= Auth::user()->usertype;
        if($usertype!='1')
    	{
    		return redirect('/');
    	}


        $total_chefs=DB::table('chefs')->count();

        $fraction=$total_chefs % 3;

        $chefs=DB::table('chefs')->get();


        $fraction_chefs=DB::table('chefs')->latest()->get();

 
        return view('admin.chefs',compact('chefs','fraction','total_chefs','fraction_chefs'));



    }
    public function order_incomplete()
    {


       // dd($orders);

       $orders=DB::table('carts')->where('product_order','yes')
       ->groupBy('invoice_no')
       ->get();


        return view('admin.incomplete-orders',compact('orders'));



    }
    public function order_complete()
    {


       // dd($orders);

       $orders=DB::table('carts')->where('product_order','delivery')
       ->groupBy('invoice_no')
       ->get();


        return view('admin.complete_orders',compact('orders'));



    }
    public function reservation()
    {

        
        $reservations=DB::table('reservations')->get();
 
 
         return view('admin.reservations',compact('reservations'));




    }
    
    public function add_menu()
    {

        return view('admin.add_menu');

    }
    public function add_chef()
    {


        return view('admin.add_chef');


    }
    public function coupon_show()
    {

        $coupons=DB::table('coupons')->get();


        return view('admin.coupons',compact('coupons'));


    }
    public function admin_show()
    {

        $admins=DB::table('users')->where('usertype','1')->orWhere('usertype','3')->get();


        return view('admin.admins',compact('admins'));


    }
    public function user_show()
    {

        $users=DB::table('users')->where('usertype','!=','1')->get();


        return view('admin.users',compact('users'));


    }

    public function charge()
    {

        $charges=DB::table('charges')->get();


        return view('admin.charges',compact('charges'));


    }
    public function banner()
    {

        $banners=DB::table('banners')->get();


        return view('admin.banners',compact('banners'));


    }
    public function customize()
    {

        $customize=DB::table('about_us')->get();


        return view('admin.customize',compact('customize'));


    }
    public function banner_add()
    {


        return view('admin.add_banner');

    }

    public function menu_add_process(Request $req)
    {
        $validated = $req->validate([
            'name' => 'required|string|min:2|max:200',
            'description' => 'required|string|min:10|max:1000',
            'price' => 'required|numeric|min:0',
            'catagory' => 'required|in:regular,special',
            'session' => 'required|in:0,1,2',
            'available' => 'required|in:Stock,Out of Stock',
            'image' => 'required|image|mimes:jpeg,jpg,png|max:5120',
        ], [
            'name.required' => 'Vui lòng nhập tên món.',
            'name.min' => 'Tên món phải có ít nhất 2 ký tự.',
            'name.max' => 'Tên món không được vượt quá 200 ký tự.',
            'description.required' => 'Vui lòng nhập mô tả.',
            'description.min' => 'Mô tả phải có ít nhất 10 ký tự.',
            'description.max' => 'Mô tả không được vượt quá 1000 ký tự.',
            'price.required' => 'Vui lòng nhập giá.',
            'price.numeric' => 'Giá phải là số.',
            'price.min' => 'Giá không được âm.',
            'catagory.required' => 'Vui lòng chọn danh mục.',
            'catagory.in' => 'Danh mục không hợp lệ.',
            'session.required' => 'Vui lòng chọn combo.',
            'session.in' => 'Combo không hợp lệ.',
            'available.required' => 'Vui lòng chọn tình trạng.',
            'available.in' => 'Tình trạng không hợp lệ.',
            'image.required' => 'Vui lòng chọn ảnh.',
            'image.image' => 'File phải là ảnh.',
            'image.mimes' => 'Chỉ chấp nhận file ảnh định dạng JPG, JPEG hoặc PNG.',
            'image.max' => 'Kích thước file không được vượt quá 5MB.',
        ]);
     
     
        $uploadedfile=$req->file('image');
        $new_image=rand().'.'.$uploadedfile->getClientOriginalExtension();
        $uploadedfile->move(public_path('/assets/images/'),$new_image);

        $data=array();
        $data['name']=$req->name;
        $data['description']=$req->description;
        $data['price']=$req->price;
        $data['catagory']=$req->catagory;
        $data['session'] = $req->input('session');
        $data['available']=$req->available;
        $data['image']=$new_image;


        $insert=DB::table('products')->Insert($data);


        session()->flash('success','Menu added successfully !');
        return back();



    }
    public function chef_add_process(Request $req)
    {
        // Server-side validation
        $validated = $req->validate([
            'name' => 'required|string|min:2|max:100',
            'job' => 'required|string|min:2|max:100',
            'fb' => 'nullable|url|max:255',
            'twitter' => 'nullable|url|max:255',
            'instagram' => 'nullable|url|max:255',
            'image' => 'required|image|mimes:jpeg,jpg,png|max:5120', // 5MB max
        ], [
            'name.required' => 'Vui lòng nhập tên đầu bếp.',
            'name.min' => 'Tên đầu bếp phải có ít nhất 2 ký tự.',
            'name.max' => 'Tên đầu bếp không được vượt quá 100 ký tự.',
            'job.required' => 'Vui lòng nhập chức danh.',
            'job.min' => 'Chức danh phải có ít nhất 2 ký tự.',
            'job.max' => 'Chức danh không được vượt quá 100 ký tự.',
            'fb.url' => 'Facebook link phải là URL hợp lệ.',
            'twitter.url' => 'Twitter link phải là URL hợp lệ.',
            'instagram.url' => 'Instagram link phải là URL hợp lệ.',
            'image.required' => 'Vui lòng chọn ảnh đầu bếp.',
            'image.image' => 'File phải là ảnh.',
            'image.mimes' => 'Chỉ chấp nhận file ảnh định dạng JPG, JPEG hoặc PNG.',
            'image.max' => 'Kích thước file không được vượt quá 5MB.',
        ]);
     
        $uploadedfile=$req->file('image');
        $new_image=rand().'.'.$uploadedfile->getClientOriginalExtension();
        $uploadedfile->move(public_path('/assets/images/'),$new_image);

        $data=array();
        $data['name']=$req->name;
        $data['job_title']=$req->job;
        $data['facebook_link']=$req->fb;
        $data['twitter_link']=$req->twitter;
        $data['instragram_link']=$req->instagram;
        $data['image']=$new_image;


        $insert=DB::table('chefs')->Insert($data);


        session()->flash('success','Chef added successfully !');
        return back();



    }
    public function menu_delete_process($id)
    {



        $delete=DB::table('products')->where('id',$id)->delete();

        session()->flash('success','Menu  deleted successfully !');
        return back();



    }

    public function chef_delete_process($id)
    {



        $delete=DB::table('chefs')->where('id',$id)->delete();

        session()->flash('success','Chef  deleted successfully !');
        return back();



    }
    public function menu_edit($id)
    {



        $products=DB::table('products')->where('id',$id)->get();

        
        return view('admin.menu_edit',compact('products'));



    }
    public function chef_edit($id)
    {



        $chefs=DB::table('chefs')->where('id',$id)->get();

        
        return view('admin.chef_edit',compact('chefs'));



    }
    public function menu_edit_process(Request $req,$id)
    {
        $validated = $req->validate([
            'name' => 'required|string|min:2|max:200',
            'description' => 'required|string|min:10|max:1000',
            'price' => 'required|numeric|min:0',
            'catagory' => 'required|in:regular,special',
            'session' => 'required|in:0,1,2',
            'available' => 'required|in:Stock,Out of Stock',
            'image' => 'nullable|image|mimes:jpeg,jpg,png|max:5120',
        ], [
            'name.required' => 'Vui lòng nhập tên món.',
            'name.min' => 'Tên món phải có ít nhất 2 ký tự.',
            'name.max' => 'Tên món không được vượt quá 200 ký tự.',
            'description.required' => 'Vui lòng nhập mô tả.',
            'description.min' => 'Mô tả phải có ít nhất 10 ký tự.',
            'description.max' => 'Mô tả không được vượt quá 1000 ký tự.',
            'price.required' => 'Vui lòng nhập giá.',
            'price.numeric' => 'Giá phải là số.',
            'price.min' => 'Giá không được âm.',
            'catagory.required' => 'Vui lòng chọn danh mục.',
            'catagory.in' => 'Danh mục không hợp lệ.',
            'session.required' => 'Vui lòng chọn combo.',
            'session.in' => 'Combo không hợp lệ.',
            'available.required' => 'Vui lòng chọn tình trạng.',
            'available.in' => 'Tình trạng không hợp lệ.',
            'image.image' => 'File phải là ảnh.',
            'image.mimes' => 'Chỉ chấp nhận file ảnh định dạng JPG, JPEG hoặc PNG.',
            'image.max' => 'Kích thước file không được vượt quá 5MB.',
        ]);

        $data=array();
        $data['name']=$req->name;
        $data['description']=$req->description;
        $data['price']=$req->price;
        $data['catagory']=$req->catagory;
        $data['session'] = $req->input('session');
        $data['available']=$req->available;

        if($req->image!=NULL)
        {
         
         
            $uploadedfile=$req->file('image');
            $new_image=rand().'.'.$uploadedfile->getClientOriginalExtension();
            $uploadedfile->move(public_path('/assets/images/'),$new_image);

            $data['image']=$new_image;

        }
  


        $update=DB::table('products')->where('id',$id)->Update($data);


        session()->flash('success','Menu updated successfully !');
        return back();



    }



    public function chef_edit_process(Request $req,$id)
    {
        // Server-side validation
        $validated = $req->validate([
            'name' => 'required|string|min:2|max:100',
            'job' => 'required|string|min:2|max:100',
            'fb' => 'nullable|url|max:255',
            'twitter' => 'nullable|url|max:255',
            'instagram' => 'nullable|url|max:255',
            'image' => 'nullable|image|mimes:jpeg,jpg,png|max:5120', // 5MB max, optional for edit
        ], [
            'name.required' => 'Vui lòng nhập tên đầu bếp.',
            'name.min' => 'Tên đầu bếp phải có ít nhất 2 ký tự.',
            'name.max' => 'Tên đầu bếp không được vượt quá 100 ký tự.',
            'job.required' => 'Vui lòng nhập chức danh.',
            'job.min' => 'Chức danh phải có ít nhất 2 ký tự.',
            'job.max' => 'Chức danh không được vượt quá 100 ký tự.',
            'fb.url' => 'Facebook link phải là URL hợp lệ.',
            'twitter.url' => 'Twitter link phải là URL hợp lệ.',
            'instagram.url' => 'Instagram link phải là URL hợp lệ.',
            'image.image' => 'File phải là ảnh.',
            'image.mimes' => 'Chỉ chấp nhận file ảnh định dạng JPG, JPEG hoặc PNG.',
            'image.max' => 'Kích thước file không được vượt quá 5MB.',
        ]);

        $data=array();
        $data['name']=$req->name;
        $data['job_title']=$req->job;
        $data['facebook_link']=$req->fb;
        $data['twitter_link']=$req->twitter;
        $data['instragram_link']=$req->instagram;
       
        if($req->image!=NULL)
        {

            $this->validate(request(),[

                'image'=>'mimes:jpeg,jpg,png',
            ]);
         
         
            $uploadedfile=$req->file('image');
            $new_image=rand().'.'.$uploadedfile->getClientOriginalExtension();
            $uploadedfile->move(public_path('/assets/images/'),$new_image);

            $data['image']=$new_image;

        }


        $update=DB::table('chefs')->where('id',$id)->Update($data);


        session()->flash('success','Chef upadetd successfully !');
        return back();


        
    }

    public function invoice_approve(Request $req,$id)
    {

        $data=array();

        $data['product_order']="approve";
    
       // return $req->time;

        $time_set_up=strtotime($req->time);
        $time_set_up=date("F j, Y, G:i:sa", $time_set_up);

        $data['delivery_time'] = $time_set_up;


        $details = [
            'title' => 'Thông Báo Từ S-Cuốn',
            'body' => 'Đơn hàng của bạn đã được S-Cuốn chấp nhận. Mã hóa đơn - '.$id.' & Thời gian giao hàng (dự kiến) - '.$req->time,
        ];

        $products=DB::table('carts')->where('invoice_no',$id)->get();

        foreach($products as $product)
        {


            $user_id=$product->user_id;
            $status=$product->product_order;


        }
        
        if($status!="approve")
        {
            $details = [
                'title' => 'Thông Báo Từ S-Cuốn',
                'body' => 'Đơn hàng của bạn đã được chấp nhận. Mã hóa đơn - '.$id.' & Thời gian giao hàng (dự kiến) - '.$req->time,
            ];

            
            $user=DB::table('users')->where('id',$user_id)->first();
        
            Mail::to($user->email)->send(new \App\Mail\ApproveMail($details));


            $update=DB::table('carts')->where('invoice_no',$id)->Update($data);


            session()->flash('success','Order approved successfully !');
            return back();


        }
        else
        {

            $details = [
                'title' => 'Thông Báo Từ S-Cuốn',
                'body' => 'Đơn hàng của bạn đã được S-Cuốn cập nhật. Mã hóa đơn - '.$id.' & Thời gian giao hàng còn lại (dự kiến) - '.$req->time,
            ];

            
            $user=DB::table('users')->where('id',$user_id)->first();
        
            Mail::to($user->email)->send(new \App\Mail\ApproveMail($details));


            $update=DB::table('carts')->where('invoice_no',$id)->Update($data);


            session()->flash('success','Order loaction updated successfully !');
            return redirect('/order/location');


        }




    }
    public function invoice_details($id)
    {
       
       $products=DB::table('carts')->where('invoice_no',$id)->get();
       $charges=DB::table('charges')->get();

        $total_price=DB::table('carts')->where('invoice_no',$id)->sum('subtotal');
        $wihout_discount_price=$total_price;
        $coupon_code = NULL;
        foreach($products as $product)
        {
            if($product->coupon_id) {
                // Lấy code từ coupon_id (id)
                $coupon_code = DB::table('coupons')->where('id', $product->coupon_id)->value('code');
                break;
            }
        }
        
        if($coupon_code) {
            $coupon_code_price=DB::table('coupons')->where('code',$coupon_code)->value('percentage');
        } else {
            $coupon_code_price = 0;
        }

        $coupon_code_price=floor($coupon_code_price);

        $discount_price=(($total_price*$coupon_code_price)/100);
        $discount_price=floor($discount_price);

        $extra_charge=DB::table('charges')->get();
        $total_extra_charge=DB::table('charges')->sum('price');


        $total_price = $total_price - $discount_price;

        $total_price=$total_price+$total_extra_charge;
        $wihout_discount_price=$wihout_discount_price+$total_extra_charge;


        return view('admin.invoice_details',compact('total_price','extra_charge','total_extra_charge','discount_price','wihout_discount_price','products'));

    }
    public function invoice_cancel($id)
    {

        $data=array();

        $data['product_order']="cancel";


        $products=DB::table('carts')->where('invoice_no',$id)->get();

        foreach($products as $product)
        {


            $user_id=$product->user_id;
            $pay_method=$product->pay_method;
            $status=$product->product_order;


        }

        if($pay_method=="Online Payment")
        {

            $details = [
                'title' => 'Thông Báo Từ S-Cuốn',
                'body' => 'Xin lỗi quý khách. Đơn hàng của bạn đã bị hủy bởi S-Cuốn vì lý do không thể tránh khỏi. Bạn sẽ nhận lại tiền trong vòng 8 ngày làm việc. Mã hóa đơn - '.$id,
            ];


        }
        else
        {


            $details = [
                'title' => 'Thông Báo Từ S-Cuốn',
                'body' => 'Xin lỗi quý khách. Đơn hàng của bạn đã bị hủy bởi S-Cuốn vì lý do không thể tránh khỏi. Mã hóa đơn - '.$id,
            ];


        }
        $user=DB::table('users')->where('id',$user_id)->first();
       
        Mail::to($user->email)->send(new \App\Mail\ApproveMail($details));


        $update=DB::table('carts')->where('invoice_no',$id)->Update($data);


        if($status!="approve")
        {
            session()->flash('success','Order cancelled successfully !');
            return back();

        }
        else
        {

            session()->flash('success','Order cancelled successfully !');

            return redirect('/order/location');

        }

    
       



    }
    

    public function order_location()
    {



        return view('admin.order_loaction');


    }
    public function edit_order_location(Request $req)
    {

        $id=$req->id;

        $products=DB::table('carts')->where('invoice_no',$id)->count();


        if($products==0)
        {


            session()->flash('wrong','Invalid Invoice no !');
            return back();
    


        }

       $products=DB::table('carts')->where('invoice_no',$id)->get();



       foreach($products as $product)
       {


            $status=$product->product_order;


       }
       if($status!="approve")
       {


           session()->flash('wrong','Order not approved !');
           return back();
   


       }

        

       $charges=DB::table('charges')->get();

        $total_price=DB::table('carts')->where('invoice_no',$id)->sum('subtotal');
        $wihout_discount_price=$total_price;
        $coupon_code = NULL;
        foreach($products as $product)
        {
            if($product->coupon_id) {
                // Lấy code từ coupon_id (id)
                $coupon_code = DB::table('coupons')->where('id', $product->coupon_id)->value('code');
                break;
            }
        }
        
        if($coupon_code) {
            $coupon_code_price=DB::table('coupons')->where('code',$coupon_code)->value('percentage');
        } else {
            $coupon_code_price = 0;
        }

        $coupon_code_price=floor($coupon_code_price);

        $discount_price=(($total_price*$coupon_code_price)/100);
        $discount_price=floor($discount_price);

        $extra_charge=DB::table('charges')->get();
        $total_extra_charge=DB::table('charges')->sum('price');


        $total_price = $total_price - $discount_price;

        $total_price=$total_price+$total_extra_charge;
        $wihout_discount_price=$wihout_discount_price+$total_extra_charge;


        return view('admin.update_order_location',compact('total_price','extra_charge','total_extra_charge','discount_price','wihout_discount_price','products'));

    }
    public function orders_process()
    {


       // dd($orders);

       $orders=DB::table('carts')->where('product_order','approve')
       ->groupBy('invoice_no')
       ->get();


        return view('admin.process_order',compact('orders'));



    }
    public function orders_cancel()
    {


       // dd($orders);

       $orders=DB::table('carts')->where('product_order','cancel')
       ->groupBy('invoice_no')
       ->get();


        return view('admin.cancel_order',compact('orders'));



    }
    public function invoice_complete($id)
    {

        $data=array();

        $data['product_order']="delivery";


        $details = [
            'title' => 'Thông Báo Từ S-Cuốn',
            'body' => 'Đơn hàng của bạn đã được S-Cuốn giao thành công. Mã hóa đơn - '.$id,
        ];

        $products=DB::table('carts')->where('invoice_no',$id)->get();

        foreach($products as $product)
        {


            $user_id=$product->user_id;
            $status=$product->product_order;


        }
        
       
        
            
            $user=DB::table('users')->where('id',$user_id)->first();
        
            Mail::to($user->email)->send(new \App\Mail\ApproveMail($details));


            $update=DB::table('carts')->where('invoice_no',$id)->Update($data);


            session()->flash('success','Order delivered successfully !');
            return back();


 




    }
    public function delivery_boy()
    {

        $delivery_boys=DB::table('users')->where('usertype','2')->get();


        return view('admin.delivery_boys',compact('delivery_boys'));


    }
    public function add_admin()
    {

        return view('admin.add_admin');



    }
    public function add_admin_process(Request $req)
    {
        $validated = $req->validate([
            'name' => 'required|string|min:2|max:100',
            'email' => 'required|email|unique:users,email|max:255',
            'phone' => 'required|numeric|digits_between:10,11|unique:users,phone',
            'type' => 'required|in:1,3',
            'salary' => 'required|numeric|min:0',
            'password' => 'required|string|min:8|confirmed',
            'image' => 'required|image|mimes:jpeg,jpg,png|max:5120',
        ], [
            'name.required' => 'Vui lòng nhập tên.',
            'name.min' => 'Tên phải có ít nhất 2 ký tự.',
            'name.max' => 'Tên không được vượt quá 100 ký tự.',
            'email.required' => 'Vui lòng nhập email.',
            'email.email' => 'Email không hợp lệ.',
            'email.unique' => 'Email đã được sử dụng.',
            'phone.required' => 'Vui lòng nhập số điện thoại.',
            'phone.numeric' => 'Số điện thoại phải là số.',
            'phone.digits_between' => 'Số điện thoại phải có 10-11 chữ số.',
            'phone.unique' => 'Số điện thoại đã được sử dụng.',
            'type.required' => 'Vui lòng chọn loại.',
            'type.in' => 'Loại không hợp lệ.',
            'salary.required' => 'Vui lòng nhập lương.',
            'salary.numeric' => 'Lương phải là số.',
            'salary.min' => 'Lương không được âm.',
            'password.required' => 'Vui lòng nhập mật khẩu.',
            'password.min' => 'Mật khẩu phải có ít nhất 8 ký tự.',
            'password.confirmed' => 'Mật khẩu xác nhận không khớp.',
            'image.required' => 'Vui lòng chọn ảnh.',
            'image.image' => 'File phải là ảnh.',
            'image.mimes' => 'Chỉ chấp nhận file ảnh định dạng JPG, JPEG hoặc PNG.',
            'image.max' => 'Kích thước file không được vượt quá 5MB.',
        ]);
     
     
        $uploadedfile=$req->file('image');
        $new_image=rand().'.'.$uploadedfile->getClientOriginalExtension();
        $uploadedfile->move(public_path('/assets/images/admin/'),$new_image);

        $data=array();
        $data['name']=$req->name;
        $data['email']=$req->email;
        $data['phone']=$req->phone;
        $data['usertype']=$req->type;
        $data['salary']=$req->salary;
        $data['profile_photo_path']=$new_image;
        $data['password']=Hash::make($req->password);


        if($req->type=='1')
        {


            $usertype="Super Admin";


        }
        else if($req->type=='3')
        {


            $usertype="Sub Admin";


        }
   


        $insert=DB::table('users')->Insert($data);


        $details = [
            'title' => 'Thông Báo Từ S-Cuốn',
            'body' => 'Chúc mừng ! Bạn đã được chọn làm '.$usertype.' ( Lương - '.number_format($req->salary * 1000, 0, ',', '.').' VNĐ ) của S-Cuốn bởi Bảng Điều Khiển Admin. Email của bạn - '.$req->email. ' & Mật khẩu - '.$req->password,
        ];


    
        Mail::to($req->email)->send(new \App\Mail\UserAddedMail($details));


        session()->flash('success','Admin added successfully !');
        return back();



    }

    public function delete_admin($id)
    {

        $my_id=NULL;

        if(Auth::user()->id==$id)
        {

            $my_id="yes";

        }

        $details = [
            'title' => 'Thông Báo Từ S-Cuốn',
            'body' => 'Xin lỗi ! Bạn đã bị sa thải khỏi công việc bởi Bảng Điều Khiển Admin S-Cuốn. Vì vậy, tài khoản của bạn đã bị xóa bởi Bảng Điều Khiển Admin S-Cuốn.',
        ];


    
        Mail::to(Auth::user()->email)->send(new \App\Mail\UserAddedMail($details));

        $delete=DB::table('users')->where('id',$id)->delete();


        if($my_id=="yes")
        {

            return redirect('/login');

        }


      


        session()->flash('success','Admin deleted successfully !');
        return back();




    }
    
    public function edit_admin($id)
    {

        $admin=DB::table('users')->where('id',$id)->get();


        return view('admin.edit_admin',compact('admin'));


    }
    public function edit_admin_process(Request $req,$id)
    {
        $previous_salary=DB::table('users')->where('id',$id)->value('salary');
        $previous_position=DB::table('users')->where('id',$id)->value('usertype');
        
        $validated = $req->validate([
            'name' => 'required|string|min:2|max:100',
            'email' => 'required|email|unique:users,email,'.$id.'|max:255',
            'phone' => 'required|numeric|digits_between:10,11|unique:users,phone,'.$id,
            'type' => 'required|in:1,3',
            'salary' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,jpg,png|max:5120',
        ], [
            'name.required' => 'Vui lòng nhập tên.',
            'name.min' => 'Tên phải có ít nhất 2 ký tự.',
            'name.max' => 'Tên không được vượt quá 100 ký tự.',
            'email.required' => 'Vui lòng nhập email.',
            'email.email' => 'Email không hợp lệ.',
            'email.unique' => 'Email đã được sử dụng.',
            'phone.required' => 'Vui lòng nhập số điện thoại.',
            'phone.numeric' => 'Số điện thoại phải là số.',
            'phone.digits_between' => 'Số điện thoại phải có 10-11 chữ số.',
            'phone.unique' => 'Số điện thoại đã được sử dụng.',
            'type.required' => 'Vui lòng chọn loại.',
            'type.in' => 'Loại không hợp lệ.',
            'salary.required' => 'Vui lòng nhập lương.',
            'salary.numeric' => 'Lương phải là số.',
            'salary.min' => 'Lương không được âm.',
            'image.image' => 'File phải là ảnh.',
            'image.mimes' => 'Chỉ chấp nhận file ảnh định dạng JPG, JPEG hoặc PNG.',
            'image.max' => 'Kích thước file không được vượt quá 5MB.',
        ]);

        $data=array();
        $data['name']=$req->name;
        $data['email']=$req->email;
        $data['phone']=$req->phone;
        $data['usertype']=$req->type;
        $data['salary']=$req->salary;
     

        if($req->image != NULL)
        {
         
         
            $uploadedfile=$req->file('image');
            $new_image=rand().'.'.$uploadedfile->getClientOriginalExtension();
            $uploadedfile->move(public_path('/assets/images/admin/'),$new_image);
            $data['profile_photo_path']=$new_image;


        }
        if($req->type=='1')
        {


            $usertype="Super Admin";


        }
        else if($req->type=='3')
        {


            $usertype="Sub Admin";


        }
   


        $update=DB::table('users')->where('id',$id)->Update($data);

        if($update)
        {
            $details = [
                'title' => 'Thông Báo Từ S-Cuốn',
                'body' => 'Chúc mừng ! Thông tin của bạn đã được cập nhật bởi Bảng Điều Khiển Admin S-Cuốn.',
            ];
    
    
            if(($req->salary != NULL && $req->salary > $previous_salary) || ($req->type !=NULL && $req->type < $previous_position))
            {
    
                
                $details = [
                    'title' => 'Thông Báo Từ S-Cuốn',
                    'body' => 'Chúc mừng ! Bạn đã được thăng chức lên vị trí '.$usertype.'. ( Hiện tại, Lương của bạn - '.number_format($req->salary * 1000, 0, ',', '.').' VNĐ ) của S-Cuốn bởi Bảng Điều Khiển Admin.',
                ];
    
    
            }
            else if(($req->salary != NULL && $req->salary < $previous_salary) || ($req->type !=NULL && $req->type > $previous_position))
            {
    
    
                $details = [
                    'title' => 'Thông Báo Từ S-Cuốn',
                    'body' => 'Xin lỗi ! Bạn đã bị giáng chức xuống vị trí '.$usertype.'. ( Hiện tại, Lương của bạn - '.number_format($req->salary * 1000, 0, ',', '.').' VNĐ ) của S-Cuốn bởi Bảng Điều Khiển Admin.',
                ];
    
    
            }
          
       
            Mail::to($req->email)->send(new \App\Mail\UserAddedMail($details));
    
    
            session()->flash('success','Admin updated successfully !');


        }
        else
        {

            session()->flash('wrong','Already same info exits !');

        }

     
        return back();




    }
    public function add_delivery_boy()
    {

        return view('admin.add_delivery_boy');



    }
    public function add_delivery_boy_process(Request $req)
    {
        $validated = $req->validate([
            'name' => 'required|string|min:2|max:100',
            'email' => 'required|email|unique:users,email|max:255',
            'phone' => 'required|numeric|digits_between:10,11|unique:users,phone',
            'salary' => 'required|numeric|min:0',
            'password' => 'required|string|min:8|confirmed',
            'image' => 'required|image|mimes:jpeg,jpg,png|max:5120',
        ], [
            'name.required' => 'Vui lòng nhập tên.',
            'name.min' => 'Tên phải có ít nhất 2 ký tự.',
            'name.max' => 'Tên không được vượt quá 100 ký tự.',
            'email.required' => 'Vui lòng nhập email.',
            'email.email' => 'Email không hợp lệ.',
            'email.unique' => 'Email đã được sử dụng.',
            'phone.required' => 'Vui lòng nhập số điện thoại.',
            'phone.numeric' => 'Số điện thoại phải là số.',
            'phone.digits_between' => 'Số điện thoại phải có 10-11 chữ số.',
            'phone.unique' => 'Số điện thoại đã được sử dụng.',
            'salary.required' => 'Vui lòng nhập lương.',
            'salary.numeric' => 'Lương phải là số.',
            'salary.min' => 'Lương không được âm.',
            'password.required' => 'Vui lòng nhập mật khẩu.',
            'password.min' => 'Mật khẩu phải có ít nhất 8 ký tự.',
            'password.confirmed' => 'Mật khẩu xác nhận không khớp.',
            'image.required' => 'Vui lòng chọn ảnh.',
            'image.image' => 'File phải là ảnh.',
            'image.mimes' => 'Chỉ chấp nhận file ảnh định dạng JPG, JPEG hoặc PNG.',
            'image.max' => 'Kích thước file không được vượt quá 5MB.',
        ]);
     
     
        $uploadedfile=$req->file('image');
        $new_image=rand().'.'.$uploadedfile->getClientOriginalExtension();
        $uploadedfile->move(public_path('/assets/images/admin/'),$new_image);

        $data=array();
        $data['name']=$req->name;
        $data['email']=$req->email;
        $data['phone']=$req->phone;
        $data['usertype']="2";
        $data['salary']=$req->salary;
        $data['profile_photo_path']=$new_image;
        $data['password']=Hash::make($req->password);


   


        $insert=DB::table('users')->Insert($data);


        $details = [
            'title' => 'Thông Báo Từ S-Cuốn',
            'body' => 'Chúc mừng ! Bạn đã được chọn làm Nhân Viên Giao Hàng ( Lương - '.number_format($req->salary * 1000, 0, ',', '.').' VNĐ ) của S-Cuốn bởi Bảng Điều Khiển Admin. Email của bạn - '.$req->email. ' & Mật khẩu - '.$req->password,
        ];


    
        Mail::to($req->email)->send(new \App\Mail\UserAddedMail($details));


        session()->flash('success','Delivery Boy added successfully !');
        return back();



    }
    public function delete_delivery_boy($id)
    {

    

        $details = [
            'title' => 'Thông Báo Từ S-Cuốn',
            'body' => 'Xin lỗi ! Bạn đã bị sa thải khỏi công việc bởi Bảng Điều Khiển Admin S-Cuốn. Vì vậy, tài khoản của bạn đã bị xóa bởi Bảng Điều Khiển Admin S-Cuốn.',
        ];


    
        Mail::to(Auth::user()->email)->send(new \App\Mail\UserAddedMail($details));

        $delete=DB::table('users')->where('id',$id)->delete();

        session()->flash('success','Delivery Boy deleted successfully !');
        return back();




    }
    public function edit_delivery_boy($id)
    {

        $delivery_boys=DB::table('users')->where('id',$id)->get();


        return view('admin.edit_delivery_boy',compact('delivery_boys'));


    }

    public function edit_delivery_boy_process(Request $req,$id)
    {
        $previous_salary=DB::table('users')->where('id',$id)->value('salary');
        
        $validated = $req->validate([
            'name' => 'required|string|min:2|max:100',
            'email' => 'required|email|unique:users,email,'.$id.'|max:255',
            'phone' => 'required|numeric|digits_between:10,11|unique:users,phone,'.$id,
            'salary' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,jpg,png|max:5120',
        ], [
            'name.required' => 'Vui lòng nhập tên.',
            'name.min' => 'Tên phải có ít nhất 2 ký tự.',
            'name.max' => 'Tên không được vượt quá 100 ký tự.',
            'email.required' => 'Vui lòng nhập email.',
            'email.email' => 'Email không hợp lệ.',
            'email.unique' => 'Email đã được sử dụng.',
            'phone.required' => 'Vui lòng nhập số điện thoại.',
            'phone.numeric' => 'Số điện thoại phải là số.',
            'phone.digits_between' => 'Số điện thoại phải có 10-11 chữ số.',
            'phone.unique' => 'Số điện thoại đã được sử dụng.',
            'salary.required' => 'Vui lòng nhập lương.',
            'salary.numeric' => 'Lương phải là số.',
            'salary.min' => 'Lương không được âm.',
            'image.image' => 'File phải là ảnh.',
            'image.mimes' => 'Chỉ chấp nhận file ảnh định dạng JPG, JPEG hoặc PNG.',
            'image.max' => 'Kích thước file không được vượt quá 5MB.',
        ]);

        $data=array();
        $data['name']=$req->name;
        $data['email']=$req->email;
        $data['phone']=$req->phone;
        $data['salary']=$req->salary;
     

        if($req->image != NULL)
        {
         
         
            $uploadedfile=$req->file('image');
            $new_image=rand().'.'.$uploadedfile->getClientOriginalExtension();
            $uploadedfile->move(public_path('/assets/images/admin/'),$new_image);
            $data['profile_photo_path']=$new_image;


        }
     
   


        $update=DB::table('users')->where('id',$id)->Update($data);

        if($update)
        {
            $details = [
                'title' => 'Thông Báo Từ S-Cuốn',
                'body' => 'Chúc mừng ! Thông tin của bạn đã được cập nhật bởi Bảng Điều Khiển Admin S-Cuốn.',
            ];
    
    
            if(($req->salary != NULL && $req->salary > $previous_salary))
            {
    
                
                $details = [
                    'title' => 'Thông Báo Từ S-Cuốn',
                    'body' => 'Chúc mừng ! Bạn đã được thăng chức lên vị trí Nhân Viên Giao Hàng. ( Hiện tại, Lương của bạn - '.number_format($req->salary * 1000, 0, ',', '.').' VNĐ ) của S-Cuốn bởi Bảng Điều Khiển Admin.',
                ];
    
    
            }
            else if(($req->salary != NULL && $req->salary < $previous_salary))
            {
    
    
                $details = [
                    'title' => 'Thông Báo Từ S-Cuốn',
                    'body' => 'Xin lỗi ! Bạn đã bị giáng chức xuống vị trí Nhân Viên Giao Hàng. ( Hiện tại, Lương của bạn - '.number_format($req->salary * 1000, 0, ',', '.').' VNĐ ) của S-Cuốn bởi Bảng Điều Khiển Admin.',
                ];
    
    
            }
          
       
            Mail::to($req->email)->send(new \App\Mail\UserAddedMail($details));
    
    
            session()->flash('success','Delivery Boy updated successfully !');


        }
        else
        {

            session()->flash('wrong','Already same info exits !');

        }

     
        return back();




    }
    public function banner_add_process(Request $req)
    {
        $validated = $req->validate([
            'image' => 'required|image|mimes:jpeg,jpg,png|max:5120',
        ], [
            'image.required' => 'Vui lòng chọn ảnh.',
            'image.image' => 'File phải là ảnh.',
            'image.mimes' => 'Chỉ chấp nhận file ảnh định dạng JPG, JPEG hoặc PNG.',
            'image.max' => 'Kích thước file không được vượt quá 5MB.',
        ]);

        $data=array();
     
     
        $uploadedfile=$req->file('image');
        $new_image=rand().'.'.$uploadedfile->getClientOriginalExtension();
        $uploadedfile->move(public_path('/assets/images/'),$new_image);
        $data['image']=$new_image;


        $upload=DB::table('banners')->Insert($data);

        session()->flash('success','Banner added successfully !');

        return back();





    }


    public function banner_edit($id)
    {


        $banner=DB::table('banners')->where('id',$id)->get();



        return view('admin.banner_edit',compact('banner'));


    }

    public function banner_edit_process($id,Request $req)
    {
        $validated = $req->validate([
            'image' => 'nullable|image|mimes:jpeg,jpg,png|max:5120',
        ], [
            'image.image' => 'File phải là ảnh.',
            'image.mimes' => 'Chỉ chấp nhận file ảnh định dạng JPG, JPEG hoặc PNG.',
            'image.max' => 'Kích thước file không được vượt quá 5MB.',
        ]);

        $data=array();
     
     
        $uploadedfile=$req->file('image');
        $new_image=rand().'.'.$uploadedfile->getClientOriginalExtension();
        $uploadedfile->move(public_path('/assets/images/'),$new_image);
        $data['image']=$new_image;


        $update=DB::table('banners')->where('id',$id)->Update($data);

        session()->flash('success','Banner  updated successfully !');

        return back();





    }
    public function banner_delete_process($id)
    {


        $delete=DB::table('banners')->where('id',$id)->delete();

        session()->flash('success','Banner deleted successfully !');

        return back();





    }
    public function add_coupon()
    {




        return view('admin.add_coupon');


    }
    public function add_coupon_process(Request $req)
    {
        $validated = $req->validate([
            'name' => 'required|string|min:2|max:100',
            'details' => 'required|string|min:5|max:500',
            'code' => 'required|string|min:3|max:20|regex:/^[A-Z0-9]+$/|unique:coupons,code',
            'discount_percentage' => 'required|numeric|min:0|max:100',
            'vaildation_date' => 'required|date|after:today',
        ], [
            'name.required' => 'Vui lòng nhập tên coupon.',
            'name.min' => 'Tên coupon phải có ít nhất 2 ký tự.',
            'name.max' => 'Tên coupon không được vượt quá 100 ký tự.',
            'details.required' => 'Vui lòng nhập chi tiết.',
            'details.min' => 'Chi tiết phải có ít nhất 5 ký tự.',
            'details.max' => 'Chi tiết không được vượt quá 500 ký tự.',
            'code.required' => 'Vui lòng nhập mã coupon.',
            'code.min' => 'Mã coupon phải có ít nhất 3 ký tự.',
            'code.max' => 'Mã coupon không được vượt quá 20 ký tự.',
            'code.regex' => 'Mã coupon chỉ được chứa chữ cái và số.',
            'code.unique' => 'Mã coupon đã tồn tại.',
            'discount_percentage.required' => 'Vui lòng nhập phần trăm giảm giá.',
            'discount_percentage.numeric' => 'Phần trăm giảm giá phải là số.',
            'discount_percentage.min' => 'Phần trăm giảm giá không được âm.',
            'discount_percentage.max' => 'Phần trăm giảm giá không được vượt quá 100%.',
            'vaildation_date.required' => 'Vui lòng chọn ngày hết hạn.',
            'vaildation_date.date' => 'Ngày hết hạn không hợp lệ.',
            'vaildation_date.after' => 'Ngày hết hạn phải sau ngày hiện tại.',
        ]);

        $data=array();
        $data['name']=$req->name;
        $data['details']=$req->details;
        $data['percentage']=$req->discount_percentage;
        $data['code']=strtoupper($req->code);
        $data['validate']=$req->vaildation_date;


        $load=DB::table('coupons')->Insert($data);



        session()->flash('success','Coupon added successfully !');

        return back();





    }
    public function delete_coupon($id)
    {


        $delete=DB::table('coupons')->where('id',$id)->delete();

        session()->flash('success','Coupon deleted successfully !');

        return back();





    }
    public function edit_coupon($id)
    {

        $coupon=DB::table('coupons')->where('id',$id)->get();



        return view('admin.edit_coupon',compact('coupon'));



    }


    public function edit_coupon_process($id,Request $req)
    {
        // Lấy ngày hết hạn hiện tại
        $currentValidateDate = DB::table('coupons')->where('id',$id)->value('validate');
        
        $validated = $req->validate([
            'name' => 'required|string|min:2|max:100',
            'details' => 'required|string|min:5|max:500',
            'code' => 'required|string|min:3|max:20|regex:/^[A-Z0-9]+$/|unique:coupons,code,'.$id,
            'discount_percentage' => 'required|numeric|min:0|max:100',
            'vaildation_date' => ['required', 'date', function ($attribute, $value, $fail) use ($currentValidateDate) {
                // Cho phép giữ nguyên ngày cũ hoặc chọn ngày mới sau hôm nay
                $selectedDate = new \DateTime($value);
                $today = new \DateTime();
                $today->setTime(0, 0, 0);
                $selectedDate->setTime(0, 0, 0);
                
                // Nếu ngày được chọn khác ngày hiện tại trong DB
                if ($currentValidateDate && $value !== $currentValidateDate) {
                    // Nếu chọn ngày mới, phải sau hôm nay
                    if ($selectedDate <= $today) {
                        $fail('Ngày hết hạn phải sau ngày hiện tại.');
                    }
                }
                // Nếu không có ngày hiện tại (trường hợp đặc biệt) và ngày chọn <= hôm nay
                elseif (!$currentValidateDate && $selectedDate <= $today) {
                    $fail('Ngày hết hạn phải sau ngày hiện tại.');
                }
            }],
        ], [
            'name.required' => 'Vui lòng nhập tên coupon.',
            'name.min' => 'Tên coupon phải có ít nhất 2 ký tự.',
            'name.max' => 'Tên coupon không được vượt quá 100 ký tự.',
            'details.required' => 'Vui lòng nhập chi tiết.',
            'details.min' => 'Chi tiết phải có ít nhất 5 ký tự.',
            'details.max' => 'Chi tiết không được vượt quá 500 ký tự.',
            'code.required' => 'Vui lòng nhập mã coupon.',
            'code.min' => 'Mã coupon phải có ít nhất 3 ký tự.',
            'code.max' => 'Mã coupon không được vượt quá 20 ký tự.',
            'code.regex' => 'Mã coupon chỉ được chứa chữ cái và số.',
            'code.unique' => 'Mã coupon đã tồn tại.',
            'discount_percentage.required' => 'Vui lòng nhập phần trăm giảm giá.',
            'discount_percentage.numeric' => 'Phần trăm giảm giá phải là số.',
            'discount_percentage.min' => 'Phần trăm giảm giá không được âm.',
            'discount_percentage.max' => 'Phần trăm giảm giá không được vượt quá 100%.',
            'vaildation_date.required' => 'Vui lòng chọn ngày hết hạn.',
            'vaildation_date.date' => 'Ngày hết hạn không hợp lệ.',
        ]);

        $data=array();
        $data['name']=$req->name;
        $data['details']=$req->details;
        $data['percentage']=$req->discount_percentage;
        $data['code']=strtoupper($req->code);
        $data['validate']=$req->vaildation_date;




        
        $load=DB::table('coupons')->where('id',$id)->Update($data);



        session()->flash('success','Coupon updated successfully !');

        return back();





    }
    public function add_charge()
    {




        return view('admin.add_charge');


    }
    public function add_charge_process(Request $req)
    {
        $validated = $req->validate([
            'name' => 'required|string|min:2|max:100',
            'price' => 'required|numeric|min:0',
        ], [
            'name.required' => 'Vui lòng nhập tên phí.',
            'name.min' => 'Tên phí phải có ít nhất 2 ký tự.',
            'name.max' => 'Tên phí không được vượt quá 100 ký tự.',
            'price.required' => 'Vui lòng nhập giá.',
            'price.numeric' => 'Giá phải là số.',
            'price.min' => 'Giá không được âm.',
        ]);

        $data=array();
        $data['name']=$req->name;
        $data['price']=$req->price;


        $load=DB::table('charges')->Insert($data);



        session()->flash('success','Charge added successfully !');

        return back();






    }


    public function delete_charge($id)
    {


        $delete=DB::table('charges')->where('id',$id)->delete();

        session()->flash('success','Charge deleted successfully !');

        return back();





    }
    public function edit_charge($id)
    {

        $charge=DB::table('charges')->where('id',$id)->get();



        return view('admin.edit_charge',compact('charge'));



    }

    public function edit_charge_process($id,Request $req)
    {
        $validated = $req->validate([
            'name' => 'required|string|min:2|max:100',
            'price' => 'required|numeric|min:0',
        ], [
            'name.required' => 'Vui lòng nhập tên phí.',
            'name.min' => 'Tên phí phải có ít nhất 2 ký tự.',
            'name.max' => 'Tên phí không được vượt quá 100 ký tự.',
            'price.required' => 'Vui lòng nhập giá.',
            'price.numeric' => 'Giá phải là số.',
            'price.min' => 'Giá không được âm.',
        ]);

        $data=array();
        $data['name']=$req->name;
        $data['price']=$req->price;


        $load=DB::table('charges')->where('id',$id)->Update($data);



        session()->flash('success','Charge updated successfully !');

        return back();






    }
    public function customize_edit()
    {

        $customize=DB::table('about_us')->get();

        return view('admin.customize_edit',compact('customize'));

    }

    public function edit_customize_process(Request $req)
    {

        $data=array();



        //return $req->description;


        $data['title']=$req->title;
        $data['description']=$req->description;
        $data['youtube_link']=$req->youtube_video_link;
     

        if($req->image1 != NULL)
        {

            $this->validate(request(),[

                'image1'=>'mimes:jpeg,jpg,png',
            ]);
         
         
            $uploadedfile=$req->file('image1');
            $new_image=rand().'.'.$uploadedfile->getClientOriginalExtension();
            $uploadedfile->move(public_path('/assets/images/'),$new_image);
            $data['image1']=$new_image;


        }
        
        if($req->image2 != NULL)
        {

            $this->validate(request(),[

                'image2'=>'mimes:jpeg,jpg,png',
            ]);
         
         
            $uploadedfile=$req->file('image2');
            $new_image2=rand().'.'.$uploadedfile->getClientOriginalExtension();
            $uploadedfile->move(public_path('/assets/images/'),$new_image2);
            $data['image2']=$new_image2;


        }
        
        if($req->image3 != NULL)
        {

            $this->validate(request(),[

                'image3'=>'mimes:jpeg,jpg,png',
            ]);
         
         
            $uploadedfile=$req->file('image3');
            $new_image3=rand().'.'.$uploadedfile->getClientOriginalExtension();
            $uploadedfile->move(public_path('/assets/images/'),$new_image3);
            $data['image3']=$new_image3;


        }
        
        if($req->image4 != NULL)
        {

            $this->validate(request(),[

                'image4'=>'mimes:jpeg,jpg,png',
            ]);
         
         
            $uploadedfile=$req->file('image4');
            $new_image4=rand().'.'.$uploadedfile->getClientOriginalExtension();
            $uploadedfile->move(public_path('/assets/images/'),$new_image4);
            $data['vd_image']=$new_image4;


        }
        
        // Xử lý upload video file
        if($req->video_file != NULL)
        {
            $this->validate(request(),[
                'video_file'=>'mimes:mp4,webm,ogg|max:51200', // Max 50MB
            ]);
         
            $uploadedfile=$req->file('video_file');
            $new_video=rand().'.'.$uploadedfile->getClientOriginalExtension();
            $uploadedfile->move(public_path('/assets/videos/'),$new_video);
            $data['video_file']=$new_video;
        }




        $load=DB::table('about_us')->Update($data);



        session()->flash('success','Customize updated successfully !');

        return back();






    }

    // ============================================
    // POST MANAGEMENT METHODS
    // ============================================

    /**
     * Danh sách bài viết (admin)
     */
    public function posts()
    {
        if(!Auth::user() || Auth::user()->usertype != '1') {
            return redirect('/');
        }

        $posts = DB::table('posts')
            ->join('users', 'posts.author_id', '=', 'users.id')
            ->select('posts.*', 'users.name as author_name')
            ->orderBy('posts.created_at', 'desc')
            ->get();

        return view('admin.posts', compact('posts'));
    }

    /**
     * Form thêm bài viết
     */
    public function add_post()
    {
        if(!Auth::user() || Auth::user()->usertype != '1') {
            return redirect('/');
        }

        return view('admin.add_post');
    }

    /**
     * Xử lý thêm bài viết
     */
    public function post_add_process(Request $req)
    {
        if(!Auth::user() || Auth::user()->usertype != '1') {
            return redirect('/');
        }

        try {
            $validated = $req->validate([
                'title' => 'required|string|min:5|max:255',
                'content' => 'required|string|min:50',
                'excerpt' => 'nullable|string|max:500',
                'category' => 'required|in:general,news,promotion,recipe',
                'status' => 'required|in:draft,published,archived',
                'featured_image' => 'nullable|image|mimes:jpeg,jpg,png|max:5120',
                'meta_title' => 'nullable|string|max:255',
                'meta_description' => 'nullable|string|max:500',
            ], [
                'title.required' => 'Vui lòng nhập tiêu đề bài viết.',
                'title.min' => 'Tiêu đề phải có ít nhất 5 ký tự.',
                'content.required' => 'Vui lòng nhập nội dung bài viết.',
                'content.min' => 'Nội dung phải có ít nhất 50 ký tự.',
                'category.required' => 'Vui lòng chọn danh mục.',
                'status.required' => 'Vui lòng chọn trạng thái.',
                'featured_image.image' => 'File phải là hình ảnh.',
                'featured_image.max' => 'Kích thước ảnh không được vượt quá 5MB.',
            ]);

            $data = [
                'title' => $req->title,
                'slug' => \Illuminate\Support\Str::slug($req->title),
                'content' => $req->input('content'),
                'excerpt' => $req->input('excerpt') ?? null,
                'category' => $req->category,
                'status' => $req->status,
                'author_id' => Auth::user()->id,
                'is_featured' => $req->has('is_featured') ? 1 : 0,
                'meta_title' => $req->meta_title ?? null,
                'meta_description' => $req->meta_description ?? null,
                'published_at' => $req->status == 'published' ? now() : null,
                'created_at' => now(),
                'updated_at' => now(),
            ];

            // Upload ảnh
            if($req->hasFile('featured_image')) {
                $uploadedfile = $req->file('featured_image');
                $new_image = rand().'.'.$uploadedfile->getClientOriginalExtension();
                $uploadedfile->move(public_path('/assets/images/'), $new_image);
                $data['featured_image'] = $new_image;
            }

            // Kiểm tra slug trùng lặp
            $slug_count = DB::table('posts')->where('slug', $data['slug'])->count();
            if($slug_count > 0) {
                $data['slug'] = $data['slug'] . '-' . time();
            }

            DB::table('posts')->insert($data);

            session()->flash('success', 'Bài viết đã được thêm thành công!');
            return redirect()->route('admin.posts');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->route('admin.posts.add')->withErrors($e->validator)->withInput();
        } catch (\Exception $e) {
            session()->flash('wrong', 'Có lỗi xảy ra: ' . $e->getMessage());
            return redirect()->route('admin.posts.add')->withInput();
        }
    }

    /**
     * Form sửa bài viết
     */
    public function post_edit($id)
    {
        if(!Auth::user() || Auth::user()->usertype != '1') {
            return redirect('/');
        }

        $post = DB::table('posts')->where('id', $id)->first();
        
        if(!$post) {
            session()->flash('wrong', 'Bài viết không tồn tại!');
            return redirect()->route('admin.posts');
        }

        return view('admin.edit_post', compact('post'));
    }

    /**
     * Xử lý sửa bài viết
     */
    public function post_edit_process(Request $req, $id)
    {
        if(!Auth::user() || Auth::user()->usertype != '1') {
            return redirect('/');
        }

        $validated = $req->validate([
            'title' => 'required|string|min:5|max:255',
            'content' => 'required|string|min:50',
            'excerpt' => 'nullable|string|max:500',
            'category' => 'required|in:general,news,promotion,recipe',
            'status' => 'required|in:draft,published,archived',
            'featured_image' => 'nullable|image|mimes:jpeg,jpg,png|max:5120',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
        ], [
            'title.required' => 'Vui lòng nhập tiêu đề bài viết.',
            'title.min' => 'Tiêu đề phải có ít nhất 5 ký tự.',
            'content.required' => 'Vui lòng nhập nội dung bài viết.',
            'content.min' => 'Nội dung phải có ít nhất 50 ký tự.',
            'category.required' => 'Vui lòng chọn danh mục.',
            'status.required' => 'Vui lòng chọn trạng thái.',
            'featured_image.image' => 'File phải là hình ảnh.',
            'featured_image.max' => 'Kích thước ảnh không được vượt quá 5MB.',
        ]);

        $post = DB::table('posts')->where('id', $id)->first();
        
        if(!$post) {
            session()->flash('wrong', 'Bài viết không tồn tại!');
            return redirect()->route('admin.posts');
        }

        $data = [
            'title' => $req->title,
            'slug' => \Illuminate\Support\Str::slug($req->title),
            'content' => $req->input('content'),
            'excerpt' => $req->input('excerpt') ?? null,
            'category' => $req->category,
            'status' => $req->status,
            'is_featured' => $req->has('is_featured') ? 1 : 0,
            'meta_title' => $req->meta_title ?? null,
            'meta_description' => $req->meta_description ?? null,
            'updated_at' => now(),
        ];

        // Cập nhật published_at nếu chuyển sang published
        if($req->status == 'published' && $post->status != 'published') {
            $data['published_at'] = now();
        }

        // Kiểm tra slug trùng lặp (trừ chính nó)
        $slug_count = DB::table('posts')
            ->where('slug', $data['slug'])
            ->where('id', '!=', $id)
            ->count();
        if($slug_count > 0) {
            $data['slug'] = $data['slug'] . '-' . time();
        }

        // Upload ảnh mới nếu có
        if($req->hasFile('featured_image')) {
            // Xóa ảnh cũ nếu có
            if($post->featured_image && file_exists(public_path('/assets/images/'.$post->featured_image))) {
                unlink(public_path('/assets/images/'.$post->featured_image));
            }

            $uploadedfile = $req->file('featured_image');
            $new_image = rand().'.'.$uploadedfile->getClientOriginalExtension();
            $uploadedfile->move(public_path('/assets/images/'), $new_image);
            $data['featured_image'] = $new_image;
        }

        DB::table('posts')->where('id', $id)->update($data);

        session()->flash('success', 'Bài viết đã được cập nhật thành công!');
        return redirect()->route('admin.posts');
    }

    /**
     * Xóa bài viết
     */
    public function post_delete($id)
    {
        if(!Auth::user() || Auth::user()->usertype != '1') {
            return redirect('/');
        }

        $post = DB::table('posts')->where('id', $id)->first();
        
        if(!$post) {
            session()->flash('wrong', 'Bài viết không tồn tại!');
            return back();
        }

        // Xóa ảnh nếu có
        if($post->featured_image && file_exists(public_path('/assets/images/'.$post->featured_image))) {
            unlink(public_path('/assets/images/'.$post->featured_image));
        }

        DB::table('posts')->where('id', $id)->delete();

        session()->flash('success', 'Bài viết đã được xóa thành công!');
        return back();
    }

    /**
     * Đổi trạng thái bài viết
     */
    public function post_change_status(Request $req, $id)
    {
        if(!Auth::user() || Auth::user()->usertype != '1') {
            return redirect('/');
        }

        $post = DB::table('posts')->where('id', $id)->first();
        
        if(!$post) {
            return response()->json(['success' => false, 'message' => 'Bài viết không tồn tại!']);
        }

        $status = $req->status;
        $data = ['status' => $status];

        if($status == 'published' && $post->status != 'published') {
            $data['published_at'] = now();
        }

        DB::table('posts')->where('id', $id)->update($data);

        return response()->json(['success' => true, 'message' => 'Trạng thái đã được cập nhật!']);
    }

    /**
     * Đánh dấu nổi bật/không nổi bật
     */
    public function post_toggle_featured($id)
    {
        if(!Auth::user() || Auth::user()->usertype != '1') {
            return redirect('/');
        }

        $post = DB::table('posts')->where('id', $id)->first();
        
        if(!$post) {
            return response()->json(['success' => false, 'message' => 'Bài viết không tồn tại!']);
        }

        $new_featured = $post->is_featured == 1 ? 0 : 1;
        DB::table('posts')->where('id', $id)->update(['is_featured' => $new_featured]);

        $message = $new_featured == 1 ? 'Đã đánh dấu nổi bật!' : 'Đã bỏ đánh dấu nổi bật!';
        return response()->json(['success' => true, 'message' => $message, 'is_featured' => $new_featured]);
    }


}
