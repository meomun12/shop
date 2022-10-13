@extends('layout-admin')
@section('content')

<div id="page-wrapper">
            <div class="container-fluid">
                <div class="row bg-title">
                    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                        <h4 class="page-title">Giới Thiệu</h4> </div>
                    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                        <a href="{{route('client.homepage')}}" target="_blank" class="btn btn-danger pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light">Về trang chủ <i class="fa fa-home" aria-hidden="true"></i></a>
                        <ol class="breadcrumb">
                            <li><a href="{{route('admin.dashboard')}}">Bảng điều khiển</a></li>
                            <li class="active">Giới Thiệu</li>
                        </ol>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="white-box">
                                <h3 class="box-title">Danh sách</h3>
                                <p class="success" style="color:green; font-size:20px; font-weight:bold;">
                        <?php
                        $message = Session::get('message');
                        if($message){
                            echo $message;
                            Session::put('message', NULL);
                        }
                    ?>
                    </p>
                            <div class="table-responsive">
                                <table class="table table-hover" id="example" class="display" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Tiêu Đề</th>
                                            <th>Mô Tả</th>
                                            <th>Ảnh</th>
                                            <th>
                                               Hành động
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($about as $item)
                                            <tr>
                                                <td>{{$item->id}}</td>
                                                <td>{{$item->title}}</td>
                                                <td><button type="button" class="btn btn-info" data-toggle="modal" data-target="#myModal">
                                                    Show
                                            </button>
                                                <div class="modal fade" id="myModal">
                                                    <div class="modal-dialog modal-lg">
                                                        <div class="modal-content">
                                                            <!-- Modal Header -->
                                                            <div class="modal-header">
                                                                <h4 class="modal-title">Mô Tả</h4>
                                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                            </div>
                                                            <!-- Modal body -->
                                                            <div class="modal-body" style="text-align: center;">
                                                                {!! $item->description !!}
        
                                                            </div>
                                                            <!-- Modal footer -->
                                                            <div class="modal-footer">
                                                              
                                                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div></td>
                                                <td><img src="{{$item->image}}" width="100" height="100" alt=""></td>
                                                <td style="font-size: 20px;">
                                                    <a style="padding-left: 10px;" href="{{route('admin.editAbout',['id'=>$item->id])}}"><i class="fa fa-pencil-square" aria-hidden="true"></i></a>
                                                    
                                                </td>
                                            </tr>  
                                        @endforeach
                                    </tbody>
                                    
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <footer class="footer text-center"> 2021 &copy; Ample Admin brought to you by MarketNow.com </footer>
        </div>

@endsection
