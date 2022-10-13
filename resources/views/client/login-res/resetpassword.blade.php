@extends('layout-client')
@section('content')
<!-- Breadcrumb Area start -->
<section class="breadcrumb-area" style = "padding: 35px 0;">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="breadcrumb-content">
                    <h1 class="breadcrumb-hrading">Đổi Mật Khẩu</h1>
                    <ul class="breadcrumb-links">
                        <li><a href="{{route('client.homepage')}}">Trang chủ</a></li>
                        <li>Đổi Mật Khẩu</li>
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
                    <div class="tab-content">
                        <div id="lg1" class="tab-pane active">
                            <div class="login-form-container">
                                <div class="login-register-form">
                                    <p style="text-align: center;font-size: 150%;color: #4fb68d;font-weight: bold;"><?php
                                        $message = Session::get('message');
                                        if($message){
                                            echo $message;
                                            Session::put('message', NULL);
                                        }
                                    ?></p>
                                    <form method="post" action="{{route('client.resetpasswords', ['id' => $user->id])}}"  class="was-validated">
                                    @csrf
                                    <input type="text"  name="token" value="{{(old('token'))}}" placeholder="Nhập mã OTP" required/>
                                    <input type="password" class="form-control" id="password" name="password" placeholder="Mật khẩu mới" />
                                        @error('password')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                        
                                     <div class="button-box">
                                            <button type="submit"><span>Đổi mật khẩu</span></button>
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