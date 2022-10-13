@extends('layout-client')
@section('content')
<!-- Breadcrumb Area start -->
<section class="breadcrumb-area" style="
    background: repeating-linear-gradient(21deg, #4fb68d96, #edb1b100 244px);
">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="breadcrumb-content">
                    <h1 class="breadcrumb-hrading">Liên Hệ</h1>
                    <ul class="breadcrumb-links">
                        <li><a href="{{route('client.homepage')}}">Trang chủ</a></li>
                        <li>Liên hệ</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="contact-area mtb-60px">
    <div class="container">

        <div class="custom-row-2">
            <div class="col-lg-4 col-md-5">
                <div class="contact-info-wrap">
                    <div class="single-contact-info">
                        <div class="contact-icon">
                            <i class="fa fa-phone"></i>
                        </div>
                        <div class="contact-info-dec">
                            <p>(+84) 333507696</p>
                            <p>(+84) 973476045</p>
                        </div>
                    </div>
                    <div class="single-contact-info">
                        <div class="contact-icon">
                            <i class="fa fa-globe"></i>
                        </div>
                        <div class="contact-info-dec">
                            <p><a href="#">cuahangtaphoachucan@gmail.com</a></p>
                            <p><a href="#">cuahangtaphoachucan.com</a></p>
                        </div>
                    </div>
                    <div class="single-contact-info">
                        <div class="contact-icon">
                            <i class="fa fa-map-marker"></i>
                        </div>
                        <div class="contact-info-dec">
                            <p>Số 265 Trung Hoà, Phường Trung Hoà </p>
                            <p>Quận Cầu Giấy,TP Hà Nội</p>
                        </div>
                    </div>
                    <div class="contact-social">
                        <h3>Theo dõi</h3>
                        <div class="social-info">
                            <ul>
                                <li>
                                    <a href="#"><i class="ion-social-facebook"></i></a>
                                </li>
                                <li>
                                    <a href="#"><i class="ion-social-twitter"></i></a>
                                </li>
                                <li>
                                    <a href="#"><i class="ion-social-youtube"></i></a>
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
                </div>
            </div>
            <div class="col-lg-8 col-md-7">
                <div class="contact-form">
                    <div class="contact-title mb-30">
                        <h2>Liên hệ với chúng tôi</h2>
                    </div>
                    @if(Session::has('message'))
                    <div class="alert alert-success">{{ Session::get('message') }}</div>
                    @endif
                    <form class="contact-form-style" id="contact-form" action="{{route('client.postcontact')}}" method="post" role="form">
                        @csrf
                        <div class="row">
                            <div class="col-lg-6">
                                <input name="name" placeholder="Tên*" type="text" required />
                            </div>
                            <div class="col-lg-6">
                                <input name="email" placeholder="Email*" type="email" required />
                            </div>
                            <div class="col-lg-12">
                                <input name="title" placeholder="Tiêu đề*" type="text" required/>
                            </div>
                            <div class="col-lg-12">
                                <textarea name="content" placeholder="Nội dung*" required></textarea>
                                <button class="submit" type="submit">Gửi</button>
                            </div>
                        </div>
                    </form>
                    
                    <p class="form-messege"></p>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- contact area end -->
@endsection

