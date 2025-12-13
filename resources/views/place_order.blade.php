@extends('layout', ['title'=> 'Đặt Hàng'])

@section('page-content')

    <style>
    .checkout-page {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        min-height: calc(100vh - 200px);
        padding: 60px 0;
        margin-top: 80px;
    }

    .checkout-container {
        max-width: 1200px;
        margin: 0 auto;
    }

    .checkout-header {
        text-align: center;
        margin-bottom: 40px;
        color: white;
    }

    .checkout-header img {
        max-width: 200px;
        margin-bottom: 20px;
        filter: drop-shadow(0 4px 6px rgba(0,0,0,0.1));
    }

    .checkout-header h1 {
        font-size: 2.5rem;
        font-weight: 700;
        margin-bottom: 10px;
        text-shadow: 2px 2px 4px rgba(0,0,0,0.2);
    }

    .checkout-header p {
        font-size: 1.1rem;
        opacity: 0.9;
    }

    .checkout-card {
        background: white;
        border-radius: 20px;
        box-shadow: 0 20px 60px rgba(0,0,0,0.3);
        padding: 40px;
        margin-bottom: 30px;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .checkout-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 25px 70px rgba(0,0,0,0.35);
    }

    .order-summary-card {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border-radius: 20px;
        padding: 30px;
        position: sticky;
        top: 100px;
    }

    .order-summary-card h4 {
        font-size: 1.5rem;
        font-weight: 700;
        margin-bottom: 25px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .order-summary-card h4 i {
        font-size: 1.3rem;
    }

    .total-amount {
        background: rgba(255,255,255,0.2);
        border-radius: 15px;
        padding: 20px;
        margin-top: 20px;
        backdrop-filter: blur(10px);
    }

    .total-amount .label {
        font-size: 1rem;
        opacity: 0.9;
        margin-bottom: 10px;
    }

    .total-amount .amount {
        font-size: 2.5rem;
        font-weight: 700;
        color: white;
    }

    .form-section-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: #333;
        margin-bottom: 25px;
        display: flex;
        align-items: center;
        gap: 10px;
        padding-bottom: 15px;
        border-bottom: 3px solid #667eea;
    }

    .form-section-title i {
        color: #667eea;
        font-size: 1.3rem;
    }

    .form-group label {
        font-weight: 600;
        color: #333;
        margin-bottom: 8px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .form-group label i {
        color: #667eea;
        font-size: 0.9rem;
    }

    .form-control, .custom-select {
        border: 2px solid #e0e0e0;
        border-radius: 10px;
        padding: 12px 15px;
        font-size: 1rem;
        transition: all 0.3s ease;
    }

    .form-control:focus, .custom-select:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        outline: none;
    }

    .form-control::placeholder {
        color: #999;
    }

    .btn-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        border-radius: 12px;
        padding: 15px 40px;
        font-size: 1.1rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 1px;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
        width: 100%;
        margin-top: 20px;
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(102, 126, 234, 0.5);
        background: linear-gradient(135deg, #764ba2 0%, #667eea 100%);
    }

    .step-indicator {
        display: flex;
        justify-content: center;
        margin-bottom: 40px;
        gap: 20px;
    }

    .step {
        display: flex;
        align-items: center;
        gap: 10px;
        color: white;
        font-weight: 600;
    }

    .step-number {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: rgba(255,255,255,0.3);
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
    }

    .step.active .step-number {
        background: white;
        color: #667eea;
    }

    .divider {
        height: 2px;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.5), transparent);
        margin: 30px 0;
    }

    .info-box {
        background: #f8f9fa;
        border-left: 4px solid #667eea;
        border-radius: 8px;
        padding: 15px;
        margin-bottom: 20px;
    }

    .info-box i {
        color: #667eea;
        margin-right: 10px;
    }

    .cart-items-list::-webkit-scrollbar {
        width: 6px;
    }

    .cart-items-list::-webkit-scrollbar-track {
        background: rgba(255,255,255,0.1);
        border-radius: 10px;
    }

    .cart-items-list::-webkit-scrollbar-thumb {
        background: rgba(255,255,255,0.3);
        border-radius: 10px;
    }

    .cart-items-list::-webkit-scrollbar-thumb:hover {
        background: rgba(255,255,255,0.5);
    }

    /* Success Modal */
    .success-modal {
        display: none;
        position: fixed;
        z-index: 10000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0,0,0,0.5);
        animation: fadeIn 0.3s;
    }

    .success-modal.show {
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .success-modal-content {
        background: white;
        border-radius: 20px;
        padding: 40px;
        max-width: 500px;
        width: 90%;
        text-align: center;
        box-shadow: 0 20px 60px rgba(0,0,0,0.3);
        animation: slideUp 0.3s;
    }

    .success-icon {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        background: #4CAF50;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 20px;
    }

    .success-icon i {
        color: white;
        font-size: 50px;
    }

    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    @keyframes slideUp {
        from {
            transform: translateY(50px);
            opacity: 0;
        }
        to {
            transform: translateY(0);
            opacity: 1;
        }
    }

    @media (max-width: 768px) {
        .checkout-page {
            padding: 40px 0;
        }

        .checkout-card {
            padding: 25px;
        }

        .checkout-header h1 {
            font-size: 2rem;
        }

        .order-summary-card {
            position: relative;
            top: 0;
            margin-bottom: 30px;
            }
        }
    </style>

<div class="checkout-page">
    <div class="checkout-container">
        <div class="checkout-header">
            <h1>Đặt Hàng</h1>
            <p>Hoàn tất thông tin để đặt hàng</p>
        </div>

        <div class="step-indicator">
            <div class="step active">
                <div class="step-number">1</div>
                <span>Thông tin giao hàng</span>
            </div>
            <div class="step">
                <div class="step-number">2</div>
                <span>Xác nhận đơn hàng</span>
            </div>
    </div>

    <div class="row">
            <!-- Order Summary -->
            <div class="col-lg-4 order-lg-2 mb-4">
                <div class="order-summary-card">
                    <h4>
                        <i class="fas fa-shopping-cart"></i>
                        Tóm tắt đơn hàng
            </h4>
                    <div class="divider"></div>
                    
                    <!-- Danh sách sản phẩm -->
                    <div class="cart-items-list" style="max-height: 400px; overflow-y: auto; margin-bottom: 20px;">
                        @if(isset($cart_items) && count($cart_items) > 0)
                            @foreach($cart_items as $item)
                                <div class="cart-item" style="background: rgba(255,255,255,0.15); border-radius: 12px; padding: 15px; margin-bottom: 15px; backdrop-filter: blur(10px);">
                                    <div class="d-flex align-items-center">
                                        <div class="item-image" style="width: 60px; height: 60px; border-radius: 8px; overflow: hidden; margin-right: 12px; flex-shrink: 0;">
                                            <img src="{{ asset('assets/images/'.$item->product_image) }}" 
                                                 alt="{{ $item->product_name }}" 
                                                 style="width: 100%; height: 100%; object-fit: cover;">
                                        </div>
                                        <div class="item-details" style="flex: 1; min-width: 0;">
                                            <div class="item-name" style="font-weight: 600; font-size: 0.95rem; color: white; margin-bottom: 5px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                                {{ $item->product_name }}
                                            </div>
                                            <div class="item-quantity" style="font-size: 0.85rem; color: rgba(255,255,255,0.8); margin-bottom: 5px;">
                                                Số lượng: {{ $item->quantity }}
                                            </div>
                                            <div class="item-price" style="font-weight: 700; font-size: 1rem; color: white;">
                                                @php
                                                    $price_value = (float)$item->subtotal * 1000;
                                                    $formatted_price = number_format($price_value, 0, ',', '.');
                                                @endphp
                                                {{ $formatted_price }} VNĐ
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div style="text-align: center; padding: 20px; color: rgba(255,255,255,0.8);">
                                <i class="fas fa-shopping-cart" style="font-size: 2rem; margin-bottom: 10px; opacity: 0.5;"></i>
                                <p>Giỏ hàng trống</p>
                            </div>
                        @endif
        </div>

                    <div class="divider"></div>

                    <div class="total-amount">
                        <div class="label">Tổng tiền</div>
                        <div class="amount">
                            @php
                                $total_value = (float)$total * 1000;
                                $formatted_total = number_format($total_value, 0, ',', '.');
                            @endphp
                            {{ $formatted_total }} VNĐ
                        </div>
                    </div>
                    <div class="info-box" style="background: rgba(255,255,255,0.1); border: none; margin-top: 20px;">
                        <i class="fas fa-info-circle"></i>
                    </div>
                </div>
                </div>

            <!-- Shipping Form or Success Message -->
            <div class="col-lg-8 order-lg-1">
                @if(Session::has('order_success'))
                    <!-- Chỉ hiển thị thông báo thành công -->
                    <div class="checkout-card" style="background: linear-gradient(135deg, #4CAF50 0%, #45a049 100%); color: white;">
                        <div style="text-align: center; padding: 20px;">
                            <div style="width: 80px; height: 80px; border-radius: 50%; background: rgba(255,255,255,0.3); display: flex; align-items: center; justify-content: center; margin: 0 auto 20px;">
                                <i class="fas fa-check-circle" style="font-size: 40px; color: white;"></i>
                            </div>
                            <h2 style="color: white; margin-bottom: 15px; font-weight: 700; font-size: 2rem;">Đặt hàng thành công!</h2>
                            <p style="font-size: 1.1rem; margin-bottom: 10px; color: rgba(255,255,255,0.9);">Mã đơn hàng của bạn: <strong style="font-size: 1.3rem; color: white;">{{ Session::get('invoice') }}</strong></p>
                            <p style="color: rgba(255,255,255,0.9); margin-bottom: 30px; font-size: 1rem;">Chúng tôi đã gửi email xác nhận đến địa chỉ email của bạn.</p>
                            <div style="display: flex; gap: 15px; justify-content: center; flex-wrap: wrap;">
                                <a href="/" class="btn" style="background: white; color: #4CAF50; padding: 12px 30px; border-radius: 25px; font-weight: 600; text-decoration: none; transition: all 0.3s; border: 2px solid white;">
                                    <i class="fas fa-home mr-2"></i>Về trang chủ
                                </a>
                                <a href="/my-order" class="btn" style="background: rgba(255,255,255,0.2); color: white; border: 2px solid white; padding: 12px 30px; border-radius: 25px; font-weight: 600; text-decoration: none; transition: all 0.3s;">
                                    <i class="fas fa-shopping-bag mr-2"></i>Xem đơn hàng
                                </a>
                            </div>
                        </div>
                    </div>
                @else
                    <!-- Hiển thị form địa chỉ giao hàng -->
                    <div class="checkout-card">
                        <h3 class="form-section-title">
                            <i class="fas fa-map-marker-alt"></i>
                            Địa chỉ giao hàng
                        </h3>

                        <form method="POST" action="{{url('confirm_place_order/'.$total)}}" class="needs-validation" id="orderForm" novalidate>
                        @csrf

                        <div class="form-group">
                            <label for="address">
                                <i class="fas fa-home"></i>
                                Địa chỉ
                            </label>
                            <input type="text" class="form-control" name="address" id="address" 
                                   placeholder="Số nhà, tên đường" required>
                        <div class="invalid-feedback">
                                Vui lòng nhập địa chỉ giao hàng.
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="address2">
                                <i class="fas fa-building"></i>
                                Địa chỉ 2 <span class="text-muted">(Tùy chọn)</span>
                            </label>
                            <input type="text" class="form-control" id="address2" name="address2" 
                                   placeholder="Số phòng, tầng, tòa nhà">
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label for="country">
                                        <i class="fas fa-globe"></i>
                                        Quốc gia
                                    </label>
                                    <select class="custom-select" id="country" name="country" required>
                                        <option value="">Chọn quốc gia...</option>
                                        <option value="Vietnam" selected>Việt Nam</option>
                                    </select>
                                    <div class="invalid-feedback">
                                        Vui lòng chọn quốc gia.
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label for="state">
                                        <i class="fas fa-city"></i>
                                        Tỉnh/Thành phố
                                    </label>
                                    <select class="custom-select" id="state" name="state" required>
                                        <option value="">Chọn tỉnh/thành phố...</option>
                                        <option value="Ha Noi">Hà Nội</option>
                                        <option value="Ho Chi Minh">Hồ Chí Minh</option>
                                        <option value="Da Nang">Đà Nẵng</option>
                                        <option value="Hai Phong">Hải Phòng</option>
                                        <option value="Can Tho">Cần Thơ</option>
                                        <option value="An Giang">An Giang</option>
                                        <option value="Ba Ria - Vung Tau">Bà Rịa - Vũng Tàu</option>
                                        <option value="Bac Lieu">Bạc Liêu</option>
                                        <option value="Bac Kan">Bắc Kạn</option>
                                        <option value="Bac Giang">Bắc Giang</option>
                                        <option value="Bac Ninh">Bắc Ninh</option>
                                        <option value="Ben Tre">Bến Tre</option>
                                        <option value="Binh Dinh">Bình Định</option>
                                        <option value="Binh Duong">Bình Dương</option>
                                        <option value="Binh Phuoc">Bình Phước</option>
                                        <option value="Binh Thuan">Bình Thuận</option>
                                        <option value="Ca Mau">Cà Mau</option>
                                        <option value="Cao Bang">Cao Bằng</option>
                                        <option value="Dak Lak">Đắk Lắk</option>
                                        <option value="Dak Nong">Đắk Nông</option>
                                        <option value="Dien Bien">Điện Biên</option>
                                        <option value="Dong Nai">Đồng Nai</option>
                                        <option value="Dong Thap">Đồng Tháp</option>
                                        <option value="Gia Lai">Gia Lai</option>
                                        <option value="Ha Giang">Hà Giang</option>
                                        <option value="Ha Nam">Hà Nam</option>
                                        <option value="Ha Tinh">Hà Tĩnh</option>
                                        <option value="Hai Duong">Hải Dương</option>
                                        <option value="Hau Giang">Hậu Giang</option>
                                        <option value="Hoa Binh">Hòa Bình</option>
                                        <option value="Hung Yen">Hưng Yên</option>
                                        <option value="Khanh Hoa">Khánh Hòa</option>
                                        <option value="Kien Giang">Kiên Giang</option>
                                        <option value="Kon Tum">Kon Tum</option>
                                        <option value="Lai Chau">Lai Châu</option>
                                        <option value="Lam Dong">Lâm Đồng</option>
                                        <option value="Lang Son">Lạng Sơn</option>
                                        <option value="Lao Cai">Lào Cai</option>
                                        <option value="Long An">Long An</option>
                                        <option value="Nam Dinh">Nam Định</option>
                                        <option value="Nghe An">Nghệ An</option>
                                        <option value="Ninh Binh">Ninh Bình</option>
                                        <option value="Ninh Thuan">Ninh Thuận</option>
                                        <option value="Phu Tho">Phú Thọ</option>
                                        <option value="Phu Yen">Phú Yên</option>
                                        <option value="Quang Binh">Quảng Bình</option>
                                        <option value="Quang Nam">Quảng Nam</option>
                                        <option value="Quang Ngai">Quảng Ngãi</option>
                                        <option value="Quang Ninh">Quảng Ninh</option>
                                        <option value="Quang Tri">Quảng Trị</option>
                                        <option value="Soc Trang">Sóc Trăng</option>
                                        <option value="Son La">Sơn La</option>
                                        <option value="Tay Ninh">Tây Ninh</option>
                                        <option value="Thai Binh">Thái Bình</option>
                                        <option value="Thai Nguyen">Thái Nguyên</option>
                                        <option value="Thanh Hoa">Thanh Hóa</option>
                                        <option value="Thua Thien Hue">Thừa Thiên Huế</option>
                                        <option value="Tien Giang">Tiền Giang</option>
                                        <option value="Tra Vinh">Trà Vinh</option>
                                        <option value="Tuyen Quang">Tuyên Quang</option>
                                        <option value="Vinh Long">Vĩnh Long</option>
                                        <option value="Vinh Phuc">Vĩnh Phúc</option>
                                        <option value="Yen Bai">Yên Bái</option>
                                    </select>
                                    <div class="invalid-feedback">
                                        Vui lòng chọn tỉnh/thành phố.
                                    </div>
                                </div>
                            </div>
                        </div>
              
                        <div class="divider" style="background: #e0e0e0; margin: 30px 0;"></div>
                     
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-check-circle mr-2"></i>
                            Xác nhận đơn hàng
                        </button>
                    </form>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Success Modal -->
<div id="successModal" class="success-modal">
    <div class="success-modal-content">
        <div class="success-icon">
            <i class="fas fa-check"></i>
        </div>
        <h2 style="color: #4CAF50; margin-bottom: 15px;">Đặt hàng thành công!</h2>
        <p id="invoiceNumber" style="font-size: 1.1rem; margin-bottom: 20px;"></p>
        <p style="color: #666; margin-bottom: 30px;">Chúng tôi đã gửi email xác nhận đến địa chỉ email của bạn.</p>
        <div>
            <a href="/" class="btn btn-primary" style="margin-right: 10px;">Về trang chủ</a>
            <a href="/my-order" class="btn btn-outline-primary">Xem đơn hàng</a>
        </div>
    </div>
</div>

<script>
    // Form validation
    (function() {
        'use strict';
        window.addEventListener('load', function() {
            var forms = document.getElementsByClassName('needs-validation');
            var validation = Array.prototype.filter.call(forms, function(form) {
                form.addEventListener('submit', function(event) {
                    if (form.checkValidity() === false) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        }, false);
    })();

    // Hiển thị thông báo thành công nếu có
    @if(Session::has('order_success'))
        // Scroll to top để hiển thị thông báo
        window.scrollTo({ top: 0, behavior: 'smooth' });
    @endif
</script>

@endsection
