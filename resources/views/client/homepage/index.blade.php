@extends('layout-client')
@section('content')
<style>
.rating-active .active {
    color: #ff9705 !important;
}
</style>
<!-- Slider Arae Start -->
<div class="slider-area">
    <div class="slider-active-3 owl-carousel slider-hm8 owl-dot-style">
        <!-- Slider Single Item Start -->
        @foreach ($slider as $ad)
        <div class="slider-height-6 d-flex align-items-start justify-content-start bg-img"
            style="background-image: url({{$ad->image}});">
            <div class="container">
                <div class="slider-content-1 slider-animated-1 text-left">
                    <span class="animated">{{ $ad->description }}</span>
                    <h1 class="animated">
                        {{$ad->title}}
                    </h1>
                    <p class="animated">Giao hàng miễn phí trong 500m</p>
                    <a href="shop-4-column.html" class="shop-btn animated">ĐẶT HÀNG</a>
                </div>
            </div>
        </div>
        @endforeach

        <!-- Slider Single Item End -->


    </div>
</div>
<!-- Slider Arae End -->

<!-- Category Area Start -->
<section class="categorie-area" style="height: 326px; margin-top: 50px;">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <!-- Section Title -->
                <div class="section-title mt-res-sx-30px mt-res-md-30px">
                    <h2>DANH MỤC</h2>
                </div>
                <!-- Section Title -->
            </div>
        </div>
        <!-- Category Slider Start -->
        <div class="category-slider owl-carousel owl-nav-style">
            <!-- Single item -->
            @foreach($cates as $item)
            <div class="category-item">
                <div class="category-list banner-inner banner-box" style="border: outset; ">
                    <div class="category-thumb">
                        <a href="{{route('client.cate-product',['id'=>$item->id])}}">
                            <img src="{{$item->image}}" alt="" width="" height="200" />
                        </a>
                    </div>
                    <div class="desc-listcategoreis">
                        <div class="name_categories">
                            <h4>{{$item->name}}</h4>
                        </div>
                        <span class="number_product">{{count($item->products) }} Sản phẩm</span>
                        <a href="{{route('client.cate-product',['id'=>$item->id])}}"> Xem ngay <i
                                class="ion-android-arrow-dropright-circle"></i></a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
<!-- Category Area End  -->

<!-- Best Sells Area Start -->
<section class="best-sells-area mb-30px">
    <div class="container">
        <!-- Section Title Start -->
        <div class="row">
            <div class="col-md-12">
                <div class="section-title">
                    <h2>Sản phẩm đi chợ
                    </h2>
                </div>
            </div>
        </div>
        <!-- Section Title End -->
        <!-- Best Sell Slider Carousel Start -->
        <div class="best-sell-slider owl-carousel owl-nav-style">
            @foreach ($market_product as $item)
            <?php
                $avg = 0;
                if($item->pro_total_rating){
                    $avg = round($item->pro_total_number / $item->pro_total_rating, 2);
                }
            ?>
            <article class="list-product">
                <div class="img-block">
                    <a href="{{route('client.single-product',['id'=>$item->id])}}" class="thumbnail">
                        <img src="{{$item->image_gallery}}" alt="" width="256" height="256" />
                    </a>
                </div>

                <ul class="product-flag">
                    <li class="{{$item->quantily <= 0 ? 'new bg-danger' : 'new'}}">
                        {{$item->quantily <= 0 ? "Hết hàng" : "Mới"}}</li>
                </ul>
                <div class="product-decs">
                    <a class="inner-link"
                        href="#"><span>{{isset($item->category) ? $item->category->name : ''}}</span></a>
                    <h2><a href="{{route('client.single-product',['id'=>$item->id])}}"
                            class="product-link">{{$item->name}}</a></h2>
                    <div class="rating-active">
                        @for($i = 1; $i <= 5; $i++) <i class="fa fa-star {{ $i <= $avg ? 'active' : '' }}">
                            </i>
                            @endfor
                    </div>
                    <div class="pricing-meta">
                        <ul>
                            <li class="">{{($item->views)}} Views</li>
                        </ul>
                        <ul>
                            <li class="current-price">{{number_format($item->price)}}đ</li>
                        </ul>
                    </div>
                </div>
                <div class="add-to-link">
                    <ul>
                        <li class="cart">
                            @if ($today <= "09:00:00" && $item->allow_market ==2)
                            <a @if(Auth::check()) class="cart-btn" product-id='{{$item->id}}' @else
                                href="{{route('client.login')}}" @endif >Thêm vào giỏ</a>
                            @endif
                            @if ($item->allow_market ==1)
                            <a @if(Auth::check()) class="cart-btn" product-id='{{$item->id}}' @else
                                href="{{route('client.login')}}" @endif >Thêm vào giỏ</a>
                            @endif

                            @if($today > "09:00:00" && $item->allow_market ==2)
                            <a @if(Auth::check()) class="cart-btns" product-id='{{$item->id}}' @else
                                href="{{route('client.login')}}" @endif >Thêm vào giỏ</a>
                            @endif
                        </li>
                        <li>
                            <a
                            @if(Auth::check())
                                onclick="return confirm('Bạn muốn thêm sản phẩm vừa chọn vào mục yêu thích?')" href="{{route('client.add-wishlist',['id'=>$item->id])}}"><i class="ion-android-favorite-outline"
                                @else
                                href="{{route('client.login')}}"
                            @endif
                            >
                            </i></a>
                        </li>
                    </ul>
                </div>
            </article>
            @endforeach
        </div>
        <!-- Best Sells Carousel End -->
    </div>
</section>
<!-- Best Sells Slider End -->

<!-- Hot deal area Start -->
<section class="hot-deal-area mb-30px">
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-5 col-lg-5 col-xl-4">
                <div class="row">
                    <div class="col-md-12">
                        <!-- Section Title -->
                        <div class="section-title">
                            <h2>Sản phẩm hót</h2>
                            <p>Những sản phẩm được đánh giá tốt nhất</p>
                        </div>
                        <!-- Section Title End-->
                    </div>
                </div>
                <!-- Hot Deal Slider Start -->
                <div class="hot-deal owl-carousel owl-nav-style mb-res-sm-30px mb-res-sm-30px">
                    <!--  Single item -->
                    @foreach ($sortbyRate as $item)
                    <?php
                        $avg = 0;
                        if($item->pro_total_rating){
                            $avg = round($item->pro_total_number / $item->pro_total_rating, 2);
                        }
                    ?>
                    <article class="list-product">
                        <div class="img-block">
                            <a href="{{route('client.single-product',['id'=>$item->id])}}" class="thumbnail">
                                <img class="first-img" style="width: 83%;margin: 0 auto;" src="{{$item->image_gallery}}"
                                    alt="" />
                            </a>
                        </div>
                        <ul class="product-flag">
                            <li class="{{$item->quantily <= 0 ? 'new bg-danger' : 'new'}}">
                                {{$item->quantily <= 0 ? "Hết hàng" : "Mới"}}</li>
                        </ul>
                        <div class="product-decs">
                            <a class="inner-link"
                                href="shop-4-column.html"><span>{{isset($item->category) ? $item->category->name : ''}}</span></a>
                            <h2><a href="{{route('client.single-product',['id'=>$item->id])}}"
                                    class="product-link">{{$item->name}}</a></h2>
                            <div class="rating-active">
                                @for($i = 1; $i <= 5; $i++) <i class="fa fa-star {{ $i <= $avg ? 'active' : '' }}">
                                    </i>
                                    @endfor
                            </div>
                            <div class="pricing-meta">
                                <ul style="padding:7px;">
                                    <li class="">Lượt xem : {{($item->views)}}</li>
                                </ul>
                                <ul>
                                    <li class="current-price">{{number_format($item->price)}} đ</li>
                                </ul>
                            </div>
                            <div class="add-to-link">
                                <ul>
                                    <li class="cart">
                                        <a
                                            @if(Auth::check()) class="cart-btn" product-id='{{$item->id}}'
                                            @else
                                            href="{{route('client.login')}}"
                                            @endif
                                        {{$item->quantily <= 0 ? "hidden" : ""}}>
                                        Thêm vào giỏ</a>
                                    </li>
                                    <li>
                                        <a
                                        @if(Auth::check())
                                            onclick="return confirm('Bạn muốn thêm sản phẩm vừa chọn vào mục yêu thích?')" href="{{route('client.add-wishlist',['id'=>$item->id])}}"><i class="ion-android-favorite-outline"
                                            @else
                                            href="{{route('client.login')}}"
                                        @endif
                                        >
                                        </i></a>
                                    </li>
                                </ul>
                            </div>
                            <div class="in-stock" style="padding:10px;">Số lượng: <span>{{$item->quantily}} trong kho</span></div>
                        </div>
                    </article>
                    @endforeach
                </div>
                <!-- Hot Deal Slider end -->
            </div>
            <!-- New Arrivals Area Start -->
            <div class="col-xs-12 col-sm-12 col-md-7 col-lg-7 col-xl-8">
                <div class="row">
                    <div class="col-md-12">
                        <!-- Section Title -->
                        <div class="section-title ml-0px">
                            <h2>Sản phẩm mới</h2>
                            <p>Các sản phẩm mới được cập nhật liên tục</p>
                        </div>
                        <!-- Section Title -->
                    </div>
                </div>

                <div class="new-product-slider owl-carousel owl-nav-style">
                    <!-- Product Single Item -->
                    @foreach ($new_product as $item)
                        <?php
                            $avg = 0;
                            if($item->pro_total_rating){
                                $avg = round($item->pro_total_number / $item->pro_total_rating, 2);
                            }
                        ?>
                    <div class="product-inner-item">
                        <article class="list-product mb-30px">
                            <div class="img-block">
                                <a href="{{route('client.single-product', ['id'=>$item->id])}}" class="thumbnail">
                                    <img class="first-img" src="{{$item->image_gallery}}" alt="" />
                                </a>
                            </div>
                            <ul class="product-flag">
                                <li class="{{$item->quantily <= 0 ? 'new bg-danger' : 'new'}}">
                                    {{$item->quantily <= 0 ? "Hết hàng" : "Mới"}}</li>
                            </ul>
                            <div class="product-decs">
                                <a class="inner-link"
                                    href="{{route('client.single-product', ['id'=>$item->id])}}"><span>{{isset($item->category) ? $item->category->name : ''}}</span></a>
                                <h2><a href="{{route('client.single-product', ['id'=>$item->id])}}" class="product-link">{{$item->name}}</a>
                                </h2>
                                <div class="rating-active">
                                    @for($i = 1; $i <= 5; $i++) <i class="fa fa-star {{ $i <= $avg ? 'active' : '' }}">
                                        </i>
                                        @endfor
                                </div>
                                <div class="pricing-meta">
                                    <ul>
                                        <li class="current-price">{{number_format($item->price)}}đ</li>
                                    </ul>
                                </div>
                            </div>
                            <div class="add-to-link">
                                <ul>
                                    <li class="cart">
                                        <a
                                            @if(Auth::check()) class="cart-btn" product-id='{{$item->id}}'
                                            @else
                                            href="{{route('client.login')}}"
                                            @endif
                                        {{$item->quantily <= 0 ? "hidden" : ""}}>
                                        Thêm vào giỏ</a>
                                    </li>
                                    <li>
                                        <a
                                        @if(Auth::check())
                                            onclick="return confirm('Bạn muốn thêm sản phẩm vừa chọn vào mục yêu thích?')" href="{{route('client.add-wishlist',['id'=>$item->id])}}"><i class="ion-android-favorite-outline"
                                            @else
                                            href="{{route('client.login')}}"
                                        @endif
                                        >
                                        </i></a>
                                    </li>
                                </ul>
                            </div>
                        </article>
                    </div>
                    @endforeach
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-12">
                        <!-- Section Title -->
                        <div class="section-title ml-0px">
                            <h2>Quan tâm nhất</h2>
                            <p>Nhiều ưu đãi hấp dẫn</p>
                        </div>
                        <!-- Section Title -->
                    </div>
                </div>
                <div class="new-product-slider owl-carousel owl-nav-style">
                    <!-- Product Single Item -->
                    @foreach ($sortbyCmt as $item)
                        <?php
                            $avg = 0;
                            if($item->pro_total_rating){
                                $avg = round($item->pro_total_number / $item->pro_total_rating, 2);
                            }
                        ?>
                    <div class="product-inner-item">
                        <article class="list-product mb-30px">
                            <div class="img-block">
                                <a href="{{route('client.single-product',['id'=>$item->id])}}" class="thumbnail">
                                    <img class="first-img" src="{{$item->image_gallery}}" alt="" />
                                </a>
                            </div>
                            <ul class="product-flag">
                                <li class="{{$item->quantily <= 0 ? 'new bg-danger' : 'new'}}">
                                    {{$item->quantily <= 0 ? "Hết hàng" : "Mới"}}</li>
                            </ul>
                            <div class="product-decs">
                                <a class="inner-link"
                                href="{{route('client.single-product',['id'=>$item->id])}}"><span>{{isset($item->category) ? $item->category->name : ''}}</span></a>
                                <h2><a href="{{route('client.single-product', ['id'=>$item->id])}}" class="product-link">{{$item->name}}</a>
                                </h2>
                                <div class="rating-active">
                                    @for($i = 1; $i <= 5; $i++) <i class="fa fa-star {{ $i <= $avg ? 'active' : '' }}">
                                        </i>
                                        @endfor
                                </div>
                                <div class="pricing-meta">
                                    <ul>
                                        <li class="current-price">{{number_format($item->price)}} đ</li>
                                    </ul>
                                </div>
                            </div>
                            <div class="add-to-link">
                                <ul>
                                    <li class="cart">
                                        <a
                                            @if(Auth::check()) class="cart-btn" product-id='{{$item->id}}'
                                            @else
                                            href="{{route('client.login')}}"
                                            @endif
                                        {{$item->quantily <= 0 ? "hidden" : ""}}>
                                        Thêm vào giỏ</a>
                                    </li>
                                    <li>
                                        <a
                                        @if(Auth::check())
                                            onclick="return confirm('Bạn muốn thêm sản phẩm vừa chọn vào mục yêu thích?')" href="{{route('client.add-wishlist',['id'=>$item->id])}}"><i class="ion-android-favorite-outline"
                                            @else
                                            href="{{route('client.login')}}"
                                        @endif
                                        >
                                        </i></a>
                                    </li>
                                </ul>
                            </div>
                        </article>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Hot Deal Area End -->


<div class="banner-area-2 mt-0px mb-100px">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="banner-inner banner-box">
                    <a href="shop-4-column.html"><img src="{{asset('assets/client/images/banner-image/4.jpg')}}"
                            alt="" /></a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Feature Area Start -->
<section class="feature-area">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <!-- Section Title -->
                <div class="section-title">
                    <h2>XEM NHIỀU NHẤT</h2>
                </div>
                <!-- Section Title -->
            </div>
        </div>
        <!-- Feature Slider Start -->
        <div class="feature-slider owl-carousel owl-nav-style">
            <!-- Single Item -->
            @foreach ($sortbyView as $item)
            <?php
                $avg = 0;
                if($item->pro_total_rating){
                    $avg = round($item->pro_total_number / $item->pro_total_rating, 2);
                }
            ?>
            <div class="feature-slider-item">
                <article class="list-product">
                    <div class="img-block">
                        <a href="{{route('client.single-product',['id'=>$item->id])}}" class="thumbnail">
                            <img class="first-img" src="{{asset($item->image_gallery)}}" alt="" />
                        </a>
                    </div>
                    <div class="product-decs" style="width:51%;">
                        <a class="inner-link" style="margin-bottom: -60px;"
                            href="shop-4-column.html"><span>{{isset($item->category) ? $item->category->name : ''}}</span></a>
                        <h2
                            style="white-space: pre-wrap;  width:100%;overflow: hidden; text-overflow: ellipsis; -webkit-line-clamp: 3;-webkit-box-orient: vertical;display: -webkit-box;">
                            <a href="{{route('client.single-product',['id'=>$item->id])}}"
                                class="product-link">{{$item->name}}</a>
                        </h2>
                        <div class="rating-active" style="padding: 4px 0px;">
                            @for($i = 1; $i <= 5; $i++) <i class="fa fa-star {{ $i <= $avg ? 'active' : '' }}"></i>
                                @endfor
                        </div>
                        <div class="pricing-meta">
                            <ul>
                                <li class="">{{($item->views)}} Views</li>
                            </ul>
                            <ul>
                                <li class="current-price">{{number_format($item->price)}}đ</li>
                            </ul>
                        </div>
                    </div>
                </article>
            </div>
            @endforeach

            <!-- Feature Slider End -->
        </div>
</section>



<!-- Static Area Start -->
<section class="static-area mtb-60px">
    <div class="container">
        <div class="static-area-wrap">
            <div class="row">
                <!-- Static Single Item Start -->
                <div class="col-lg-3 col-xs-12 col-md-6 col-sm-6">
                    <div class="single-static pb-res-md-0 pb-res-sm-0 pb-res-xs-0">
                        <img src="{{asset('assets/client/images/icons/static-icons-1.png')}}" alt=""
                            class="img-responsive" />
                        <div class="single-static-meta">
                            <h4>Miễn phí giao hàng</h4>
                            <p>cho đơn hàng bán kính dưới 500m tại cửa hàng</p>
                        </div>
                    </div>
                </div>
                <!-- Static Single Item End -->
                <!-- Static Single Item Start -->
                <div class="col-lg-3 col-xs-12 col-md-6 col-sm-6">
                    <div class="single-static pb-res-md-0 pb-res-sm-0 pb-res-xs-0 pt-res-xs-20">
                        <img src="{{asset('assets/client/images/icons/static-icons-2.png')}}" alt=""
                            class="img-responsive" />
                        <div class="single-static-meta">
                            <h4>Đặt hàng trực tuyến</h4>
                            <p>Đặt hàng nhanh gọn trực tuyến trên internet</p>
                        </div>
                    </div>
                </div>
                <!-- Static Single Item End -->
                <!-- Static Single Item Start -->
                <div class="col-lg-3 col-xs-12 col-md-6 col-sm-6">
                    <div class="single-static pt-res-md-30 pb-res-sm-30 pb-res-xs-0 pt-res-xs-20">
                        <img src="{{asset('assets/client/images/icons/static-icons-3.png')}}" alt=""
                            class="img-responsive" />
                        <div class="single-static-meta">
                            <h4>Thanh toán đa dạng</h4>
                            <p>Thanh toán đa dạng theo nhiều loại hình </p>
                        </div>
                    </div>
                </div>
                <!-- Static Single Item End -->
                <!-- Static Single Item Start -->
                <div class="col-lg-3 col-xs-12 col-md-6 col-sm-6">
                    <div class="single-static pt-res-md-30 pb-res-sm-30 pt-res-xs-20">
                        <img src="{{asset('assets/client/images/icons/static-icons-4.png')}}" alt=""
                            class="img-responsive" />
                        <div class="single-static-meta">
                            <h4>Hỗ trợ 24/7</h4>
                            <p>Gọi cho chúng tôi nếu bạn có thắc mắc</p>
                        </div>
                    </div>
                </div>
                <!-- Static Single Item End -->
            </div>
        </div>
    </div>
</section>
<!-- Static Area End -->
@endsection