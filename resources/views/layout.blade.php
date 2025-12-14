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

    <title>S-Cuốn - Món Cuốn Yêu Thích Của Bạn</title>

    <!-- Additional CSS Files -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/bootstrap.min.css')}}">

    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/font-awesome.css')}}">

    <link rel="stylesheet" href="{{ asset('assets/css/css-library.css')}}">

    <link rel="stylesheet" href="{{ asset('assets/css/owl-carousel.css')}}">

    <link rel="stylesheet" href="{{ asset('assets/css/lightbox.css')}}">

    @stack('styles')

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
    <header class="header-area" style="z-index:1000;height: 90px;">
        <div class="container">
                    <nav class="main-nav">
                        <!-- ***** Menu Start ***** -->
                        <ul class="nav">

                            <!-- ***** Logo Start ***** -->
                            <li class="logo-item">
                                <a href="/" class="logo">
                                    <img width="100px" height="100px" src="{{ asset('assets/images/logo.png')}}" style="object-fit: contain;">
                                </a>
                            </li>
                            <!-- ***** Logo End ***** -->
                            <li class="scroll-to-section"><a href="/">TRANG CHỦ</a></li>
                            <li class="scroll-to-section"><a href="/#about">VỀ CHÚNG TÔI</a></li>
                           	
                            <li class="scroll-to-section"><a href="/menu">MENU</a></li>
                        
                            <li class="scroll-to-section"><a href="/trace-my-order">TRA CỨU ĐƠN</a></li>

                            <li class="scroll-to-section"><a href="/my-order">ĐƠN HÀNG</a></li>
                          
                            <li class="scroll-to-section"><a href="{{ route('posts.index') }}">BÀI VIẾT</a></li> 
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
                                
                                /* Logo alignment - ở giữa menu */
                                .header-area .main-nav .nav li.logo-item {
                                    padding: 0 30px !important;
                                    display: flex;
                                    align-items: center;
                                    justify-content: center;
                                    margin-top: -10px !important;
                                }
                                
                                .header-area .main-nav .logo {
                                    line-height: 100px !important;
                                    display: inline-block;
                                    vertical-align: middle;
                                    margin: 0;
                                    margin-top: -15px !important;
                                }
                                
                                .header-area .main-nav .logo img {
                                    margin-top: 0px;
                                    max-width: 180px;
                                    height: auto;
                                    display: block;
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
                                    justify-content: center;
                                }
                                
                                /* Menu container - căn giữa */
                                .header-area .main-nav .nav {
                                    justify-content: center;
                                    align-items: center;
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
                                
                                /* ========== MENU SECTION HEADING ========== */
                                    #menu .section-heading {
                                        text-align: center !important;
                                        margin-bottom: 60px !important;
                                    }
                                    
                                    #menu .menu-section-title {
                                        font-family: 'Dancing Script', cursive !important;
                                        font-size: 4.5rem !important;
                                        font-weight: 700 !important;
                                        background: linear-gradient(135deg, #fb5849 0%, #d15400 30%, #ff6b5a 60%, #fb5849 100%) !important;
                                        -webkit-background-clip: text !important;
                                        -webkit-text-fill-color: transparent !important;
                                        background-clip: text !important;
                                        letter-spacing: 3px !important;
                                        text-shadow: 0 4px 20px rgba(251, 88, 73, 0.3) !important;
                                        position: relative !important;
                                        display: inline-block !important;
                                        margin-bottom: 20px !important;
                                        padding: 0 !important;
                                        padding-left: 0 !important;
                                        animation: titleGlow 3s ease-in-out infinite !important;
                                    }
                                    
                                    #menu .menu-section-title:before {
                                        display: none !important;
                                    }
                                    
                                    @keyframes titleGlow {
                                        0%, 100% {
                                            filter: drop-shadow(0 0 10px rgba(251, 88, 73, 0.3));
                                        }
                                        50% {
                                            filter: drop-shadow(0 0 20px rgba(251, 88, 73, 0.6));
                                        }
                                    }
                                    
                                    #menu .menu-section-subtitle {
                                        font-family: 'Inter', sans-serif !important;
                                        font-size: 1.5rem !important;
                                        font-weight: 400 !important;
                                        font-style: italic !important;
                                        color: #666 !important;
                                        letter-spacing: 2px !important;
                                        margin-top: 10px !important;
                                        margin-bottom: 0 !important;
                                        position: relative !important;
                                        padding: 0 20px !important;
                                    }
                                    
                                    #menu .menu-section-subtitle::before,
                                    #menu .menu-section-subtitle::after {
                                        content: '✦' !important;
                                        color: #fb5849 !important;
                                        font-size: 1.2rem !important;
                                        margin: 0 15px !important;
                                        opacity: 0.7 !important;
                                    }
                                    
                                    @media (max-width: 768px) {
                                        #menu .menu-section-title {
                                            font-size: 3rem !important;
                                        }
                                        #menu .menu-section-subtitle {
                                            font-size: 1.2rem !important;
                                        }
                                    }
                                
                                /* ========== PRODUCT CARDS - HOVER & INFO OVERLAY ========== */
                                    #menu .card {
                                        height: 520px !important;
                                        position: relative !important;
                                        overflow: hidden !important;
                                        border-radius: 15px !important;
                                        transition: transform 0.4s ease-out, box-shadow 0.4s ease-out, border-radius 0.4s ease-out !important;
                                        transform-origin: center center !important;
                                    }

                                    #menu .card:hover {
                                        transform: scale(1.05) !important;
                                        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3) !important;
                                        border-radius: 30px !important;
                                        z-index: 100 !important;
                                    }

                                    #menu .card[data-bg-image] {
                                        background-image: var(--bg-image);
                                        background-size: cover;
                                        background-position: center;
                                    }

                                    /* --- PRICE TAG --- */
                                    #menu .card .price {
                                        position: absolute !important;
                                        top: 0 !important;
                                        right: 0 !important;
                                        z-index: 10 !important;
                                    }

                                    #menu .price h6 {
                                        width: 150px !important;
                                        min-width: 150px !important;
                                        height: 70px !important;
                                        background-color: #fb5849 !important;
                                        font-size: 18px !important;
                                        font-weight: 700 !important;
                                        color: #fff !important;
                                        border-radius: 3px !important;
                                        text-align: center !important;
                                        line-height: 70px !important;
                                        padding: 0 10px !important;
                                        white-space: nowrap !important;
                                        overflow: hidden !important;
                                        text-overflow: ellipsis !important;
                                        display: flex !important;
                                        align-items: center !important;
                                        justify-content: center !important;
                                        margin: 0 !important;
                                    }

                                    /* --- INFO OVERLAY (PHẦN NỀN ĐỎ DƯỚI) --- */
                                    #menu .card .info {
                                        position: absolute !important;
                                        bottom: 0 !important;
                                        left: 0 !important;
                                        right: 0 !important;
                                        background: rgba(251, 88, 73, 0.95);
                                        padding: 20px;
                                        height: 150px !important; /* Chiều cao mặc định */
                                        min-height: 150px !important;
                                        max-height: 150px !important;
                                        overflow: hidden !important;
                                        transition: all 1s cubic-bezier(0.25, 0.46, 0.45, 0.94) !important;
                                        transform: translateY(0) !important;
                                        display: flex;
                                        flex-direction: column;
                                        justify-content: center;
                                        align-items: center;
                                    }

                                    /* Hiệu ứng khi Hover vào Card -> Info trượt lên */
                                    #menu .card:hover .info {
                                        height: auto !important;
                                        min-height: 400px !important;
                                        max-height: 400px !important;
                                        transform: translateY(-10px) !important;
                                        justify-content: flex-start !important;
                                        padding-top: 20px !important;
                                        padding-bottom: 20px !important;
                                        overflow-y: auto !important;
                                    }

                                    /* Scrollbar cho Info */
                                    #menu .card .info::-webkit-scrollbar {
                                        width: 5px;
                                    }
                                    #menu .card .info::-webkit-scrollbar-thumb {
                                        background: rgba(255, 255, 255, 0.3);
                                        border-radius: 10px;
                                    }

                                    /* --- CÁC THÀNH PHẦN BÊN TRONG INFO --- */

                                    /* 1. Container chứa text */
                                    #menu .card .info .main-text-button {
                                        display: flex !important;
                                        flex-direction: column !important;
                                        align-items: center !important;
                                        justify-content: center !important;
                                        width: 100% !important;
                                        flex-shrink: 0 !important;
                                        margin: 0 !important; /* Đã gộp: Xóa margin-left/right 30px cũ */
                                        padding: 0 !important;
                                    }

                                    /* 2. Tên món ăn (Compact - Hiện khi chưa hover) */
                                    #menu .card .info .product-name-compact {
                                        display: block !important;
                                        color: #fff !important;
                                        font-size: 20px !important; /* Lấy giá trị lớn hơn từ code cũ */
                                        font-weight: 700 !important;
                                        text-align: center !important;
                                        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
                                        margin: 0 0 15px 0 !important; /* Đã gộp margin */
                                        padding: 0 !important; /* Đã gộp: Lấy giá trị padding 0 từ đoạn code cuối cùng */
                                        line-height: 1.3 !important;
                                        max-height: 50px !important;
                                        overflow: hidden !important;
                                        display: -webkit-box !important;
                                        -webkit-line-clamp: 2 !important;
                                        line-clamp: 2 !important;
                                        -webkit-box-orient: vertical !important;
                                        flex-shrink: 0 !important;
                                    }

                                    /* Ẩn tên compact khi hover */
                                    #menu .card:hover .info .product-name-compact {
                                        display: none !important;
                                    }

                                    /* 3. Title (Tên món full - Chỉ hiện khi hover) */
                                    #menu .card .info .title {
                                        display: none !important;
                                    }

                                    #menu .card:hover .info .title {
                                        display: block !important;
                                    }

                                    /* 4. Rating Stars */
                                    #menu .card .info .product-rating-section {
                                        display: flex !important;
                                        align-items: center !important;
                                        justify-content: center !important;
                                        margin: 0 !important;
                                        padding: 0 30px !important;
                                        flex-shrink: 0 !important;
                                        width: 100% !important;
                                    }

                                    #menu .card .info .product_rating {
                                        display: flex;
                                        gap: 5px;
                                        align-items: center;
                                        font-size: 1.8rem !important;
                                        filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.3));
                                    }

                                    #menu .card .info .product_rating .fa-star,
                                    #menu .card .info .product_rating .fa-star-half {
                                        color: #ffc107 !important;
                                        animation: starGlow 2s ease-in-out infinite;
                                    }

                                    /* 5. Description (Mô tả - Chỉ hiện khi hover) */
                                    #menu .card .info .description {
                                        display: none !important;
                                    }

                                    #menu .card:hover .info .description {
                                        display: block !important;
                                        text-align: center !important;
                                        line-height: 1.6 !important;
                                        margin-top: 15px !important;
                                        padding: 0 30px !important;
                                        max-height: 200px !important;
                                        overflow-y: auto !important;
                                        flex-shrink: 0 !important;
                                        width: 100% !important;
                                    }

                                    /* Animation cho sao */
                                    @keyframes starGlow {
                                        0%, 100% { filter: drop-shadow(0 0 5px rgba(255, 193, 7, 0.5)); }
                                        50% { filter: drop-shadow(0 0 10px rgba(255, 193, 7, 0.8)); }
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
                                
                                /* Style nghệ thuật cho "Cuốn ơi là cuốn!" */
                                #offers .section-heading .cuon-title {
                                    font-family: 'Dancing Script', cursive !important;
                                    font-size: 3.5rem !important;
                                    font-weight: 700 !important;
                                    background: linear-gradient(135deg, #fb5849 0%, #d15400 30%, #ff6b5a 60%, #fb5849 100%) !important;
                                    -webkit-background-clip: text !important;
                                    -webkit-text-fill-color: transparent !important;
                                    background-clip: text !important;
                                    letter-spacing: 2px !important;
                                    text-shadow: 0 4px 20px rgba(251, 88, 73, 0.3) !important;
                                    position: relative !important;
                                    display: inline-block !important;
                                    margin-top: 15px !important;
                                    margin-bottom: 0 !important;
                                    animation: cuonGlow 3s ease-in-out infinite !important;
                                    transform: perspective(1000px) rotateX(5deg) !important;
                                    text-transform: none !important;
                                }
                                
                                @keyframes cuonGlow {
                                    0%, 100% {
                                        filter: drop-shadow(0 0 10px rgba(251, 88, 73, 0.3));
                                        transform: perspective(1000px) rotateX(5deg) scale(1);
                                    }
                                    50% {
                                        filter: drop-shadow(0 0 20px rgba(251, 88, 73, 0.6));
                                        transform: perspective(1000px) rotateX(5deg) scale(1.05);
                                    }
                                }
                                
                                @media (max-width: 768px) {
                                    #offers .section-heading .cuon-title {
                                        font-size: 2.5rem !important;
                                    }
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
                                
                                /* ========== CHEFS SECTION HEADING ========== */
                                #chefs .section-heading {
                                    display: flex;
                                    flex-direction: column;
                                    align-items: center;
                                    justify-content: center;
                                    text-align: center;
                                    width: 100%;
                                    margin-bottom: 60px;
                                }

                                /* ===== Title ===== */
                                #chefs .chefs-section-title {
                                    font-family: 'Dancing Script', cursive;
                                    font-size: 4.5rem;
                                    font-weight: 700;
                                    letter-spacing: 3px;
                                    margin-bottom: 20px;
                                    display: inline-block;

                                    background: linear-gradient(
                                        135deg,
                                        #fb5849 0%,
                                        #d15400 30%,
                                        #ff6b5a 60%,
                                        #fb5849 100%
                                    );
                                    -webkit-background-clip: text;
                                    background-clip: text;
                                    -webkit-text-fill-color: transparent;

                                    text-shadow: 0 4px 20px rgba(251, 88, 73, 0.3);
                                    animation: chefsTitleGlow 3s ease-in-out infinite;
                                }

                                /* Remove theme underline if any */
                                #chefs .chefs-section-title::before {
                                    display: none;
                                }

                                /* Glow animation */
                                @keyframes chefsTitleGlow {
                                    0%, 100% {
                                        filter: drop-shadow(0 0 10px rgba(251, 88, 73, 0.3));
                                    }
                                    50% {
                                        filter: drop-shadow(0 0 20px rgba(251, 88, 73, 0.6));
                                    }
                                }

                                /* ===== Subtitle ===== */
                                #chefs .chefs-section-subtitle {
                                    font-family: 'Inter', sans-serif;
                                    font-size: 1.5rem;
                                    font-style: italic;
                                    font-weight: 400;
                                    color: #666;
                                    letter-spacing: 2px;
                                    margin-top: 10px;
                                    text-align: center;
                                }

                                /* Decorative icons */
                                #chefs .chefs-section-subtitle::before,
                                #chefs .chefs-section-subtitle::after {
                                    content: '✦';
                                    font-size: 1.2rem;
                                    color: #fb5849;
                                    margin: 0 12px;
                                    opacity: 0.7;
                                    vertical-align: middle;
                                }

                                /* ===== Responsive ===== */
                                @media (max-width: 768px) {
                                    #chefs .chefs-section-title {
                                        font-size: 3rem;
                                    }

                                    #chefs .chefs-section-subtitle {
                                        font-size: 1.2rem;
                                        letter-spacing: 1px;
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
                                        <a href="{{ route('login') }}" class="text-sm text-gray-700 underline">Đăng nhập</a>
                                      </li>
                                        @if (Route::has('register'))
                                            <li><a href="{{ route('register') }}" class="ml-4 text-sm text-gray-700 underline">Đăng ký</a> </li>
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

    <!-- Cart Success Popup -->
    <div id="cartSuccessPopup" class="cart-popup">
        <div class="cart-popup-content">
            <div class="cart-popup-icon">
                <i class="fa fa-check-circle"></i>
            </div>
            <div class="cart-popup-message" id="cartPopupMessage">Đã thêm vào giỏ hàng thành công!</div>
            <button class="cart-popup-close" onclick="closeCartPopup()">
                <i class="fa fa-times"></i>
            </button>
        </div>
    </div>

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
                        <a href="/"><img src="{{ asset('assets/images/logo.png')}}" alt="S-Cuốn" style="width: 180px; height: auto; filter: brightness(0) invert(1);"></a>
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

        /* ========== CART SUCCESS POPUP ========== */
        .cart-popup {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 10000;
            animation: fadeIn 0.3s ease;
        }

        .cart-popup.show {
            display: flex;
        }

        .cart-popup-content {
            background: #fff;
            border-radius: 15px;
            padding: 30px 40px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.3);
            position: relative;
            min-width: 350px;
            max-width: 500px;
            text-align: center;
            animation: slideUp 0.4s ease;
        }

        .cart-popup-icon {
            font-size: 60px;
            color: #4CAF50;
            margin-bottom: 15px;
            animation: scaleIn 0.5s ease;
        }

        .cart-popup-icon i {
            animation: bounce 0.6s ease;
        }

        .cart-popup-message {
            font-size: 18px;
            font-weight: 600;
            color: #2a2a2a;
            margin-bottom: 10px;
            font-family: 'Inter', sans-serif;
        }

        .cart-popup-close {
            position: absolute;
            top: 10px;
            right: 10px;
            background: transparent;
            border: none;
            font-size: 24px;
            color: #999;
            cursor: pointer;
            padding: 5px 10px;
            transition: color 0.3s ease;
        }

        .cart-popup-close:hover {
            color: #fb5849;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
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

        @keyframes scaleIn {
            from {
                transform: scale(0);
            }
            to {
                transform: scale(1);
            }
        }

        @keyframes bounce {
            0%, 100% {
                transform: scale(1);
            }
            50% {
                transform: scale(1.2);
            }
        }

        @media (max-width: 768px) {
            .cart-popup-content {
                min-width: 300px;
                padding: 25px 30px;
                margin: 20px;
            }

            .cart-popup-icon {
                font-size: 50px;
            }

            .cart-popup-message {
                font-size: 16px;
            }
        }
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

    @stack('scripts')

    <!-- Cart Success Popup Script -->
    <script>
        function showCartPopup(message) {
            const popup = document.getElementById('cartSuccessPopup');
            const messageEl = document.getElementById('cartPopupMessage');
            
            if (message) {
                messageEl.textContent = message;
            }
            
            popup.classList.add('show');
            
            // Tự động đóng sau 3 giây
            setTimeout(function() {
                closeCartPopup();
            }, 3000);
        }

        function closeCartPopup() {
            const popup = document.getElementById('cartSuccessPopup');
            popup.classList.remove('show');
        }

        // Hiển thị popup nếu có session message
        @if(session('cart_success'))
            document.addEventListener('DOMContentLoaded', function() {
                showCartPopup('{{ session('cart_success') }}');
            });
        @endif

        // Đóng popup khi click vào overlay
        document.addEventListener('DOMContentLoaded', function() {
            const popup = document.getElementById('cartSuccessPopup');
            popup.addEventListener('click', function(e) {
                if (e.target === popup) {
                    closeCartPopup();
                }
            });
        });
    </script>
  </body>
</html>