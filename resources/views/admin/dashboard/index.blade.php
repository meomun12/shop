@extends('layout-admin')
@section('content')
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row bg-title">
            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                <h4 class="page-title">Bảng điều khiển</h4>
            </div>
            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                <a href="{{route('client.homepage')}}" target="_blank"
                    class="btn btn-danger pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light">Về trang chủ
                    <i class="fa fa-home" aria-hidden="true"></i></a>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-2 col-sm-6 col-xs-12">
                <div class="white-box analytics-info text-center">
                    <h3 class="box-title text-info">Đơn hàng</h3>
                    <span class="text-dark">( {{$oders}} )</span><br>
                    <a href="{{route('admin.listOrder')}}"><i class="fa fa-table text-info" style="font-size: 100px;"
                            aria-hidden="true"></i></a>
                </div>
            </div>
            <div class="col-lg-2 col-sm-6 col-xs-12">
                <div class="white-box analytics-info text-center">
                    <h3 class="box-title">Doanh Thu</h3>
                    <span class="text-dark">( 7.8M )</span><br>
                    <a href="{{route('admin.totalCash')}}"><i class="fa fa-signal" style="font-size: 100px;"
                            aria-hidden="true"></i></a>
                </div>
            </div>

            <div class="col-lg-2 col-sm-6 col-xs-12">
                <div class="white-box analytics-info text-center">
                    <h3 class="box-title text-success">Sản phẩm</h3>
                    <span class="text-dark">( {{$products}} )</span><br>
                    <a href="{{route('admin.listProduct')}}"><i class="fa fa-product-hunt text-success"
                            style="font-size: 100px;" aria-hidden="true"></i></a>
                </div>
            </div>

            <div class="col-lg-2 col-sm-6 col-xs-12">
                <div class="white-box analytics-info text-center">
                    <h3 class="box-title text-warning">Bình luận</h3>
                    <span class="text-dark">( {{$comments}} )</span><br>
                    <a href="{{route('admin.listComment')}}"><i class="fa fa-comments-o text-warning"
                            style="font-size: 100px;" aria-hidden="true"></i></a>
                </div>
            </div>

            <div class="col-lg-2 col-sm-6 col-xs-12">
                <div class="white-box analytics-info text-center">
                    <h3 class="box-title text-primary">Mã giảm giá</h3>
                    <span class="text-dark">( {{$vouchers}} )</span><br>
                    <a href="{{route('admin.listVoucher')}}"><i class="fa fa-tags text-primary"
                            style="font-size: 100px;" aria-hidden="true"></i></a>
                </div>
            </div>

            <div class="col-lg-2 col-sm-6 col-xs-12">
                <div class="white-box analytics-info text-center">
                    <h3 class="box-title text-danger">Tài khoản</h3>
                    <span class="text-dark">( {{$users}} )</span><br>
                    <a href="{{route('admin.listUser')}}"><i class="fa fa-users text-danger" style="font-size: 100px;"
                            aria-hidden="true"></i></a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
                <div class="white-box">
                    <h3 class="box-title" style=" text-align: center;font-weight: 600;font-size:22px;">Biên động doanh
                        thu</h3>
                    <form autocomplete="off" class="form-group">
                        @csrf
                        <div class="col-md-2">
                            <p>Từ ngày : <input type="text" id="datepicker" class="form-control"></p>
                            <input type="button" id="btn-dashboard-filter" class="btn btn-primary btn-sm"
                                value="Lọc kết quả" style="margin-top:15px;">
                        </div>

                        <div class="col-md-2">
                            <p>Đến ngày : <input type="text" id="datepicker2" class="form-control"></p>
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

                    <div id="myfirstchart" style="height: 450px;margin-top:130px;"></div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 col-lg-12 col-sm-12">
                <div class="white-box">
                    <div class="col-md-3 col-sm-4 col-xs-6 pull-right">
                        <select class="form-control pull-right row b-none">
                            <option>Hôm nay</option>
                            <option>3 ngày</option>
                            <option>7 ngày</option>
                            <option>15 ngày</option>
                            <option>30 ngày</option>
                        </select>
                    </div>
                    <h3 class="box-title">Đơn hàng hôm nay</h3>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Tài khoản</th>
                                    <th>Giá trị</th>
                                    <th>Loại</th>
                                    <th>Tình trạng</th>
                                    <th>Ngày đặt</th>
                                    <th>Chi tiết</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order as $key => $item)
                                @if($today <= "24:00:00" && $item->created_at >= $today)
                                    <tr>
                                        <td>{{$item->id}}</td>
                                        <td><a href="profile.html">{{$item->customer_fullname}}</a></td>
                                        <td>{{number_format($item->totalMoney)}}VND</td>
                                        <td>{{$item->order_market == 1 ? "Thông Thường" : "Đi chợ"}}</td>
                                        <td class=' {{$item->status == null ? "text-danger" : "text-success"}}'>
                                            {{$item->status == null ? "Chưa hoàn thành" : "Đã hoàn thành"}}</td>
                                        <td>{{$item->created_at}}</td>
                                        <td><a href="{{URL::to('/admin/order/order-detail/'.$item->id)}}"><i
                                                    class="fa fa-edit"></i> Xem</a></td>
                                    </tr>
                                    @endif

                                    @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!--  Pagination Area Start -->
                    <div class="pro-pagination-style text-center">
                        <ul>
                            <li>
                                {{$order->links()}}
                            </li>
                        </ul>
                    </div>
                    <!--  Pagination Area End -->
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 col-lg-8 col-sm-12">
                <div class="white-box">
                    <h3 class="box-title">Bình luận gần đây</h3>
                    <div class="comment-center p-t-10">
                        @foreach($ratings as $item)
                        <div class="comment-body">
                            <div class="user-img">
                                <img src="{{isset($item->user_comment) ? $item->user_comment->avatar : ''}}" alt="user"
                                    class="img-circle">
                            </div>
                            <div class="mail-contnet">
                                <h5>{{isset($item->user_comment) ? $item->user_comment->name : ''}}</h5>
                                <span class="time">{{$item->created_at}}</span>
                                <br /><span class="mail-desc">{{$item->ra_content}}</span>
                                <a onclick="return confirm('Bạn có chắc muốn xoá bình luận này')"
                                    href="{{route('admin.removeComment', ['id' => $item->id])}}"
                                    class="btn-rounded btn btn-default btn-outline"><i class="fa fa-trash"></i></a>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-12">
                <div class="panel">
                    <div class="sk-chat-widgets">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                CHAT LISTING
                            </div>
                            <div class="panel-body">
                                <ul class="chatonline">
                                    <li>
                                        <div class="call-chat">
                                            <button class="btn btn-success btn-circle btn-lg" type="button"><i
                                                    class="fa fa-phone"></i></button>
                                            <button class="btn btn-info btn-circle btn-lg" type="button"><i
                                                    class="fa fa-comments-o"></i></button>
                                        </div>
                                        <a href="javascript:void(0)"><img
                                                src="{{asset('assets/admin/plugins/images/users/varun.jpg')}}"
                                                alt="user-img" class="img-circle"> <span>Varun Dhavan <small
                                                    class="text-success">online</small></span></a>
                                    </li>
                                    <li>
                                        <div class="call-chat">
                                            <button class="btn btn-success btn-circle btn-lg" type="button"><i
                                                    class="fa fa-phone"></i></button>
                                            <button class="btn btn-info btn-circle btn-lg" type="button"><i
                                                    class="fa fa-comments-o"></i></button>
                                        </div>
                                        <a href="javascript:void(0)"><img
                                                src="{{asset('assets/admin/plugins/images/users/genu.jpg')}}"
                                                alt="user-img" class="img-circle"> <span>Genelia Deshmukh <small
                                                    class="text-warning">Away</small></span></a>
                                    </li>
                                    <li>
                                        <div class="call-chat">
                                            <button class="btn btn-success btn-circle btn-lg" type="button"><i
                                                    class="fa fa-phone"></i></button>
                                            <button class="btn btn-info btn-circle btn-lg" type="button"><i
                                                    class="fa fa-comments-o"></i></button>
                                        </div>
                                        <a href="javascript:void(0)"><img
                                                src="{{asset('assets/admin/plugins/images/users/ritesh.jpg')}}"
                                                alt="user-img" class="img-circle"> <span>Ritesh Deshmukh <small
                                                    class="text-danger">Busy</small></span></a>
                                    </li>
                                    <li>
                                        <div class="call-chat">
                                            <button class="btn btn-success btn-circle btn-lg" type="button"><i
                                                    class="fa fa-phone"></i></button>
                                            <button class="btn btn-info btn-circle btn-lg" type="button"><i
                                                    class="fa fa-comments-o"></i></button>
                                        </div>
                                        <a href="javascript:void(0)"><img
                                                src="{{asset('assets/admin/plugins/images/users/arijit.jpg')}}"
                                                alt="user-img" class="img-circle"> <span>Arijit Sinh <small
                                                    class="text-muted">Offline</small></span></a>
                                    </li>
                                    <li>
                                        <div class="call-chat">
                                            <button class="btn btn-success btn-circle btn-lg" type="button"><i
                                                    class="fa fa-phone"></i></button>
                                            <button class="btn btn-info btn-circle btn-lg" type="button"><i
                                                    class="fa fa-comments-o"></i></button>
                                        </div>
                                        <a href="javascript:void(0)"><img
                                                src="{{asset('assets/admin/plugins/images/users/govinda.jpg')}}"
                                                alt="user-img" class="img-circle"> <span>Govinda Star <small
                                                    class="text-success">online</small></span></a>
                                    </li>
                                    <li>
                                        <div class="call-chat">
                                            <button class="btn btn-success btn-circle btn-lg" type="button"><i
                                                    class="fa fa-phone"></i></button>
                                            <button class="btn btn-info btn-circle btn-lg" type="button"><i
                                                    class="fa fa-comments-o"></i></button>
                                        </div>
                                        <a href="javascript:void(0)"><img
                                                src="{{asset('assets/admin/plugins/images/users/hritik.jpg')}}"
                                                alt="user-img" class="img-circle"> <span>John Abraham<small
                                                    class="text-success">online</small></span></a>
                                    </li>
                                    <li>
                                        <div class="call-chat">
                                            <button class="btn btn-success btn-circle btn-lg" type="button"><i
                                                    class="fa fa-phone"></i></button>
                                            <button class="btn btn-info btn-circle btn-lg" type="button"><i
                                                    class="fa fa-comments-o"></i></button>
                                        </div>
                                        <a href="javascript:void(0)"><img
                                                src="{{asset('assets/admin/plugins/images/users/varun.jpg')}}"
                                                alt="user-img" class="img-circle"> <span>Varun Dhavan <small
                                                    class="text-success">online</small></span></a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <footer class="footer text-center"> 2021 &copy; Ample Admin brought to you by MarketNow.com </footer>
</div>

@endsection