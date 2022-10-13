@extends('layout-admin')
@section('content')
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row bg-title">
            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                <h4 class="page-title">Cập nhật sản phẩm</h4>
            </div>
            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                <a href="{{route('client.homepage')}}" target="_blank"
                    class="btn btn-danger pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light">Về trang chủ
                    <i class="fa fa-home" aria-hidden="true"></i></a>

                <ol class="breadcrumb">
                    <li><a href="{{route('admin.dashboard')}}">Bảng điều khiển</a></li>
                    <li class="active">Cập nhật sản phẩm</li>
                </ol>
            </div>
        </div>
        <div class="row">
            @foreach($edit_product as $key => $item)
            <form class="form-horizontal form-material" action="{{URL::to('/admin/products/update/'.$item->id)}}" method="POST" enctype="multipart/form-data"role="form" style="width:100%;">
            @csrf
                <div class="col-md-8 col-xs-12">
                    <div class="white-box">
                        <div class="form-group">
                            <label class="col-md-12">Tên sản phẩm</label>
                            <div class="col-md-12">
                                <input type="text" name="name" value="{{$item->name}}" class="form-control form-control-line">
                                @error('name')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="example-email" class="col-md-12">Giá</label>
                            <div class="col-md-12">
                                <input type="number" value="{{$item->price}}" class="form-control form-control-line"
                                    name="price" id="example-email">
                                    @error('price')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-12">Mô tả</label>
                            <div class="col-md-12">
                            <textarea rows="5"  name="description" id="description" class="form-control form-control-line">
                            {{(old('description'))}}  {{$item->description}}
                            </textarea>
                                    @error('description')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-12">Danh Mục</label>
                            <div class="col-sm-12">
                                <select name="category_id" class="form-control form-control-line">
                                    @foreach($cate_product as $key => $cate)
                                    @if($cate->id == $item->category_id)
                                    <option selected value="{{$cate->id }}">{{$cate->name}}</option>
                                    @else
                                    <option value="{{$cate->id }}">{{$cate->name}}</option>
                                    @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-12">Số lượng</label>
                            <div class="col-md-12">
                                <input type="number" name="quantily" value="{{$item->quantily}}" class="form-control form-control-line">
                                @error('quantily')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                            </div>
                        </div>
                        <img id="image" src="{{$item->image_gallery}}" width="auto"  height="300px"/>
                        <div class="form-group">
                            <label class="col-sm-12">Tải ảnh mới</label>
                            <input class="col-sm-12" name="image_gallery" type="file" onchange="changeImage()" id="fileImage">
                        </div>
                        @error('image_gallery')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="exampleCheck1" name="allow_market" id="allow_market" value="2" 
                            @if($item->allow_market == 2) checked
                            @endif
                            >
                            <label style="margin: 0 20px;" class="form-check-label" for="exampleCheck1">Sản phẩm để đi chợ</label>
                        </div>
                        <div class="form-group" style="margin-top: 20px;">
                            <div class="col-sm-12">
                                <button type="submit" class="btn btn-danger">Cập nhật</button>
                                <a href="{{route('admin.listProduct')}}" class="btn btn-success">Trở về</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 col-xs-12">
                    <div class="white-box">
                            <div id="btnThemFile" class="btn btn-primary">Thêm ảnh cho sản phẩm</div>
                            <div class="form-group">
                            <hr>
                            <div id="chonFile">
                            <input class="col-sm-12" name="gallery_img[]" type="file">
                            </div>
                            </div>
                    </div>
                    </form>
                    @endforeach
                    <div class="white-box" style="padding-bottom: 110%;">
                        <label class="col-sm-12">Toàn bộ ảnh sản phẩm: <b>{{count($product_img)}}</b></label>
                        @foreach($product_img as $item)
                        <div class="col-sm-12" style="width: 50%;margin: 10px 0">
                        <img src="{{$item->gallery_img}}"  width="110px" height ="170px">
                        <button  data-url="{{route('product-delete',['id' => $item->id])}}"  type="button" 
                        data-target="#delete" data-toggle="modal" class="btn btn-outline-info" 
                        style="margin-left: -86px;font-weight: bold;color: white;">Xóa</button>
                        </div>  
                        @endforeach
                    </div>
                </div>
        </div>
    </div>
</div>
<footer class="footer text-center"> 2021 &copy; Ample Admin brought to you by MarketNow.com </footer>
</div>

@endsection