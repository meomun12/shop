<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <style>
        body{
            font-family: Arial;
        }
        .mail{
            border: 5px dotted #bbb;
            width: 80%;
            border-radius: 15px;
            margin: 0 auto;
            max-width: 600px;
        }
        .container{
            padding: 2px 16px;
            background-color: #f1f1f1;
        }
        h3{
            text-align: center;
        }
        .promo{
            background: #ccc;
            padding: 3px;
        }
        .expire{
            color: red;
            text-align: center;
        }
        p.code{
            text-align: center;
            font-size: 20px;
        }
        h2.note{
            text-align: center;
            font-size: large;
            text-decoration: underline;
        }
    </style>
    <title>Document</title>
</head>
<body>
    <div class="mail">
        <div class="container">
            <h3>Mã khuyến mãi cho khách hàng từ <b>Cửa hàng Chúc An</b></h3>
        </div>
        <div class="container" style="background-color: white">
            <h2 class="note"><b><i>
                @if ($voucher['type'] == 1)
                    Giảm {{number_format($voucher['value'],0,',','.')  }} VND
                @else
                    Giảm {{$voucher['value']  }} %
                @endif
                    cho đơn hàng từ 300k trở lên
            </i></b></h2>
            <div class="container">
                <p class="code">Sử dụng code sau: <span class="promo"><b>{{ $voucher['code'] }}</b> </span> chỉ còn <b>{{ $voucher['amount'] }}</b> mã giảm giá. nhanh tay đặt mua kẻo hết</p>
                <p class="expire">Ngày bắt đầu: {{ $voucher['start_date'] }} / Ngày hết hạn: <b>{{ $voucher['finish_date'] }}</p>
                
            </div>
        </div>
    </div>
</body>
</html>