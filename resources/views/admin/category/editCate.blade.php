@extends('layout-admin')
@section('content')


<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row bg-title">
            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                <h4 class="page-title">Cập nhật danh mục</h4>
            </div>
            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                <a href="{{route('client.homepage')}}" target="_blank"
                    class="btn btn-danger pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light">Về trang chủ
                    <i class="fa fa-home" aria-hidden="true"></i></a>

                <ol class="breadcrumb">
                    <li><a href="#">Bảng điều khiển</a></li>
                    <li class="active">Cập nhật danh mục</li>
                </ol>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 col-xs-12">
                <div class="white-box">
                    <form class="form-horizontal form-material"  action="{{URL::to('/admin/categories/update/'.$objU->id)}}" method="POST" enctype="multipart/form-data">
        
                            @csrf
                        <div class="form-group">
                            <label class="col-md-12">Tên danh mục</label>
                            <div class="col-md-12">
                                <input type="text" name="name" value="{{$objU->name}}"
                                    class="form-control form-control-line " value="{{ old('name') }}" require>
                                    @error('name')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                            </div>
                           
                        </div>
                        <img id="image" src="{{$objU->image}}" width="30%" height="300px" alt="">
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
                                <button type="submit" class="btn btn-danger">Cập nhật</button>
                                <a href="{{route('admin.listCate')}}" class="btn btn-success">Trở về</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            @endsection