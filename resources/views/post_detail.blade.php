@extends('layout', ['title'=> $post->title])

@section('page-content')

<style>
@import url('https://fonts.googleapis.com/css2?family=Dancing+Script:wght@400;500;600;700&family=Inter:wght@300;400;500;600;700;800;900&display=swap');

.post-detail-page {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    min-height: calc(100vh - 200px);
    padding: 60px 0;
    margin-top: 80px;
    font-family: 'Inter', sans-serif;
}

.post-detail-container {
    max-width: 1000px;
    margin: 0 auto;
    padding: 0 20px;
}

.post-header {
    background: white;
    border-radius: 20px;
    padding: 40px;
    margin-bottom: 30px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.1);
}

.post-category-badge {
    display: inline-block;
    padding: 8px 16px;
    background: linear-gradient(135deg, #fb5849 0%, #d15400 100%);
    color: white;
    border-radius: 20px;
    font-size: 0.85rem;
    font-weight: 600;
    margin-bottom: 20px;
    text-transform: uppercase;
}

.post-title {
    font-family: 'Dancing Script', cursive;
    font-size: 3rem;
    font-weight: 700;
    margin-bottom: 20px;
    color: #2a2a2a;
    line-height: 1.2;
}

.post-meta {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
    padding: 15px 0;
    border-top: 1px solid #e0e0e0;
    border-bottom: 1px solid #e0e0e0;
    margin: 20px 0;
    font-size: 0.9rem;
    color: #666;
}

.post-meta-item {
    display: flex;
    align-items: center;
    gap: 8px;
}

.post-featured-image {
    width: 100%;
    max-height: 500px;
    object-fit: cover;
    border-radius: 15px;
    margin: 30px 0;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
}

.post-content {
    background: white;
    border-radius: 20px;
    padding: 40px;
    margin-bottom: 30px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.1);
}

.post-content-body {
    font-size: 1.1rem;
    line-height: 1.8;
    color: #333;
}

.post-content-body p {
    margin-bottom: 20px;
}

.post-content-body img {
    max-width: 100%;
    height: auto;
    border-radius: 10px;
    margin: 20px 0;
}

.related-posts {
    background: white;
    border-radius: 20px;
    padding: 40px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.1);
}

.related-posts-title {
    font-family: 'Dancing Script', cursive;
    font-size: 2.5rem;
    font-weight: 700;
    margin-bottom: 30px;
    color: #2a2a2a;
    text-align: center;
}

.related-posts-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
    gap: 20px;
}

.related-post-card {
    background: #f8f9fa;
    border-radius: 10px;
    overflow: hidden;
    transition: all 0.3s ease;
    text-decoration: none;
    color: inherit;
    display: block;
}

.related-post-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    text-decoration: none;
    color: inherit;
}

.related-post-image {
    width: 100%;
    height: 150px;
    object-fit: cover;
}

.related-post-content {
    padding: 15px;
}

.related-post-title {
    font-size: 1rem;
    font-weight: 600;
    margin-bottom: 8px;
    color: #2a2a2a;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.related-post-date {
    font-size: 0.85rem;
    color: #999;
}

.share-buttons {
    display: flex;
    gap: 10px;
    margin-top: 30px;
    padding-top: 30px;
    border-top: 1px solid #e0e0e0;
}

.share-button {
    padding: 10px 20px;
    border-radius: 8px;
    color: white;
    text-decoration: none;
    font-weight: 600;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    gap: 8px;
}

.share-button:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.2);
    text-decoration: none;
    color: white;
}

.share-facebook {
    background: #1877f2;
}

.share-zalo {
    background: #0068ff;
}

@media (max-width: 768px) {
    .post-title {
        font-size: 2rem;
    }
    
    .related-posts-grid {
        grid-template-columns: 1fr;
    }
}
</style>

<div class="post-detail-page">
    <div class="post-detail-container">
        <!-- Post Header -->
        <div class="post-header">
            <span class="post-category-badge">
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
            <h1 class="post-title">{{ $post->title }}</h1>
            
            <div class="post-meta">
                <div class="post-meta-item">
                    <i class="fa fa-user"></i>
                    <span>{{ $post->author_name }}</span>
                </div>
                <div class="post-meta-item">
                    <i class="fa fa-calendar"></i>
                    <span>{{ date('d/m/Y H:i', strtotime($post->published_at ?? $post->created_at)) }}</span>
                </div>
                <div class="post-meta-item">
                    <i class="fa fa-eye"></i>
                    <span>{{ number_format($post->views, 0, ',', '.') }} lượt xem</span>
                </div>
            </div>

            @if($post->featured_image)
                <img src="{{ asset('assets/images/'.$post->featured_image) }}" alt="{{ $post->title }}" class="post-featured-image">
            @endif
        </div>

        <!-- Post Content -->
        <div class="post-content">
            @if($post->excerpt)
                <div style="background: #fff3e0; padding: 20px; border-radius: 10px; border-left: 4px solid #fb5849; margin-bottom: 30px;">
                    <p style="font-size: 1.1rem; font-style: italic; color: #e65100; margin: 0;">{{ $post->excerpt }}</p>
                </div>
            @endif

            <div class="post-content-body">
                {!! nl2br(e($post->content)) !!}
            </div>

            <div class="share-buttons">
                <span style="font-weight: 600; margin-right: 10px;">Chia sẻ:</span>
                <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" 
                   target="_blank" 
                   class="share-button share-facebook">
                    <i class="fa fa-facebook"></i> Facebook
                </a>
                <a href="https://zalo.me/share?url={{ urlencode(url()->current()) }}" 
                   target="_blank" 
                   class="share-button share-zalo">
                    <i class="fa fa-share"></i> Zalo
                </a>
            </div>
        </div>

        <!-- Related Posts -->
        @if($related_posts && $related_posts->count() > 0)
            <div class="related-posts">
                <h2 class="related-posts-title">Bài Viết Liên Quan</h2>
                <div class="related-posts-grid">
                    @foreach($related_posts as $related)
                        <a href="{{ route('posts.show', $related->slug) }}" class="related-post-card">
                            @if($related->featured_image)
                                <img src="{{ asset('assets/images/'.$related->featured_image) }}" alt="{{ $related->title }}" class="related-post-image">
                            @else
                                <div style="width: 100%; height: 150px; background: linear-gradient(135deg, #fb5849 0%, #d15400 100%); display: flex; align-items: center; justify-content: center; color: white; font-size: 2rem;">
                                    <i class="fa fa-file-text"></i>
                                </div>
                            @endif
                            <div class="related-post-content">
                                <h4 class="related-post-title">{{ $related->title }}</h4>
                                <div class="related-post-date">
                                    <i class="fa fa-calendar"></i> {{ date('d/m/Y', strtotime($related->published_at ?? $related->created_at)) }}
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</div>

@endsection

