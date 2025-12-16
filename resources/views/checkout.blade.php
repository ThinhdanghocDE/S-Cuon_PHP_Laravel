@extends('layout', ['title'=> 'Thanh Toán'])

@section('page-content')
<div class="checkout-container">
    <div class="container" style="padding-top: 120px; padding-bottom: 80px;">
        <!-- Page Header -->
        <div class="checkout-header text-center mb-5">
            <h1 class="checkout-page-title">Thanh Toán</h1>
            <p class="checkout-page-subtitle">Hoàn tất đơn hàng của bạn</p>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-8">
                <!-- Order Summary Card -->
                <div class="checkout-card order-summary-card mb-4">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fa fa-shopping-bag"></i> Tổng đơn hàng
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="order-total-display">
                            <span class="total-label">Tổng tiền:</span>
                            <span class="total-amount">{{ number_format((float)$total * 1000, 0, ',', '.') }} VNĐ</span>
                        </div>
                    </div>
                </div>

                <!-- Payment Method Card -->
                <div class="checkout-card payment-method-card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fa fa-credit-card"></i> Chọn phương thức thanh toán
                        </h3>
                    </div>
                    <div class="card-body">
                        <div ng-app="" class="payment-methods">
                            <!-- COD Payment Option -->
                            <div class="payment-option">
                                <input ng-model="myVar" type="radio" id="cod" name="payment_method" value="cod" class="payment-radio">
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

                            <!-- Online Payment Option (VNPay) -->
                            <div class="payment-option">
                                <input ng-model="myVar" type="radio" id="online" name="payment_method" value="online" class="payment-radio">
                                <label for="online" class="payment-label">
                                    <div class="payment-option-content">
                                        <div class="payment-icon">
                                            <i class="fa fa-credit-card" style="font-size: 32px; color: #fb5849;"></i>
                                        </div>
                                        <div class="payment-info">
                                            <h4 class="payment-name">Thanh toán trực tuyến (VNPay)</h4>
                                            <p class="payment-description">Thanh toán qua cổng thanh toán VNPay</p>
                                        </div>
                                        <div class="payment-check">
                                            <i class="fa fa-check-circle"></i>
                                        </div>
                                    </div>
                                </label>
                            </div>
                        </div>

                        <!-- Payment Action Buttons -->
                        <div ng-switch="myVar" class="payment-actions mt-4">
                            <!-- COD: cho phép guest đặt hàng -->
                            <div ng-switch-when="cod" class="payment-action-content">
                                <form method="get" action="{{route('mails.shipped', $total)}}" class="payment-form">
                                    <button type="submit" class="btn-place-order">
                                        <i class="fa fa-check"></i> Đặt hàng ngay
                                    </button>
                                </form>
                            </div>

                            <!-- Online Payment (VNPay): hiện tại vẫn yêu cầu đăng nhập -->
                            <div ng-switch-when="online" class="payment-action-content">
                                @if (Auth::check())
                                    @php
                                        session(['total' => $total]);
                                    @endphp
                                    <form method="POST" action="{{ route('vnpay.create') }}">
                                        @csrf
                                        <button type="submit" class="btn-place-order">
                                            <i class="fa fa-credit-card"></i> Thanh toán trực tuyến (VNPay)
                                        </button>
                                    </form>
                                @else
                                    <a href="/login" class="btn-place-order-link">
                                        <button type="button" class="btn-place-order">
                                            <i class="fa fa-sign-in"></i> Đăng nhập để thanh toán VNPay
                                        </button>
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Back to Cart Link -->
                <div class="text-center mt-4">
                    <a href="{{ route('cart') }}" class="btn-back-cart">
                        <i class="fa fa-angle-left"></i> Quay lại giỏ hàng
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Bungee&family=Inter:wght@300;400;500;600;700;800;900&family=Dancing+Script:wght@400;500;600;700&display=swap" rel="stylesheet">
<style>
    .checkout-container {
        min-height: 100vh;
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        font-family: 'Inter', sans-serif;
    }

    .checkout-header {
        margin-bottom: 40px;
    }

    .checkout-page-title {
        font-family: 'Dancing Script', cursive;
        font-size: 4rem;
        font-weight: 700;
        background: linear-gradient(135deg, #fb5849 0%, #d15400 30%, #ff6b5a 60%, #fb5849 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        margin-bottom: 15px;
        letter-spacing: 2px;
        text-shadow: 0 4px 20px rgba(251, 88, 73, 0.3);
    }

    .checkout-page-subtitle {
        font-size: 1.2rem;
        color: #666;
        font-style: italic;
        font-weight: 400;
    }

    .checkout-card {
        background: #fff;
        border-radius: 20px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .checkout-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.15);
    }

    .card-header {
        background: linear-gradient(135deg, #fb5849 0%, #d15400 100%);
        padding: 25px 30px;
        color: #fff;
    }

    .card-title {
        font-size: 1.5rem;
        font-weight: 700;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .card-title i {
        font-size: 1.3rem;
    }

    .card-body {
        padding: 30px;
    }

    .order-summary-card .order-total-display {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 20px;
        background: #f8f9fa;
        border-radius: 12px;
    }

    .total-label {
        font-size: 1.2rem;
        color: #666;
        font-weight: 500;
    }

    .total-amount {
        font-size: 2rem;
        font-weight: 700;
        color: #fb5849;
        font-family: 'Inter', sans-serif;
    }

    .payment-methods {
        display: flex;
        flex-direction: column;
        gap: 20px;
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
        border-radius: 15px;
        padding: 20px;
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
        gap: 20px;
        position: relative;
    }

    .payment-icon {
        flex-shrink: 0;
        width: 80px;
        height: 80px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        padding: 10px;
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
        font-size: 1.2rem;
        font-weight: 700;
        color: #2a2a2a;
        margin: 0 0 8px 0;
    }

    .payment-description {
        font-size: 0.95rem;
        color: #666;
        margin: 0;
        line-height: 1.5;
    }

    .payment-check {
        flex-shrink: 0;
        width: 30px;
        height: 30px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #4CAF50;
        font-size: 1.5rem;
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .payment-radio:checked + .payment-label .payment-check {
        opacity: 1;
    }

    .payment-actions {
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

    .btn-place-order {
        width: 100%;
        padding: 18px 30px;
        background: linear-gradient(135deg, #fb5849 0%, #d15400 100%);
        color: #fff;
        border: none;
        border-radius: 12px;
        font-size: 1.2rem;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        box-shadow: 0 4px 15px rgba(251, 88, 73, 0.3);
        font-family: 'Inter', sans-serif;
    }

    .btn-place-order:hover {
        transform: translateY(-3px);
        box-shadow: 0 6px 25px rgba(251, 88, 73, 0.4);
        background: linear-gradient(135deg, #d15400 0%, #fb5849 100%);
    }

    .btn-place-order:active {
        transform: translateY(-1px);
    }

    .btn-place-order i {
        font-size: 1.1rem;
    }

    .btn-place-order-link {
        display: block;
        width: 100%;
        text-decoration: none;
    }

    .btn-back-cart {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 12px 25px;
        color: #666;
        text-decoration: none;
        font-weight: 600;
        transition: all 0.3s ease;
        border-radius: 8px;
    }

    .btn-back-cart:hover {
        color: #fb5849;
        background: #fff;
        text-decoration: none;
        transform: translateX(-5px);
    }

    .btn-back-cart i {
        font-size: 1.2rem;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .checkout-page-title {
            font-size: 2.5rem;
        }

        .checkout-page-subtitle {
            font-size: 1rem;
        }

        .card-header {
            padding: 20px;
        }

        .card-title {
            font-size: 1.2rem;
        }

        .card-body {
            padding: 20px;
        }

        .order-total-display {
            flex-direction: column;
            gap: 10px;
            text-align: center;
        }

        .total-amount {
            font-size: 1.5rem;
        }

        .payment-option-content {
            flex-direction: column;
            text-align: center;
        }

        .payment-icon {
            width: 100px;
            height: 100px;
        }

        .payment-check {
            position: absolute;
            top: 10px;
            right: 10px;
        }

        .btn-place-order {
            padding: 15px 20px;
            font-size: 1rem;
        }
    }

    @media (max-width: 576px) {
        .checkout-container .container {
            padding-top: 100px;
            padding-bottom: 50px;
        }

        .checkout-page-title {
            font-size: 2rem;
        }

        .payment-label {
            padding: 15px;
        }

        .payment-icon {
            width: 80px;
            height: 80px;
        }
    }
</style>
@endpush
@endsection
