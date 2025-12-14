@extends('layout', ['title'=> 'Bài Viết'])

@section('page-content')

<style>
@import url('https://fonts.googleapis.com/css2?family=Dancing+Script:wght@400;500;600;700&family=Inter:wght@300;400;500;600;700;800;900&display=swap');

.posts-page {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    min-height: calc(100vh - 200px);
    padding: 60px 0;
    margin-top: 80px;
    font-family: 'Inter', sans-serif;
}

.posts-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
}

.posts-header {
    text-align: center;
    margin-bottom: 50px;
}

.posts-header h1 {
    font-family: 'Dancing Script', cursive;
    font-size: 4rem;
    font-weight: 700;
    margin-bottom: 15px;
    background: linear-gradient(135deg, #fb5849 0%, #d15400 30%, #ff6b5a 60%, #fb5849 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    letter-spacing: 2px;
}

.posts-header p {
    font-size: 1.2rem;
    color: #666;
    font-style: italic;
}

.posts-filters {
    background: white;
    padding: 25px;
    border-radius: 15px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    margin-bottom: 40px;
}

.filter-row {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
    align-items: flex-end;
}

.filter-group {
    flex: 1;
    min-width: 200px;
}

.filter-group label {
    display: block;
    font-weight: 600;
    margin-bottom: 8px;
    color: #2a2a2a;
    font-size: 0.9rem;
}

.filter-group input,
.filter-group select {
    width: 100%;
    padding: 10px 15px;
    border: 2px solid #e0e0e0;
    border-radius: 8px;
    font-size: 0.95rem;
    transition: border-color 0.3s ease;
}

.filter-group input:focus,
.filter-group select:focus {
    outline: none;
    border-color: #fb5849;
}

.btn-filter {
    padding: 10px 25px;
    background: linear-gradient(135deg, #fb5849 0%, #d15400 100%);
    color: white;
    border: none;
    border-radius: 8px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
}

.btn-filter:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(251, 88, 73, 0.4);
}

.posts-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
    gap: 30px;
    margin-bottom: 40px;
}

.post-card {
    background: white;
    border-radius: 15px;
    overflow: hidden;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    transition: all 0.3s ease;
    cursor: pointer;
    text-decoration: none;
    color: inherit;
    display: block;
}

.post-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.15);
    text-decoration: none;
    color: inherit;
}

.post-card-image {
    width: 100%;
    height: 220px;
    overflow: hidden;
    background: #f0f0f0;
}

.post-card-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.post-card:hover .post-card-image img {
    transform: scale(1.05);
}

.post-card-content {
    padding: 25px;
}

.post-card-category {
    display: inline-block;
    padding: 5px 12px;
    background: #fb5849;
    color: white;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 600;
    margin-bottom: 12px;
    text-transform: uppercase;
}

.post-card-title {
    font-size: 1.3rem;
    font-weight: 700;
    margin-bottom: 10px;
    color: #2a2a2a;
    line-height: 1.4;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.post-card-excerpt {
    font-size: 0.95rem;
    color: #666;
    line-height: 1.6;
    margin-bottom: 15px;
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.post-card-meta {
    display: flex;
    justify-content: space-between;
    align-items: center;
    font-size: 0.85rem;
    color: #999;
    padding-top: 15px;
    border-top: 1px solid #e0e0e0;
}

.post-card-date {
    display: flex;
    align-items: center;
    gap: 5px;
}

.post-card-views {
    display: flex;
    align-items: center;
    gap: 5px;
}

.no-posts {
    text-align: center;
    padding: 60px 20px;
    background: white;
    border-radius: 15px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
}

.no-posts h3 {
    font-size: 1.5rem;
    color: #666;
    margin-bottom: 10px;
}

.no-posts p {
    color: #999;
}

.pagination-wrapper {
    display: flex;
    justify-content: center;
    margin-top: 40px;
}

.pagination {
    display: flex;
    gap: 10px;
    list-style: none;
    padding: 0;
}

.pagination li {
    display: inline-block;
}

.pagination a,
.pagination span {
    display: block;
    padding: 10px 15px;
    background: white;
    color: #fb5849;
    border-radius: 8px;
    text-decoration: none;
    font-weight: 600;
    transition: all 0.3s ease;
    border: 2px solid #e0e0e0;
}

.pagination a:hover {
    background: #fb5849;
    color: white;
    border-color: #fb5849;
}

.pagination .active span {
    background: #fb5849;
    color: white;
    border-color: #fb5849;
}

@media (max-width: 768px) {
    .posts-grid {
        grid-template-columns: 1fr;
    }
    
    .filter-row {
        flex-direction: column;
    }
    
    .posts-header h1 {
        font-size: 2.5rem;
    }
}
</style>

<div class="posts-page">
    <div class="posts-container">
        <div class="posts-header">
            <h1>Bài Viết</h1>
            <p>Khám phá những câu chuyện và tin tức từ S-Cuốn</p>
        </div>

        <form method="GET" action="{{ route('posts.index') }}" class="posts-filters">
            <div class="filter-row">
                <div class="filter-group">
                    <label for="search">Tìm kiếm:</label>
                    <input type="text" name="search" id="search" value="{{ request('search') }}" placeholder="Nhập từ khóa...">
                </div>
                
                <div class="filter-group">
                    <label for="category">Danh mục:</label>
                    <select name="category" id="category">
                        <option value="">Tất cả</option>
                        <option value="general" {{ request('category') == 'general' ? 'selected' : '' }}>Tổng hợp</option>
                        <option value="news" {{ request('category') == 'news' ? 'selected' : '' }}>Tin tức</option>
                        <option value="promotion" {{ request('category') == 'promotion' ? 'selected' : '' }}>Khuyến mãi</option>
                        <option value="recipe" {{ request('category') == 'recipe' ? 'selected' : '' }}>Công thức</option>
                    </select>
                </div>

                <div class="filter-group">
                    <button type="submit" class="btn-filter">Tìm kiếm</button>
                </div>
            </div>
        </form>

        @if($posts->count() > 0)
            <div class="posts-grid">
                @foreach($posts as $post)
                    <a href="{{ route('posts.show', $post->slug) }}" class="post-card">
                        <div class="post-card-image">
                            @if($post->featured_image)
                                <img src="{{ asset('assets/images/'.$post->featured_image) }}" alt="{{ $post->title }}">
                            @else
                                <div style="width: 100%; height: 100%; background: linear-gradient(135deg, #fb5849 0%, #d15400 100%); display: flex; align-items: center; justify-content: center; color: white; font-size: 3rem;">
                                    <i class="fa fa-file-text"></i>
                                </div>
                            @endif
                        </div>
                        <div class="post-card-content">
                            <span class="post-card-category">
                                @if($post->category == 'general')
                                    Tổng hợp
                                @elseif($post->category == 'news')
                                    Tin tức
                                @elseif($post->category == 'promotion')
                                    Khuyến mãi
                                @elseif($post->category == 'recipe')
                                    Công thức
                                @endif
                            </span>
                            <h3 class="post-card-title">{{ $post->title }}</h3>
                            @if($post->excerpt)
                                <p class="post-card-excerpt">{{ $post->excerpt }}</p>
                            @endif
                            <div class="post-card-meta">
                                <span class="post-card-date">
                                    <i class="fa fa-calendar"></i>
                                    {{ date('d/m/Y', strtotime($post->published_at ?? $post->created_at)) }}
                                </span>
                                <span class="post-card-views">
                                    <i class="fa fa-eye"></i>
                                    {{ number_format($post->views, 0, ',', '.') }}
                                </span>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>

            <div class="pagination-wrapper">
                {{ $posts->links() }}
            </div>
        @else
            <div class="no-posts">
                <h3>Không tìm thấy bài viết nào</h3>
                <p>Vui lòng thử lại với từ khóa hoặc danh mục khác</p>
            </div>
        @endif
    </div>
</div>

@endsection

