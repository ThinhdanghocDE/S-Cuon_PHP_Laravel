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
                    
                        <h3>Cuốn là mê</h3>
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
                                            <div class="tab-item" style="height: 100%;">
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
                                            <div class="tab-item" style="height: 100%;">
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
                                            <div class="tab-item" style="height: 100%;">
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
                <div class="col-lg-4">
                    <div class="section-heading" >
                        <h6>THỰC ĐƠN</h6>
                        <h2>Special - Sạch - Sành.</h2>
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
                    ?>
                        <div class="card" style="background-image: url('{{ asset('assets/images/'.$img) }}')">
                            <div class="price"><h6>{{ number_format((float)$product->price * 1000, 0, ',', '.') }} VNĐ</h6>
                            @if($product->available!="Stock")
                            <h4 style="">Out Of Stock</h4> 

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
                                  <h3 class="product-name-compact" style="color: #fff; font-size: 18px; font-weight: 700; margin-bottom: 10px; padding: 0 30px;">{{ $product->name }}</h3>
                                  <span class="product_rating">
                                  @for($i=1;$i<=$whole;$i++)

                                    <i class="fa fa-star "></i>

                                    @endfor

                                    @if($fraction!=0)

                                    <i class="fa fa-star-half"></i>

                                    @endif
                                        
                                        
                                    <span class="rating_avg">({{  $per_rate}})</span>
            </span>
      <br>
                                   <a href="/rate/{{ $product->id }}" style="color:blue;">Đánh giá</a>
                                  <p>Số lượng: </p>
                                @if($product->available=="Stock")
                                  <form method="post" action="{{route('cart.store',$product->id)}}">
                                     @csrf
                                  <input type="number" name="number" style="width:50px;" id="myNumber" value="1">
                                    <input type="submit" class="btn btn-success" value="Thêm vảo giỏ hàng">
                                  </form>
                                @endif

                                @if($product->available!="Stock")
                                  <form method="post" action="{{route('cart.store',$product->id)}}">
                                     @csrf
                                  <input type="number" name="number" style="width:50px;" id="myNumber" value="1">
                                    <input type="submit" class="btn btn-success" disabled value="Add Chart">
                                  </form>
                                @endif
                                </div>
                              </div>
                              
                            </div>
                        </div>
                    </div>
                   
                    @endforeach
                </div>
            </div>
        </div>
    </section>
    <!-- ***** Menu Area Ends ***** -->

    <!-- ***** Chefs Area Starts ***** -->
    <section class="section" id="chefs">
        <div class="container">
          
            <div class="row">
                <div class="col-lg-4 offset-lg-4 text-center">
                    <div class="section-heading">
                        <h6>ĐẦU BẾP</h6>
                        <h4>"MÓN ĂN ĐƯỢC CHẾ BIẾN BẰNG CẢ TRÁI TIM CỦA CHÚNG TÔI"</h4>
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
                            <h6>LIÊN HỆ CHO CHÚNG TÔI</h6>
                            <h2>ĐẶT BÀN TRƯỚC TẠI NHÀ HÀNG CỦA CHÚNG TÔI</h2>
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
                                <select value="time" name="time" id="time">
                                    <option value="time">Thời gian</option>
                                    <option name="Breakfast" id="Breakfast">Sáng</option>
                                    <option name="Lunch" id="Lunch">Trưa</option>
                                    <option name="Dinner" id="Dinner">Tối</option>
                                </select>
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