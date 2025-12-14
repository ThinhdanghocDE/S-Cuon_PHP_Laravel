<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class MenuController extends Controller
{

    
    public function menu(){
        return view('menu');
    }

    public function getProducts(Request $request){
        $perPage = $request->get('per_page', 12);
        $page = $request->get('page', 1);
        $category = $request->get('category', ''); // session: 0, 1, 2 hoặc '' (tất cả)
        $priceMin = $request->get('price_min', '');
        $priceMax = $request->get('price_max', '');
        $search = $request->get('search', '');

        $query = Product::query();

        // Lọc theo category (session)
        if ($category !== '') {
            $query->where('session', $category);
        }

        // Lọc theo giá
        if ($priceMin !== '') {
            $query->where('price', '>=', $priceMin);
        }
        if ($priceMax !== '') {
            $query->where('price', '<=', $priceMax);
        }

        // Tìm kiếm theo tên
        if ($search !== '') {
            $query->where('name', 'like', '%' . $search . '%');
        }

        $products = $query->paginate($perPage, ['*'], 'page', $page);

        // Tính rating cho tất cả sản phẩm trong một query (tránh N+1 problem)
        if ($products->count() > 0) {
            $productIds = $products->pluck('id')->toArray();
            
            $ratings = DB::table('rates')
                ->whereIn('product_id', $productIds)
                ->select('product_id', DB::raw('SUM(star_value) as total_rate'), DB::raw('COUNT(*) as total_voter'))
                ->groupBy('product_id')
                ->get()
                ->keyBy('product_id');
            
            // Map ratings vào products
            foreach ($products as $product) {
                $rating = $ratings->get($product->id);
                
                if ($rating && $rating->total_voter > 0) {
                    $per_rate = $rating->total_rate / $rating->total_voter;
                } else {
                    $per_rate = 0;
                }
                
                $product->rating = number_format($per_rate, 1);
                $product->whole_stars = floor($product->rating);
                $product->has_half_star = ($product->rating - $product->whole_stars) > 0;
            }
        }

        if ($request->ajax()) {
            return response()->json([
                'html' => view('partials.menu_cards', compact('products'))->render(),
                'pagination' => view('partials.menu_pagination', compact('products'))->render(),
                'current_page' => $products->currentPage(),
                'last_page' => $products->lastPage(),
                'total' => $products->total(),
                'per_page' => $products->perPage()
            ]);
        }

        return view('menu', compact('products'));
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::findOrFail($id);
        
        // Tính rating từ bảng rates
        $total_rate = DB::table('rates')->where('product_id', $product->id)->sum('star_value');
        $total_voter = DB::table('rates')->where('product_id', $product->id)->count();
        
        if($total_voter > 0) {
            $per_rate = $total_rate / $total_voter;
        } else {
            $per_rate = 0;
        }
        
        $product->rating = number_format($per_rate, 1);
        $product->whole_stars = floor($product->rating);
        $product->has_half_star = ($product->rating - $product->whole_stars) > 0;
        $product->total_voter = $total_voter;
        
        // Tính rating statistics (số lượng đánh giá theo từng sao)
        $rating_stats = [];
        $rating_percentages = [];
        for($i = 5; $i >= 1; $i--) {
            $count = DB::table('rates')->where('product_id', $product->id)->where('star_value', $i)->count();
            $rating_stats[$i] = $count;
            $rating_percentages[$i] = $total_voter > 0 ? ($count / $total_voter * 100) : 0;
        }
        
        // Lấy comments với thông tin user từ bảng rates (có cột comment)
        $comments = DB::table('rates')
            ->join('users', 'rates.user_id', '=', 'users.id')
            ->where('rates.product_id', $product->id)
            ->whereNotNull('rates.comment')
            ->select('rates.id', 'rates.user_id', 'rates.product_id', 'rates.comment', 'rates.star_value as rating', 'rates.created_at', 'rates.updated_at', 'users.name as user_name')
            ->orderBy('rates.created_at', 'desc')
            ->get();
        
        return view('product_detail', compact('product', 'rating_stats', 'rating_percentages', 'comments'));
    }
    
    public function storeComment(Request $request, $id)
    {
        if(!Auth::user()) {
            return redirect()->route('login');
        }
        
        $request->validate([
            'comment' => 'required|string|min:10|max:1000',
            'rating' => 'required|integer|min:1|max:5',
        ], [
            'comment.required' => 'Vui lòng nhập bình luận.',
            'comment.min' => 'Bình luận phải có ít nhất 10 ký tự.',
            'comment.max' => 'Bình luận không được vượt quá 1000 ký tự.',
            'rating.required' => 'Vui lòng chọn số sao đánh giá.',
            'rating.min' => 'Số sao phải từ 1 đến 5.',
            'rating.max' => 'Số sao phải từ 1 đến 5.',
        ]);
        
        // Lưu rating và comment vào bảng rates (nếu chưa có thì thêm, có rồi thì cập nhật)
        $existing_rate = DB::table('rates')
            ->where('user_id', Auth::user()->id)
            ->where('product_id', $id)
            ->first();
            
        if($existing_rate) {
            // Cập nhật rating và comment
            DB::table('rates')
                ->where('user_id', Auth::user()->id)
                ->where('product_id', $id)
                ->update([
                    'star_value' => $request->rating,
                    'comment' => $request->comment,
                    'updated_at' => now()
                ]);
        } else {
            // Thêm mới rating và comment
            DB::table('rates')->insert([
                'user_id' => Auth::user()->id,
                'product_id' => $id,
                'star_value' => $request->rating,
                'comment' => $request->comment,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
        
        return redirect()->back()->with('success', 'Đánh giá của bạn đã được gửi thành công!');
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
}
