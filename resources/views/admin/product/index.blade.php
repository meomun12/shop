@extends('layout-admin')
@section('content')

<style>
.rating-active .active {
    color:#ff9705 !important;
    
}
</style>
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row bg-title">
            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                <h4 class="page-title">Sản phẩm</h4>
            </div>
            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                <a href="{{route('client.homepage')}}" target="_blank"
                    class="btn btn-danger pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light">Về trang chủ
                    <i class="fa fa-home" aria-hidden="true"></i></a>
                <ol class="breadcrumb">
                    <li><a href="{{route('admin.dashboard')}}">Bảng điều khiển</a></li>
                    <li class="active">Sản phẩm</li>
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
                                    <th>Mô tả</th>
                                    <th>Tên</th>
                                    <th>Số lượng</th>
                                    <th>Loại hình</th>
                                    <th>Danh mục</th>
                                    <th>Đánh giá</th>
                                    <th>Giá</th>
                                    <th>View</th>
                                    <th><a href="{{route('admin.createProduct')}}" class="btn btn-primary">Thêm</a></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($pro as $no => $item)
                                <?php
                                $avg = 0;
                                if($item->pro_total_rating){
                                    $avg = round($item->pro_total_number / $item->pro_total_rating, 2);
                                }
                                ?>
                                <tr>
                                    <td>{{$no + 1}}</td>
                                    <td>
                                    <img src="{{$item->image_gallery}}" alt=""height="100px" width="100px">
                                    </td>
                                    <td style="text-align: center;">
                                        <button type="button" data-url="{{route('product-show',['id' => $item->id])}}" class="btn btn-info btn-show" data-toggle="modal" data-target="#show">
                                            Show
                                    </button>
                                        <div class="modal fade" id="show">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <!-- Modal Header -->
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">Mô tả sản phẩm :</h4>
                                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                    </div>
                                                    <!-- Modal body -->
                                                    <div class="modal-body" style="text-align: center;">
                                                    <p id="id">
                                                    <p>
                                                    </div>
                                                    <!-- Modal footer -->
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td style="font-weight:bold;">{{$item->name}}</td>
                                    <td>{{$item->quantily}} SP</td>
                                    <td>{{$item->allow_market == 2 ? "Đi chợ" : "Thông thường"}}</td>
                                    <td>{{isset($item->category) ? $item->category->name : ''}}</td>
                                    <td><span class="rating-active">
                                    @for($i = 1; $i <= 5; $i++)
                                    <i class="fa fa-star {{ $i <= $avg ? 'active' : '' }}"></i>
                                    @endfor
                                    </span>
                                    </td>
                                    <td>{{number_format($item->price)}}đ</td>
                                    <td>{{$item->views > 0 ? $item->views : '0'}} <i class="fa fa-eye text-primary" aria-hidden="true"></i></td>
                                    <td style="font-size: 20px;">
                                        <a style="padding-left: 10px;"
                                            href="{{URL::to('/admin/products/edit/'.$item->id)}}"><i
                                                class="fa fa-pencil-square" aria-hidden="true"></i></a>
                                        <a onclick="return confirm('Bạn chắc chắn muốn xóa sản phẩm : {{$item->name}}')"
                                            style="padding-left: 10px;"
                                            href="{{route('admin.removeProduct',['id' => $item->id])}}"
                                            class="text-danger"><i class="fa fa-trash" aria-hidden="true"></i></a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th style="visibility:hidden;"></th>
                                    <th style="visibility:hidden;"></th>
                                    <th style="visibility:hidden;"></th>
                                    <th style="visibility:hidden;"></th>
                                    <th style="border:none"></th>
                                    <th style="border:none"></th>
                                    <th style="border:none"></th>
                                    <th style="visibility:hidden;"></th>
                                    <th style="visibility:hidden;"></th>
                                    <th style="visibility:hidden;"></th>
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
