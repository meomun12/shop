<style>

.wrapper{
    text-align: center;
    position: relative;
    top: 20%;
    margin:0 auto;
}

body{
    background-image: url('https://cdn.hipwallpaper.com/i/38/77/KGRu48.jpg');
}
img {
    width: 200px;
}

.button-client-admin {
    margin: 0 auto;
    text-align: center;
}
.button-client-admin .button-ck h1 a{
    font-size:20px;
    list-style:none;
    text-decoration:none;
    color:#fff;
    background:#4fb68d;
    padding: 13px 40px;
    border-radius: 15px;
}

.button-client-admin .button-ck h1 a:hover{
    background:#555;
    transition:0.9s;
}

/* .button-ck{
    background:#4fb68d;
    width: 10%;
    margin: 0 auto;
} */
</style>

<div class="wrapper">
    <div class="title-client-admin">
        <img src="{{asset('assets/client/images/logo/logo.png')}}" alt="">
        <h1>CỬA HÀNG TẠP HOÁ CHÚC AN </h1>
        <h2><i>Xin chào</i> : {{Auth::user()->name}}</h2>
    </div>
<br>
    <div class="button-client-admin contaier-fluid">
        <div class="button-ck"><h1><a href="{{route('client.homepage')}}">Trang chủ</a></h1></div> <br>
        <div class="button-ck"><h1><a href="{{route('admin.dashboard')}}">Quản Trị</a></h1></div>
    </div>
</div>
