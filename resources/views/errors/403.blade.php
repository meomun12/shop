@extends('layout-client')
<header class="main-header">
<style>
        .main-header{
            visibility:hidden;
        }
</style>
</header>
@section('content')
<!-- Breadcrumb Area start -->
<section class="breadcrumb-area" style = "padding: 35px 0;">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="breadcrumb-content">
                <h2>Tài khoản của bạn đã bị khóa hoặc bạn không có quyền truy cập trang</h2>
                <br>
                        <h4>Bạn hãy đăng nhập bằng tài khoản khác hoặc đăng kí tài khoản mới</h4>
                        <ul class="breadcrumb-links">
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Breadcrumb Area End -->
<!-- login area start -->
<div class="login-register-area mb-60px mt-53px">
    <div class="container">
        <div class="row">
            <div class="col-lg-7 col-md-12 ml-auto mr-auto">
                <div class="login-register-wrapper">
                    <div class="login-register-tab-list nav">
                    <a class="active" data-toggle="tab" href="#lg1">
                            <h4>Đăng nhập</h4>
                        </a>
                        <a data-toggle="tab" href="#lg2">
                            <h4>Đăng kí</h4>
                        </a>
                    </div>
                    <p style="text-align: center;font-size: 150%;color: #4fb68d;font-weight: bold;"><?php
                        $message = Session::get('message');
                        if($message){
                            echo $message;
                            Session::put('message', NULL);
                        }
                    ?></p>
                    <div class="tab-content">
                        <div id="lg1" class="tab-pane active">
                            <div class="login-form-container">
                                <div class="login-register-form">
                                    <form method="POST" action="{{route('client.login.err')}}" enctype="multipart/form-data" class="was-validated">
                                        @error('msg')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                        @csrf
                                        <input type="email" class="form-control" id="email" name="email" placeholder="Nhập Email" value="{{(old('email'))}}" required />
                                        @error('email')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                        <input type="password" class="form-control" id="password" name="password" placeholder="Mật khẩu" required/>
                                        @error('password')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                        <div class="button-box">
                                            <div class="login-toggle-btn">
                                                <input type="checkbox"  class="form-check-input" name="remember_me" id="remember_me"/>
                                                <label class="flote-none" for="remember_me">Lưu đăng nhập</label>
                                                <a href="#">Quên mật khẩu?</a>
                                            </div>
                                            <button type="submit"><span>Đăng nhập</span></button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div id="lg2" class="tab-pane">
                            <div class="login-form-container">
                                <div class="login-register-form" >
                                    <form method="post" action="{{route('client.registration')}}"  enctype="multipart/form-data" class="was-validated">
                                    @csrf
                                        <input type="text" name="name" class="form-control" placeholder="Tên tài khoản"  required/>
                                        <input type="password" class="form-control" name="password" placeholder="Mật khẩu" required/>
                                        <input type="file" class="form-control" name="avatar" required/>
                                        <input type="email" class="form-control" id="email" name="email" placeholder="Nhập Email" value="{{(old('email'))}}" required />
                                        <input name="phone" class="form-control" placeholder="Điện thoại" type="number" required/>
                                        <input name="address" class="form-control" placeholder="Địa chỉ" type="text" required/>
                                        <div class="button-box">
                                            <button type="submit"><span>Đăng ký</span></button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- login area end -->
@endsection