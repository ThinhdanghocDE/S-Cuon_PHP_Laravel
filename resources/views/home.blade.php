@extends('layout', ['title'=> 'Home'])


@section('page-content')

    <!-- ***** Main Banner Area Start ***** -->
    <div id="top">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-4">
                    <div class="left-content">
                        <div class="inner-content">
                            <img src="{{ asset('assets/images/logo.png')}}" alt="S-Cuốn" style="max-width: 300px; height: auto; margin-bottom: 20px;">
                            <h4 style="color: #66BB6A;">Từ Bắc vào Nam, gói tròn hương vị</h4>
                            <div class="main-white-button scroll-to-section" style="border-radius: 25px; overflow: hidden;">
                                <a href="#reservation" style="font-family: 'Dancing Script', cursive; font-size: 42px; font-weight: 700; color: #fb5849; text-decoration: none; display: block; padding: 18px 50px; transition: all 0.3s ease;">
                                    <h2 style="margin: 0; font-family: 'Dancing Script', cursive; font-size: 42px; font-weight: 700; color: #fb5849;">Cuốn Liền</h2>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="main-banner header-text">
                        <div class="Modern-Slider">

                        @foreach($banners as $banner)
                          <!-- Item -->
                          <div class="item">
                            <div class="img-fill">
                                <img src="{{ asset('assets/images/'.$banner->image)}}" alt="">
                            </div>
                          </div>

                        @endforeach
                          <!-- // Item -->
                         
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ***** Main Banner Area End ***** -->

    <!-- ***** About Area Starts ***** -->
    <section class="section" id="about">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-xs-12">
                    <div class="left-text-content">
                        <div class="section-heading">
                        @foreach($about_us as $a_us)
                            <h6>{{ __('site.About Us') }}</h6>
                            <h2>{{  $a_us->title  }}</h2>
                        </div>
                        <p>{{  $a_us->description  }}</p>
                        <div class="row">
                            <div class="col-4">
                                <img src="{{ asset('assets/images/'.$a_us->image1)}}" alt="">
                            </div>
                            <div class="col-4">
                                <img src="{{ asset('assets/images/'.$a_us->image2)}}" alt="">
                            </div>
                            <div class="col-4">
                                <img src="{{ asset('assets/images/'.$a_us->image3)}}" alt="">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-xs-12">
                    <div class="right-content">
                        <div class="thumb">
                            @if($a_us->video_file)
                                <!-- Hiển thị video từ file upload -->
                                <video controls style="width: 100%; height: auto; border-radius: 10px;">
                                    <source src="{{ asset('assets/videos/'.$a_us->video_file) }}" type="video/{{ pathinfo($a_us->video_file, PATHINFO_EXTENSION) == 'mp4' ? 'mp4' : (pathinfo($a_us->video_file, PATHINFO_EXTENSION) == 'webm' ? 'webm' : 'ogg') }}">
                                    Trình duyệt của bạn không hỗ trợ video tag.
                                </video>
                            @elseif($a_us->youtube_link)
                                <!-- Hiển thị YouTube link nếu không có video file -->
                                <a rel="nofollow" href="{{  $a_us->youtube_link    }}" target="_blank"> 
                                    <i class="fa fa-play"></i>
                                </a>
                                <img src="{{ asset('assets/images/'.$a_us->vd_image)}}" alt="">
                            @else
                                <!-- Hiển thị thumbnail nếu có -->
                                @if($a_us->vd_image)
                                    <img src="{{ asset('assets/images/'.$a_us->vd_image)}}" alt="">
                                @endif
                            @endif

                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ***** About Area Ends ***** -->

     <!-- ***** Menu Area Starts ***** -->
     <section class="section" id="offers">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 offset-lg-4 text-center">
                    <div class="section-heading">
                        <h1>KHÔNG THỂ BỎ LỠ</h1>
                    
                        <h3 class="cuon-title">Cuốn ơi là cuốn!</h3>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="row" id="tabs">
                        <div class="col-lg-12">
                            <div class="heading-tabs">
                                <div class="row">
                                    <div class="col-lg-6 offset-lg-3">
                                        <ul>
                                  
                                          <li><a href='#tabs-1'><img src="{{ asset('assets/images/tab-icon-01.png')}}" alt="">Món cuốn chính</a></li>
                                          <li><a href='#tabs-2'><img src="{{ asset('assets/images/tab-icon-02.png')}}" alt="">Món cuốn phụ</a></a></li>
                                          <li><a href='#tabs-3'><img src="{{ asset('assets/images/tab-icon-03.png')}}" alt="">Đồ uống</a></a></li>
                                      
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div style="text-align:center;" class="col-lg-12">
                            <section class='tabs-content'>
                                <article id='tabs-1'>
                                    <div class="row">

                                        @foreach($breakfast as $item)

                                        <?php

                            
                                        $total_rate=Illuminate\Support\Facades\DB::table('rates')->where('product_id',$item->id)
                                        ->sum('star_value');


                                        $total_voter=Illuminate\Support\Facades\DB::table('rates')->where('product_id',$item->id)
                                        ->count();

                                        if($total_voter>0)
                                        {

                                            $per_rate=$total_rate/$total_voter;

                                        }
                                        else
                                        {

                                            $per_rate=0;


                                        }

                                        $per_rate=number_format($per_rate, 1);


                                        $whole = floor($per_rate);      // 1
                                        $fraction = $per_rate - $whole

                                        ?>

                                        <div class="col-lg-6 col-md-6 col-sm-12 mb-4">
                                            <a href="{{ route('product.show', $item->id) }}" style="text-decoration: none; display: block; color: inherit;">
                                            <div class="tab-item" style="height: 100%; cursor: pointer; transition: transform 0.3s ease;">
                                                <img src="{{ asset('assets/images/'.$item->image)}}" alt="" style="width: 100%; height: 200px; object-fit: cover; border-radius: 10px;">
                                                <h4>{{ $item->name }}</h4>
                                                <p>{{  $item->description }}</p>
                                                <div class="price">
                                                    <h6>{{ number_format((float)$item->price * 1000, 0, ',', '.') }} VNĐ</h6>
                                                </div>
                                                <span class="product_rating">
                                                    @for($i=1;$i<=$whole;$i++)
                                                        <i class="fa fa-star "></i>
                                                    @endfor
                                                    @if($fraction!=0)
                                                        <i class="fa fa-star-half"></i>
                                                    @endif
                                                    <span class="rating_avg">({{  $per_rate}})</span>
                                                </span>
                                            </div>
                                        </div>

                                        @endforeach
                                        
                                      
                                    </div>
                                </article>  
                                <article id='tabs-2'>
                                    <div class="row">
                                    @foreach($lunch as $item)

                                    <?php

                            
                                        $total_rate=Illuminate\Support\Facades\DB::table('rates')->where('product_id',$item->id)
                                        ->sum('star_value');


                                        $total_voter=Illuminate\Support\Facades\DB::table('rates')->where('product_id',$item->id)
                                        ->count();

                                        if($total_voter>0)
                                        {

                                            $per_rate=$total_rate/$total_voter;

                                        }
                                        else
                                        {

                                            $per_rate=0;


                                        }

                                        $per_rate=number_format($per_rate, 1);


                                        $whole = floor($per_rate);      // 1
                                        $fraction = $per_rate - $whole

                                        ?>

                                        <div class="col-lg-6 col-md-6 col-sm-12 mb-4">
                                            <a href="{{ route('product.show', $item->id) }}" style="text-decoration: none; display: block; color: inherit;">
                                            <div class="tab-item" style="height: 100%; cursor: pointer; transition: transform 0.3s ease;">
                                                <img src="{{ asset('assets/images/'.$item->image)}}" alt="" style="width: 100%; height: 200px; object-fit: cover; border-radius: 10px;">
                                                <h4>{{ $item->name }}</h4>
                                                <p>{{  $item->description }}</p>
                                                <div class="price">
                                                    <h6>{{ number_format((float)$item->price * 1000, 0, ',', '.') }} VNĐ</h6>
                                                </div>
                                                <span class="product_rating">
                                                    @for($i=1;$i<=$whole;$i++)
                                                        <i class="fa fa-star "></i>
                                                    @endfor
                                                    @if($fraction!=0)
                                                        <i class="fa fa-star-half"></i>
                                                    @endif
                                                    <span class="rating_avg">({{  $per_rate}})</span>
                                                </span>
                                            </div>
                                            </a>
                                        </div>

                                    @endforeach
                                      
                                    </div>
                                </article>  
                                <article id='tabs-3'>
                                    <div class="row">
                                    @foreach($dinner as $item)

                                    <?php

                            
                                        $total_rate=Illuminate\Support\Facades\DB::table('rates')->where('product_id',$item->id)
                                        ->sum('star_value');


                                        $total_voter=Illuminate\Support\Facades\DB::table('rates')->where('product_id',$item->id)
                                        ->count();

                                        if($total_voter>0)
                                        {

                                            $per_rate=$total_rate/$total_voter;

                                        }
                                        else
                                        {

                                            $per_rate=0;


                                        }

                                        $per_rate=number_format($per_rate, 1);


                                        $whole = floor($per_rate);      // 1
                                        $fraction = $per_rate - $whole

                                        ?>

                                        <div class="col-lg-6 col-md-6 col-sm-12 mb-4">
                                            <a href="{{ route('product.show', $item->id) }}" style="text-decoration: none; display: block; color: inherit;">
                                            <div class="tab-item" style="height: 100%; cursor: pointer; transition: transform 0.3s ease;">
                                                <img src="{{ asset('assets/images/'.$item->image)}}" alt="" style="width: 100%; height: 200px; object-fit: cover; border-radius: 10px;">
                                                <h4>{{ $item->name }}</h4>
                                                <p>{{  $item->description }}</p>
                                                <div class="price">
                                                    <h6>{{ number_format((float)$item->price * 1000, 0, ',', '.') }} VNĐ</h6>
                                                </div>
                                                <span class="product_rating">
                                                    @for($i=1;$i<=$whole;$i++)
                                                        <i class="fa fa-star "></i>
                                                    @endfor
                                                    @if($fraction!=0)
                                                        <i class="fa fa-star-half"></i>
                                                    @endif
                                                    <span class="rating_avg">({{  $per_rate}})</span>
                                                </span>
                                            </div>
                                            </a>
                                        </div>

                                    @endforeach
                                     
                                    </div>
                                </article>   
                            </section>
                            <br>
                            <a href="/menu"><input style="color:#fff; background-color:#FB5849; font-size:20px;"
                            class="btn" type="submit" value="XEM THỰC ĐƠN"></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ***** Chefs Area Ends ***** --> 
<!-- ***** Menu Area Starts ***** -->
<section class="section"  id="menu">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-heading text-center" >
                        <h6 class="menu-section-title">ĐẶC SẢN 3 MIỀN TỔ QUỐC</h6>
                        <h2 class="menu-section-subtitle">Special - Sạch - Sành.</h2>
                    </div>
                </div>
            </div>
        </div>
        <div class="menu-item-carousel">
            <div class="col-lg-12">
                <div class="owl-menu-item owl-carousel" >
                  
                    @foreach($menu as $product)
                   
                    <div class="item">

                    <?php
                        $img=$product->image;
                        $imgUrl = asset('assets/images/'.$img);
                    ?>
                        <a href="{{ route('product.show', $product->id) }}" style="text-decoration: none; display: block; cursor: pointer;">
                        <div class="card" data-bg-image="{{ $imgUrl }}">
                            <div class="price"><h6>{{ number_format((float)$product->price * 1000, 0, ',', '.') }} VNĐ</h6>
                            @if($product->available!="Stock")
                            <h4>Out Of Stock</h4> 
                            @endif
                        </div>
                        <?php

                            
                            $total_rate=Illuminate\Support\Facades\DB::table('rates')->where('product_id',$product->id)
                            ->sum('star_value');


                            $total_voter=Illuminate\Support\Facades\DB::table('rates')->where('product_id',$product->id)
                            ->count();

                            if($total_voter>0)
                            {

                                $per_rate=$total_rate/$total_voter;

                            }
                            else
                            {

                                $per_rate=0;


                            }

                            $per_rate=number_format($per_rate, 1);


                            $whole = floor($per_rate);      // 1
                            $fraction = $per_rate - $whole

                        ?>
                            <div class='info'>
                              <h1 class='title'>{{ $product->name }}</h1>
                              <p class='description'>{{ $product->description  }}</p>
                              <div class="main-text-button">
                                  <div class="scroll-to-section" >
                                  <!-- Tên món hiển thị khi không hover -->
                                  <h3 class="product-name-compact" style="color: #fff; font-size: 18px; font-weight: 700; margin-bottom: 15px; padding: 0 30px;">{{ $product->name }}</h3>
                                  <!-- Số sao đánh giá nổi bật -->
                                  <div class="product-rating-section" style="padding: 0 30px; display: flex; justify-content: center; align-items: center;">
                                      <span class="product_rating" style="font-size: 1.5rem; display: flex; gap: 5px; align-items: center;">
                                          @for($i=1;$i<=$whole;$i++)
                                              <i class="fa fa-star" style="color: #ffc107;"></i>
                                          @endfor
                                          @if($fraction!=0)
                                              <i class="fa fa-star-half" style="color: #ffc107;"></i>
                                          @endif
                                          @if($total_voter == 0)
                                              <span style="color: rgba(255,255,255,0.7); font-size: 0.9rem; margin-left: 8px;">Chưa có đánh giá</span>
                                          @endif
                                      </span>
                                  </div>
                                </div>
                              </div>
                              
                            </div>
                        </div>
                        </a>
                    </div>
                   
                    @endforeach
                </div>
            </div>
        </div>
    </section>
    <!-- ***** Menu Area Ends ***** -->

    <!-- ***** Featured Posts Area Starts ***** -->
    @if(isset($featured_posts) && $featured_posts->count() > 0)
    <section class="section" id="featured-posts" style="background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%); padding: 80px 0;">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 offset-lg-4 text-center">
                    <div class="section-heading">
                        <h6 style="font-size: 18px; color: #fb5849; font-weight: 600; letter-spacing: 2px; margin-bottom: 15px;">BÀI VIẾT NỔI BẬT</h6>
                        <h2 style="font-family: 'Dancing Script', cursive; font-size: 48px; color: #333; font-weight: 700; margin-bottom: 50px;">Tin Tức & Sự Kiện</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                @foreach($featured_posts as $post)
                <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
                    <a href="{{ route('posts.show', $post->slug) }}" style="text-decoration: none; display: block; color: inherit;">
                        <div class="post-card" style="background: #fff; border-radius: 15px; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.1); transition: all 0.3s ease; height: 100%;">
                            <div class="post-image" style="width: 100%; height: 250px; overflow: hidden; position: relative;">
                                @if($post->featured_image)
                                    <img src="{{ asset('assets/images/'.$post->featured_image) }}" alt="{{ $post->title }}" style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.3s ease;">
                                @else
                                    <div style="width: 100%; height: 100%; background: linear-gradient(135deg, #fb5849 0%, #d15400 100%); display: flex; align-items: center; justify-content: center;">
                                        <i class="fa fa-file-text-o" style="font-size: 60px; color: #fff; opacity: 0.5;"></i>
                                    </div>
                                @endif
                                <div class="post-category" style="position: absolute; top: 15px; right: 15px; background: rgba(251, 88, 73, 0.9); color: #fff; padding: 5px 15px; border-radius: 20px; font-size: 12px; font-weight: 600; text-transform: uppercase;">
                                    @if($post->category == 'general') Tổng hợp
                                    @elseif($post->category == 'news') Tin tức
                                    @elseif($post->category == 'promotion') Khuyến mãi
                                    @elseif($post->category == 'recipe') Công thức
                                    @endif
                                </div>
                            </div>
                            <div class="post-content" style="padding: 25px;">
                                <h4 style="font-size: 22px; font-weight: 700; color: #333; margin-bottom: 15px; line-height: 1.4; min-height: 60px; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                                    {{ $post->title }}
                                </h4>
                                @if($post->excerpt)
                                <p style="color: #666; font-size: 14px; line-height: 1.6; margin-bottom: 15px; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden;">
                                    {{ $post->excerpt }}
                                </p>
                                @else
                                <p style="color: #666; font-size: 14px; line-height: 1.6; margin-bottom: 15px; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden;">
                                    {{ Str::limit(strip_tags($post->content), 120) }}
                                </p>
                                @endif
                                <div style="display: flex; align-items: center; justify-content: space-between; margin-top: 20px; padding-top: 15px; border-top: 1px solid #eee;">
                                    <span style="color: #999; font-size: 13px;">
                                        <i class="fa fa-calendar"></i> 
                                        @if($post->published_at)
                                            {{ \Carbon\Carbon::parse($post->published_at)->format('d/m/Y') }}
                                        @else
                                            {{ \Carbon\Carbon::parse($post->created_at)->format('d/m/Y') }}
                                        @endif
                                    </span>
                                    <span style="color: #fb5849; font-weight: 600; font-size: 14px;">
                                        Đọc thêm <i class="fa fa-arrow-right" style="margin-left: 5px;"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                @endforeach
            </div>
            @if($featured_posts->count() >= 3)
            <div class="row mt-4">
                <div class="col-lg-12 text-center">
                    <a href="{{ route('posts.index') }}" style="display: inline-block; padding: 15px 40px; background: linear-gradient(135deg, #fb5849 0%, #d15400 100%); color: #fff; border-radius: 30px; font-weight: 600; text-decoration: none; transition: all 0.3s ease; box-shadow: 0 5px 15px rgba(251, 88, 73, 0.3);">
                        Xem Tất Cả Bài Viết <i class="fa fa-arrow-right" style="margin-left: 8px;"></i>
                    </a>
                </div>
            </div>
            @endif
        </div>
    </section>
    @endif
    <!-- ***** Featured Posts Area Ends ***** -->

    <!-- ***** Chefs Area Starts ***** -->
    <section class="section" id="chefs">
        <div class="container">
          
            <div class="row">
                <div class="col-lg-4 offset-lg-4 text-center">
                    <div class="section-heading">
                        <h6 class="chefs-section-title">ĐẦU BẾP</h6>
                        <h4 class="chefs-section-subtitle">MASTERCHEF</h4>
                    </div>
                </div>
            </div>
           
            <div class="row">
                @foreach($chefs as $chef)
                <div class="col-lg-4">
                    <div class="chef-item">
                        <div class="thumb">
                            <div class="overlay"></div>
                            <ul class="social-icons">
                                <li><a href="{{ $chef->facebook_link  }}" target="_blank"><i class="fa fa-facebook"></i></a></li>
                                <li><a href="{{ $chef->twitter_link  }}" target="_blank"><i class="fa fa-twitter"></i></a></li>
                                <li><a href="{{ $chef->instragram_link  }}" target="_blank"><i class="fa fa-instagram"></i></a></li>
                            </ul>
                            <img src="{{ asset('assets/images/'.$chef->image)}}" alt="Chef #1">
                        </div>
                        <div class="down-content">
                            <h4>{{ $chef->name  }}</h4>
                            <span>{{ $chef->job_title  }}</span>
                        </div>
                    </div>
                </div>
                @endforeach
                
            </div>
        </div>
    </section>
    <!-- ***** Chefs Area Ends ***** -->

    <!-- ***** Reservation Us Area Starts ***** -->
    <section class="section" id="reservation">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 align-self-center">
                    <div class="left-text-content">
                        <div class="section-heading">
                            <h6>LIÊN HỆ ĐẶT BÀN</h6>
                            <h2>NHỚ ĐẶT BÀN TRƯỚC 60P BẠN NHÉ!</h2>
                        </div>
                        <p>Chúng tôi luôn luôn sẵn sàng phục vụ bạn.</p>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="phone">
                                    <i class="fa fa-phone"></i>
                                    <h4>Số điện thoại</h4>
                                    <span><a href="#">01824072334</a>
									<br><a href="#">01554649446</a>
									</span>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="message">
                                    <i class="fa fa-envelope"></i>
                                    <h4>Emails</h4>
                                    <span><a href="mailto:cajunkinghanoi@gmail.com">cajunkinghanoi@gmail.com</a><br>
									<a href="mailto:vuthinh122004@gmail.com">vuthinh122004@gmail.com</a><br>
									</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="contact-form">
                        <form id="contact" action="/reserve/confirm" method="post">
                            @csrf
                          <div class="row">
                            <div class="col-lg-12">
                                <h4>ĐẶT BÀN</h4>
                            </div>
                            <div class="col-lg-6 col-sm-12">
                              <fieldset>
                                <input name="name" type="text" id="name" placeholder="Họ và tên*" required="">
                              </fieldset>
                            </div>
                            <div class="col-lg-6 col-sm-12">
                              <fieldset>
                              <input name="email" type="text" id="email" pattern="[^ @]*@[^ @]*" placeholder="Email" required="">
                            </fieldset>
                            </div>
                            <div class="col-lg-6 col-sm-12">
                              <fieldset>
                                <input name="phone" type="text" id="phone" placeholder="Số điện thoại" required="">
                              </fieldset>
                            </div>
                            <div class="col-md-6 col-sm-12">
                              <fieldset>
                                <select value="number-guests" name="no_guest" id="number-guests">
                                    <option value="number-guests">Số người</option>
                                    <option name="1" id="1">1</option>
                                    <option name="2" id="2">2</option>
                                    <option name="3" id="3">3</option>
                                    <option name="4" id="4">4</option>
                                    <option name="5" id="5">5</option>
                                    <option name="6" id="6">6</option>
                                    <option name="7" id="7">7</option>
                                    <option name="8" id="8">8</option>
                                    <option name="9" id="9">9</option>
                                    <option name="10" id="10">10</option>
                                    <option name="11" id="11">11</option>
                                    <option name="12" id="12">12</option>
                                </select>
                              </fieldset>
                            </div>
                            <div class="col-lg-6">
                                <div id="filterDate2">    
                                  <div class="input-group date" data-date-format="dd/mm/yyyy">
                                    <input  name="date" id="date" type="text" class="form-control" placeholder="dd/mm/yyyy">
                                    <div class="input-group-addon" >
                                      <span class="glyphicon glyphicon-th"></span>
                                    </div>
                                  </div>
                                </div>   
                            </div>
                            <div class="col-md-6 col-sm-12">
                              <fieldset>
                                <input name="time" type="time" id="time" class="form-control" placeholder="Chọn thời gian" required="">
                              </fieldset>
                            </div>
                            <div class="col-lg-12">
                              <fieldset>
                                <textarea name="message" rows="6" id="message" placeholder="Message" required=""></textarea>
                              </fieldset>
                            </div>
                            <div class="col-lg-12">
                              <fieldset>
                                <button type="submit" id="form-submit" class="main-button-icon">ĐẶT BÀN</button>
                              </fieldset>
                            </div>
                          </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ***** Reservation Area Ends ***** -->

   
    
   @endsection

@push('styles')
<style>
    /* Featured Posts Hover Effects */
    .post-card {
        transition: all 0.3s ease;
    }
    
    .post-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 40px rgba(0,0,0,0.15) !important;
    }
    
    .post-card:hover .post-image img {
        transform: scale(1.1);
    }
    
    .post-card:hover .post-content h4 {
        color: #fb5849;
    }
    
    .post-card:hover .post-content span:last-child {
        transform: translateX(5px);
    }
    
    @media (max-width: 768px) {
        #featured-posts {
            padding: 60px 0 !important;
        }
        
        .post-card {
            margin-bottom: 30px;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Set background image từ data attribute
        document.querySelectorAll('#menu .card[data-bg-image]').forEach(function(card) {
            const bgImage = card.getAttribute('data-bg-image');
            card.style.setProperty('--bg-image', 'url(' + bgImage + ')');
            card.style.backgroundImage = 'url(' + bgImage + ')';
            card.style.backgroundSize = 'cover';
            card.style.backgroundPosition = 'center';
        });
    });
</script>
@endpush