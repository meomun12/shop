@extends('layout-admin')
@section('content')

<div id="page-wrapper">
            <div class="container-fluid">
                <div class="row bg-title">
                    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                        <h4 class="page-title">Danh Mục</h4> </div>
                    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                        <a href="{{route('client.homepage')}}" target="_blank" class="btn btn-danger pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light">Về trang chủ <i class="fa fa-home" aria-hidden="true"></i></a>
                        <ol class="breadcrumb">
                            <li><a href="{{route('admin.dashboard')}}">Bảng điều khiển</a></li>
                            <li class="active">Slider</li>
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
                                <h3 class="box-title">Slider</h3>
                            <div class="table-responsive">
                                <table table class="table table-hover" id="example" class="display" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Tiêu đề</th>
                                            <th>Ảnh</th>
                                            <th>Show</th>
                                            <th><a href="{{route('admin.addSlider')}}" class="btn btn-primary">Thêm</a></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($slider as $item)
                                            <tr>
                                                <td>{{$item->id}}</td>
                                                <td>{{$item->title}}</td>
                                                <td><img src="{{$item->image}}" width="200" height="150" alt=""></td>
                                                <td>{{$item->description}}</td>
                                                <td style="font-size: 20px;">
                                                    <a style="padding-left: 10px;" href="{{route('admin.editSlider',['id'=>$item->id])}}"><i class="fa fa-pencil-square" aria-hidden="true"></i></a>
                                                    <a class="text-danger" href="{{route( 'admin.deteleSlider',[ 'id'=>$item->id]) }}"  
                                                        onclick="return confirm('Bạn muốn xóa danh mục {{$item->title}}')"><i class="fa fa-trash" aria-hidden="true"></i>
                                                    </a>
                                                </td>
                                            </tr>  
                                        @endforeach
                                    </tbody>
                                    
                                </table>
                                <div class="col-xs-12 offset-xs-8 text-center pull-right ">
                                    {{$slider->links()}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <footer class="footer text-center"> 2021 &copy; Ample Admin brought to you by MarketNow.com </footer>
        </div>

@endsection
