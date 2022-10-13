@extends('layout-admin')
@section('content')
<div id="page-wrapper">
            <div class="container-fluid">
                <div class="row bg-title">
                    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                        <h4 class="page-title">Tài khoản</h4> </div>
                    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                        <a href="{{route('client.homepage')}}" target="_blank" class="btn btn-danger pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light">Về trang chủ <i class="fa fa-home" aria-hidden="true"></i></a>
                        <ol class="breadcrumb">
                            <li><a href="{{route('admin.dashboard')}}">Bảng điều khiển</a></li>
                            <li class="active">Tài khoản</li>
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
                                            <th>#</th>
                                            <th>Ảnh</th>
                                            <th>Email</th>
                                            <th>SĐT</th>
                                            <th>Quyền</th>
                                            <th>Trạng thái</th>
                                            <th><a href="{{route('admin.addUser')}}" class="btn btn-primary">Thêm</a></th>
                                        </tr>
                                    </thead>
                                    <tbody id="FilterContainer">
                                    @foreach($user as $key => $objU)
                                        <tr class="column" data-data1="{{$objU->role_id}}" data-data2="{{$objU->status}}">
                                            <td>{{$key + 1}}</td>
                                            <td><img src="{{$objU->avatar}}" alt="" width="100px" height="100px"></td>
                                            <td>{{$objU->email}}</td>
                                            <td>{{$objU->phone}}</td>
                                            <td class='{{$objU->role_id == 0 ? "text-primary" : "text-danger"}}'>
                                            {{$objU->role_id == 0 ? "Thành Viên" : "Quản Trị"}}</td>
                                            <td class='{{$objU->status == 0 ? "text-success" : "text-danger"}}'>
                                            {{$objU->status == 0 ? "Hoạt động" : "Cấm"}}
                                            </td>
                                            <td style="font-size: 20px;">
                                                <a style="padding-left: 10px;" href="{{route( 'admin.editUser',[ 'id'=>$objU->id]) }}"><i class="fa fa-pencil-square" aria-hidden="true"></i></a>
                                                <a style="padding-left: 10px;" href="{{route( 'admin.deteleUser',[ 'id'=>$objU->id]) }}"
                                                onclick="return confirm('Bạn muốn xóa tài khoản {{$objU->name}}')"
                                                class="text-danger"><i class="fa fa-trash" aria-hidden="true"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th style="visibility:hidden;">#</th>
                                            <th style="visibility:hidden;">Ảnh</th>
                                            <th style="visibility:hidden;">Email</th>
                                            <th style="visibility:hidden;">SĐT</th>
                                            <th style="border:none">Quyền</th>
                                            <th style="border:none">Trạng thái</th>
                                            <th style="visibility:hidden;"><a href="{{route('admin.addUser')}}" class="btn btn-primary">Thêm</a></th>
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