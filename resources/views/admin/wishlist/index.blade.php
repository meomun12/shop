@extends('layout-admin')
@section('content')

<div id="page-wrapper">
            <div class="container-fluid">
                <div class="row bg-title">
                    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                        <h4 class="page-title">Danh Mục</h4> </div>
                    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                        <a href="{{route('client.homepage')}}" target="_blank" class="btn btn-danger pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light">Về trang chủ <i class="fa fa-home" aria-hidden="true"></i></a>
                        <ol class="breadcrumb">
                            <li><a href="{{route('admin.dashboard')}}">Bảng điều khiển</a></li>
                            <li class="active">Danh mục</li>
                        </ol>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="white-box">
                                <h3 class="box-title">Danh sách</h3>
                                <p class="success" style="color:green; font-size:20px; font-weight:bold;"></p>
                            <div class="table-responsive">
                                <table class="table table-hover" id="example" class="display" style="width:100%">
                                    <thead>
                                        <tr>
                                            <td>Ảnh</td>
                                            <th>Tên Sản phẩm</th>
                                            <th>Giá</th>
                                            <th>Tài khoản</th>
                                            <th>Email</th>
                                            <th>Số hàng còn</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($wish_lists as $item)
                                            <tr>
                                                <td><img src="{{$item->product->image_gallery}}" width="100" height="100" alt=""></td>
                                                <td>{{isset($item->product) ? $item->product->name : ''}}</td>
                                                <td>{{isset($item->product) ? number_format($item->product->price) : ''}} đ</td>
                                                <td>{{isset($item->user) ? $item->user->name : ''}}</td>
                                                <td>{{isset($item->user) ? $item->user->email : ''}}</td>
                                                <td>{{isset($item->product) ? $item->product->quantily : ''}} SP</td>
                                            </tr>  
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th style="visibility:hidden;">Anhr</th>
                                            <th style="visibility:hidden;">Tên sản phẩm</th>
                                            <th style="visibility:hidden;">Giá</th>
                                            <th style="border:none">Tài khoản</th>
                                            <th style="border:none">Email</th>
                                            <th style="border:none">Số hàng còn</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <footer class="footer text-center"> 2021 &copy; Ample Admin brought to you by MarketNow.com </footer>
        </div>

@endsection
