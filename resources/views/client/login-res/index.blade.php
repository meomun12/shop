@extends('layout-client')
@section('content')
<!-- Breadcrumb Area start -->
<section class="breadcrumb-area" style = "padding: 35px 0;">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="breadcrumb-content">
                    <h1 class="breadcrumb-hrading">Đăng nhập / Đăng ký</h1>
                    <ul class="breadcrumb-links">
                        <li><a href="{{route('client.homepage')}}">Trang chủ</a></li>
                        <li>Đăng nhập / Đăng ký</li>
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
                                    <form method="post" action="{{route('client.login')}}" class="was-validated">
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
                                                <a href="{{ route('client.forgotpassword') }}">Quên mật khẩu?</a>
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
                                        <input type="text" name="name"  placeholder="Họ và tên"  />
                                        @error('name')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                        <input type="password"  name="password" placeholder="Mật khẩu" />
                                        @error('password')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                        <input id="password-confirm" type="password" placeholder="Nhập lại Mật khẩu"   name="password_confirmation" autocomplete="new-password">
                                        @error('password_confirmation')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                        <input type="file"  name="avatar" />
                                        @error('avatar')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                        <input type="email"  id="email" name="email" placeholder="Nhập Email" value="{{(old('email'))}}"  />
                                        @error('email')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                        <input name="phone"  placeholder="Điện thoại" type="number" />
                                        @error('phone')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                        <input name="address"  placeholder="Địa chỉ" type="text"/>
                                        @error('address')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
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