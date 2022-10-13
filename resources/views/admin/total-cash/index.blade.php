@extends('layout-admin')
@section('content')


<div id="page-wrapper">
            <div class="container-fluid">
                <div class="row bg-title">
                    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                        <h4 class="page-title">Doanh thu</h4> </div>
                    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                        <a href="{{route('client.homepage')}}" target="_blank" class="btn btn-danger pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light">Về trang chủ <i class="fa fa-home" aria-hidden="true"></i></a>
                        <ol class="breadcrumb">
                            <li><a href="{{route('admin.dashboard')}}">Bảng điều khiển</a></li>
                            <li class="active">Doanh thu</li>
                        </ol>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
                        <div class="white-box">
                        <h3 class="box-title" style=" text-align: center;font-weight: 600;font-size:22px;">Biên động doanh thu</h3>
                        <h5 style="font-size:16px;font-weight:700;">Hôm nay : <i>{{$carbon}}</i></h5>
                        <h5 style="font-size:16px;font-weight:700;">Tổng tiền đã thu : {{number_format($sum_price_1)}} ₫</h5>
                        <h5 style="font-size:16px;font-weight:700;">Tổng tiền chưa thu : {{number_format($sum_price_0)}} ₫</h5>
                            <form autocomplete="off" class="form-group">
                                @csrf
                                <div class="col-md-2">
                                    <p>Từ ngày : <input type="text" id="datepicker" class="form-control" placeholder="--chọn ngày--"></p>
                                    <input type="button" id="btn-dashboard-filter" class="btn btn-primary btn-sm"
                                        value="Lọc kết quả" style="margin-top:15px;" >
                                </div>
        
                                <div class="col-md-2">
                                    <p>Đến ngày : <input type="text" id="datepicker2" class="form-control" placeholder="--chọn ngày--"></p>
                                </div>
        
                                <div class="col-md-2">
                                    <p>
                                        Lọc theo:
                                        <select class="dashboard-filter form-control">
                                            <option value="">--Chọn--</option>
                                            <option value="7ngay">7 ngày qua</option>
                                            <option value="thangtruoc">tháng trước</option>
                                            <option value="thangnay">tháng này</option>
                                            <option value="365ngayqua">365 ngày qua</option>
                                        </select>
                                    </p>
                                </div>
                            </form>
                        
                            <div id="myfirstchart" style="height: 450px;margin-top:150px;"></div>
                        </div>
                    </div>
                </div>
            </div>
            <footer class="footer text-center"> 2021 &copy; Ample Admin brought to you by MarketNow.com </footer>
        </div>

        @endsection