@extends('layout-client')
@section('content')
<!-- Breadcrumb Area start -->
<section class="breadcrumb-area" style="
    background: repeating-linear-gradient(21deg, #4fb68d96, #edb1b100 244px);">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="breadcrumb-content">
                    <h1 class="breadcrumb-hrading">Tài khoản</h1>
                    <ul class="breadcrumb-links">
                        <li><a href="{{route('client.homepage')}}">Trang chủ</a></li>
                        <li>Tài khoản</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Breadcrumb Area End -->
<!-- account area start -->
<div class="checkout-area mtb-60px">
    <div class="container">
        <div class="row">
            <div class="ml-auto mr-auto col-lg-9">
                <div class="checkout-wrapper">
                    <div id="faq" class="panel-group">
                        <div class="panel panel-default single-my-account">
                            <div class="panel-heading my-account-title">
                                <h3 class="panel-title"><span>1 .</span> <a data-toggle="collapse" data-parent="#faq"
                                        href="#my-account-1">THÔNG TIN CÁ NHÂN </a></h3>
                            </div>
                            <div id="my-account-1" class="panel-collapse collapse show">
                                <p class="success" style="color:green; font-size:20px; font-weight:bold;">
                                    <?php
                                    $message = Session::get('message');
                                    if($message){
                                        echo $message;
                                        Session::put('message', NULL);
                                        }
                                    ?>
                                </p>
                                <div class="panel-body">
                                    <form class="form-horizontal form-material" method="POST" enctype="multipart/form-data" action="{{URL::to('/client/my-account/update/'.Auth::user()->id)}}">
                                        @csrf
                                    <div class="myaccount-info-wrapper">
                                        <div class="account-info-wrapper">
                                            <h4>TÀI KHOẢN CỦA BẠN</h4>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-6 col-md-6">
                                                <div class="billing-info">
                                                    <label>Họ và tên</label>
                                                    <input type="text" value="{{ Auth::user()->name }}" name="name"/>
                                                </div>
                                                @error('name')
                                                    <div class="alert alert-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-lg-6 col-md-6 ">
                                                <div class="billing-info">
                                                    <img id="image" src="{{asset(Auth::user()->avatar)}}" width="60%" height="200px" alt="{{Auth::user()->avatar}}">
                                                    <input name="avatar" type="file" onchange="changeImage()" id="fileImage" alt="{{Auth::user()->avatar}}"/>
                                                </div>
                                                @error('avatar')
                                                    <div class="alert alert-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-lg-6 col-md-6">
                                                <div class="billing-info">
                                                    <label>Email</label>
                                                    <input type="text" value="{{ Auth::user()->email }}" name="email"/>
                                                </div>
                                                @error('email')
                                                    <div class="alert alert-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-lg-6 col-md-6">
                                                <div class="billing-info">
                                                    <label>Điện thoại</label>
                                                    <input type="text" value="{{ Auth::user()->phone }}" name="phone"/>
                                                </div>
                                                @error('phone')
                                                    <div class="alert alert-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-lg-12 col-md-12">
                                                <div class="billing-info">
                                                    <label>Địa chỉ</label>
                                                    <input type="text" value="{{ Auth::user()->address }}" name="address"/>
                                                </div>
                                                @error('address')
                                                    <div class="alert alert-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="billing-back-btn">
                                            <div class="billing-back">
                                                <a href="#"><i class="fa fa-arrow-up"></i> Quay lại</a>
                                            </div>
                                            <div class="billing-btn">
                                                <button type="submit" class="btn btn-danger">Cập nhật</button>
                                            </div>
                                        </div>
                                    </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-default single-my-account">
                            <div class="panel-heading my-account-title">
                                <h3 class="panel-title"><span>2 .</span> <a data-toggle="collapse" data-parent="#faq"
                                        href="#my-account-2">Mật khẩu</a></h3>
                            </div>
                            <div id="my-account-2" class="panel-collapse collapse">
                                <div class="panel-body">
                                    <div class="myaccount-info-wrapper">
                                        <div class="account-info-wrapper">
                                            <h4>Đổi mật khẩu</h4>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-12 col-md-12">
                                                <div class="billing-info">
                                                    <label>Mật khẩu cũ</label>
                                                    <input type="password" />
                                                </div>
                                            </div>
                                            <div class="col-lg-12 col-md-12">
                                                <div class="billing-info">
                                                    <label>Mật khẩu mới</label>
                                                    <input type="password" />
                                                </div>
                                            </div>
                                            <div class="col-lg-12 col-md-12">
                                                <div class="billing-info">
                                                    <label>Nhập lại mật khẩu mới</label>
                                                    <input type="password" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="billing-back-btn">
                                            <div class="billing-back">
                                                <a href="#"><i class="fa fa-arrow-up"></i> Quay lại</a>
                                            </div>
                                            <div class="billing-btn">
                                                <button type="submit">Cập nhật</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-default single-my-account">
                            <div class="panel-heading my-account-title">
                                <h3 class="panel-title"><span>3 .</span> <a href="{{route('client.show.my_order')}}">Đơn hàng
                                    </a></h3>
                            </div>
                        </div>
                        <div class="panel panel-default single-my-account">
                            <div class="panel-heading my-account-title">
                                <h3 class="panel-title"><span>4 .</span> <a href="{{route('client.show-wishlist')}}">Yêu thích
                                    </a></h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- account area end -->
<!-- Footer Area start -->
@endsection