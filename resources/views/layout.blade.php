<!DOCTYPE html>
<html lang="vi">

  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" type="image/x-icon" href="{{asset('assets/images/short.jpg') }}">
    <link href="https://fonts.googleapis.com/css?family=Poppins:100,200,300,400,500,600,700,800,900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Dancing+Script:wght@400;500;600;700&display=swap" rel="stylesheet">

    <title>Midway Dine - Your Favourite Foods</title>

    <!-- Additional CSS Files -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/bootstrap.min.css')}}">

    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/font-awesome.css')}}">

    <link rel="stylesheet" href="{{ asset('assets/css/css-library.css')}}">

    <link rel="stylesheet" href="{{ asset('assets/css/owl-carousel.css')}}">

    <link rel="stylesheet" href="{{ asset('assets/css/lightbox.css')}}">

    <script src="{{ asset('assets/js/angular.min.js')}}"></script>
    <script src="{{ asset('assets/js/bKash-checkout.js')}}"></script>
    <script src="{{ asset('assets/js/bKash-checkout-sandbox.js')}}"></script>

    </head>
    
    <body ng-app="">
    
    <!-- ***** Preloader Start ***** -->
    <div id="preloader">
        <div class="jumper">
            <div></div>
            <div></div>
            <div></div>
        </div>
    </div>  
    <!-- ***** Preloader End ***** -->
    
    
    <!-- ***** Header Area Start ***** -->
    <header class="header-area" style="z-index:1000">
        <div class="container">
                    <nav class="main-nav">
                        <!-- ***** Logo Start ***** -->
                        <a href="{{url('home')}}" class="logo">
                            <img width="200px" height="100px" src="{{ asset('assets/images/logo.png')}}" style="object-fit: contain;">
                        </a>
                        <!-- ***** Logo End ***** -->
                        <!-- ***** Menu Start ***** -->
                        <ul class="nav">
                            <li class="scroll-to-section"><a href="/">TRANG CHỦ</a></li>
                            <li class="scroll-to-section"><a href="/#about">VỀ CHÚNG TÔI</a></li>
                           	
                            <li class="scroll-to-section"><a href="/#menu">MENU</a></li>
                        
                            <li class="scroll-to-section"><a href="/trace-my-order">TRA CỨU ĐƠN</a></li>

                            <li class="scroll-to-section"><a href="/my-order">ĐƠN HÀNG</a></li>
                          
                            <li class="scroll-to-section"><a href="/#chefs">ĐẦU BẾP</a></li> 
                            <li class="scroll-to-section"><a href="/#reservation">LIÊN HỆ</a></li>
                            <li><a href="/cart"><i class="fa fa-shopping-cart"></i></a></li>


                            <?php
                                
                                if(Auth::user())
                                {
                        
                                    $cart_amount=DB::table('carts')->where('user_id',Auth::user()->id)->where('product_order','no')->count();
                        
                        
                                }
                                else
                                {
                        
                                    $cart_amount=0;
                        
                                }


                            ?>


                            <span class='badge badge-warning' id='lblCartCount'> {{ $cart_amount }} </span>

                            <style>


                                .badge {
                                padding-left: 9px;
                                padding-right: 9px;
                                padding-top:10px;
                                -webkit-border-radius: 9px;
                                -moz-border-radius: 9px;
                                border-radius: 9px;
                                height:16px;
                                text-align:center;
                                }

                                .label-warning[href],
                                .badge-warning[href] {
                                background-color: #c67605;
                                }
                                #lblCartCount {
                                    font-size: 12px;
                                    background: #ff0000;
                                    color: #fff;
                                    padding: 0 5px;
                                    vertical-align: top;
                                    margin-left: -10px; 
                                }
                                
                                /* ========== FONT INTER & VIETNAMESE OPTIMIZATION ========== */
                                
                                /* Apply Inter font to body */
                                body, h1, h2, h3, h4, h5, h6, p, a, span, div, input, textarea, button, select {
                                    font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
                                }
                                
                                /* Keep Dancing Script for decorative text */
                                .dancing-script {
                                    font-family: 'Dancing Script', cursive !important;
                                }
                                
                                /* IMPORTANT: Keep original fonts for ALL icon elements */
                                .fa, [class*="fa-"], .mdi, [class*="mdi-"], .slick-arrow, .NextArrow, .PreviousArrow, .icon, [class*="icon-"], i {
                                    font-family: 'FontAwesome', 'Material Design Icons', sans-serif !important;
                                }
                                
                                /* Better text rendering for Vietnamese */
                                body {
                                    -webkit-font-smoothing: antialiased;
                                    -moz-osx-font-smoothing: grayscale;
                                    text-rendering: optimizeLegibility;
                                }
                                
                                /* ========== NAVIGATION MENU STYLING ========== */
                                
                                /* Menu items spacing */
                                .header-area .main-nav .nav li {
                                    padding-left: 15px !important;
                                    padding-right: 15px !important;
                                }
                                
                                /* Menu text styling - TO, ĐẬM, IN HOA */
                                .header-area .main-nav .nav li a {
                                    font-size: 15px !important;
                                    font-weight: 700 !important;
                                    text-transform: uppercase !important;
                                    white-space: nowrap;
                                    letter-spacing: 0.5px !important;
                                }
                                
                                /* Logo alignment */
                                .header-area .main-nav .logo {
                                    line-height: 100px !important;
                                    display: inline-block;
                                    vertical-align: middle;
                                }
                                
                                .header-area .main-nav .logo img {
                                    vertical-align: middle;
                                    margin-top: 0px;
                                }
                                
                                /* Nav vertical position */
                                .header-area .main-nav .nav {
                                    margin-top: 27px !important;
                                    float: none !important;
                                    width: auto !important;
                                    max-width: 100% !important;
                                    display: flex !important;
                                    flex-wrap: nowrap !important;
                                }
                                
                                /* Main nav container */
                                .header-area .main-nav {
                                    display: flex;
                                    align-items: center;
                                    justify-content: space-between;
                                }
                                
                                /* ========== RESPONSIVE ========== */
                                
                                @media (max-width: 1400px) {
                                    .header-area .main-nav .nav li {
                                        padding-left: 12px !important;
                                        padding-right: 12px !important;
                                    }
                                    .header-area .main-nav .nav li a {
                                        font-size: 14px !important;
                                    }
                                }
                                
                                @media (max-width: 1200px) {
                                    .header-area .main-nav .nav li {
                                        padding-left: 8px !important;
                                        padding-right: 8px !important;
                                    }
                                    .header-area .main-nav .nav li a {
                                        font-size: 13px !important;
                                        letter-spacing: 0.3px !important;
                                    }
                                }
                                
                                /* ========== USER PROFILE DROPDOWN - 1 DÒNG ========== */
                                
                                nav.bg-white .inline-flex button[type="button"].inline-flex,
                                nav.bg-white .inline-flex button[type="button"],
                                .header-area ~ * nav button[type="button"],
                                .header-area nav button[type="button"] {
                                    white-space: nowrap !important;
                                    display: inline-flex !important;
                                    align-items: center !important;
                                    flex-wrap: nowrap !important;
                                    max-width: none !important;
                                    width: auto !important;
                                }
                                
                                nav.bg-white button[type="button"] span,
                                nav.bg-white button[type="button"] {
                                    white-space: nowrap !important;
                                    overflow: visible !important;
                                }
                                
                                /* ========== PRODUCT CARDS - HOVER & INFO OVERLAY ========== */
                                
                                /* Card cao cố định */
                                #menu .card {
                                    height: 520px !important;
                                    position: relative !important;
                                    overflow: hidden !important;
                                    border-radius: 15px !important;
                                    transition: transform 0.4s ease-out, 
                                                box-shadow 0.4s ease-out,
                                                border-radius 0.4s ease-out !important;
                                    transform-origin: center center !important;
                                }
                                
                                /* Price tag rộng hơn cho card món ăn */
                                #menu .price h6 {
                                    width: 150px !important; /* Tăng từ 70px lên 150px */
                                    min-width: 150px !important;
                                    height: 70px !important;
                                    background-color: #fb5849 !important;
                                    font-size: 18px !important;
                                    font-weight: 700 !important;
                                    color: #fff !important;
                                    border-radius: 3px !important;
                                    text-align: center !important;
                                    line-height: 70px !important;
                                    padding: 0 10px !important; /* Thêm padding để text không sát viền */
                                    white-space: nowrap !important;
                                    overflow: hidden !important;
                                    text-overflow: ellipsis !important;
                                    display: flex !important;
                                    align-items: center !important;
                                    justify-content: center !important;
                                }
                                
                                /* Khi hover: card phóng to ra và bo tròn hơn */
                                #menu .card:hover {
                                    transform: scale(1.05) !important;
                                    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3) !important;
                                    border-radius: 30px !important;
                                    z-index: 100 !important;
                                }
                                
                                /* Tên món hiển thị khi không hover */
                                #menu .card .info .product-name-compact {
                                    display: block !important;
                                    color: #fff !important;
                                    font-size: 18px !important;
                                    font-weight: 700 !important;
                                    margin: 0 0 10px 0 !important;
                                    padding: 0 !important;
                                    line-height: 1.3 !important;
                                    text-align: left !important;
                                }
                                
                                #menu .card .info .main-text-button {
                                    margin-left: 30px !important;
                                    margin-right: 30px !important;
                                    padding-left: 0 !important;
                                    padding-right: 0 !important;
                                }
                                
                                /* Ẩn tên món trong .title khi không hover */
                                #menu .card .info .title {
                                    display: none !important;
                                }
                                
                                /* Hiển thị lại tên món trong .title khi hover */
                                #menu .card:hover .info .title {
                                    display: block !important;
                                }
                                
                                /* Ẩn tên món compact khi hover */
                                #menu .card:hover .info .product-name-compact {
                                    display: none !important;
                                }
                                
                                /* Overlay info cố định phía dưới */
                                #menu .card .info {
                                    position: absolute !important;
                                    bottom: 0 !important;
                                    left: 0 !important;
                                    right: 0 !important;
                                    background: rgba(251, 88, 73, 0.95);
                                    padding: 20px;
                                    max-height: 270px !important; /* Tăng lên để đủ chỗ cho tên 2 dòng */
                                    height: 270px !important;
                                    min-height: 270px !important;
                                    overflow: hidden !important;
                                    transition: max-height 0.6s cubic-bezier(0.4, 0, 0.2, 1),
                                                height 0.6s cubic-bezier(0.4, 0, 0.2, 1) !important;
                                    transform: translateY(0) !important;
                                    display: flex;
                                    flex-direction: column;
                                }
                                
                                #menu .card .info,
                                #menu .card .info:before {
                                    transform: translateY(0) !important;
                                }
                                
                                #menu .card .info > * {
                                    flex-shrink: 0 !important;
                                }
                                
                                /* Giới hạn chiều cao tên món để không chiếm quá nhiều chỗ */
                                #menu .card .info .product-name-compact {
                                    max-height: 50px !important; /* Giới hạn tối đa 2 dòng */
                                    overflow: hidden !important;
                                    line-height: 1.3 !important;
                                    display: -webkit-box !important;
                                    -webkit-line-clamp: 2 !important; /* Tối đa 2 dòng */
                                    -webkit-box-orient: vertical !important;
                                }
                                
                                #menu .card .info .main-text-button {
                                    margin-top: auto !important; /* Đẩy xuống cuối */
                                    flex-shrink: 0 !important; /* Không bị co lại */
                                    min-height: 80px !important; /* Đảm bảo có đủ chỗ cho button */
                                }
                                
                                /* Ẩn mô tả khi không hover */
                                #menu .card .info .description {
                                    max-height: 0px !important;
                                    overflow: hidden !important;
                                    margin: 0 !important;
                                    padding: 0 !important;
                                    opacity: 0 !important;
                                    transition: max-height 0.3s ease, opacity 0.3s ease !important;
                                }
                                
                                /* Hiển thị mô tả khi hover */
                                #menu .card:hover .info .description {
                                    max-height: 200px !important;
                                    opacity: 1 !important;
                                    margin-bottom: 15px !important;
                                    padding: 0px 30px !important;
                                }
                                
                                /* Khi hover: mở rộng overlay lên 80% */
                                #menu .card:hover .info {
                                    max-height: 416px !important;
                                    height: 416px !important;
                                    overflow-y: auto !important;
                                    transform: translateY(0) !important;
                                    transition: max-height 0.6s cubic-bezier(0.4, 0, 0.2, 1),
                                                height 0.6s cubic-bezier(0.4, 0, 0.2, 1) !important;
                                }
                                
                                #menu .card:hover .info:before {
                                    transform: none !important;
                                }
                                
                                /* Nút Add to Cart luôn nằm cuối overlay */
                                #menu .card .info .main-text-button {
                                    margin-top: auto;
                                    padding-top: 10px;
                                    padding-bottom: 10px;
                                    flex-shrink: 0;
                                    background: rgba(251, 88, 73, 0.95);
                                    position: sticky;
                                    bottom: 0;
                                    z-index: 10;
                                }
                                
                                /* Scrollbar nhỏ gọn */
                                #menu .card .info::-webkit-scrollbar {
                                    width: 5px;
                                }
                                #menu .card .info::-webkit-scrollbar-thumb {
                                    background: rgba(255, 255, 255, 0.3);
                                    border-radius: 10px;
                                }
                                
                                /* ========== SẮP XẾP TAB ITEMS - MÓN CUỐN CHÍNH, PHỤ, ĐỒ UỐNG ========== */
                                
                                /* Reset và giữ layout gốc nhưng cải thiện */
                                #offers .tab-item {
                                    position: relative !important;
                                    margin-bottom: 30px !important; /* Giảm margin */
                                    padding: 15px !important; /* Giảm padding */
                                    background: #fff !important;
                                    border-radius: 8px !important;
                                    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08) !important;
                                    transition: transform 0.3s ease, box-shadow 0.3s ease !important;
                                }
                                
                                #offers .tab-item:hover {
                                    transform: translateY(-3px) !important;
                                    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.12) !important;
                                }
                                
                                /* Ảnh nhỏ gọn hơn - giữ layout gốc */
                                #offers .tab-item img {
                                    float: left !important;
                                    width: 120px !important; /* Tăng từ 100px lên 120px */
                                    max-width: 120px !important;
                                    height: 120px !important; /* Thêm height cố định */
                                    object-fit: cover !important;
                                    margin-right: 20px !important;
                                    border-radius: 8px !important;
                                    margin-bottom: 0 !important;
                                }
                                
                                /* Đảm bảo các cột sắp xếp đều */
                                #offers .row {
                                    display: flex !important;
                                    flex-wrap: wrap !important;
                                }
                                
                                #offers .col-lg-6,
                                #offers .col-md-6,
                                #offers .col-sm-12 {
                                    display: block !important; /* Không dùng flex để giữ layout gốc */
                                }
                                
                                /* Text styling */
                                #offers .tab-item h4 {
                                    font-size: 18px !important; /* Giảm từ 20px */
                                    font-weight: 700 !important;
                                    margin-bottom: 8px !important;
                                    color: #2a2a2a !important;
                                    padding-top: 0 !important;
                                    margin-right: 130px !important; /* Thêm margin-right để tránh bị tag giá che */
                                }
                                
                                /* Mô tả - giới hạn chiều cao và thêm scroll, tránh bị tag giá che */
                                #offers .tab-item p {
                                    font-size: 13px !important;
                                    line-height: 1.5 !important;
                                    color: #666 !important;
                                    margin-bottom: 10px !important;
                                    margin-right: 130px !important; /* Thêm margin-right để tránh bị tag giá che */
                                    max-height: 80px !important; /* Giới hạn chiều cao */
                                    overflow-y: auto !important; /* Thêm scroll nếu quá dài */
                                    overflow-x: hidden !important;
                                    text-overflow: ellipsis !important;
                                    display: -webkit-box !important;
                                    -webkit-line-clamp: 4 !important; /* Tối đa 4 dòng */
                                    -webkit-box-orient: vertical !important;
                                }
                                
                                /* Title cũng cần margin-right để tránh bị che */
                                #offers .tab-item h4 {
                                    margin-right: 130px !important;
                                }
                                
                                /* Scrollbar cho mô tả */
                                #offers .tab-item p::-webkit-scrollbar {
                                    width: 4px;
                                }
                                #offers .tab-item p::-webkit-scrollbar-thumb {
                                    background: rgba(0, 0, 0, 0.2);
                                    border-radius: 10px;
                                }
                                
                                /* Price styling - tag tiền dài ra */
                                #offers .tab-item .price {
                                    margin-top: 10px !important;
                                }
                                
                                #offers .tab-item .price h6 {
                                    position: absolute !important;
                                    top: 15px !important;
                                    right: 0 !important;
                                    width: 120px !important; /* Tăng từ 70px lên 120px */
                                    min-width: 120px !important;
                                    height: 70px !important;
                                    background-color: #fb5849 !important;
                                    display: inline-flex !important;
                                    align-items: center !important;
                                    justify-content: center !important;
                                    text-align: center !important;
                                    line-height: 70px !important;
                                    border-radius: 3px !important;
                                    font-size: 18px !important;
                                    font-weight: 700 !important;
                                    color: #fff !important;
                                    margin: 0 !important;
                                    padding: 0 10px !important; /* Thêm padding để text không sát viền */
                                    white-space: nowrap !important;
                                    overflow: hidden !important;
                                    text-overflow: ellipsis !important;
                                }
                                
                                /* Rating cũng cần margin-right để tránh bị che */
                                #offers .tab-item .product_rating {
                                    margin-right: 130px !important;
                                    margin-top: 5px !important;
                                }
                                
                                /* Clear float */
                                #offers .tab-item::after {
                                    content: "";
                                    display: table;
                                    clear: both;
                                }
                                
                                /* ========== NÚT CUỐN LIỀN - NGHỆ THUẬT ========== */
                                .main-white-button {
                                    border-radius: 25px !important;
                                    overflow: hidden !important;
                                    transition: transform 0.3s ease, box-shadow 0.3s ease !important;
                                }
                                
                                .main-white-button:hover {
                                    transform: translateY(-3px) !important;
                                    box-shadow: 0 5px 15px rgba(251, 88, 73, 0.3) !important;
                                }
                                
                                .main-white-button a {
                                    border-radius: 25px !important;
                                    font-family: 'Dancing Script', cursive !important;
                                    font-size: 42px !important;
                                    font-weight: 700 !important;
                                    color: #fb5849 !important;
                                    text-decoration: none !important;
                                    display: block !important;
                                    padding: 18px 50px !important;
                                    transition: all 0.3s ease !important;
                                }
                                
                                .main-white-button a:hover {
                                    color: #d15400 !important;
                                    background: rgba(251, 88, 73, 0.1) !important;
                                }
                                
                                .main-white-button h2 {
                                    margin: 0 !important;
                                    font-family: 'Dancing Script', cursive !important;
                                    font-size: 42px !important;
                                    font-weight: 700 !important;
                                    color: #fb5849 !important;
                                }
                                
                                /* Responsive cho button */
                                @media (max-width: 768px) {
                                    .main-white-button a,
                                    .main-white-button h2 {
                                        font-size: 36px !important;
                                        padding: 15px 40px !important;
                                    }
                                }
                                
                                /* ========== STYLING CHO TIÊU ĐỀ MÓN NỔI BẬT ========== */
                                #offers .section-heading h1 {
                                    font-family: 'Dancing Script', cursive !important;
                                    font-size: 56px !important;
                                    font-weight: 700 !important;
                                    color: #fb5849 !important;
                                    margin-bottom: 15px !important;
                                    text-shadow: 2px 2px 4px rgba(0,0,0,0.1) !important;
                                    letter-spacing: 2px !important;
                                    line-height: 1.2 !important;
                                }
                                
                                #offers .section-heading h3 {
                                    font-family: 'Inter', sans-serif !important;
                                    font-size: 20px !important;
                                    font-weight: 500 !important;
                                    color: #666 !important;
                                    letter-spacing: 1px !important;
                                    text-transform: uppercase !important;
                                    margin-top: 10px !important;
                                }
                                
                                /* Responsive cho tiêu đề */
                                @media (max-width: 768px) {
                                    #offers .section-heading h1 {
                                        font-size: 42px !important;
                                    }
                                    #offers .section-heading h3 {
                                        font-size: 16px !important;
                                    }
                                }
                            </style>
                            <li>
                                @if (Route::has('login'))
                                <div class="hidden fixed top-0 right-0 px-6 py-4 sm:block">
                                    @auth
                                        <li style="margin-top:-13px;">
                                            <x-app-layout> </x-app-layout>
                                        </li>
                                    @else
                                      <li>
                                        <a href="{{ route('login') }}" class="text-sm text-gray-700 underline">Log in</a>
                                      </li>
                                        @if (Route::has('register'))
                                            <li><a href="{{ route('register') }}" class="ml-4 text-sm text-gray-700 underline">Register</a> </li>
                                        @endif
                                    @endauth
                                </div>
                                @endif
                            </li>
                        </ul>        
                        
                        <!-- ***** Menu End ***** -->
                    </nav>
        </div>
    </header>
    <!-- ***** Header Area End ***** -->

    <div style="min-height:750px">
        @yield('page-content')
    </div>

    <!-- ***** Footer Start ***** -->
    <footer style="background: #2a2a2a; color: #fff; padding: 60px 0 30px;">
        <div class="container">
            <div class="row">
                <!-- Cột 1: Logo và Thông Tin -->
                <div class="col-lg-3 col-md-6 col-sm-12" style="margin-bottom: 30px;">
                    <div class="logo" style="margin-bottom: 20px;">
                        <a href="{{url('home')}}"><img src="{{ asset('assets/images/logo.png')}}" alt="S-Cuốn" style="width: 180px; height: auto; filter: brightness(0) invert(1);"></a>
                    </div>
                    <p style="color: #ccc; line-height: 1.8; margin-bottom: 20px;">
                        Nhà hàng buffet Việt Nam hàng đầu, mang đến trải nghiệm ẩm thực đặc biệt cho thực khách.
                    </p>
                    <ul class="social-icons" style="list-style: none; padding: 0; display: flex; gap: 15px;">
                        <li><a href="#" style="color: #fff; font-size: 20px;"><i class="fa fa-facebook"></i></a></li>
                        <li><a href="#" style="color: #fff; font-size: 20px;"><i class="fa fa-instagram"></i></a></li>
                        <li><a href="#" style="color: #fff; font-size: 20px;"><i class="fa fa-youtube"></i></a></li>
                        <li><a href="#" style="color: #fff; font-size: 20px;"><i class="fa fa-zalo"></i></a></li>
                    </ul>
                </div>

                <!-- Cột 2: Liên Kết Nhanh -->
                <div class="col-lg-3 col-md-6 col-sm-12" style="margin-bottom: 30px;">
                    <h4 style="color: #fb5849; margin-bottom: 20px; font-size: 18px; font-weight: 700;">Liên Kết Nhanh</h4>
                    <ul style="list-style: none; padding: 0; line-height: 2.5;">
                        <li><a href="/" style="color: #ccc; text-decoration: none; transition: color 0.3s;">Trang Chủ</a></li>
                        <li><a href="/#menu" style="color: #ccc; text-decoration: none; transition: color 0.3s;">Thực Đơn</a></li>
                        <li><a href="/#about" style="color: #ccc; text-decoration: none; transition: color 0.3s;">Về Chúng Tôi</a></li>
                        <li><a href="/#reservation" style="color: #ccc; text-decoration: none; transition: color 0.3s;">Đặt Bàn</a></li>
                        <li><a href="/trace-my-order" style="color: #ccc; text-decoration: none; transition: color 0.3s;">Tra Cứu Đơn Hàng</a></li>
                    </ul>
                </div>

                <!-- Cột 3: Chính Sách và Điều Khoản -->
                <div class="col-lg-3 col-md-6 col-sm-12" style="margin-bottom: 30px;">
                    <h4 style="color: #fb5849; margin-bottom: 20px; font-size: 18px; font-weight: 700;">Chính Sách</h4>
                    <ul style="list-style: none; padding: 0; line-height: 2.5;">
                        <li><a href="{{ route('terms-of-use') }}" style="color: #ccc; text-decoration: none; transition: color 0.3s;">Điều Khoản Sử Dụng</a></li>
                        <li><a href="{{ route('cookie-policy') }}" style="color: #ccc; text-decoration: none; transition: color 0.3s;">Chính Sách Cookie</a></li>
                        <li><a href="{{ route('privacy-policy') }}" style="color: #ccc; text-decoration: none; transition: color 0.3s;">Chính Sách Bảo Mật</a></li>
                        <li><a href="{{ route('recruitment') }}" style="color: #ccc; text-decoration: none; transition: color 0.3s;">Thông Tin Tuyển Dụng</a></li>
                        <li><a href="{{ route('invoice-lookup') }}" style="color: #ccc; text-decoration: none; transition: color 0.3s;">Tra Cứu Hóa Đơn Điện Tử</a></li>
                    </ul>
                </div>

                <!-- Cột 4: Google Map -->
                <div class="col-lg-3 col-md-6 col-sm-12" style="margin-bottom: 30px;">
                    <h4 style="color: #fb5849; margin-bottom: 20px; font-size: 18px; font-weight: 700;">Địa Chỉ</h4>
                    <p style="color: #ccc; line-height: 1.8; margin-bottom: 15px;">
                        <i class="fa fa-map-marker" style="color: #fb5849; margin-right: 10px;"></i>
                        17T6 P. Hoàng Đạo Thúy, Nhân Chính, Thanh Xuân, Hà Nội 10000, Vietnam<br>
                    </p>
                    <p style="color: #ccc; line-height: 1.8; margin-bottom: 15px;">
                        <i class="fa fa-phone" style="color: #fb5849; margin-right: 10px;"></i>
                        0123 456 789
                    </p>
                    <p style="color: #ccc; line-height: 1.8;">
                        <i class="fa fa-envelope" style="color: #fb5849; margin-right: 10px;"></i>
                        info@scuon.vn
                    </p>
                    <div style="margin-top: 15px; border-radius: 8px; overflow: hidden;">
                    <iframe 
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3724.6603379191256!2d105.80155607540748!3d21.00624838063758!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3135aca18b388933%3A0x5666d2762f469c61!2sCuon%20N%20Roll%20Restaurant!5e0!3m2!1sen!2s!4v1765578351948!5m2!1sen!2s" 
                        width="100%" 
                        height="150" 
                        style="border:0; border-radius: 8px;" 
                        allowfullscreen="" 
                        loading="lazy" 
                        referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                </div>  

                </div>
            </div>

            <!-- Copyright -->
            <div class="row" style="margin-top: 40px; padding-top: 30px; border-top: 1px solid #444; text-align: center;">
                <div class="col-lg-12">
                    <p style="color: #999; margin: 0;">
                        © {{ __('site.Copyright') }} S-Cuốn {{ __('site.Since') }} 2025. Tất cả quyền được bảo lưu.
                    </p>
                </div>
            </div>
        </div>
    </footer>

    <style>
        footer a:hover {
            color: #fb5849 !important;
        }
        
        /* Làm mờ background image của section reservation */
        #reservation {
            position: relative !important;
        }
        
        #reservation::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5) !important; /* Lớp phủ tối với độ mờ 50% */
            z-index: 1;
            pointer-events: none;
        }
        
        #reservation .container {
            position: relative;
            z-index: 2;
        }
        
        /* Tăng độ mờ hơn nếu cần - có thể điều chỉnh opacity */
        /* background: rgba(0, 0, 0, 0.6) !important; cho mờ hơn */
        /* background: rgba(0, 0, 0, 0.4) !important; cho mờ ít hơn */
    </style>

    <!-- jQuery -->
    <script src="{{ asset('assets/js/jquery-2.1.0.min.js')}}"></script>

    <!-- Bootstrap -->
    <script src="{{ asset('assets/js/popper.js')}}"></script>
    <script src="{{ asset('assets/js/bootstrap.min.js')}}"></script>

    <!-- Plugins -->
    <script src="{{ asset('assets/js/owl-carousel.js')}}"></script>
    <script src="{{ asset('assets/js/accordions.js')}}"></script>
    <script src="{{ asset('assets/js/datepicker.js')}}"></script>
    <script src="{{ asset('assets/js/scrollreveal.min.js')}}"></script>
    <script src="{{ asset('assets/js/waypoints.min.js')}}"></script>
    <script src="{{ asset('assets/js/jquery.counterup.min.js')}}"></script>
    <script src="{{ asset('assets/js/imgfix.min.js')}}"></script> 
    <script src="{{ asset('assets/js/slick.js')}}"></script> 
    <script src="{{ asset('assets/js/lightbox.js')}}"></script> 
    <script src="{{ asset('assets/js/isotope.js')}}"></script> 
    
    <!-- Global Init -->
    <script src="{{ asset('assets/js/custom.js')}}"></script>
    <script>

        $(function() {
            var selectedClass = "";
            $("p").click(function(){
            selectedClass = $(this).attr("data-rel");
            $("#portfolio").fadeTo(50, 0.1);
                $("#portfolio div").not("."+selectedClass).fadeOut();
            setTimeout(function() {
              $("."+selectedClass).fadeIn();
              $("#portfolio").fadeTo(50, 1);
            }, 500);
                
            });
        });

    </script>
  </body>
</html>