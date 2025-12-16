@extends('layout', ['title'=> 'Giỏ Hàng'])

@section('page-content')
<div class="cart-container">
    <div class="container" style="padding-top: 100px; padding-bottom: 50px;">
        <div class="text-center mb-5">
            <h1 class="cart-page-title">Giỏ Hàng Của Tôi</h1>
            <p class="cart-page-subtitle">Kiểm tra và chỉnh sửa đơn hàng của bạn</p>
        </div>

        @if(Session::has('wrong'))
        <div class="alert alert-danger">
            <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
            <strong>Lỗi!</strong> {{Session::get('wrong')}}
        </div>
        @endif

        @if(Session::has('coupon_expired') || Session::has('coupon_already_applied'))
            <!-- Popup (không dùng JS) -->
            <div class="coupon-popup-overlay">
                <div class="coupon-popup">
                    <div class="coupon-popup-header">
                        <strong>Thông báo</strong>
                        <a href="{{ url('/cart') }}" class="coupon-popup-close" aria-label="Đóng">×</a>
                    </div>
                    <div class="coupon-popup-body">
                        {{ Session::get('wrong', 'Có lỗi khi áp dụng mã khuyến mãi!') }}
                    </div>
                    <div class="coupon-popup-footer">
                        <a href="{{ url('/cart') }}" class="btn btn-primary">OK</a>
                    </div>
                </div>
            </div>
        @endif

        @if(Session::has('success'))
        <div class="alert alert-success">
            <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
            <strong>Thành công!</strong> {{Session::get('success')}}
        </div>
        @endif

        @if(count($carts) > 0)
            <div class="cart-items">
                @foreach($carts as $product)
                    @php
                        $imageUrl = !empty($product->product_image)
                            ? asset('assets/images/'.$product->product_image)
                            : asset('assets/images/default-food.jpg');
                    @endphp
                    <div class="cart-item-card">
                        <div class="cart-item-image">
                            <img src="{{ $imageUrl }}" alt="{{ $product->name }}">
                        </div>
                        <div class="cart-item-info">
                            <h3 class="cart-item-name">{{ $product->name }}</h3>
                            <p class="cart-item-price-unit">{{ number_format((float)$product->price * 1000, 0, ',', '.') }} VNĐ / phần</p>
                        </div>
                        <div class="cart-item-quantity">
                            <span class="quantity-label">Số lượng:</span>
                            <span class="quantity-value">{{ $product->quantity }}</span>
                        </div>
                        <div class="cart-item-subtotal">
                            <span class="subtotal-label">Thành tiền:</span>
                            <span class="subtotal-value">{{ number_format((float)$product->subtotal * 1000, 0, ',', '.') }} VNĐ</span>
                        </div>
                        <div class="cart-item-actions">
                            <form method="post" action="{{ route('cart.destroy', Auth::check() ? $product : $product->product_id) }}" onsubmit="return confirm('Bạn có chắc chắn muốn xóa món này khỏi giỏ hàng?')">
                                @csrf
                                <button type="submit" class="btn-remove-item" title="Xóa khỏi giỏ hàng">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach

                @if($total_price!=0 && isset($extra_charge) && count($extra_charge) > 0)
                    <div class="extra-charges-section">
                        <h4 class="extra-charges-title">Phí bổ sung:</h4>
                        @foreach($extra_charge as $charge)
                            <div class="extra-charge-item">
                                <span class="charge-name">{{ $charge->name }}</span>
                                <span class="charge-price">{{ number_format((float)$charge->price * 1000, 0, ',', '.') }} VNĐ</span>
                            </div>
                        @endforeach
                    </div>
                @endif

<style>
  .coupon-popup-overlay{
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,.55);
    z-index: 99999;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 16px;
  }
  .coupon-popup{
    width: 100%;
    max-width: 520px;
    background: #fff;
    border-radius: 14px;
    box-shadow: 0 20px 60px rgba(0,0,0,.3);
    overflow: hidden;
  }
  .coupon-popup-header{
    display:flex;
    align-items:center;
    justify-content: space-between;
    padding: 14px 16px;
    background: linear-gradient(135deg, #fb5849 0%, #d15400 100%);
    color: #fff;
  }
  .coupon-popup-close{
    color:#fff;
    font-size: 22px;
    line-height: 1;
    text-decoration: none;
    opacity: .9;
  }
  .coupon-popup-close:hover{ opacity: 1; }
  .coupon-popup-body{
    padding: 18px 16px;
    color: #333;
    font-size: 15px;
    line-height: 1.5;
  }
  .coupon-popup-footer{
    padding: 0 16px 16px 16px;
    display: flex;
    justify-content: flex-end;
    gap: 10px;
  }
</style>

                <div class="cart-summary">
                    <div class="coupon-section">
                        <form method="post" action="{{route('coupon/apply')}}" class="coupon-form">
                            @csrf
                            <div class="coupon-input-group">
                                <label for="coupon-code">Mã giảm giá:</label>
                                <input type="text" name="code" id="coupon-code" class="form-control coupon-input" placeholder="Nhập mã giảm giá">
                                @if($total_price==0)
                                    <button type="submit" class="btn-apply-coupon" disabled>Áp dụng</button>
                                @else
                                    <button type="submit" class="btn-apply-coupon">Áp dụng</button>
                                @endif
                            </div>
                        </form>
                    </div>

                    @php 
                        if($total_price!=0)
                        {
                            $total_price=$total_price+$total_extra_charge;
                            $without_discount_price=$without_discount_price + $total_extra_charge;
                        }
                        $total = $total_price;
                        Session::put('total',$total);
                    @endphp

                    <div class="summary-details">
                        <div class="summary-row">
                            <span class="summary-label">Tổng tiền:</span>
                            <span class="summary-value">{{ number_format((float)$without_discount_price * 1000, 0, ',', '.') }} VNĐ</span>
                        </div>
                        @if($discount_price > 0)
                        <div class="summary-row discount-row">
                            <span class="summary-label">Giảm giá:</span>
                            <span class="summary-value discount-value">-{{ number_format((float)$discount_price * 1000, 0, ',', '.') }} VNĐ</span>
                        </div>
                        @endif
                        <div class="summary-row total-row">
                            <span class="summary-label">Tổng thanh toán:</span>
                            <span class="summary-value total-value">{{ number_format((float)$total_price * 1000, 0, ',', '.') }} VNĐ</span>
                        </div>
                    </div>

                    <!-- Payment Method Section -->
                    @if($total_price > 0)
                    <div class="payment-method-section">
                        <div class="payment-section-header">
                            <h3 class="payment-section-title">
                                <i class="fa fa-credit-card"></i> Chọn phương thức thanh toán
                            </h3>
                        </div>
                        <div ng-app="" class="payment-methods">
                            <!-- COD Payment Option -->
                            <div class="payment-option">
                                <input ng-model="paymentMethod" type="radio" id="cod" name="payment_method" value="cod" class="payment-radio">
                                <label for="cod" class="payment-label">
                                    <div class="payment-option-content">
                                        <div class="payment-icon">
                                            <img src="{{ asset('assets/images/cod.png')}}" alt="COD">
                                        </div>
                                        <div class="payment-info">
                                            <h4 class="payment-name">Thanh toán khi nhận hàng (COD)</h4>
                                            <p class="payment-description">Thanh toán bằng tiền mặt khi nhận được đơn hàng</p>
                                        </div>
                                        <div class="payment-check">
                                            <i class="fa fa-check-circle"></i>
                                        </div>
                                    </div>
                                </label>
                            </div>

                            <!-- Online Payment Option -->
                            <div class="payment-option">
                                <input ng-model="paymentMethod" type="radio" id="online" name="payment_method" value="online" class="payment-radio">
                                <label for="online" class="payment-label">
                                    <div class="payment-option-content">
                                        <div class="payment-icon">
                                            <i class="fa fa-credit-card" style="font-size: 24px;"></i>
                                        </div>
                                        <div class="payment-info">
                                            <h4 class="payment-name">Thanh toán trực tuyến</h4>
                                            <p class="payment-description">Thanh toán qua cổng thanh toán trực tuyến</p>
                                        </div>
                                        <div class="payment-check">
                                            <i class="fa fa-check-circle"></i>
                                        </div>
                                    </div>
                                </label>
                            </div>
                        </div>

                        <!-- Payment Action Buttons -->
                        <div ng-switch="paymentMethod" class="payment-actions">
                            <!-- COD: cho phép guest đặt hàng -->
                            <div ng-switch-when="cod" class="payment-action-content">
                                <form method="get" action="{{route('mails.shipped', $total)}}" class="payment-form">
                                    <div class="cart-actions">
                                        <a href="{{ url('/menu') }}" class="btn-continue-shopping">
                                            <i class="fa fa-angle-left"></i> Tiếp tục mua sắm
                                        </a>
                                        <button type="submit" class="btn-checkout">
                                            <i class="fa fa-check"></i> Đặt hàng ngay
                                        </button>
                                    </div>
                                </form>
                            </div>

                            <!-- Online (VNPay): hiện tại vẫn yêu cầu đăng nhập -->
                            <div ng-switch-when="online" class="payment-action-content">
                                <div class="cart-actions">
                                    <a href="{{ url('/menu') }}" class="btn-continue-shopping">
                                        <i class="fa fa-angle-left"></i> Tiếp tục mua sắm
                                    </a>
                                    @if (Auth::check())
                                        @php
                                            session(['total' => $total]);
                                        @endphp
                                        <form method="POST" action="{{ route('vnpay.create') }}" style="display: inline-block;">
                                            @csrf
                                            <button type="submit" class="btn-checkout">
                                                <i class="fa fa-credit-card"></i> Thanh toán qua VNPay
                                            </button>
                                        </form>
                                    @else
                                        <a href="/login" class="btn-checkout-link">
                                            <button type="button" class="btn-checkout">
                                                <i class="fa fa-sign-in"></i> Đăng nhập để thanh toán VNPay
                                            </button>
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    @else
                    <div class="cart-actions">
                        <a href="{{ url('/menu') }}" class="btn-continue-shopping">
                            <i class="fa fa-angle-left"></i> Tiếp tục mua sắm
                        </a>
                        <button type="button" class="btn-checkout" disabled>Thanh toán</button>
                    </div>
                    @endif
                </div>
            </div>
        @else
            <div class="empty-cart">
                <div class="empty-cart-icon">
                    <i class="fa fa-shopping-cart"></i>
                </div>
                <h3>Giỏ hàng của bạn đang trống</h3>
                <p>Hãy thêm một số món ăn ngon vào giỏ hàng!</p>
                <a href="{{ url('/menu') }}" class="btn-continue-shopping">
                    <i class="fa fa-shopping-bag"></i>Xem thực đơn
                </a>
            </div>
        @endif
    </div>
</div>

@push('styles')
<style>
    .cart-container {
        min-height: 100vh;
        background: #f8f9fa;
    }

    .cart-page-title {
        font-family: 'Dancing Script', cursive;
        font-size: 3.5rem;
        font-weight: 700;
        background: linear-gradient(135deg, #fb5849 0%, #d15400 30%, #ff6b5a 60%, #fb5849 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        margin-bottom: 10px;
    }

    .cart-page-subtitle {
        font-size: 1.1rem;
        color: #666;
        font-style: italic;
    }

    .alert {
        padding: 15px 20px;
        margin-bottom: 20px;
        border-radius: 8px;
        position: relative;
    }

    .alert-danger {
        background-color: #f44336;
        color: white;
    }

    .alert-success {
        background-color: #4BB543;
        color: white;
    }

    .closebtn {
        margin-left: 15px;
        color: white;
        font-weight: bold;
        float: right;
        font-size: 22px;
        line-height: 20px;
        cursor: pointer;
        transition: 0.3s;
    }

    .closebtn:hover {
        color: rgba(0, 0, 0, 0.7);
    }

    .cart-items {
        display: flex;
        flex-direction: column;
        gap: 20px;
        margin-bottom: 30px;
    }

    .cart-item-card {
        background: #fff;
        border-radius: 15px;
        padding: 20px;
        display: flex;
        align-items: center;
        gap: 20px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .cart-item-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
    }

    .cart-item-image {
        flex-shrink: 0;
        width: 120px;
        height: 120px;
        border-radius: 10px;
        overflow: hidden;
        background: #f0f0f0;
    }

    .cart-item-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .cart-item-info {
        flex: 1;
        min-width: 0;
    }

    .cart-item-name {
        font-size: 1.3rem;
        font-weight: 600;
        color: #333;
        margin: 0 0 8px 0;
    }

    .cart-item-price-unit {
        font-size: 0.95rem;
        color: #666;
        margin: 0;
    }

    .cart-item-quantity,
    .cart-item-subtotal {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 5px;
    }

    .quantity-label,
    .subtotal-label {
        font-size: 0.85rem;
        color: #999;
        font-weight: 500;
    }

    .quantity-value {
        font-size: 1.1rem;
        font-weight: 600;
        color: #333;
        background: #f8f9fa;
        padding: 5px 15px;
        border-radius: 20px;
    }

    .subtotal-value {
        font-size: 1.2rem;
        font-weight: 700;
        color: #fb5849;
    }

    .cart-item-actions {
        flex-shrink: 0;
    }

    .btn-remove-item {
        background: #f44336;
        color: white;
        border: none;
        padding: 12px 18px;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.3s ease;
        font-size: 1.1rem;
    }

    .btn-remove-item:hover {
        background: #d32f2f;
        transform: scale(1.1);
    }

    .extra-charges-section {
        background: #fff;
        border-radius: 15px;
        padding: 20px;
        margin-bottom: 20px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    .extra-charges-title {
        font-size: 1.2rem;
        font-weight: 600;
        color: #333;
        margin-bottom: 15px;
    }

    .extra-charge-item {
        display: flex;
        justify-content: space-between;
        padding: 10px 0;
        border-bottom: 1px solid #f0f0f0;
    }

    .extra-charge-item:last-child {
        border-bottom: none;
    }

    .charge-name {
        color: #666;
    }

    .charge-price {
        font-weight: 600;
        color: #333;
    }

    .cart-summary {
        background: #fff;
        border-radius: 15px;
        padding: 30px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    .coupon-section {
        margin-bottom: 25px;
        padding-bottom: 25px;
        border-bottom: 2px solid #f0f0f0;
    }

    .coupon-form label {
        display: block;
        font-weight: 600;
        color: #333;
        margin-bottom: 10px;
    }

    .coupon-input-group {
        display: flex;
        gap: 10px;
        align-items: flex-end;
    }

    .coupon-input {
        flex: 1;
        padding: 12px 15px;
        border: 2px solid #e0e0e0;
        border-radius: 8px;
        font-size: 1rem;
        transition: border-color 0.3s ease;
    }

    .coupon-input:focus {
        outline: none;
        border-color: #fb5849;
    }

    .btn-apply-coupon {
        padding: 12px 25px;
        background: linear-gradient(135deg, #fb5849 0%, #d15400 100%);
        color: white;
        border: none;
        border-radius: 8px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .btn-apply-coupon:hover:not(:disabled) {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(251, 88, 73, 0.3);
    }

    .btn-apply-coupon:disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }

    .summary-details {
        margin-bottom: 25px;
    }

    .summary-row {
        display: flex;
        justify-content: space-between;
        padding: 12px 0;
        font-size: 1.1rem;
    }

    .summary-label {
        color: #666;
        font-weight: 500;
    }

    .summary-value {
        font-weight: 600;
        color: #333;
    }

    .discount-row {
        color: #4BB543;
    }

    .discount-value {
        color: #4BB543;
    }

    .total-row {
        border-top: 2px solid #e0e0e0;
        padding-top: 15px;
        margin-top: 10px;
        font-size: 1.3rem;
    }

    .total-value {
        font-size: 1.5rem;
        color: #fb5849;
        font-weight: 700;
    }

    .cart-actions {
        display: flex;
        gap: 15px;
        justify-content: flex-end;
        flex-wrap: wrap;
    }

    .btn-continue-shopping {
        display: inline-block;
        padding: 12px 30px;
        background: #6c757d;
        color: white;
        text-decoration: none;
        border-radius: 8px;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-continue-shopping:hover {
        background: #5a6268;
        transform: translateY(-2px);
        color: white;
        text-decoration: none;
    }

    .btn-checkout {
        padding: 12px 40px;
        background: linear-gradient(135deg, #fb5849 0%, #d15400 100%);
        color: white;
        border: none;
        border-radius: 8px;
        font-weight: 600;
        font-size: 1.1rem;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(251, 88, 73, 0.3);
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .btn-checkout i {
        font-size: 1rem;
    }

    .btn-checkout:hover:not(:disabled) {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(251, 88, 73, 0.4);
    }

    .btn-checkout:disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }

    .btn-checkout-link {
        text-decoration: none;
        display: inline-block;
    }

    /* Payment Method Section */
    .payment-method-section {
        margin-top: 30px;
        padding-top: 30px;
        border-top: 2px solid #e0e0e0;
    }

    .payment-section-header {
        margin-bottom: 20px;
    }

    .payment-section-title {
        font-size: 1.4rem;
        font-weight: 700;
        color: #2a2a2a;
        display: flex;
        align-items: center;
        gap: 12px;
        margin: 0;
    }

    .payment-section-title i {
        color: #fb5849;
        font-size: 1.3rem;
    }

    .payment-methods {
        display: flex;
        flex-direction: column;
        gap: 15px;
        margin-bottom: 25px;
    }

    .payment-option {
        position: relative;
    }

    .payment-radio {
        position: absolute;
        opacity: 0;
        cursor: pointer;
    }

    .payment-label {
        display: block;
        cursor: pointer;
        border: 3px solid #e0e0e0;
        border-radius: 12px;
        padding: 18px;
        transition: all 0.3s ease;
        background: #fff;
    }

    .payment-label:hover {
        border-color: #fb5849;
        background: #fff5f5;
        transform: translateX(5px);
    }

    .payment-radio:checked + .payment-label {
        border-color: #fb5849;
        background: linear-gradient(135deg, #fff5f5 0%, #ffe5e5 100%);
        box-shadow: 0 4px 15px rgba(251, 88, 73, 0.2);
    }

    .payment-option-content {
        display: flex;
        align-items: center;
        gap: 18px;
        position: relative;
    }

    .payment-icon {
        flex-shrink: 0;
        width: 70px;
        height: 70px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #fff;
        border-radius: 10px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        padding: 8px;
    }

    .payment-icon img {
        max-width: 100%;
        max-height: 100%;
        object-fit: contain;
    }

    .payment-info {
        flex: 1;
        min-width: 0;
    }

    .payment-name {
        font-size: 1.1rem;
        font-weight: 700;
        color: #2a2a2a;
        margin: 0 0 6px 0;
    }

    .payment-description {
        font-size: 0.9rem;
        color: #666;
        margin: 0;
        line-height: 1.4;
    }

    .payment-check {
        flex-shrink: 0;
        width: 28px;
        height: 28px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #4CAF50;
        font-size: 1.4rem;
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .payment-radio:checked + .payment-label .payment-check {
        opacity: 1;
    }

    .payment-actions {
        margin-top: 20px;
        padding-top: 20px;
        border-top: 2px solid #f0f0f0;
    }

    .payment-action-content {
        animation: fadeIn 0.3s ease;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .payment-form {
        width: 100%;
    }

    .empty-cart {
        text-align: center;
        padding: 80px 20px;
        background: #fff;
        border-radius: 15px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    .empty-cart-icon {
        font-size: 5rem;
        color: #ddd;
        margin-bottom: 20px;
    }

    .empty-cart h3 {
        color: #333;
        margin-bottom: 10px;
        font-size: 1.8rem;
    }

    .empty-cart p {
        color: #666;
        margin-bottom: 30px;
        font-size: 1.1rem;
    }

    @media (max-width: 768px) {
        .cart-page-title {
            font-size: 2.5rem;
        }

        .cart-item-card {
            flex-direction: column;
            text-align: center;
        }

        .cart-item-image {
            width: 100%;
            height: 200px;
        }

        .cart-item-quantity,
        .cart-item-subtotal {
            flex-direction: row;
            gap: 10px;
        }

        .coupon-input-group {
            flex-direction: column;
            align-items: stretch;
        }

        .cart-actions {
            flex-direction: column;
        }

        .btn-continue-shopping,
        .btn-checkout {
            width: 100%;
            text-align: center;
        }

        .payment-option-content {
            flex-direction: column;
            text-align: center;
        }

        .payment-icon {
            width: 80px;
            height: 80px;
            margin: 0 auto;
        }

        .payment-check {
            position: absolute;
            top: 10px;
            right: 10px;
        }
    }
</style>
@endpush
@endsection