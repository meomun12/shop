@extends('layout-admin')
@section('content')
<div id="page-wrapper">
            <div class="container-fluid">
                <div class="row bg-title">
                    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                        <h4 class="page-title">Cập nhật đơn hàng</h4> </div>
                    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                        <a href="{{route('client.homepage')}}" target="_blank" class="btn btn-danger pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light">Về trang chủ <i class="fa fa-home" aria-hidden="true"></i></a>
                        
                        <ol class="breadcrumb">
                            <li><a href="#">Bảng điều khiển</a></li>
                            <li class="active">Cập nhật đơn hàng</li>
                        </ol>
                    </div>
                </div>
                <div class="row">
                
                    <div class="col-md-8 col-xs-12">
                        <form class="form-horizonthal form-material" action="{{URL::to('/admin/order/update/'.$order->id)}}" method="POST" >
                            <div class="white-box">
                                @csrf
                                <div class="form-group">
                                    <label class="col-sm-12">Loại</label>
                                    <div class="col-sm-12">
                                        <select class="form-control form-control-line" name="order_market">
                                            @php
                                                if($order->order_market == 1){
                                                    echo'<option value = "1" >Thông thường</option>';
                                                    echo'<option value = "2" >Đi chợ</option>';
                                                }else{
                                                    echo'<option value = "2" >Đi chợ</option>';
                                                    echo'<option value = "1" >Thông thường</option>';
                                                    
                                                }
                                            @endphp
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-12">Tình trạng</label>
                                    <div class="col-sm-12">
                                        <select class="form-control form-control-line" name="status">
                                            @php
                                                if($order->status == 0){
                                                    echo'<option value = "0" >Chưa hoàn thành</option>';
                                                    echo'<option value = "1" >Hoàn thành</option>';
                                                }else{
                                                    echo'<option value = "1" >Hoàn Thành</option>';
                                                    echo'<option value = "0" >Chưa hoàn thành</option>';
                                                    
                                                }
                                            @endphp
                                        </select>
                                    </div>
                                </div>
                               
                                <div class="form-group">
                                    <label class="col-sm-12">Ngày đặt: {{ $order->created_at }}</label>
                                    <div class="col-md-12">
                                        <input type="datetime-local" value="{{ $order->created_at }}" name="created_at" class="form-control form-control-line">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-12">Địa chỉ nhận hàng</label>
                                    <div class="col-md-12">
                                        <textarea rows="5"  name="customer_address"  id="description" class="form-control form-control-line">{{(old('customer_address'))}}{{ $order->customer_address }}</textarea>
                                    </div>
                                </div>
                                
                        @if ($order->order_market == 2)
                        
                                    @foreach ($order_detail as $item)
                                    <div class="form-group">
                                        <label class="col-sm-12">Sô lượng
                                        <?php 
                                            $parent = App\Models\Product::find($item->product_order->id);
                                            $cate_t = $parent->name;    
                                        ?>
                                            {{  $cate_t }}
                                        </label>
                                        
                                        <input type="number" step="0.1" name="quantily[]" value="{{$item->quantily}}"  class="form-control form-control-line">
                                        
                                    </div>
                                    @endforeach
                        
                        @endif
                                @if ($order->order_market == 1)
                                    @foreach ($order_detail as $item)
                                    <div class="form-group">
                                        <label class="col-sm-12">Sô lượng
                                        <?php 
                                            $parent = App\Models\Product::find($item->product_order->id);
                                            $cate_t = $parent->name;    
                                        ?>
                                            {{  $cate_t }}
                                        </label>
                                       
                                        <input type="number" name="quantily[]" value="{{ $item->quantily }}"   class="form-control form-control-line">
                                        
                                    </div>
                                    @endforeach
                              
                                @endif
                                <div class="form-group">
                                    <div class="col-sm-12">
                                        <button type="submit" class="btn btn-danger">Cập nhật</button>
                                        <a href="{{route('admin.listOrder')}}" class="btn btn-success">Trở về</a>
                                    </div>
                                </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection