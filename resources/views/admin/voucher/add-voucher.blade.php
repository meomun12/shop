@extends('layout-admin')
@section('content')
<div id="page-wrapper">
            <div class="container-fluid">
                <div class="row bg-title">
                    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                        <h4 class="page-title">Thêm Voucher Mới</h4> </div>
                    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                        <a href="{{route('client.homepage')}}" target="_blank" class="btn btn-danger pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light">Về trang chủ <i class="fa fa-home" aria-hidden="true"></i></a>
                        
                        <ol class="breadcrumb">
                            <li><a href="{{route('admin.dashboard')}}">Bảng điều khiển</a></li>
                            <li class="active">Thêm voucher</li>
                        </ol>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-8 col-xs-12">
                        <div class="white-box">
                            <form class="form-horizontal form-material" method="post" action="{{route('admin.addVoucher')}}">
                                @error('msg')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                @csrf
                                <div class="form-group">
                                    <label class="col-md-12">Tên Voucher</label>
                                    <div class="col-md-12">
                                        <input type="text" value="{{ old('name') }}" name="name" class="form-control form-control-line"> </div>
                                </div>
                                @error('name')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                                <div class="form-group">
                                    <label for="example-email" class="col-md-12">Mã Code</label>
                                    <div class="col-md-12">
                                        <input type="text" value="{{ old('code') }}" class="form-control form-control-line" name="code" id="example-email"> </div>
                                </div>
                                @error('code')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                                
                                <div class="form-group">
                                    <label class="col-sm-12">Ngày kết thúc</label>
                                    <div class="col-md-12">
                                        <input type="datetime-local" value="{{ old('finish_date') }}" name="finish_date" class="form-control form-control-line">
                                    </div>
                                </div> 
                                @error('finish_date')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                                <div class="form-group">
                                    <label for="example-email" class="col-md-12">Giá Trị</label>
                                    <div class="col-md-12">
                                    <input type="number" value="{{ old('value') }}" class="form-control form-control-line" name="value" id="example-email"> </div>
                                    </div>
                                @error('value')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                                <div class="form-group">
                                    <label for="example-email" class="col-md-12">Số lượng</label>
                                    <div class="col-md-12">
                                    <input type="number" value="{{ old('amount') }}" class="form-control form-control-line" name="amount" id="example-email"> </div>
                                    </div>
                                @error('amount')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                                <div class="form-group">
                                    <label class="col-sm-12">Loại</label>
                                    <div class="col-sm-12">
                                        <select name="type" class="form-control form-control-line">
                                            <option value="1">Giảm theo giá tiền</option>
                                            <option value="2">Giảm theo %</option>
                                            
                                        </select>
                                    </div>
                                </div>
                                @error('type')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                                <div class="form-group">
                                    <label class="col-sm-12">Trạng thái</label>
                                    <div class="col-sm-12">
                                        <select class="form-control form-control-line" name="status">
                                            <option name="status" value="1">Kích hoạt</option>
                                        </select>
                                    </div>
                                </div>
                                @error('status')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                                
                                <div class="form-group">
                                    <div class="col-sm-12">
                                        <button type="submit" class="btn btn-danger">Thêm mới</button>
                                        <a href="{{route('admin.listVoucher')}}" class="btn btn-success">Trở về</a>
                                    </div>
                                </div>
                            </form>
            </div>
        </div>
@endsection