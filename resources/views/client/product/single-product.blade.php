@extends('layout-client')
@section('content')
<?php
    $avg = 0;
    if($product->pro_total_rating){
        $avg = round($product->pro_total_number / $product->pro_total_rating, 2);
    }
    ?>
<style>
.list_start i:hover {
    cursor: pointer;
}
.rating-product {
    margin-bottom: 0;
}
.list_text {
    display: inline-block;
    margin-left: 10px;
    position: relative;
    background: #4fb68d;
    color: #fff;
    padding: 0px 8px;
    box-sizing: border-box;
    font-size: 12px;
    border-radius: 2px;
    display: none;
}
.list_text:after {
    right: 100%;
    top: 50%;
    border: solid transparent;
    content: " ";
    height: 0;
    width: 0;
    position: absolute;
    pointer-events: none;
    border-color: rgba(82, 184, 88, 0);
    border-right-color: #4fb68d;
    border-width: 6px;
    margin-top: -6px;
}
.list_start .rating_active {
    color: #ff9705;
}
.rating-active .active {
    color: #ff9705 !important;
}
</style>
<!-- Breadcrumb Area start -->
<section class="breadcrumb-area" style="
    background: repeating-linear-gradient(21deg, #4fb68d96, #edb1b100 244px);">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="breadcrumb-content">
                    <h1 class="breadcrumb-hrading">Chi tiết sản phẩm</h1>
                    <ul class="breadcrumb-links">
                        <li><a href="{{route('client.homepage')}}">Trang chủ</a></li>
                        <li>Chi tiết</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Breadcrumb Area End -->
<!-- Shop details Area start -->
<section class="product-details-area mtb-60px">
    <div class="container">
        <div class="row">

            <div class="col-xl-6 col-lg-6 col-md-12">
                <div class="product-details-img product-details-tab">
                    <div class="zoompro-wrap zoompro-2">
                        <div class="zoompro-border zoompro-span">
                            <img class="zoompro" src="../../{{$product->image_gallery}}" data-zoom-image="../../{{$product->image_gallery}}" alt="" width="80" height="500"/>
                        </div>
                    </div>
                    <div id="gallery" class="product-dec-slider-2" style="text-align: left">
                        <a class="active" data-image="../../{{$product->image_gallery}}"
                            data-zoom-image="../../{{$product->image_gallery}}">
                            <img src="../../{{$product->image_gallery}}" alt="" />
                        </a>
                        @foreach($img_url as $img)
                        <a data-image="../../{{$img->gallery_img}}"
                            data-zoom-image="../../{{$img->gallery_img}}">
                        <img class="active" src="../../{{$img->gallery_img}}" alt="" />
                        </a>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="col-xl-6 col-lg-6 col-md-12">
                <div class="product-details-content">
                    <h2>{{$product->name}}</h2>
                    <p class="reference">{{isset($product->category) ? $product->category->name : ''}}</p>
                    <div class="pro-details-rating-wrap">
                        <div class="rating-active">
                            @for($i = 1; $i <= 5; $i++) <i class="fa fa-star {{ $i <= $avg ? 'active' : '' }}"></i>
                                @endfor
                        </div>

                        <span style="margin-left: 15px;" class="read-review"><a class="reviews" href="#">Bình luận
                                ({{count($comments)}})</a></span>
                    </div>
                    <div class="pricing-meta">
                        <ul>
                            <li class="old-price not-cut text-danger">Giá: {{number_format($product->price)}}đ</li><br>
                            <li class="tinhtrang pb-2">Tình trạng : <b>{{$product->quantily <= 0 ? " Hết hàng " : " Còn hàng "}}</b></li>
                        </ul>
                    </div>
                    <div class="pro-details-quality mt-0px">
                        <div class="pro-details-cart btn-hover">
                                @if ($today <= "09:00:00" && $product->allow_market ==2)
                                <a class="cart-btn" product-id='{{$product->id}}' href="#" >Thêm vào giỏ</a>
                                @endif
                                @if ($product->allow_market ==1)
                                <a class="cart-btn" product-id='{{$product->id}}' href="#" >Thêm vào giỏ</a>
                                @endif
                                @if($today > "09:00:00" && $product->allow_market ==2)
                                <a class="cart-btns" product-id='{{$product->id}}' href="#" >Thêm vào giỏ</a>
                                @endif  
                        </div>
                        <div class="cart-plus-minus" style="visibility: hidden;">
                            <input class="cart-plus-minus-box" type="text" name="quantily" value="1" />
                            <input class="cart-plus-minus-box" prod-id="{{$product['id']}}" type="text" name="quantily" value="1" />
                        </div>
                    </div>
                    <div class="pro-details-wish-com">
                        <div class="pro-details-wishlist">
                            <a
                                @if(Auth::check())
                                    onclick="return confirm('Bạn muốn thêm sản phẩm vừa chọn vào mục yêu thích?')" href="{{route('client.add-wishlist',['id'=>$product->id])}}"><i class="ion-android-favorite-outline"
                                    @else
                                        hidden
                                @endif
                                > Thêm vào danh sách yêu thích</i></a>
                        </div>
                    </div>
                    <div class="pro-details-social-info">
                        <span>Chia sẻ</span>
                        <div class="social-info">
                            <ul>
                                <li>
                                    <a href="#"><i class="ion-social-facebook"></i></a>
                                </li>
                                <li>
                                    <a href="#"><i class="ion-social-twitter"></i></a>
                                </li>
                                <li>
                                    <a href="#"><i class="ion-social-google"></i></a>
                                </li>
                                <li>
                                    <a href="#"><i class="ion-social-instagram"></i></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="pro-details-policy">
                        <ul>
                            <li><img src="{{asset('assets/client/images/icons/policy.png')}}" alt="" /><span>Giao hàng miễn phí</span></li>
                            <li><img src="{{asset('assets/client/images/icons/policy-2.png')}}" alt="" /><span>Miễn phí đổi trả</span></li>
                            <li><img src="{{asset('assets/client/images/icons/policy-3.png')}}" alt="" /><span>Áp dụng mã giảm giá</span>s</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Shop details Area End -->
<!-- product details description area start -->
<div class="description-review-area mb-60px">
    <div class="container">
        <div class="description-review-wrapper">
            <div class="description-review-topbar nav">
                <a class="active" data-toggle="tab" href="#des-details3">Bình Luận</a>
                <a data-toggle="tab" href="#des-details2">MÔ TẢ</a>
            </div>
            <div class="tab-content description-review-bottom">
                <div id="des-details2" class="tab-pane">
                    <div class="product-anotherinfo-wrapper">
                    <h2>{{$product->name}}</h2>
                    <br>
                        <p>{!!$product->description!!}</p>
                    </div>
                </div>
                <div id="des-details3" class="tab-pane active">
                    <div class="row">
                        <div class="col-lg-12">
                            @foreach($comments as $item)
                            <div class="review-wrapper">
                                <div class="single-review">
                                    <div class="review-img">
                                        <img src="{{isset($item->user_comment) ? asset($item->user_comment->avatar) : ''}}"
                                            width="70" height="70" style="border-radius:100px;" alt="" />
                                    </div>
                                    <div class="review-content">
                                        <div class="review-top-wrap" style="margin: 0 0px 0px;">
                                            <div class="review-left">
                                                <div class="review-name">
                                                    <h4 style="line-height:2;font-weight:bold;color:#111;">
                                                        {{isset($item->user_comment) ? $item->user_comment->name : ''}}
                                                    </h4>
                                                </div>

                                                <span class="rating-active">
                                                    @for($i = 1; $i <= 5; $i++) <i
                                                        class="fa fa-star {{ $i <= $item->ra_number ? 'active' : '' }}">
                                                        </i>
                                                        @endfor
                                                </span>

                                            </div>
                                            <!-- <div class="review-left">
                                                <a href="#">Reply</a>
                                            </div> -->
                                        </div>
                                        <div class="review-bottom" style="margin: 0 0px 6px 0px;">
                                            <p style="width:100%; color:#333;">
                                                {{$item->ra_content}}
                                            </p>
                                        </div>
                                        <div class="review-time">
                                            <p>{{$item->created_at}}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        <div class="col-lg-12" style="height: 28px; border-top: 1px solid #ebebeb; margin-top: 30px;">
                        </div>

                        <div class="col-lg-12">
                            <div class="ratting-form-wrapper pl-50">
                                <div class="ratting-form">
                                    <!-- đánh giá sản phẩm theo rating -->
                                    <div class="component_rating">
                                        <h3 style="font-weight:bold; font-size:30px; ">Đánh giá sản phẩm</h3>
                                        <div class="row component_rating_content"
                                            style="display:flex; align-items:center; border:1px solid #dedede;width:100%;margin:25px auto;">
                                            <div class="col-sm-3">
                                                <div class="rating-item"
                                                    style=" posision:relative; border-right: 1px solid #dedede;">
                                                    <div class=""><span class="fa fa-star"
                                                            style="font-size:100px; color:#ff9705;display:block; margin:0 auto; text-align:center;"></span>
                                                        <b
                                                            style="position:absolute; top:50%; left:50%;transform:translateX(-50%) translateY(-40%); font-size: 26px;color: #fff;">
                                                            {{$avg}}</b>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-1"></div>

                                            <div class="col-sm-7">
                                                <div class="list_rating" style="padding:20px;">
                                                    @foreach($arrayRatings as $key => $arrayRating)
                                                    <?php
                                                       $itemAge = round(($arrayRating['total'] / $product->pro_total_rating) * 100,0);
                                                    //    dd($product->pro_total_rating);
                                                    ?>

                                                    <div class="item_rating" style="display:flex; align-items:center;">
                                                        <div style="width:10%;">
                                                            {{ $key }}<span class="fa fa-star"
                                                                style="padding: 0 5px; color: #ff9705;"></span>
                                                        </div>
                                                        <div style="width:70%; margin:0 20px;">
                                                            <span class=""
                                                                style="width:100%; height:8px; display:block; border:1px solid #dedede; border-radius:5px;">
                                                                <b
                                                                    style="width:{{$itemAge}}%; background-color:#f25800; display:block; height:100%; border-radius:5px;"></b>
                                                            </span>
                                                        </div>
                                                        <div style="width:20%;">
                                                            <a style="color:#666;" href="">{{$arrayRating['total']}}
                                                                đánh giá ({{$itemAge}}%)</a>
                                                        </div>
                                                    </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <br>

                                    @if(isset(Auth::user()->name))
                                    <?php
                                $listRatingText = [
                                    1 => 'Không thích',
                                    2 => 'Tạm được',
                                    3 => 'Bình thường',
                                    4 => 'Rất tốt',
                                    5 => 'Tuyệt vời',
                                ];
                                ?>
                                    <div class="" style="display:flex; font-size:20px;">
                                        <p style="font-weight:bold;margin-bottom:0;">Chọn đánh giá của bạn </p>
                                        <span class="list_start" ; style="margin:0 30px;">

                                            @for($i = 1; $i <= 5; $i++) <i class="fa fa-star" data-key="{{$i}}"
                                                style="padding: 0 3px;"></i>
                                                @endfor
                                        </span>
                                        <span class="list_text"></span>

                                    </div>
                                    <br>
                                    <div class="row">
                                        <br>
                                        <div class="col-md-12">
                                            <form method="POST">
                                                @csrf
                                                <input type="hidden" value="" class="number_rating">
                                                <input type="hidden" value="{{$product->id}}" class="id_product">
                                                <p
                                                    style="color:green; font-weight:bold;  font-size:18px; margin:15px 0px;">
                                                    @if(session('thongbao'))
                                                    {{session('thongbao')}}
                                                    @endif
                                                </p>
                                                <div class="rating-form-style form-submit">
                                                    <textarea name="ra_content" id="ra_content"
                                                        placeholder="Viết bình luận ..."></textarea>

                                                    <input type="submit" class="js_rating_product"
                                                        value="Bình Luận" />
                                                    
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- {{URL::to('/client/single-product/rating/'.$product->id)}} -->
<!-- product details description area end -->
<!-- Recent Add Product Area Start -->
<section class="recent-add-area">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <!-- Section Title -->
                <div class="section-title">
                    <h2>Sản phẩm liên quan</h2>
                </div>
                <!-- Section Title -->
            </div>
        </div>
        <!-- Recent Product slider Start -->
        <div class="recent-product-slider owl-carousel owl-nav-style">
            <!-- Single Item -->
            @foreach($related_pro as $item)
            <?php
                $avg = 0;
                if($item->pro_total_rating){
                    $avg = round($item->pro_total_number / $item->pro_total_rating, 2);
                }
            ?>
            <article class="list-product">
                <div class="img-block">
                    <a href="{{route('client.single-product',['id'=>$item->id])}}" class="thumbnail">
                        <img src="{{asset($item->image_gallery)}}" alt="" />
                    </a>
                </div>
                <ul class="product-flag">
                    <li class="{{$item->quantily <= 0 ? 'new bg-danger' : 'new'}}">
                        {{$item->quantily <= 0 ? "Hết hàng" : "Mới"}}</li>
                </ul>
                <div class="product-decs">
                    <a class="inner-link" href="{{route('client.single-product',['id'=>$item->id])}}"><span>{{isset($item->category) ? $item->category->name : ''}}</span></a>
                    <h2><a href="" class="product-link">{{$item->name}}</a></h2>
                    <span class="rating-active">
                        @for($i = 1; $i <= 5; $i++)
                        <i class="fa fa-star {{ $i <= $avg ? 'active' : '' }}"></i>
                        @endfor
                    </span>
                    <div class="pricing-meta">
                        <ul>
                            <li class="current-price">{{number_format($item->price)}} đ</li>
                        </ul>
                    </div>
                </div>
                <div class="add-to-link">
                    <ul>
                        <li class="cart">
                            @if ($today <= "09:00:00" && $item->allow_market ==2)
                            <a class="cart-btn" product-id='{{$item->id}}' href="#" >Thêm vào giỏ</a>
                            @endif
                            @if ($item->allow_market ==1)
                            <a class="cart-btn" product-id='{{$item->id}}' href="#" >Thêm vào giỏ</a>
                            @endif
                            @if($today > "09:00:00" && $item->allow_market ==2)
                            <a class="cart-btns" product-id='{{$item->id}}' href="#" >Thêm vào giỏ</a>
                            @endif  
                        </li>
                        <li>
                            <a
                            @if(Auth::check())
                                onclick="return confirm('Bạn muốn thêm sản phẩm vừa chọn vào mục yêu thích?')" href="{{route('client.add-wishlist',['id'=>$item->id])}}"><i class="ion-android-favorite-outline"
                                @else
                                    hidden
                            @endif
                            >
                            </i></a>
                        </li>
                    </ul>
                </div>
            </article>
            @endforeach
            <!-- End Single Item -->
        </div>
        <!-- Recent product slider end -->
    </div>
</section>
<!-- Recent product area end -->
@endsection


@section('script')
<script type="text/javascript">
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
// rating product
$(function() {
    let listStart = $(".list_start .fa");
    listRatingText = {
        1: 'Không thích',
        2: 'Tạm được',
        3: 'Bình thường',
        4: 'Rất tốt',
        5: 'Rất tuyệt vời',
    }
    listStart.mouseover(function() {
        let $this = $(this);
        let number = $this.attr('data-key');
        listStart.removeClass('rating_active');
        $(".number_rating").val(number);
        $.each(listStart, function(key, value) {
            if (key + 1 <= number) {
                $(this).addClass('rating_active')
            }
        });
        $(".list_text").text('').text(listRatingText[$this.attr('data-key')]).show();
        console.log(number);
    });
    $(".js_rating_product").click(function(e) {
        event.preventDefault();
        let number = $(".number_rating").val();
        let content = $("#ra_content").val();
        let url = $(this).attr('href');
        let idProduct = $(".id_product").val();
        if (content && number) {
            $.ajax({
                url: '/DATN-2021/datn/public/client/single-product/rating/' + idProduct,
                type: 'POST',
                data: {
                    number: number,
                    r_content: content,
                }
            }).done(function(result) {
                if (result.code == 1) {
                    location.reload();
                }
            });
        }
    });
});
</script>
@stop