@extends('layout-client')
@section('content')
<!-- Breadcrumb Area start -->
<section class="breadcrumb-area" style="
    background: repeating-linear-gradient(21deg, #4fb68d96, #edb1b100 244px);">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="breadcrumb-content">
                    <h1 class="breadcrumb-hrading">Sản phẩm yêu thích</h1>
                    <ul class="breadcrumb-links">
                        <li><a href="{{route('client.homepage')}}">Trang chủ</a></li>
                        <li>Sản phẩm yêu thích</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Breadcrumb Area End -->
<!-- cart area start -->
<div class="cart-main-area mtb-60px">
    <div class="container">
        <h3 class="cart-page-title">Danh sách</h3>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                <form action="#">
                    <div class="table-content table-responsive cart-table-content">
                        <table width="100%">
                            <thead>
                                <tr>
                                    <th>STT</th>
                                    <th>Ảnh</th>
                                    <th>Tên Sản phẩm</th>
                                    <th>Giá</th>
                                    <th>Thêm vào giỏ hàng</th>
                                    <th>Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                            @if (session('alert'))
                                <div class="alert alert-success">
                                    {{ session('alert') }}
                                </div>
                            @endif
                            @foreach ($wish_lists as $item)
                                <tr>   
                                    <td>{{$item->id }}</td>
                                    <td class="product-thumbnail">
                                        <a href="{{route('client.single-product',['id'=>$item->product->id])}}"><img width="100" height="100" src="{{asset($item->product->image_gallery)}}" alt="" /></a>
                                    </td>
                                    <td class="product-name"><a href="{{route('client.single-product',['id'=>$item->product->id])}}">{{$item->product->name}}</a></td>
                                    <td class="product-price-cart"><span class="amount">{{number_format($item->product->price)}} đ</span></td>
                                    <td class="product-wishlist-cart">
                                        <a class="cart-btn {{$item->product->quantily <= 0 ? ' bg-danger' : ''}}" {{$item->product->quantily <= 0 ? "" : "product-id="}} {{$item->product->id}}>
                                        {{$item->product->quantily <= 0 ? "Hết hàng" : "Thêm vào giỏ"}}</a>
                                    </td>
                                    <td>
                                        <a class="text-dark" onclick="return confirm('Bạn muốn xóa sản phẩm này khỏi mục yêu thích?')" href="{{route('client.remove-wishlist',['id'=>$item->id])}}"><i class="fa fa-times"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- cart area end -->
@endsection