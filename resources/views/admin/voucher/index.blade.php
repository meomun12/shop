@extends('layout-admin')
@section('content')
<div id="page-wrapper">
            <div class="container-fluid">
                <div class="row bg-title">
                    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                        <h4 class="page-title">Voucher</h4> </div>
                    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                        <a href="{{route('client.homepage')}}" target="_blank" class="btn btn-danger pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light">Về trang chủ <i class="fa fa-home" aria-hidden="true"></i></a>
                        <ol class="breadcrumb">
                            <li><a href="{{route('admin.dashboard')}}">Bảng điều khiển</a></li>
                            <li class="active">Voucher</li>
                        </ol>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="white-box">
                        <p class="success" style="color:green; font-size:20px; font-weight:bold;">
                            <?php
                            $message = Session::get('message');
                            if($message){
                                echo $message;
                                Session::put('message', NULL);
                                }
                            ?>
                        </p>
                            <h3 class="box-title">Danh sách</h3>
                            <div class="table-responsive">
                                <table class="table table-hover" id="example" class="display" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Tên Voucher</th>
                                            <th>Mã code</th>
                                            <th>Ngày bắt đầu</th>
                                            <th>Ngày kết thúc</th>
                                            <th>Số lượng </th>
                                            <th>Loại</th>      
                                            <th>Giá trị </th>                                     
                                            <th>Trạng Thái</th>
                                            <th>Tình trạng</th>
                                            <th><a href="{{route('admin.addVoucher')}}" class="btn btn-primary">Thêm</a></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($voucher as $key => $item)
                                        <tr>
                                            <td>{{$key + 1}}</td>
                                            <td>{{$item->name}}</td>
                                            <td>{{$item->code}}</td>                                         
                                            <td>{{$item->start_date}}</td>
                                            <td>{{$item->finish_date}}</td>
                                            <td>{{$item->amount}} Mã</td>
                                            <td ><?php 
                                                if ($item->type==1) {
                                                ?>
                                                Giảm theo giá trị
                                            <?php 
                                            }else {
                                            ?>
                                                Giảm theo %
                                                <?php
                                            }
                                            ?>
                                            </td>
                                            <td>
                                                <?php 
                                                    if ($item->type==1) {
                                                    ?>
                                                    Giảm {{ number_format($item->value) }}VND
                                                <?php 
                                                }else {
                                                ?>
                                                    Giảm {{ $item->value }}%
                                                    <?php
                                                }
                                                ?>
                                            </td>
                                            <td class="text-{{$item->status == 1 ? "success" : "danger"}}">{{$item->status == 1 ? "Đang kích hoạt" : "Đang tắt"}}</td>
                                            <td class="text-{{$item->finish_date>=$today ? "success" : "danger"}}">{{$item->finish_date>=$today ? "Còn hạn" : "Hết hạn"}}</td>
                                            <td style="font-size: 20px;">
                                                <a style="padding-left: 10px;" href="{{route('admin.editVoucher',['id' => $item->id])}}"><i class="fa fa-pencil-square" aria-hidden="true"></i></a>
                                                <a style="padding-left: 10px;" onclick="return confirm('bạn chắc chắn muốn xoá voucher: {{$item->name}}')"  href="{{route( 'admin.deteleVoucher',[ 'id'=>$item->id]) }}" class="text-danger"><i class="fa fa-trash" aria-hidden="true"></i></a>
                                                <br>
                                                <a href="{{route('admin.sendMailVoucher',['id' => $item->id])}}" class="btn btn-default">Gửi mã voucher</a>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr style="">
                                            <th style="visibility:hidden;">ID</th>
                                            <th style="visibility:hidden;">Tên Voucher</th>
                                            <th style="visibility:hidden;">Mã code</th>
                                            <th style="border:none">Ngày bắt đầu</th>
                                            <th style="border:none">Ngày kết thúc</th>
                                            <th style="border:none">SL</th>
                                            <th style="border:none">Loại</th>      
                                            <th style="border:none">Giá trị </th>                                     
                                            <th style="border:none">Trạng Thái</th>
                                            <th style="border:none">Tình trạng</th>
                                            <th style="visibility:hidden;"><a href="{{route('admin.addVoucher')}}" class="btn btn-primary">Thêm</a></th>
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
