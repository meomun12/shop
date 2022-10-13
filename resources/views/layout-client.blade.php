<?php
    if(!isset($_SESSION))
    {
        session_start();
    }
    $totalItem = 0;
    if(isset($_SESSION['cart'])){
        foreach($_SESSION['cart'] as $val){
            $totalItem += $val['quantity'];
        }
    }
    if(isset($_SESSION['carts'])){
        foreach($_SESSION['carts'] as $val){
            $totalItem += $val['quantity'];
        }
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>Tạp hoá Chúc An</title>
    <link rel="shortcut icon" type="image/x-icon" href="{{asset('assets/client/images/favicon/favicon.png')}}" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i,800&amp;display=swap"
        rel="stylesheet" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css">
    <link rel="stylesheet" href="{{asset('assets/client/css/vendor/plugins.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/client/css/style.min.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link rel="stylesheet" href="{{asset('assets/client/css/responsive.min.css')}}">
    <link href="{{asset('assets/client/css/order-detail.css')}}" id="theme" rel="stylesheet">


    <style>
        .count-cart::after{ content:'{{$totalItem}}' !important}
        .form-control form-control-sm{
            visibility:hidden;
        }
    </style>
</head>

<body>

    <div id="main">
        @include('client/layout/header')
        @yield('content')
        @include('client/layout/footer')

    </div>
    <script src="{{asset('assets/client/js/vendor/jquery-3.5.1.min.js')}}"></script>
    <script src="{{asset('assets/client/js/vendor/modernizr-3.7.1.min.js')}}"></script>
    <script src="{{asset('assets/client/js/plugins.min.js')}}"></script>
    <script src="{{asset('assets/client/js/main.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    @yield('script')
    
    <script>
        $(document).ready(function(){
            var paymentMethod = ''
            $('.select-payment-method').click(function(){
                $('.select-payment-method').not(this).prop("checked", false);
                paymentMethod = $(this).val()
            })
            $('#checkout').click(function(e){
                e.preventDefault()
                var checkBoxPayment = $('.select-payment-method').is(':checked')
                var fullNameCustomer = $('#full-name-customer').val()
                var addressCustomer = $('#address-customer').val()
                var phoneCustomer = $('#phone-customer').val()
                var emailCustomer = $('#email-customer').val()
                if(checkBoxPayment ===true){
                    if(paymentMethod == 'vnpay'){
                        Swal.fire({
                            icon: 'error',
                            title: 'Lỗi...',
                            text: 'Phương thức thanh toán này chưa được hỗ trợ, vui lòng chọn phương thức thanh toán khác!'
                        })
                    }
                    else{
                        $.ajax({
                            type:"POST",
                            url: "{{route('client.checkOut')}}",
                            dataType:"json",
                            data:{
                                paymentMethod:paymentMethod,
                                fullname:fullNameCustomer,
                                address:addressCustomer,
                                phone:phoneCustomer,
                                email:emailCustomer,
                                _token:"{{csrf_token()}}"
                            },
                            success: function(result){
                                if(result.status ===false){
                                    result.msg.map(function(item,index){
                                        if(item.fullname){
                                            toastr.error(item.fullname[index],'Lỗi')
                                        }
                                        if(item.phone){
                                            toastr.error(item.phone[index],'Lỗi')
                                        }
                                        if(item.email){
                                            toastr.error(item.email[index],'Lỗi')
                                        }
                                        if(item.address){
                                            toastr.error(item.address[index],'Lỗi')
                                        }
                                    })
                                }
                                if(result.status ==='error'){
                                    Swal.fire('Quá số lượng',result.msg , 'error')
                                }
                                if(result.status ===true){
                                    Swal.fire('',result.msg , 'success')
                                    sessionStorage.clear();
                                    $('head').append(`<style>.count-cart::after{ content:'${0}' !important}</style>`);
                                    $(".content-cart, .cart-page-title").empty()
                                    setTimeout(function(){
                                        $(".content-cart").append(`<h3 class="container-fluid text-center">Giỏ hàng trống!</h3>`)
                                    },200)
                                }

                            }
                        })
                    }
                    
                }
                else{
                    Swal.fire({
                        icon: 'error',
                        title: 'Lỗi...',
                        text: 'Bạn chưa chọn phương thức thanh toán!',
                    })
                    // alert("")
                    // toastr.error("Họ tên k đc để trống",'Lỗi')
                    // toastr.error("Email k đc để trống",'Lỗi')
                    // toastr.error("Sđt k đc để trống",'Lỗi')
                    // toastr.error("Địa chỉ nhận hàng k đc để trống",'Lỗi')
                }
            })
            // Thêm mã giảm giá
            $('#add-voucher').click(function(e){
                e.preventDefault()
                var voucherCode = $('#voucher-code').val()
                if(!voucherCode){
                    toastr.error('Mã giảm giá không được bỏ trống', 'Thông báo')
                }
                else{
                    $.ajax({
                        type:"POST",
                        url: "{{route('client.addVoucherToCart')}}",
                        dataType:"json",
                        data:{
                            voucherCode:voucherCode,
                            _token:"{{csrf_token()}}"
                        },
                        success: function(result){
                            if(result.status === false){
                                toastr.error(result.msg, 'Thông báo')
                            }
                            if(result.status === true){
                                var totalPriceInCart = result.totalPriceInCart
                                Swal.fire('',result.msg , 'success')
                                window.location.reload()
                                $('.voucher-box').empty()
                                if(result.data.type ==2){
                                    sessionStorage.setItem("typeVoucher",result.data.type);
                                    // typeVoucher =result.data.type
                                    sessionStorage.setItem('voucherValue',result.data.value);
                                    // voucherValue =result.data.value
                                    $('#sale-off').html(new Intl.NumberFormat('en-GB').format(totalPriceInCart * result.data.value / 100) + " VNĐ")
                                    $('.grand-totall-title').html("Tổng tiền " + new Intl.NumberFormat('en-GB').format(totalPriceInCart - totalPriceInCart * result.data.value / 100 ) + " VNĐ")
                                }
                                if(result.data.type ==1){
                                    // typeVoucher =result.data.type
                                    // voucherValue =result.data.value
                                    sessionStorage.setItem("typeVoucher",result.data.type);
                                    sessionStorage.setItem('voucherValue',result.data.value);
                                    $('#sale-off').html(new Intl.NumberFormat('en-GB').format(result.data.value) + " VNĐ")
                                    $('.grand-totall-title').html("Tổng tiền " + new Intl.NumberFormat('en-GB').format(totalPriceInCart - result.data.value) + " VNĐ")
                                }
                            }
                        }
                    })
                }
            })
            // thêm vào giỏ hàng
            $('.cart-btn').click(function(e){
                e.preventDefault();
                var idProduct = $(this).attr('product-id')
                $.ajax({
                    type:"POST",
                    url: "{{route('client.add-to-cart')}}",
                    dataType:"json",
                    data:{
                        id:idProduct,
                        _token:"{{csrf_token()}}"
                    },
                    success: function(result){
                        if(result.status === true){
                            toastr.success('Thêm vào giỏ hàng thành công', 'Thông báo')
                            $('head').append(`<style>.count-cart::after{ content:'${result.totalItem}' !important}</style>`);
                        }
                    }
                })
            })
            // cập nhật giỏ hàng
            $('#update-cart').click(function(e){
                var typeVoucher =sessionStorage.getItem('typeVoucher')
                var voucherValue =sessionStorage.getItem('voucherValue')
                e.preventDefault();
                var arrayProduct = []
                var arrayQuantity = []
                var updateCart = $('.cart-plus-minus-box').each(function(item){
                    var idProduct = $(this).attr('prod-id')
                    var quantity = $(this).val()
                    arrayProduct.push(idProduct)
                    arrayQuantity.push(quantity)
                })
                $.ajax({
                        type:"POST",
                        url: "{{route('client.update-cart')}}",
                        dataType:"json",
                        data:{
                            id:arrayProduct,
                            quantity:arrayQuantity,
                            _token:"{{csrf_token()}}"
                        },
                        success: function(result){
                            if(result.status === true){
                                console.log(typeVoucher)
                                var totalPriceInCart = result.totalPriceInCart
                                Swal.fire('', 'Cập nhật giỏ hàng thành công', 'success')
                                $('.product-subtotals').each(function(item){
                                    var proId =$(this).attr("prod-id")
                                    var totalPrice = new Intl.NumberFormat('en-GB').format(result.market[proId].quantity * result.market[proId].price)
                                    if(result.market[proId].id == proId){
                                        $(this).html(totalPrice + " VNĐ")
                                        $('head').append(`<style>.count-cart::after{ content:'${result.totalItem}' !important}</style>`);
                                    }
                                })
                                $('.product-subtotal').each(function(item){
                                    var proId =$(this).attr("prod-id")
                                    var totalPrice = new Intl.NumberFormat('en-GB').format(result.data[proId].quantity * result.data[proId].price)
                                    if(result.data[proId].id == proId){
                                        $(this).html(totalPrice + " VNĐ")
                                        $('head').append(`<style>.count-cart::after{ content:'${result.totalItem}' !important}</style>`);
                                    }
                                })
                                if(typeVoucher==2){
                                    $('#sale-off').html(new Intl.NumberFormat('en-GB').format(totalPriceInCart * voucherValue / 100) + " VNĐ")
                                    $('.grand-totall-title').html("Tổng tiền " + new Intl.NumberFormat('en-GB').format(totalPriceInCart - totalPriceInCart * voucherValue / 100 + (totalPriceInCart*0.1)) + " VNĐ")
                                }
                                else if(typeVoucher==1){
                                    console.log(1)
                                    $('#sale-off').html(new Intl.NumberFormat('en-GB').format(voucherValue) + " VNĐ")
                                    $('.grand-totall-title').html("Tổng tiền " + new Intl.NumberFormat('en-GB').format(totalPriceInCart - voucherValue + (totalPriceInCart*0.1)) + " VNĐ")
                                }
                                else{
                                    $('.grand-totall-title').html("Tổng tiền " + new Intl.NumberFormat('en-GB').format(totalPriceInCart +  (totalPriceInCart*0.1)) + " VNĐ")
                                }
                                $('#total-price-cart').html(new Intl.NumberFormat('en-GB').format(totalPriceInCart) + " VNĐ")
                            }
                            if(result.status === false){
                                toastr.error(result.msg,'Lỗi')
                            }
                        }
                })
            })
            //remove item cart
            $('.product-remove a').click(function(e){
                e.preventDefault();
                var typeVoucher =sessionStorage.getItem('typeVoucher')
                var voucherValue =sessionStorage.getItem('voucherValue')
                var idProduct = $(this).attr('prod-id')
                $("#" +idProduct).fadeOut(1000,function(){
                    $.ajax({
                        type:"POST",
                        url: "{{route('client.remove-product-in-cart')}}",
                        dataType:"json",
                        data:{
                            action:'remove-one',
                            id:idProduct,
                            _token:"{{csrf_token()}}"
                        },
                        success: function(result){
                            if(result.status === true){
                                var totalPriceInCart = result.totalPriceInCart
                                $('#total-price-cart').html(new Intl.NumberFormat('en-GB').format(totalPriceInCart) +" VNĐ")
                                if(typeVoucher ==2){
                                    $('#sale-off').html(new Intl.NumberFormat('en-GB').format(totalPriceInCart * voucherValue / 100) + " VNĐ")
                                    $('.grand-totall-title').html("Tổng tiền " + new Intl.NumberFormat('en-GB').format(totalPriceInCart - totalPriceInCart * voucherValue / 100) + " VNĐ")
                                }
                                else if(typeVoucher ==1){
                                    $('#sale-off').html(new Intl.NumberFormat('en-GB').format(voucherValue) + " VNĐ")
                                    $('.grand-totall-title').html("Tổng tiền " + new Intl.NumberFormat('en-GB').format(totalPriceInCart - voucherValue) + " VNĐ")
                                }
                                else{
                                    $('.grand-totall-title').html("Tổng tiền " + new Intl.NumberFormat('en-GB').format(totalPriceInCart) + " VNĐ")
                                }
                                $('head').append(`<style>.count-cart::after{ content:'${result.totalItem}' !important}</style>`);
                                $("#" +idProduct).remove()
                                if(!$("tbody tr").html()){
                                    sessionStorage.clear();
                                    $(".content-cart, .cart-page-title").empty()
                                    setTimeout(function(){
                                        $(".content-cart").append(`<h3 class="container-fluid text-center">Giỏ hàng trống!</h3>`)
                                    },200)
                                }
                            }
                        }
                    })
                })
            })
            //remove all item cart
            
        })
        
    </script>
    <script>
        $(document).ready(function(){
          $('.cart-btns').tooltip({title: "Hết thời gian đặt hàng", placement: "top"});
        });
    </script>
    <script>
        $(document).ready(function() {
        setInterval( function() {
        var hours = new Date().getHours();
        $(".hours").html(( hours < 10 ? "0" : "" ) + hours);
        }, 1000);
        setInterval( function() {
        var minutes = new Date().getMinutes();
        $(".min").html(( minutes < 10 ? "0" : "" ) + minutes);
        },1000);
        setInterval( function() {
        var seconds = new Date().getSeconds();
        $(".sec").html(( seconds < 10 ? "0" : "" ) + seconds);
        },1000);
        });
        </script>
</body>

</html>