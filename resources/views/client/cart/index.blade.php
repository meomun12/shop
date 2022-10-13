@extends('layout-client')
@section('content')
<?php
    $totalPriceInCart = 0;                               
    if(isset($_SESSION['cart'])){
        foreach($_SESSION['cart'] as $val){
            $totalPriceInCart += $val['price'] * $val['quantity'];
        }
    }
    if(isset($_SESSION['carts'])){
        foreach($_SESSION['carts'] as $val){
            $totalPriceInCart += $val['price'] * $val['quantity'];
        }
    }
?>
<!-- Breadcrumb Area start -->
<section class="breadcrumb-area" style="
    background: repeating-linear-gradient(21deg, #4fb68d96, #edb1b100 244px);">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="breadcrumb-content">
                    <h1 class="breadcrumb-hrading">Giỏ Hàng</h1>
                    <ul class="breadcrumb-links">
                        <li><a href="{{route('client.homepage')}}">Trang chủ</a></li>
                        <li>Giỏ hàng</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Breadcrumb Area End -->
<!-- cart area start -->
<div class="cart-main-area mtb-60px">
    <div class="container">
        <h3 class="cart-page-title">Giỏ hàng của bạn</h3>
        <div class="row content-cart">
            <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                <form action="#">
                    <div class="table-content table-responsive cart-table-content">
                        <table>
                            <thead>
                                <tr>
                                    <th>Ảnh</th>
                                    <th>Tên Sản phẩm</th>
                                    <th>Loại sản phẩm</th>
                                    <th>Giá</th>
                                    <th>Số lượng</th>
                                    <th>Thành tiền</th>
                                    <th>Hạnh động</th>
                                </tr>
                            </thead>
                            <tbody>
                            @if (isset($_SESSION['cart']) && !empty($_SESSION['cart']) || isset($_SESSION['carts']) && !empty($_SESSION['carts']))
                            <?php if(isset($_SESSION['cart']) && !empty($_SESSION['cart'])) :  ?>
                                    @foreach ($_SESSION['cart'] as $item)  
                                    <tr id="{{$item['id']}}">
                                        <td class="product-thumbnail">
                                            <a href="#"><img width="60" height="60" src="{{asset('/')}}{{$item['image']}}" alt="" /></a>
                                        </td>
                                        <td class="product-name"><a href="#">{{$item['name']}}</a></td>
                                        <td class="product-market"><a href="#">{{$item['allow_market'] == 1 ? "Thông Thường" : "Đi chợ"}}</a></td>
                                        <td class="product-price-cart"><span class="amount">{{number_format($item['price'])}} VNĐ</span></td>
                                        <td class="product-quantity">
                                            <div class="cart-plus-minus">
                                                <input class="cart-plus-minus-box" prod-id="{{$item['id']}}" type="text" name="qtybutton" value="{{$item['quantity']}}" />
                                            </div>
                                        </td>
                                        <td class="product-subtotal" prod-id="{{$item['id']}}">{{number_format($item['price'] * $item['quantity'])}} VNĐ</td>
                                        <td class="product-remove">
                                            <a href="#" prod-id="{{$item['id']}}"><i class="fa fa-times"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                                <?php endif ?>
                                <?php if(isset($_SESSION['carts']) && !empty($_SESSION['carts'])) :  ?>
                                @foreach ($_SESSION['carts'] as $item)
                                        <tr id="{{$item['id']}}">
                                            <td class="product-thumbnail">
                                                <a href="#"><img width="60" height="60" src="{{asset('/')}}{{$item['image']}}" alt="" /></a>
                                            </td>
                                            <td class="product-name"><a href="#">{{$item['name']}}</a></td>
                                            <td class="product-market"><a href="#">{{$item['allow_market'] == 2 ? "Đi chợ" : "Thông Thường"}}</a></td>
                                            <td class="product-price-cart"><span class="amount">{{number_format($item['price'])}} VNĐ</span></td>
                                            <td class="product-quantity">
                                                <div class="cart-plus-minus">
                                                    <input class="cart-plus-minus-box" prod-id="{{$item['id']}}" type="number" name="qtybutton"  value="{{$item['quantity']}}" 
                                                    step ="<?php $parent = App\Models\Category::all()->where('id',35);
                                                        if(isset($parent)){
                                                            print "0.2";
                                                        }
                                                    ?>"
                                                    />
                                                </div>
                                            </td>
                                            <td class="product-subtotals" prod-id="{{$item['id']}}">{{number_format($item['price'] * $item['quantity'])}} VNĐ</td>
                                            <td class="product-remove">
                                                <a href="#" prod-id="{{$item['id']}}"><i class="fa fa-times"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    <?php endif ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="cart-shiping-update-wrapper">
                                <div class="cart-shiping-update">
                                    <a href="{{route('client.homepage')}}">Tiếp tục mua sắm</a>
                                </div>
                                <div class="cart-clear">
                                    <a href="#" id="update-cart">Cập nhật giỏ hàng</a>
                                    <a href="{{route('client.remove-product-in-carts')}}" onclick="return confirm('Bạn muốn xóa toàn bộ giỏ hàng')" id="delete-cart">Xóa giỏ hàng</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="row">
                    
                    <div class="col-lg-4 col-md-6 voucher-box">
                        <?php if(!isset($_SESSION['voucher'])) : ?>
                        <div class="discount-code-wrapper">
                            <div class="title-wrap">
                                
                                <h4 class="cart-bottom-title section-bg-gray">Mã giảm giá</h4>
                            </div>
                            <div class="discount-code">
                                <i>Phiếu giảm giá chỉ áp dụng cho sản phẩm thông thường.</i>
                                <form>
                                    <input type="text" id="voucher-code" required="" name="name" />
                                    <button id="add-voucher" class="cart-btn-2" type="submit">Áp dụng phiếu giảm giá</button>
                                </form>
                            </div>
                        </div>
                        <?php endif ?>
                    </div>
                    
                    <div class="col-lg-8 col-md-12">
                        <div class="grand-totall">
                            <div class="title-wrap">
                                <h4 class="cart-bottom-title section-bg-gary-cart">Hóa đơn chi tiết</h4>
                            </div>
                            <?php 
                                $totalPriceInCartAfterAddVoucher = ($totalPriceInCart);
                            ?>
                            <h5>Tổng tiền sản phẩm <span id="total-price-cart">{{number_format($totalPriceInCartAfterAddVoucher)}} VNĐ</span></h5>
                            <h5>Giảm giá 
                                <span id="sale-off">
                                    <?php 
                                        $voucherPrice = 0;
                                        if(isset($_SESSION['voucher'])){
                                            if($_SESSION['voucher']['type'] == 1){
                                                $voucherPrice = ($_SESSION['voucher']['value']);
                                                echo number_format($voucherPrice). " VNĐ";
                                            }
                                            else if($_SESSION['voucher']['type'] == 2){
                                                $voucherPrice = ($totalPriceInCart * ($_SESSION['voucher']['value']) /100);
                                                echo number_format($voucherPrice) . " VNĐ";
                                            }   
                                        }
                                        else {
                                            echo $voucherPrice." VNĐ";
                                        }
                            
                                    ?> 
                                </span>
                            </h5>
                            <h5>VAT (10%)<span>{{number_format($totalPriceInCart*0.1)}} VNĐ</span></h5>
                            <h5>Phí giao hàng <span>0 VNĐ</span></h5>
                            <div class="title-wrap">
                                <h4 class="cart-bottom-title section-bg-gary-cart">Thông tin đặt hàng</h4>
                                
                            </div>
                            {{-- <label for="">Họ Tên</label> --}}
                            <input class="mt-4 pl-2" type="text" style="width:100%;height:36px;" id="full-name-customer" value="@if(Auth::user()) {{Auth::user()->name}} @endif">
                            <input class="mt-4 pl-2" type="text" style="width:100%;height:36px;" id="email-customer" value="@if(Auth::user()) {{Auth::user()->email}} @endif">
                            {{-- <label for="">Số điện thoại</label> --}}
                            <input class="mt-4 pl-2" type="text" style="width:100%;height:36px;" id="phone-customer" value="@if(Auth::user()) {{Auth::user()->phone}} @endif">
                            <textarea class="mt-4 pl-2" rows="5" type="text" style="width:100%;height:px;" id="address-customer" placeholder="Địa chỉ nhận hàng">@if(Auth::user()) {{Auth::user()->address}} @endif</textarea>
                            <div class="total-shipping">
                                <h5>Loại hình thanh toán</h5>
                                <ul>
                                    <li><input type="checkbox" class="select-payment-method" value="cod"/> Thanh toán khi nhận hàng</li>
                                    <li><input type="checkbox" class="select-payment-method" value="vnpay"/> Thanh toán online qua VNPay</li>
                                </ul>
                            </div>
                            <?php 
                                $totalPriceInCartAfterAddVoucher = ($totalPriceInCart) - $voucherPrice +($totalPriceInCart*0.1);
                            ?>
                            <h4 class="grand-totall-title">Tổng tiền : {{number_format($totalPriceInCartAfterAddVoucher)}} VNĐ</span></h4>
                            <a id="checkout" href="">Thanh toán</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @else
            <h3 class="container-fluid text-center">Giỏ hàng trống!</h3>                    
        @endif
    </div>
</div>
<!-- cart area end -->
@endsection