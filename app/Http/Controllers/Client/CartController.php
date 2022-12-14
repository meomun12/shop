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
                        'msg' => 'B???n ch??a ch???n ph????ng th???c thanh to??n',

                    ]
                );
            }
            else if($rq->paymentMethod=='vnpay'){
                return response()->json(
                    [
                        'status' => false,
                        'msg' => 'Ph????ng th???c thanh to??n n??y ch??a ???????c h??? tr???, vui l??ng ch???n ph????ng th???c thanh to??n kh??c!',

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
                    'fullname.required' =>'Vui l??ng nh???p ?????y ????? h??? t??n',
                    'fullname.max' =>'H??? t??n t???i ??a 100 k?? t???',
                    'email.required'=>'Vui l??ng nh???p Email',
                    'email.email'=>'Email kh??ng ????ng ?????nh d???ng',
                    'email.max'=>'Email t???i ??a 255 k?? t???',
                    'phone.required'=> 'Nh???p s??? ??i???n tho???i',
                    'phone.min'=> 'Nh???p s??? ??i???n tho???i c?? 10 ch??? s???',
                    'phone.numeric'=> 'S??? ??i???n tho???i kh??ng ????ng ?????nh d???ng',
                    'address.required'=>'B???n ch??a nh???p ?????a ch???'

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
                                    'msg' => 'S???n ph???m <b>'. $sl->name . '</b> c??n <b>' . $sl->quantily + $val['quantity'] . '</b> s???n ph???m',
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
                                    $message    = "C???a H??ng T???p H??a Ch??c An c???m ??n qu?? kh??ch ???? s??? d???ng d???ch v??? c???a ch??ng t??i";
                                    $Api_SMS    = $HostDomain .'key=' . $key .'&number=' . $number .'&message='.$message. '&devices=' . $devices;
                                    $response   = Http::get($Api_SMS);
                }
            }
            else{
                return response()->json(
                    [
                        'status' => false,
                        'msg' => 'Vui l??ng ch???n ph????ng th???c thanh to??n h???p l???! ',
                    ]
                );
            }
        }
        if($rq->isMethod('POST') && isset($_SESSION['carts'])){
            if(!$rq->paymentMethod){
                return response()->json(
                    [
                        'status' => false,
                        'msg' => 'B???n ch??a ch???n ph????ng th???c thanh to??n',

                    ]
                );
            }
            else if($rq->paymentMethod=='vnpay'){
                return response()->json(
                    [
                        'status' => false,
                        'msg' => 'Ph????ng th???c thanh to??n n??y ch??a ???????c h??? tr???, vui l??ng ch???n ph????ng th???c thanh to??n kh??c!',

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
                    'fullname.required' =>'Vui l??ng nh???p ?????y ????? h??? t??n',
                    'fullname.max' =>'H??? t??n t???i ??a 100 k?? t???',
                    'email.required'=>'Vui l??ng nh???p Email',
                    'email.email'=>'Email kh??ng ????ng ?????nh d???ng',
                    'email.max'=>'Email t???i ??a 255 k?? t???',
                    'phone.required'=> 'Nh???p s??? ??i???n tho???i',
                    'phone.min'=> 'Nh???p s??? ??i???n tho???i c?? 10 ch??? s???',
                    'phone.numeric'=> 'S??? ??i???n tho???i kh??ng ????ng ?????nh d???ng',
                    'address.required'=>'B???n ch??a nh???p ?????a ch???'

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
                                    'msg' => 'S???n ph???m <b>'. $sl->name . '</b> c??n <b>' . $sl->quantily + $val['quantity'] . '</b> s???n ph???m',
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
                                    $message    = "C???a H??ng T???p H??a Ch??c An c???m ??n qu?? kh??ch ???? s??? d???ng d???ch v??? c???a ch??ng t??i";
                                    $Api_SMS    = $HostDomain .'key=' . $key .'&number=' . $number .'&message='.$message. '&devices=' . $devices;
                                    $response   = Http::get($Api_SMS);
                    return response()->json(
                        [
                            'status' => true,
                            'msg' => '?????t h??ng th??nh c??ng',

                        ]
                    );
                }

            }
            else{
                return response()->json(
                    [
                        'status' => false,
                        'msg' => 'Vui l??ng ch???n ph????ng th???c thanh to??n h???p l???! ',

                    ]
                );
            }
        }
        if($rq->isMethod('POST') && isset($_SESSION['cart'])){
            if(!$rq->paymentMethod){
                return response()->json(
                    [
                        'status' => false,
                        'msg' => 'B???n ch??a ch???n ph????ng th???c thanh to??n',

                    ]
                );
            }
            else if($rq->paymentMethod=='vnpay'){
                return response()->json(
                    [
                        'status' => false,
                        'msg' => 'Ph????ng th???c thanh to??n n??y ch??a ???????c h??? tr???, vui l??ng ch???n ph????ng th???c thanh to??n kh??c!',

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
                    'fullname.required' =>'Vui l??ng nh???p ?????y ????? h??? t??n',
                    'fullname.max' =>'H??? t??n t???i ??a 100 k?? t???',
                    'email.required'=>'Vui l??ng nh???p Email',
                    'email.email'=>'Email kh??ng ????ng ?????nh d???ng',
                    'email.max'=>'Email t???i ??a 255 k?? t???',
                    'phone.required'=> 'Nh???p s??? ??i???n tho???i',
                    'phone.min'=> 'Nh???p s??? ??i???n tho???i c?? 10 ch??? s???',
                    'phone.numeric'=> 'S??? ??i???n tho???i kh??ng ????ng ?????nh d???ng',
                    'address.required'=>'B???n ch??a nh???p ?????a ch???'

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
                                    'msg' => 'S???n ph???m <b>'. $sl->name . '</b> c??n <b>' . $sl->quantily + $val['quantity'] . '</b> s???n ph???m',
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
                                    $message    = "C???a H??ng T???p H??a Ch??c An c???m ??n qu?? kh??ch ???? s??? d???ng d???ch v??? c???a ch??ng t??i";
                                    $Api_SMS    = $HostDomain .'key=' . $key .'&number=' . $number .'&message='.$message. '&devices=' . $devices;
                                    $response   = Http::get($Api_SMS);
                }
                return response()->json(
                    [
                        'status' => true,
                        'msg' => '?????t h??ng th??nh c??ng',

                    ]
                );
            }
            else{
                return response()->json(
                    [
                        'status' => false,
                        'msg' => 'Vui l??ng ch???n ph????ng th???c thanh to??n h???p l???! ',
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
                            'msg' => 'S??? l?????ng k ???????c nh??? h??n 0',
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
public function addCart(Request $request){
    $this->authorize('admin');
    $request->all();

}
}
