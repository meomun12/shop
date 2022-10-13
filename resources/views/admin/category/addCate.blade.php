@extends('layout-admin')
@section('content')

<div id="page-wrapper">
                <div class="container-fluid">
                    <div class="row bg-title">
                        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                            <h4 class="page-title">Thêm danh mục mới</h4> </div>
                        <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                            <a href="{{route('client.homepage')}}" target="_blank" class="btn btn-danger pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light">Về trang chủ <i class="fa fa-home" aria-hidden="true"></i></a>
                            
                            <ol class="breadcrumb">
                                <li><a href="#">Bảng điều khiển</a></li>
                                <li class="active">Thêm danh mục</li>
                            </ol>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 col-xs-12">
                            <div class="white-box">
                            
                                <form class="form-horizontal form-material" action="" method="POST" enctype="multipart/form-data" >
                                    @csrf
                                    <div class="form-group">
                                        <label class="col-md-12">Tên danh mục</label>
                                        <div class="col-md-12">
                                            <input type="text" name ="name"  class="form-control form-control-line" value="{{ old('name') }}"> </div>
                                    </div>
                                    @error('name')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                                        <img id="image" src="frontend/image_cate\1.jpg" width="30%" height="300px" alt="">
                                    <hr>
                                    <div class="form-group">
                                        <label class="col-sm-12">Tải ảnh mới</label>
                                        <input class="col-sm-12" name="image" type="file" onchange="changeImage()" id="fileImage">
                                    </div>
                                    @error('image')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <button type="submit" class="btn btn-danger">Thêm mới</button>
                                            <a href="{{route('admin.listCate')}}" class="btn btn-success">Trở về</a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                            
                    </div>
                </div>
            </div>
            
@endsection