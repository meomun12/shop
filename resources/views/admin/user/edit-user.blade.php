@extends('layout-admin')
@section('content')
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row bg-title">
            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                <h4 class="page-title">Cập nhật tài khoản</h4>
            </div>
            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                <a href="{{route('client.homepage')}}" target="_blank"
                    class="btn btn-danger pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light">Về trang chủ
                    <i class="fa fa-home" aria-hidden="true"></i></a>

                <ol class="breadcrumb">
                    <li><a href="{{route('admin.dashboard')}}">Bảng điều khiển</a></li>
                    <li class="active">Cập nhật tài khoản</li>
                </ol>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8 col-xs-12">
                <div class="white-box">
                    <form class="form-horizontal form-material" method="POST" enctype="multipart/form-data" action="{{URL::to('/admin/user/update/'.
                    $objU->id)}}">
                                @csrf
                        <div class="form-group">
                            <label class="col-md-12">Tên tài khoản</label>
                            <div class="col-md-12">
                                <input type="text" class="form-control form-control-line" name="name" value="{{$objU->name}}">
                            </div>
                        </div>
                        @error('name')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                        <div class="form-group">
                            <label class="col-sm-12">Phân quyền</label>
                            <div class="col-sm-12">
                                <select class="form-control form-control-line" name = "role_id">
                                <?php
                                if($objU->role_id == 0){
                                    echo'<option value = "0" >Thành Viên</option>';
                                    echo'<option value = "1">Quản trị</option>';
                                }else{
                                    echo'<option value = "1">Quản trị</option>';
                                    echo'<option value = "0">Thành Viên</option>';
                                };
                            ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-12">Trạng thái</label>
                            <div class="col-sm-12">
                                <select class="form-control form-control-line" name = "status">
                            <?php
                                if($objU->status == 0){
                                    echo'<option name="status" value="0">Hoạt động</option>';
                                    echo'<option name="status" value="1">Cấm</option>
                                    ';
                                }else{
                                    echo'<option name="status" value="1">Cấm</option>';
                                    echo'<option name="status" value="0">Hoạt động</option>';
                                };
                            ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-12">Email</label>
                            <div class="col-md-12">
                            <input type="email"  name="email" value="{{$objU->email}}" value="{{(old('email'))}}" class="form-control form-control-line">                            </div>
                        </div>
                        @error('email')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                        <div class="form-group">
                            <label class="col-md-12">Phone</label>
                            <div class="col-md-12">
                            <input type="text" name="phone" value="{{$objU->phone}}" value="{{(old('phone'))}}" class="form-control form-control-line">
                            </div>
                        </div>
                        @error('phone')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                        <div class="form-group">
                            <label class="col-md-12">Địa chỉ</label>
                            <div class="col-md-12">
                            <textarea rows="5" name="address" value="" class="form-control form-control-line">{{$objU->address}}{{(old('address'))}}</textarea>
                            </div>
                        </div>
                        @error('address')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                        <div class="form-group">
                            <div class="col-sm-12">
                                <button type="submit" class="btn btn-danger">Cập nhật</button>
                                <a href="{{route('admin.listUser')}}" class="btn btn-success">Trở về</a>
                            </div>
                        </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="white-box">
                    <img id="image" src="{{$objU->avatar}}" width="100%" height="300px" alt="{{$objU->avatar}}">
                    <div class="form-group">
                        <label class="col-sm-12">Tải ảnh mới</label>
                        <input class="col-sm-12" name="avatar" type="file" onchange="changeImage()" id="fileImage">
                    </div>
                </div>
                @error('avatar')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            </form>
        </div>
    </div>
</div>
<footer class="footer text-center"> 2021 &copy; Ample Admin brought to you by MarketNow.com </footer>
</div>
@endsection