<header class="main-header">
    <!-- Header Buttom Start -->
    <div class="header-navigation sticky-nav">
        <div class="container-fluid">
            <div class="row">
                <!-- Logo Start -->
                <div class="col-md-2 col-sm-2">
                    <div class="logo">
                        <a href="{{route('client.homepage')}}"><img style="width:80%;"
                                src="{{asset('assets/client/images/logo/logo.png')}}" alt="" /></a>
                    </div>
                </div>
                <!-- Logo End -->
                <!-- Navigation Start -->
                <div class="col-md-10 col-sm-10">
                    <!--Main Navigation Start -->
                    <div class="main-navigation d-none d-lg-block">
                        <ul>
                            <li class="menu-dropdown">
                                <a href="{{route('client.homepage')}}">Trang chủ</a>
                            </li>
                            <li class="menu-dropdown">
                                            <a href="{{route('client.shop')}}">Cửa hàng <i class="ion-ios-arrow-down"></i></a>
                                            <ul class="sub-menu">
                                                <li><a href="{{route('client.shops')}}">Sản phẩm thông thường</a></li>
                                                <li><a href="{{route('client.allow-market')}}">Đi chợ hộ !</a></li>
                                            </ul>
                            </li>
                            <li class="menu-dropdown">
                                <a href="{{route('client.about')}}">Giới thiệu</a>
                            </li>
                            <li><a href="{{route('client.contact')}}">Liên hệ</a></li>
                        </ul>
                    </div>
                    <!--Main Navigation End -->
                    <!--Header Bottom Account Start -->
                    <div class="header_account_area">
                        <div class="header_account_list search_list">
                            <a href="javascript:void(0)"><i class="ion-ios-search-strong"></i></a>
                            <div class="dropdown_search">
                                <form action="{{URL::to('/search')}}" method="POST">
                                @csrf
                                    <input placeholder="Tìm mọi thứ ở đây ..." type="text" name="keyword_submit" />
                                    <button type="submit"><i class="ion-ios-search-strong"></i></button>
                                </form>
                            </div>
                        </div>
                        <!--Login info Start -->
                        <div class="cart-info d-flex">
                            @if (Auth::check())
                            <div class="main-navigation" style="margin: 0px;">
                                <ul>
                                    <li class="menu-dropdown">
                                        <span><b style="width:10%;"><i class="fa fa-user" aria-hidden="true"></i> Hello:
                                                {{Auth::user()->name}}</b></span>
                                        <ul class="sub-menu">
                                            @if (Auth::user()->role_id == 1)
                                            <li><a href="{{route('admin.dashboard')}}">Trang Quản Trị</a></li>
                                            @endif
                                            <li><a href="{{route('client.my-account')}}">Thông tin cá nhân</a></li>
                                            <li><a href="{{route('client.show.my_order')}}">Đơn hàng của tôi</a></li>
                                            <li><a href="{{route('client.show-wishlist')}}">Sản phẩm Yêu thích</a></li>
                                            <li><a href="{{route('Auth.Logout')}}" class="text-danger">Đăng xuất</a>
                                            </li>
                                        </ul>
                                    </li>
                                </ul>
                            </div>
                            @else
                            <a href="{{route('client.login')}}" class="login text-dark"><b>Đăng nhập / Đăng kí</b></a>
                            @endif
                        </div>
                        <!--Login info End -->
                        <!--Cart info Start -->
                        <div class="cart-info d-flex">
                            <div class="mini-cart-warp">
                                    @if(Auth::check())
                                        <a href="{{route('client.cart')}}" class="count-cart"></a>
                                    @else
                                        <a href="#" class="count-cart"></a>
                                    @endif
                                
                            </div>
                        </div>
                    </div>
                </div>
                <!-- mobile menu -->
                
                <div class="mobile-menu-area">
                    <div class="mobile-menu">
                        <nav id="mobile-menu-active">
                            
                        @if (Auth::check())
                            <ul class="menu-overflow">
                                <li>
                                    <a href="#">Xin chào : {{Auth::user()->name}}</a>
                                    <ul>
                                    @if (Auth::user()->role_id == 1)
                                    <li><a href="{{route('admin.dashboard')}}">Trang Quản Trị</a></li>
                                    @endif
                                        <li><a href="{{route('client.my-account')}}">Thông tin cá nhân</a></li>
                                        <li><a href="{{route('client.show.my_order')}}">Đơn hàng của tôi</a></li>
                                        <li><a href="{{route('client.show-wishlist')}}">Sản phẩm Yêu thích</a></li>
                                        <li><a href="{{route('Auth.Logout')}}" class="text-danger">Đăng xuất</a>
                                    </ul>
                                </li>
                            @else
                            <ul class="menu-overflow">
                                <li><a href="{{route('client.login')}}" class="login text-dark"><b>Đăng nhập / Đăng kí</b></a></li>
                            @endif
 
                                <li><a href="{{route('client.homepage')}}">Trang chủ</a></li>
                                <li>
                                    <a href="{{route('client.shop')}}">Cửa hàng</a>
                                    <ul>
                                    <li><a href="{{route('client.shops')}}">Sản phẩm thông thường</a></li>
                                        <li><a href="{{route('client.allow-market')}}">Đi chợ hộ !</a></li>
                                    </ul>
                                </li>
                                <li><a href="{{route('client.about')}}">Giới thiệu</a></li>
                                <li><a href="{{route('client.contact')}}">Liên hệ</a></li>
                            </ul>
                        </nav>
                    </div>
                </div>
                <!-- mobile menu end-->
            </div>
        </div>
        <!--Header Bottom Account End -->
</header>