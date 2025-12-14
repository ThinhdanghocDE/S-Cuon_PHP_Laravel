@extends('layout', ['title'=> $product->name])

@section('page-content')

<div class="product-detail-page">
    <div class="container">
        <div class="product-detail-container">
            <!-- Left: Product Image -->
            <div class="product-image-section">
                <div class="product-image-wrapper">
                    <img src="{{asset('assets/images/'.$product->image)}}" alt="{{$product->name}}" class="product-main-image">
                </div>
            </div>

            <!-- Right: Product Information -->
            <div class="product-info-section">
                <h1 class="product-name">{{$product->name}}</h1>
                <div class="product-price">{{number_format($product->price * 1000, 0, ',', '.')}} VNĐ</div>

                <div class="product-info-header">
                    <h3>Thông tin sản phẩm</h3>
                </div>

                <div class="product-description">
                    <p>{{$product->description}}</p>
                </div>

                <div class="product-rating">
                    @for($i=1; $i<=$product->whole_stars; $i++)
                        <i class="fa fa-star"></i>
                    @endfor
                    @if($product->has_half_star)
                        <i class="fa fa-star-half"></i>
                    @endif
                    <span class="rating-value">({{$product->rating}})</span>
                </div>

                @if($product->available == "Stock")
                    <form method="post" action="{{route('cart.store', $product)}}" class="product-order-form">
                        @csrf
                        <div class="quantity-section">
                            <label for="quantity">Số lượng:</label>
                            <div class="quantity-controls">
                                <button type="button" class="quantity-btn minus" onclick="decreaseQuantity()">-</button>
                                <input type="number" name="number" id="quantity" class="quantity-input" value="1" min="1">
                                <button type="button" class="quantity-btn plus" onclick="increaseQuantity()">+</button>
                            </div>
                        </div>

                        <button type="submit" class="btn-order">
                            Đặt món
                        </button>
                    </form>
                @else
                    <div class="out-of-stock-message">
                        <p>Sản phẩm hiện đang hết hàng</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Reviews and Comments Section -->
        <div class="reviews-section">
            @if(session('success'))
                <div class="alert-success-message">
                    {{ session('success') }}
                </div>
            @endif

            <div class="reviews-header">
                <h2 class="reviews-title">ĐÁNH GIÁ VÀ BÌNH LUẬN</h2>
                @auth
                    <button type="button" class="btn-write-review" onclick="showReviewForm()">
                        <i class="fa fa-plus-circle"></i> Viết đánh giá
                    </button>
                @else
                    <a href="/login" class="btn-write-review">
                        <i class="fa fa-plus-circle"></i> Viết đánh giá
                    </a>
                @endauth
            </div>

            <div class="reviews-content">
                <!-- Left: Rating Summary -->
                <div class="rating-summary">
                    <div class="average-rating-box">
                        <div class="average-rating-number">{{$product->rating}}</div>
                        <div class="average-rating-text">trên 5</div>
                    </div>
                    <div class="rating-breakdown">
                        @for($i = 5; $i >= 1; $i--)
                            <div class="rating-row">
                                <span class="star-label">{{$i}} sao</span>
                                <div class="rating-bar-container">
                                    <div class="rating-bar" data-width="{{$rating_percentages[$i]}}"></div>
                                </div>
                                <span class="rating-count">{{$rating_stats[$i]}} đánh giá</span>
                            </div>
                        @endfor
                    </div>
                </div>

                <!-- Right: Comments List -->
                <div class="comments-list">
                    @if($comments->count() > 0)
                        @foreach($comments as $comment)
                            <div class="comment-item">
                                <div class="comment-header">
                                    <div class="comment-user-info">
                                        <div class="comment-user-name">{{$comment->user_name}}</div>
                                        <div class="comment-date">{{date('d/m/Y', strtotime($comment->created_at))}}</div>
                                    </div>
                                    <div class="comment-rating">
                                        @for($j = 1; $j <= 5; $j++)
                                            @if($j <= $comment->rating)
                                                <i class="fa fa-star"></i>
                                            @else
                                                <i class="fa fa-star-o"></i>
                                            @endif
                                        @endfor
                                    </div>
                                </div>
                                <div class="comment-text">{{$comment->comment}}</div>
                            </div>
                        @endforeach
                    @else
                        <div class="no-comments">
                            <p>Chưa có đánh giá nào. Hãy là người đầu tiên đánh giá sản phẩm này!</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Review Form Modal -->
        @auth
        <div id="reviewFormModal" class="review-modal" style="display: none;">
            <div class="review-modal-content">
                <div class="review-modal-header">
                    <h3>Viết đánh giá</h3>
                    <button type="button" class="close-modal" onclick="closeReviewForm()">&times;</button>
                </div>
                <form method="POST" action="{{route('product.comment', $product->id)}}" class="review-form">
                    @csrf
                    <div class="form-group">
                        <label>Đánh giá của bạn:</label>
                        <div class="star-rating-input">
                            @for($i = 5; $i >= 1; $i--)
                                <input type="radio" name="rating" value="{{$i}}" id="star{{$i}}" required>
                                <label for="star{{$i}}" class="star-label-input">
                                    <i class="fa fa-star"></i>
                                </label>
                            @endfor
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="comment">Bình luận:</label>
                        <textarea name="comment" id="comment" rows="5" class="form-control" placeholder="Chia sẻ trải nghiệm của bạn về món ăn này..." required></textarea>
                    </div>
                    <div class="form-actions">
                        <button type="button" class="btn-cancel" onclick="closeReviewForm()">Hủy</button>
                        <button type="submit" class="btn-submit">Gửi đánh giá</button>
                    </div>
                </form>
            </div>
        </div>
        @endauth
    </div>
</div>

@endsection

@push('styles')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Bungee&family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
<link rel="stylesheet" href="{{asset('css/product-detail.css')}}">
@endpush

@push('scripts')
<script>
    function increaseQuantity() {
        const input = document.getElementById('quantity');
        const currentValue = parseInt(input.value);
        input.value = currentValue + 1;
    }

    function decreaseQuantity() {
        const input = document.getElementById('quantity');
        const currentValue = parseInt(input.value);
        if (currentValue > 1) {
            input.value = currentValue - 1;
        }
    }

    function showReviewForm() {
        document.getElementById('reviewFormModal').style.display = 'flex';
    }

    function closeReviewForm() {
        document.getElementById('reviewFormModal').style.display = 'none';
    }

    // Close modal when clicking outside
    window.onclick = function(event) {
        const modal = document.getElementById('reviewFormModal');
        if (event.target == modal) {
            closeReviewForm();
        }
    }

    // Star rating interaction
    document.querySelectorAll('.star-label-input').forEach((label, index) => {
        label.addEventListener('click', function() {
            const starValue = 6 - index; // 5, 4, 3, 2, 1
            document.querySelectorAll('.star-label-input').forEach((l, i) => {
                if (i < index + 1) {
                    l.classList.add('active');
                } else {
                    l.classList.remove('active');
                }
            });
        });
    });

    // Set rating bar widths
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.rating-bar[data-width]').forEach(function(bar) {
            const width = bar.getAttribute('data-width');
            bar.style.width = width + '%';
        });
    });
</script>
@endpush

