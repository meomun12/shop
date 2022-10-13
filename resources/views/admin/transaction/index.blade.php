@extends('layout-admin')
@section('content')
<div id="page-wrapper">
            <div class="container-fluid">
                <div class="row bg-title">
                    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                        <h4 class="page-title">Lịch sử giao dịch</h4> </div>
                    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                        <a href="{{route('client.homepage')}}" target="_blank" class="btn btn-danger pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light">Về trang chủ <i class="fa fa-home" aria-hidden="true"></i></a>
                        <ol class="breadcrumb">
                            <li><a href="{{route('admin.dashboard')}}">Bảng điều khiển</a></li>
                            <li class="active">Lịch sử giao dịch</li>
                        </ol>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="white-box">
                            <h3 class="box-title">Danh sách</h3>
                            <div class="table-responsive">
                                <table class="table table-hover" id="example" class="display" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Tài khoản</th>
                                            <th>Loại GD</th>
                                            <th>Ngày GD</th>
                                            <th>Số tiền</th>
                                            <th>Chi tiết</th>
                                        </tr>
                                    </thead>
                                    <tbody >
                                        <tr>
                                            <td>1</td>
                                            <td class="txt-oflo">taikhoan1</td>
                                            <td>Nạp tiền</td>
                                            <td class="txt-oflo">April 18, 2017</td>
                                            <td><span class="text-success">+240.000đ</span></td>
                                            <td><a href="#"><i class="fa fa-edit"></i> Xem</a></td>
                                        </tr>
                                        <tr>
                                            <td>2</td>
                                            <td class="txt-oflo">Nguyên</td>
                                            <td>Hoàn tiền</td>
                                            <td class="txt-oflo">April 19, 2017</td>
                                            <td><span class="text-info">+20.000đ</span></td>
                                            <td><a href="#"><i class="fa fa-edit"></i> Xem</a></td>
                                        </tr>
                                        <tr>
                                            <td>3</td>
                                            <td class="txt-oflo">Tú</td>
                                            <td>Hoàn tiền</td>
                                            <td class="txt-oflo">April 19, 2017</td>
                                            <td><span class="text-info">+32.000đ</span></td>
                                            <td><a href="#"><i class="fa fa-edit"></i> Xem</a></td>
                                        </tr>
                                        <tr>
                                            <td>4</td>
                                            <td class="txt-oflo">Thanh</td>
                                            <td>Thanh toán</td>
                                            <td class="txt-oflo">April 20, 2017</td>
                                            <td><span class="text-danger">-30.000đ</span></td>
                                            <td><a href="#"><i class="fa fa-edit"></i> Xem</a></td>
                                        </tr>
                                        <tr>
                                            <td>1</td>
                                            <td class="txt-oflo">Đào Hùng</td>
                                            <td>Nạp tiền</td>
                                            <td class="txt-oflo">April 18, 2017</td>
                                            <td><span class="text-success">+240.000đ</span></td>
                                            <td><a href="#"><i class="fa fa-edit"></i> Xem</a></td>
                                        </tr>
                                        <tr>
                                            <td>2</td>
                                            <td class="txt-oflo">Nguyên</td>
                                            <td>Hoàn tiền</td>
                                            <td class="txt-oflo">April 19, 2017</td>
                                            <td><span class="text-info">+20.000đ</span></td>
                                            <td><a href="#"><i class="fa fa-edit"></i> Xem</a></td>
                                        </tr>
                                        <tr>
                                            <td>3</td>
                                            <td class="txt-oflo">Tú</td>
                                            <td>Hoàn tiền</td>
                                            <td class="txt-oflo">April 19, 2017</td>
                                            <td><span class="text-info">+32.000đ</span></td>
                                            <td><a href="#"><i class="fa fa-edit"></i> Xem</a></td>
                                        </tr>
                                        <tr>
                                            <td>4</td>
                                            <td class="txt-oflo">Thanh</td>
                                            <td>Thanh toán</td>
                                            <td class="txt-oflo">April 20, 2017</td>
                                            <td><span class="text-danger">-30.000đ</span></td>
                                            <td><a href="#"><i class="fa fa-edit"></i> Xem</a></td>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th style="visibility:hidden;">#</th>
                                            <th style="visibility:hidden;">Tài khoản</th>
                                            <th style="border:none">Loại GD</th>
                                            <th style="border:none">Ngày GD</th>
                                            <th style="visibility:hidden;">Số tiền</th>
                                            <th style="visibility:hidden;">Chi tiết</th>
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