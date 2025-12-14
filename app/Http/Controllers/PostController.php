<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Post;

class PostController extends Controller
{
    /**
     * Hiển thị danh sách bài viết (client side)
     */
    public function index(Request $request)
    {
        $query = DB::table('posts')
            ->join('users', 'posts.author_id', '=', 'users.id')
            ->select('posts.*', 'users.name as author_name')
            ->where('posts.status', 'published')
            ->where(function($q) {
                $q->whereNull('posts.published_at')
                  ->orWhere('posts.published_at', '<=', now());
            });

        // Filter theo category
        if($request->has('category') && $request->category) {
            $query->where('posts.category', $request->category);
        }

        // Tìm kiếm
        if($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('posts.title', 'like', '%'.$search.'%')
                  ->orWhere('posts.content', 'like', '%'.$search.'%')
                  ->orWhere('posts.excerpt', 'like', '%'.$search.'%');
            });
        }

        $posts = $query->orderBy('posts.published_at', 'desc')
                       ->orderBy('posts.created_at', 'desc')
                       ->paginate(12);

        // Lấy danh sách categories
        $categories = DB::table('posts')
            ->where('status', 'published')
            ->select('category')
            ->distinct()
            ->pluck('category');

        return view('posts', compact('posts', 'categories'));
    }

    /**
     * Hiển thị chi tiết bài viết
     */
    public function show($slug)
    {
        $post = DB::table('posts')
            ->join('users', 'posts.author_id', '=', 'users.id')
            ->select('posts.*', 'users.name as author_name')
            ->where('posts.slug', $slug)
            ->where('posts.status', 'published')
            ->where(function($q) {
                $q->whereNull('posts.published_at')
                  ->orWhere('posts.published_at', '<=', now());
            })
            ->first();

        if(!$post) {
            abort(404, 'Bài viết không tồn tại');
        }

        // Tăng lượt xem
        DB::table('posts')->where('id', $post->id)->increment('views');

        // Bài viết liên quan (cùng category)
        $related_posts = DB::table('posts')
            ->where('category', $post->category)
            ->where('id', '!=', $post->id)
            ->where('status', 'published')
            ->where(function($q) {
                $q->whereNull('published_at')
                  ->orWhere('published_at', '<=', now());
            })
            ->orderBy('published_at', 'desc')
            ->limit(4)
            ->get();

        // Bài viết nổi bật
        $featured_posts = DB::table('posts')
            ->where('is_featured', 1)
            ->where('status', 'published')
            ->where('id', '!=', $post->id)
            ->where(function($q) {
                $q->whereNull('published_at')
                  ->orWhere('published_at', '<=', now());
            })
            ->orderBy('published_at', 'desc')
            ->limit(3)
            ->get();

        return view('post_detail', compact('post', 'related_posts', 'featured_posts'));
    }

    /**
     * Lọc bài viết theo category
     */
    public function category($category)
    {
        $posts = DB::table('posts')
            ->join('users', 'posts.author_id', '=', 'users.id')
            ->select('posts.*', 'users.name as author_name')
            ->where('posts.status', 'published')
            ->where('posts.category', $category)
            ->where(function($q) {
                $q->whereNull('posts.published_at')
                  ->orWhere('posts.published_at', '<=', now());
            })
            ->orderBy('posts.published_at', 'desc')
            ->orderBy('posts.created_at', 'desc')
            ->paginate(12);

        $categories = DB::table('posts')
            ->where('status', 'published')
            ->select('category')
            ->distinct()
            ->pluck('category');

        return view('posts', compact('posts', 'categories'));
    }
}

