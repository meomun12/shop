@extends('layout-client')
@section('content')
<!-- Breadcrumb Area start -->
<section class="breadcrumb-area" style = "padding: 35px 0;">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="breadcrumb-content">
                    <h1 class="breadcrumb-hrading">Quên Mật Khẩu</h1>
                    <ul class="breadcrumb-links">
                        <li><a href="{{route('client.homepage')}}">Trang chủ</a></li>
                        <li>Quên Mật Khẩu</li>
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
                                <p class="success" style="color:red; font-size:15px; font-weight:bold;">
                                    <?php
                                    $message = Session::get('error');
                                    if($message){
                                        echo $message;
                                        Session::put('error', NULL);
                                        }
                                    ?>
                                </p>
                                <div class="login-register-form">
                                    <form  method="POST" action="{{URL::to('/client/sendSmsToken')}}" class="was-validated">
                                        @csrf
                                        <input type="phone" class="form-control" id="phone" name="phone" placeholder="Nhập số điện thoại" value="{{(old('phone'))}}" required />
                                        <div class="button-box">
                                            <button type="submit"><span>Gửi mã OTP</span></button>
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