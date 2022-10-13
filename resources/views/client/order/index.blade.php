@extends('layout-client')
@section('content')
<style>
.form-group {
    margin-top: 15px;
}

</style>
<!-- Breadcrumb Area start -->
<section class="breadcrumb-area" style="
    background: repeating-linear-gradient(21deg, #4fb68d96, #edb1b100 244px);">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="breadcrumb-content">
                    <h1 class="breadcrumb-hrading">Đơn hàng của tôi</h1>
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
        <h3 class="cart-page-title">Danh sách đơn hàng (Hiển thị {{ count($my_order) }} / {{ count($my_orders) }})</h3>
        <p class="success" style="color:green; font-size:20px; font-weight:bold;text-align: center;">
                            <?php
                            $message = Session::get('message');
                            if($message){
                                echo $message;
                                Session::put('message', NULL);
                                }
                            ?>
                        </p>
        @foreach($my_order as $key =>$item)
        <div class="row" style="margin: 63px 0;">
            <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="col-md-12" style="margin-bottom: 15px;padding: 0px;">
                    <strong style="color:#000;font-size:19px;text-transform:uppercase;">Mã đơn hàng :
                        {{$item->id}}</strong>
                </div>
                <div class="white-box" style="border:1px solid #4fb68d;">
                    <div class="col-md-12" style="background:#4fb68d; padding:10px;">
                        <strong style="color:#fff;padding: 15px;">Thông tin đặt hàng</strong>
                    </div>

                    <div class="row">

                        <div class="col-md-6">
                            <div class="box-content">
                                <div class="col-md-12" style="margin-top:15px;"><strong>Ngày đặt hàng :
                                        {{$item->created_at}}</strong></div>
                                <div class="form-group">
                                    <div class="col-md-12"><strong>Tên người đặt</strong></div>
                                    <div class="col-md-12">
                                        <input type="text" class="form-control" value="{{$item->customer_fullname}}" readonly>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12"><strong>Địa chỉ</strong></div>
                                    <div class="col-md-12">
                                        <textarea name="" id="" cols="30" rows="5"
                                            class="form-control" readonly>{{$item->customer_address}}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="box-content">
                                <div class="col-md-12"  style="margin-top:15px;">
                                    <strong>Tình trạng đơn hàng :
                                        <span class=' {{$item->status == 0 || $item->status == 4 ? "text-danger" : "text-success"}}'>
<?php
                                        if($item->status == 0){
                                            echo "Chờ xác nhận";
                                        }
                                        if($item->status == 1){
                                            echo "Đã nhận đơn";
                                        }
                                        if($item->status == 2){
                                            echo "Đang giao";
                                        }
                                        if($item->status == 3){
                                            echo "Đã thanh toán";
                                        }
                                        if($item->status == 4){
                                            echo "Đơn hàng đã bị hủy";
                                        }
?>
                                        </span>
                                    </strong>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12"><strong>Email</strong></div>
                                    <div class="col-md-12">
                                        <input type="email" class="form-control" value="{{$item->customer_email}}" readonly>
                                    </div>
                                </div>
                                <div class="form-group" style="margin-bottom:20px;">
                                    <div class="col-md-12"><strong>Số điện thoại</strong></div>
                                    <div class="col-md-12">
                                        <input type="number" max="11" min="12" class="form-control"
                                            value="{{$item->customer_phone}}" readonly>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                <a href="{{URL::to('/client/order/order-detail/'.$item->id)}}"><button class="btn btn-success">Chi tiết đơn hàng</button></a>
                                    <a href="{{route('client.delete-order',['id'=>$item->id])}}" 
                                    <?php
                                        if($item->status > 0){
                                            echo "hidden";
                                        }
                                    ?>
                                    class="btn btn-danger">Hủy đơn hàng</a>
                                    <a href="{{route('client.add2-order',['id'=>$item->id])}}" 
                                    <?php
                                        if(empty($item->status == 4)){
                                            echo "hidden";
                                        }
                                    ?>
                                    class="btn btn-danger">Đăt hàng lại</a>
                                    <a href="{{route('client.delete2-order',['id'=>$item->id])}}" 
                                    <?php
                                        if(empty($item->status == 4)){
                                            echo "hidden";
                                        }
                                    ?>
                                    class="btn btn-danger">Xóa</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12" style="border:1px solid #888"></div>
        @endforeach
    </div>
</div>
@endsection