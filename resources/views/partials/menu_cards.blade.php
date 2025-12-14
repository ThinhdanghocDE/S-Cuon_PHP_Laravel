@foreach($products as $product)
    <div class="menu-card">
        <div class="menu-card-image">
            <a href="/product/{{$product->id}}" style="display: block; width: 100%; height: 100%;">
                <img src="{{asset('assets/images/'.$product->image)}}" alt="{{$product->name}}">
            </a>
            @if($product->available != "Stock")
                <div class="out-of-stock-badge">Hết hàng</div>
            @endif
        </div>
        <div class="menu-card-content">
            <h3 class="menu-card-title">
                <a href="/product/{{$product->id}}" style="text-decoration: none; color: inherit;">{{$product->name}}</a>
            </h3>
            <div class="menu-card-price">{{number_format($product->price * 1000, 0, ',', '.')}} VNĐ</div>
            
            <div class="menu-card-rating">
                @for($i=1; $i<=$product->whole_stars; $i++)
                    <i class="fa fa-star"></i>
                @endfor
                @if($product->has_half_star)
                    <i class="fa fa-star-half"></i>
                @endif
                <span class="rating-value">({{$product->rating}})</span>
            </div>

            @if($product->available == "Stock")
                <form method="post" action="{{route('cart.store', $product)}}" class="menu-card-form">
                    @csrf
                    <div class="menu-card-actions">
                        <input type="number" name="number" class="quantity-input" value="1" min="1">
                        <button type="submit" class="btn-add-cart">
                            <i class="fa fa-shopping-cart"></i> Thêm vào giỏ
                        </button>
                    </div>
                </form>
            @else
                <div class="menu-card-actions">
                    <button class="btn-out-of-stock" disabled>Hết hàng</button>
                </div>
            @endif
        </div>
    </div>
@endforeach

