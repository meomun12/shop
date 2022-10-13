<?php

namespace App\Http\Controllers\Client;
session_start();
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Order;
use Illuminate\Support\Facades\Http;
use App\Models\OrderDetail;
use App\Models\Voucher;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Carbon\Carbon;
class CartController extends Controller
{
    //
    public function index(){
        $this->authorize('member');

        return view('client.cart.index');
    }
    public function addToCart(Request $rq){
        $this->authorize('member');
        $id = $rq ->id;
        $product = Product::where('id',$id)->first();
        if($product->allow_market==2 && $product->category_id ==35){
            if($product){
                if(!isset($_SESSION['carts'][$id])){
                    $_SESSION['carts'][$id]['id'] =$product->id;
                    $_SESSION['carts'][$id]['name'] =$product->name;
                    $_SESSION['carts'][$id]['allow_market'] = $product->allow_market;
                    $_SESSION['carts'][$id]['image'] =$product->image_gallery;
                    $_SESSION['carts'][$id]['price'] =$product->price;
                    $_SESSION['carts'][$id]['quantity'] = 0.2;
                }
                else{
                    $_SESSION['carts'][$id]['quantity'] += 0.2;
                }
                $totalItem = 0;
                $totalPriceInCart = 0;
                foreach($_SESSION['carts'] as $val){
                    $totalItem += $val['quantity'];
                    $totalPriceInCart += $val['price'] * $val['quantity'];
                }
                return response()->json(
                    [
                        'status' => true,
                        'totalItem' => $totalItem,
                        'totalPriceInCart' => $totalPriceInCart
                    ]
                );
            }}
    if($product->allow_market==1){
        if($product){
            if(!isset($_SESSION['cart'][$id])){
                $_SESSION['cart'][$id]['id'] =$product->id;
                $_SESSION['cart'][$id]['name'] =$product->name;
                $_SESSION['cart'][$id]['allow_market'] = $product->allow_market;
                $_SESSION['cart'][$id]['image'] =$product->image_gallery;
                $_SESSION['cart'][$id]['price'] =$product->price;
                $_SESSION['cart'][$id]['quantity'] = 1;
            }
            else{
                $_SESSION['cart'][$id]['quantity'] += 1;
            }
            $totalItem = 0;
            $totalPriceInCart = 0;
            foreach($_SESSION['cart'] as $val){
                $totalItem += $val['quantity'];
                $totalPriceInCart += $val['price'] * $val['quantity'];
            }
            return response()->json(
                [
                    'status' => true,
                    'totalItem' => $totalItem,
                    'totalPriceInCart' => $totalPriceInCart
                ]
            );
        }
    }
    if($product->allow_market==2){
    if($product){
        if(!isset($_SESSION['carts'][$id])){
            $_SESSION['carts'][$id]['id'] =$product->id;
            $_SESSION['carts'][$id]['name'] =$product->name;
            $_SESSION['carts'][$id]['allow_market'] = $product->allow_market;
            $_SESSION['carts'][$id]['image'] =$product->image_gallery;
            $_SESSION['carts'][$id]['price'] =$product->price;
            $_SESSION['carts'][$id]['quantity'] = 1 ;
        }
        else{
            $_SESSION['carts'][$id]['quantity'] += 1;
        }
        $totalItem = 0;
        $totalPriceInCart = 0;
        foreach($_SESSION['carts'] as $val){
            $totalItem += $val['quantity'];
            $totalPriceInCart += $val['price'] * $val['quantity'];
        }
        return response()->json(
            [
                'status' => true,
                'totalItem' => $totalItem,
                'totalPriceInCart' => $totalPriceInCart
            ]
        );
    }
}       
    }


    public function checkOut(Request $rq){
        // dd($rq);
        if($rq->isMethod('POST') && isset($_SESSION['cart'])&& isset($_SESSION['carts'])){
            if(!$rq->paymentMethod){
                return response()->json(
                    [
                        'status' => false,
                        'msg' => 'Bạn chưa chọn phương thức thanh toán',
                        
                    ]
                );
            }
            else if($rq->paymentMethod=='vnpay'){
                return response()->json(
                    [
                        'status' => false,
                        'msg' => 'Phương thức thanh toán này chưa được hỗ trợ, vui lòng chọn phương thức thanh toán khác!',
                        
                    ]
                );
            }
            else if($rq->paymentMethod=='cod'){
                $rule = [
                    'fullname'=>'required|max:100',
                    'email'=>'required|email|max:255',
                    'phone'=>'required|min:10|numeric',
                    'address'=>'required',
    
                    ];
                $msg = [
                    'fullname.required' =>'Vui lòng nhập đầy đủ họ tên',
                    'fullname.max' =>'Họ tên tối đa 100 kí tự',
                    'email.required'=>'Vui lòng nhập Email',
                    'email.email'=>'Email không đúng định dạng',
                    'email.max'=>'Email tối đa 255 kí tự',
                    'phone.required'=> 'Nhập số điện thoại',
                    'phone.min'=> 'Nhập số điện thoại có 10 chữ số',
                    'phone.numeric'=> 'Số điện thoại không đúng định dạng',
                    'address.required'=>'Bạn chưa nhập địa chỉ'
                    
                ];
                $validator = Validator::make($rq->all(), $rule, $msg);
                if ($validator->fails()) {
                    return response()->json(
                        [
                            'status' => false,
                            'msg'=> [$validator->errors()]
                            
                        ]
                    );
                }
                
                $totalPriceInCart = 0;
                foreach($_SESSION['cart'] as $val){
                    $totalPriceInCart += $val['price'] * $val['quantity'];
                }
                //insert order into database
                $voucherId = isset($_SESSION['voucher']) ? $_SESSION['voucher']['id'] : 0;
                if($voucherId > 0){
                    $voucher = Voucher::find($voucherId);
                    $voucher->amount += -1;
                    $voucher->save();
                }
                $voucherPrice = 0;
                                        if(isset($_SESSION['voucher'])){
                                            if($_SESSION['voucher']['type'] == 1){
                                                $voucherPrice = ($_SESSION['voucher']['value']);
                                            }
                                            else if($_SESSION['voucher']['type'] == 2){
                                                $voucherPrice = ($totalPriceInCart * ($_SESSION['voucher']['value']) /100);
                                            }   
                                        }
                $order_date  =  Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d');
                $insertOrder = Order::insert([
                    'customer_email' =>$rq->email,
                    'customer_phone' =>$rq->phone,
                    'customer_address' =>$rq->address,
                    'customer_fullname' =>$rq->fullname,
                    'payment_method' =>$rq->paymentMethod,
                    'voucher_id' => $voucherId,
                    'order_by'=> Auth::user()->id,
                    'order_market'=> 1,
                    'status'=> 0,
                    'totalMoney' => $totalPriceInCart - $voucherPrice + ($totalPriceInCart*0.1),
                    'order_date' => $order_date,
                ]);
                $getOrderId = Order::where('customer_email',$rq->email)->orderBy('created_at','desc')->first('id');
                if($insertOrder){
                    foreach($_SESSION['cart'] as $val){
                        $sl = Product::find($val['id']);
                        $sl->quantily = $sl->quantily - $val['quantity'];
                        if($sl->quantily >= 0){
                            $sl->save();
                        }
                        if($sl->quantily < 0){
                            return response()->json(
                                [
                                    'status' => "error",
                                    'msg' => 'Sản phẩm <b>'. $sl->name . '</b> còn <b>' . $sl->quantily + $val['quantity'] . '</b> sản phẩm',
                                ]
                            );
                        } 
                        $insertOderDetail = OrderDetail::insert([
                            'order_id' =>$getOrderId->id,
                            'product_id' =>$val['id'],
                            'total' =>$val['price'] * $val['quantity'],
                            'unit_price' =>$val['price'],
                            'quantily' =>$val['quantity']
                        ]);
                        if($insertOderDetail){
                            unset($_SESSION['cart']);
                            unset($_SESSION['voucher']);
                        }
                    }
                
                    $HostDomain = config('common.HostDomain_servesms');
                                    $key        = config('common.key_servesms');       
                                    $devices    = config('common.devices_servesms');
                                    $number     = $rq->phone;
                                    $message    = "Cửa Hàng Tạp Hóa Chúc An cảm ơn quý khách đã sử dụng dịch vụ của chúng tôi";
                                    $Api_SMS    = $HostDomain .'key=' . $key .'&number=' . $number .'&message='.$message. '&devices=' . $devices;
                                    $response   = Http::get($Api_SMS);
                }
            }
            else{
                return response()->json(
                    [
                        'status' => false,
                        'msg' => 'Vui lòng chọn phương thức thanh toán hợp lệ! ',
                    ]
                );
            }
        }
        if($rq->isMethod('POST') && isset($_SESSION['carts'])){
            if(!$rq->paymentMethod){
                return response()->json(
                    [
                        'status' => false,
                        'msg' => 'Bạn chưa chọn phương thức thanh toán',
                        
                    ]
                );
            }
            else if($rq->paymentMethod=='vnpay'){
                return response()->json(
                    [
                        'status' => false,
                        'msg' => 'Phương thức thanh toán này chưa được hỗ trợ, vui lòng chọn phương thức thanh toán khác!',
                        
                    ]
                );
            }
            else if($rq->paymentMethod=='cod'){
                $rule = [
                    'fullname'=>'required|max:100',
                    'email'=>'required|email|max:255',
                    'phone'=>'required|min:10|numeric',
                    'address'=>'required',
    
                    ];
                $msg = [
                    'fullname.required' =>'Vui lòng nhập đầy đủ họ tên',
                    'fullname.max' =>'Họ tên tối đa 100 kí tự',
                    'email.required'=>'Vui lòng nhập Email',
                    'email.email'=>'Email không đúng định dạng',
                    'email.max'=>'Email tối đa 255 kí tự',
                    'phone.required'=> 'Nhập số điện thoại',
                    'phone.min'=> 'Nhập số điện thoại có 10 chữ số',
                    'phone.numeric'=> 'Số điện thoại không đúng định dạng',
                    'address.required'=>'Bạn chưa nhập địa chỉ'
                    
                ];
                $validator = Validator::make($rq->all(), $rule, $msg);
                if ($validator->fails()) {
                    return response()->json(
                        [
                            'status' => false,
                            'msg'=> [$validator->errors()]
                            
                        ]
                    );
                }
                
                $totalPriceInCart = 0;
                foreach($_SESSION['carts'] as $val){
                    $totalPriceInCart += ($val['price'] * $val['quantity']) + ($totalPriceInCart*0.1);
                }
                //insert order into database
                $voucherId = isset($_SESSION['voucher']) ? $_SESSION['voucher']['id'] : 0;
                if($voucherId > 0){
                    $voucher = Voucher::find($voucherId);
                    $voucher->amount += -1;
                    $voucher->save();
                }
                $voucherPrice = 0;
                                        if(isset($_SESSION['voucher'])){
                                            if($_SESSION['voucher']['type'] == 1){
                                                $voucherPrice = ($_SESSION['voucher']['value']);
                                            }
                                            else if($_SESSION['voucher']['type'] == 2){
                                                $voucherPrice = ($totalPriceInCart * ($_SESSION['voucher']['value']) /100);
                                            }   
                                        }
                $order_date  =  Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d');
                $insertOrder = Order::insert([
                    'customer_email' =>$rq->email,
                    'customer_phone' =>$rq->phone,
                    'customer_address' =>$rq->address,
                    'customer_fullname' =>$rq->fullname,
                    'payment_method' =>$rq->paymentMethod,
                    'voucher_id' => $voucherId,
                    'status'=> 0,
                    'order_by'=> Auth::user()->id,
                    'order_market'=> 2,
                    'totalMoney' => $totalPriceInCart - $voucherPrice + ($totalPriceInCart*0.1),
                    'order_date' => $order_date,

                ]);
                $getOrderId = Order::where('customer_email',$rq->email)->orderBy('created_at','desc')->first('id');
                if($insertOrder){
                    foreach($_SESSION['carts'] as $val){
                        $sl = Product::find($val['id']);
                        $sl->quantily = $sl->quantily - $val['quantity'];
                        if($sl->quantily >= 0){
                            $sl->save();
                        }
                        if($sl->quantily < 0){
                            return response()->json(
                                [
                                    'status' => "error",
                                    'msg' => 'Sản phẩm <b>'. $sl->name . '</b> còn <b>' . $sl->quantily + $val['quantity'] . '</b> sản phẩm',
                                ]
                            );
                        }   
                        $insertOderDetail = OrderDetail::insert([
                            'order_id' =>$getOrderId->id,
                            'product_id' =>$val['id'],
                            'total' =>$val['price'] * $val['quantity'],
                            'unit_price' =>$val['price'],
                            'quantily' => $val['quantity']

                        ]);
                        if($insertOderDetail){
                            unset($_SESSION['carts']);
                            unset($_SESSION['voucher']);
                        }
                    }
                
                    $HostDomain = config('common.HostDomain_servesms');
                                    $key        = config('common.key_servesms');       
                                    $devices    = config('common.devices_servesms');
                                    $number     = $rq->phone;
                                    $message    = "Cửa Hàng Tạp Hóa Chúc An cảm ơn quý khách đã sử dụng dịch vụ của chúng tôi";
                                    $Api_SMS    = $HostDomain .'key=' . $key .'&number=' . $number .'&message='.$message. '&devices=' . $devices;
                                    $response   = Http::get($Api_SMS);
                    return response()->json(
                        [
                            'status' => true,
                            'msg' => 'Đặt hàng thành công',
                            
                        ]
                    );
                }
                
            }
            else{
                return response()->json(
                    [
                        'status' => false,
                        'msg' => 'Vui lòng chọn phương thức thanh toán hợp lệ! ',
                        
                    ]
                );
            }
        } 
        if($rq->isMethod('POST') && isset($_SESSION['cart'])){
            if(!$rq->paymentMethod){
                return response()->json(
                    [
                        'status' => false,
                        'msg' => 'Bạn chưa chọn phương thức thanh toán',
                        
                    ]
                );
            }
            else if($rq->paymentMethod=='vnpay'){
                return response()->json(
                    [
                        'status' => false,
                        'msg' => 'Phương thức thanh toán này chưa được hỗ trợ, vui lòng chọn phương thức thanh toán khác!',
                        
                    ]
                );
            }
            else if($rq->paymentMethod=='cod'){
                $rule = [
                    'fullname'=>'required|max:100',
                    'email'=>'required|email|max:255',
                    'phone'=>'required|min:10|numeric',
                    'address'=>'required',
    
                    ];
                $msg = [
                    'fullname.required' =>'Vui lòng nhập đầy đủ họ tên',
                    'fullname.max' =>'Họ tên tối đa 100 kí tự',
                    'email.required'=>'Vui lòng nhập Email',
                    'email.email'=>'Email không đúng định dạng',
                    'email.max'=>'Email tối đa 255 kí tự',
                    'phone.required'=> 'Nhập số điện thoại',
                    'phone.min'=> 'Nhập số điện thoại có 10 chữ số',
                    'phone.numeric'=> 'Số điện thoại không đúng định dạng',
                    'address.required'=>'Bạn chưa nhập địa chỉ'
                    
                ];
                $validator = Validator::make($rq->all(), $rule, $msg);
                if ($validator->fails()) {
                    return response()->json(
                        [
                            'status' => false,
                            'msg'=> [$validator->errors()]
                            
                        ]
                    );
                }
                
                $totalPriceInCart = 0;
                foreach($_SESSION['cart'] as $val){
                    $totalPriceInCart += $val['price'] * $val['quantity'];
                }
                //insert order into database
                $voucherId = isset($_SESSION['voucher']) ? $_SESSION['voucher']['id'] : 0;
                if($voucherId > 0){
                    $voucher = Voucher::find($voucherId);
                    $voucher->amount += -1;
                    $voucher->save();
                }
                $voucherPrice = 0;
                                        if(isset($_SESSION['voucher'])){
                                            if($_SESSION['voucher']['type'] == 1){
                                                $voucherPrice = ($_SESSION['voucher']['value']);
                                            }
                                            else if($_SESSION['voucher']['type'] == 2){
                                                $voucherPrice = ($totalPriceInCart * ($_SESSION['voucher']['value']) /100);
                                            }   
                                        }
                $order_date  =  Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d');
                $insertOrder = Order::insert([
                    'customer_email' =>$rq->email,
                    'customer_phone' =>$rq->phone,
                    'customer_address' =>$rq->address,
                    'customer_fullname' =>$rq->fullname,
                    'payment_method' =>$rq->paymentMethod,
                    'voucher_id' => $voucherId,
                    'order_by'=> Auth::user()->id,
                    'order_market'=> 1,
                    'status'=> 0,
                    'totalMoney' => $totalPriceInCart - $voucherPrice + ($totalPriceInCart*0.1),
                    'order_date' => $order_date,

                ]);
                $getOrderId = Order::where('customer_email',$rq->email)->orderBy('created_at','desc')->first('id');
                if($insertOrder){
                    foreach($_SESSION['cart'] as $val){
                        $sl = Product::find($val['id']);
                        $sl->quantily = $sl->quantily - $val['quantity'];
                        if($sl->quantily >= 0){
                            $sl->save();
                        }
                        if($sl->quantily < 0){
                            return response()->json(
                                [
                                    'status' => "error",
                                    'msg' => 'Sản phẩm <b>'. $sl->name . '</b> còn <b>' . $sl->quantily + $val['quantity'] . '</b> sản phẩm',
                                ]
                            );
                        } 
                        $insertOderDetail = OrderDetail::insert([
                            'order_id' =>$getOrderId->id,
                            'product_id' =>$val['id'],
                            'total' =>$val['price'] * $val['quantity'],
                            'unit_price' =>$val['price'],
                            'quantily' =>$val['quantity']
                        ]);
                        if($insertOderDetail){
                            unset($_SESSION['cart']);
                            unset($_SESSION['voucher']);
                        }
                    }
                
                    $HostDomain = config('common.HostDomain_servesms');
                                    $key        = config('common.key_servesms');       
                                    $devices    = config('common.devices_servesms');
                                    $number     = $rq->phone;
                                    $message    = "Cửa Hàng Tạp Hóa Chúc An cảm ơn quý khách đã sử dụng dịch vụ của chúng tôi";
                                    $Api_SMS    = $HostDomain .'key=' . $key .'&number=' . $number .'&message='.$message. '&devices=' . $devices;
                                    $response   = Http::get($Api_SMS);
                }
                return response()->json(
                    [
                        'status' => true,
                        'msg' => 'Đặt hàng thành công',
                        
                    ]
                );
            }
            else{
                return response()->json(
                    [
                        'status' => false,
                        'msg' => 'Vui lòng chọn phương thức thanh toán hợp lệ! ',
                    ]
                );
            }
        }
}
    public function removeProductInCart(Request $rq){
        $idPro = $rq->id;
        if($rq->action=='remove-one'){
            unset($_SESSION['cart'][$idPro]);
            unset($_SESSION['carts'][$idPro]);
        }
        if(empty($_SESSION['cart']) || !isset($_SESSION['cart'])){
            unset($_SESSION['voucher']);
        }
        if(empty($_SESSION['carts']) || !isset($_SESSION['carts'])){
            unset($_SESSION['voucher']);
        }
        $totalItem = 0;
        $totalPriceInCart = 0;
        foreach($_SESSION['cart'] as $val){
            $totalItem += $val['quantity'];
            $totalPriceInCart += $val['price'] * $val['quantity'];
        }
        foreach($_SESSION['carts'] as $val){
            $totalItem += $val['quantity'];
            $totalPriceInCart += $val['price'] * $val['quantity'];
        }
        if($rq->action=='remove-all'){
            unset($_SESSION['cart']);
            unset($_SESSION['voucher']);
            unset($_SESSION['carts']);
        }
        return response()->json(
            [
                'status' => true,
                'totalItem' => $totalItem,
                'totalPriceInCart' => $totalPriceInCart
            ]
        );
    }
    public function updateCart(Request $rq){
        $idPro = $rq->id;
        $quantityPro = $rq->quantity;
        $product = Product::whereIn('id',$idPro)->get();
        if($product){
            foreach($product as $key => $pro){
                if($quantityPro[$key] <= 0 ){
                    return response()->json(
                        [
                            'msg' => 'Số lượng k được nhỏ hơn 0',
                            'status' => false,
                            
                        ]
                    );
                }
                if(isset($_SESSION['cart'][$pro->id])){ 
                    if(isset($_SESSION['cart'][$idPro[$key]]['id']) == $idPro[$key]){
                        $_SESSION['cart'][$idPro[$key]]['id'] = $idPro[$key];
                        $_SESSION['cart'][$idPro[$key]]['quantity'] =$quantityPro[$key];
                    } 
                }
                if(isset($_SESSION['carts'][$pro->id])){ 
                    if(isset($_SESSION['carts'][$idPro[$key]]['id']) == $idPro[$key]){
                        $_SESSION['carts'][$idPro[$key]]['id'] = $idPro[$key];
                        $_SESSION['carts'][$idPro[$key]]['quantity'] =$quantityPro[$key];
                    } 
                    
                   
                }    
                
            }
            $totalItem = 0;
            $totalPriceInCart = 0;
            if(isset($_SESSION['cart']) && isset($_SESSION['carts'])){ 
                foreach($_SESSION['cart'] as $val){
                    $totalItem += $val['quantity'];
                    $totalPriceInCart += $val['price'] * $val['quantity'];
                }
                foreach($_SESSION['carts'] as $val){
                    $totalItem += $val['quantity'];
                    $totalPriceInCart += $val['price'] * $val['quantity'];
                }
                return response()->json(
                    [
                        'status' => true,
                        'data' => $_SESSION['cart'],
                        'market' => $_SESSION['carts'],
                        'totalItem' => $totalItem,
                        'totalPriceInCart' => $totalPriceInCart
                    ]
                );
            }
            if(isset($_SESSION['cart'])){ 
                foreach($_SESSION['cart'] as $val){
                    $totalItem += $val['quantity'];
                    $totalPriceInCart += $val['price'] * $val['quantity'];
                }
                return response()->json(
                    [
                        'status' => true,
                        'data' => $_SESSION['cart'],
                        'totalItem' => $totalItem,
                        'totalPriceInCart' => $totalPriceInCart
                    ]
                );
            }
            if(isset($_SESSION['carts'])){ 
                foreach($_SESSION['carts'] as $val){
                    $totalItem += $val['quantity'];
                    $totalPriceInCart += $val['price'] * $val['quantity'];
                }
                return response()->json(
                    [
                        'status' => true,
                        'market' => $_SESSION['carts'],
                        'totalItem' => $totalItem,
                        'totalPriceInCart' => $totalPriceInCart
                    ]
                );
            }
        }
    }
    public function removeCart(Request $rq){
        unset($_SESSION['cart']);
        unset($_SESSION['voucher']);
        unset($_SESSION['carts']);
        return back();
}

}