@extends('layout-client')
@section('content')

<style>


.info-product-order {
    background: #fafafa;
    border-bottom: 1px solid rgba(0, 0, 0, .09)
}

.info-product-order .all-info {
    width: 100%;
    height: 120px;
}

.info-product-order .all-info .image-item-product {
    width: 18%;
    height: 100%;
    float: left;
}

.info-product-order .all-info .image-item-product img {
    width: 100%;
    height: 100%;
}

.info-product-order .all-info .content-info {
    width: 82%;
    height: 100%;
    float: right;
    padding: 13px 75px;
}

.info-product-order .price-product {
    width: 100%;
    height: 120px;
}

.info-product-order .price-product span {
    position: absolute;
    right: 30%;
    bottom: 38%;
    font-size: 17px;
    font-weight: 500;
}
</style>
<!-- Breadcrumb Area start -->
<section class="breadcrumb-area" style="
    background: repeating-linear-gradient(21deg, #4fb68d96, #edb1b100 244px);">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="breadcrumb-content">
                    <h1 class="breadcrumb-hrading">Chi tiết của tôi</h1>
                    <ul class="breadcrumb-links">
                        <li><a href="{{route('client.homepage')}}">Trang chủ</a></li>
                        <li>Đơn hàng</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="cart-main-area mtb-60px">
    <div class="container">
        <h3 class="cart-page-title">Danh sách sản phẩm đã đặt</h3>
        <div class="row" style="margin: 63px 0;">
            <div class="col-lg-8 col-md-8 col-sm-12 col-12" style="margin:0 auto;">
                <div class="white-box">
                    <div class="col-md-12">
                        <a href="{{route('client.show.my_order')}}" style="color:#fff;text-align:center; font-size: 17px;font-weight: 700;"><button class="btn btn-info"> Trở về</button></a>
                    </div>
                </div>

                <div class="info-bottom" style="margin-top:30px;">
                    @foreach($order_product as $item)
                    <div class=" col-sm-12 info-product-order">
                        <div class="col-sm-8" style="padding: 15px 5px;float:left;">
                            <div class="all-info">
                                <div class="image-item-product">
                                    <img src="{{asset($item->product_order->image_gallery)}}" alt="">
                                </div>
                                <div class="content-info">
                                    <div class="name-product" style="padding:5px;"><span
                                            style="font-size:18px;">{{ isset($item->product_order) ? $item->product_order->name : '' }}</span>
                                    </div>

                                    <div class="category-product" style="padding:5px;"><span style="color: #777;">
                                            <?php 
                                        $parent = App\Models\Category::find($item->product_order->category_id);
                                        $cate_t = $parent->name;    
                                        ?>
                                            {{  $cate_t }}
                                        </span></div>
                                    <div class="product_quantily" style="padding:5px;">
                                        <span>Số lượng :
                                            {{ $item->total / $item->unit_price }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3" style="padding: 15px 5px;right: -78%;">
                            <div class="price-product"><span>{{ number_format($item->total)}} ₫</span></div>
                        </div>
                    </div>
                    @endforeach

                    <div class="payment-detail__container Ovq6t9">
                        <div class="payment-detail__item">
                            <div class="payment-detail__item__description">VAT(10%)</div>
                            <div class="payment-detail__item__value">
                                <div class="payment-detail__item__value-text"> 
                                    {{number_format($order_product->sum('total')*0.1)}} ₫
                                        </div>
                            </div>
                        </div>
                        <div class="payment-detail__item">
                            <div class="payment-detail__item__description">Khuyến mại voucher</div>
                            <div class="payment-detail__item__value">
                                <div class="payment-detail__item__value-text"> 
                                    <?php 
                                        if($order_detail->voucher_id == 0){
                                            $voucher =  'Không sử dụng';
                                        }else{
                                            $parent = App\Models\Voucher::find($order_detail->voucher_id);
                                            if($parent->type == 2){
                                                $voucher = $parent->value . ' %';    
                                            }
                                            if($parent->type == 1){
                                                $voucher = $parent->value . ' ₫';    
                                            }
                                        }
                                    ?>
                                        {{ $voucher}} 
                                        </div>
                            </div>
                        </div>
                        <div class="payment-detail__item payment-detail__item--last">
                            <div class="payment-detail__item__description">Tổng số tiền</div>
                            <div class="payment-detail__item__value payment-detail__item__value--highlighted">
                                <div class="payment-detail__item__value-text">
                                    <div>
                                        <div>{{number_format($order_detail->totalMoney)}} ₫</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection