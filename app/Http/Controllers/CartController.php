<?php

namespace App\Http\Controllers;
use App\Models\Product;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    
    
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Guest: dùng session cart (không cần đăng nhập)
        if(!Auth::user())
        {
            $guestCart = Session::get('guest_cart', []);
            $carts = collect($guestCart)->map(function ($item) {
                return (object) $item;
            });
            $carts_amount = $carts->count();

            $subtotalSum = $carts->sum('subtotal');
            $without_discount_price = $subtotalSum;
            $discount_price = 0;

            // Coupon cho guest (lưu trong session)
            $coupon_id = Session::get('guest_coupon_id');
            if ($coupon_id) {
                $coupon_code = DB::table('coupons')->where('id', $coupon_id)->value('code');
                $validate = DB::table('coupons')->where('id', $coupon_id)->value('validate');
                $today = date("Y-m-d");
                if ($validate && $validate >= $today) {
                    $percentage = (int) floor(DB::table('coupons')->where('id', $coupon_id)->value('percentage'));
                    $discount_price = floor(($subtotalSum * $percentage) / 100);
                } else {
                    // coupon hết hạn thì bỏ
                    Session::forget('guest_coupon_id');
                }
            }

            $total_price = $subtotalSum - $discount_price;

            $extra_charge=DB::table('charges')->get();
            $total_extra_charge=DB::table('charges')->sum('price');

            return view("cart", compact('carts','total_price','discount_price','without_discount_price','extra_charge','total_extra_charge'));
        }

        // Logged-in: dùng DB carts như cũ
        $carts = Cart::all()->where('user_id',Auth::user()->id)->where('product_order','no');
        $carts_amount = DB::table('carts')->where('user_id',Auth::user()->id)->where('product_order','no')->count();
        $discount_price=0;
        $without_discount_price = DB::table('carts')->where('user_id',Auth::user()->id)->where('product_order','no')->sum('subtotal');

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


            $validate=DB::table('coupons')->where('code',$coupon_code)->value('validate');

            $today=date("Y-m-d");
    
            if($validate < $today)
            {
    

                $total_price = DB::table('carts')->where('user_id',Auth::user()->id)->where('product_order','no')->sum('subtotal');

    
    
    
            }
            else
            {

                $total_price = DB::table('carts')->where('user_id',Auth::user()->id)->where('product_order','no')->sum('subtotal');

            
                $coupon_code_price=DB::table('coupons')->where('code',$coupon_code)->value('percentage');
    
                $discount_price=(($total_price*$coupon_code_price)/100);
                $discount_price=floor($discount_price);
    
    
                $total_price = $total_price - $discount_price;



            }



          


         }
         else
         {

            $total_price = DB::table('carts')->where('user_id',Auth::user()->id)->where('product_order','no')->sum('subtotal');


         }
         $extra_charge=DB::table('charges')->get();
         $total_extra_charge=DB::table('charges')->sum('price');


       
        return view("cart", compact('carts','total_price','discount_price','without_discount_price','extra_charge','total_extra_charge'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $id)
    {

        // Guest: lưu giỏ vào session
        if(!Auth::user())
        {
            // Nếu trước đó vừa đặt hàng xong, bắt đầu đơn mới thì clear trạng thái cũ
            if (Session::has('order_success') || Session::has('invoice')) {
                Session::forget('order_success');
                Session::forget('invoice');
                Session::forget('total');
                Session::forget('extra_charge');
                Session::forget('discount_price');
                Session::forget('without_discount_price');
                Session::forget('date');
            }

            $product = Product::find($id);
            if(!$product) {
                return back()->with('wrong', 'Sản phẩm không tồn tại!');
            }

            $quantity = (int) ($request->number ?? 1);
            if ($quantity < 1) $quantity = 1;

            $guestCart = Session::get('guest_cart', []);
            $key = (string) $product->id;

            if (isset($guestCart[$key])) {
                $guestCart[$key]['quantity'] = (int) $guestCart[$key]['quantity'] + $quantity;
                $guestCart[$key]['subtotal'] = $guestCart[$key]['quantity'] * $guestCart[$key]['price'];
            } else {
                $guestCart[$key] = [
                    'product_id' => $product->id,
                    'name' => $product->name,
                    'price' => $product->price,
                    'quantity' => $quantity,
                    'subtotal' => $quantity * $product->price,
                ];
            }

            Session::put('guest_cart', $guestCart);
            return back()->with('cart_success', 'Đã thêm sản phẩm vào giỏ hàng thành công!');
        }
        
        $product = Product::find($id);
        $quantity = $request->number;
        if (Cart::where('product_id', '=', $id)->where('user_id',Auth::user()->id)->where('product_order','no')->exists()) {
            $quant = DB::table('carts')->where('product_id', '=', $id)->where('user_id',Auth::user()->id)->where('product_order','no')->value('quantity');
            
          
            $quantity = $quantity + (int) $quant;

            DB::table('carts')->where('product_id', '=', $id)->where('user_id',Auth::user()->id)->where('product_order','no')->update([
                'quantity' => $quantity,
                'subtotal' => $quantity*$product->price
            ]);
            return back()->with('cart_success', 'Đã cập nhật số lượng sản phẩm trong giỏ hàng!');
        }else{
            DB::table('carts')->insert([
                'product_id' => $product->id, 
                'user_id'=> Auth::user()->id,   
                'product_order' => "no",
                'shipping_address' => 'N/A',
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => $quantity,
                'subtotal' => $quantity*$product->price
            ]);
        }

        return back()->with('cart_success', 'Đã thêm sản phẩm vào giỏ hàng thành công!');

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
        // Guest: xóa theo product_id trong session cart
        if(!Auth::user())
        {
            $guestCart = Session::get('guest_cart', []);
            $key = (string) $id;
            unset($guestCart[$key]);
            Session::put('guest_cart', $guestCart);
            return redirect()->route('cart');
        }

        $product = Cart::find($id);
        if ($product) {
            $product->delete();
        }

        return redirect()->route('cart');
    }




    public function checkout($total)
    {
        return view("checkout", compact('total'));
    }
}
