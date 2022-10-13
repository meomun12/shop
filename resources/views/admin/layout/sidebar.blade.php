<base href="{{asset('')}}">
<div class="navbar-default sidebar" role="navigation">
    <div class="sidebar-nav slimscrollsidebar">
        <div class="sidebar-head">
            <h3><span class="fa-fw open-close"><i class="ti-close ti-menu"></i></span> <span
                    class="hide-menu">Navigation</span></h3>
        </div>
        <ul class="nav" id="side-menu">
            <li style="padding: 70px 0 0;">
                <a href="{{route('admin.dashboard')}}" class="waves-effect"><i class="fa fa-tachometer" aria-hidden="true"></i> Bảng điều khiển</a>
            </li>
            <li>
                <a href="{{route('admin.totalCash')}}" class="waves-effect"><i class="fa fa-signal" aria-hidden="true"></i> Doanh thu</a>
            </li>
            <li>
                <a href="{{route('admin.listCate')}}" class="waves-effect"><i class="fa fa-tasks" aria-hidden="true"></i> Danh Mục</a>
            </li>
            <li>
                <a href="{{route('admin.listProduct')}}" class="waves-effect"><i class="fa fa-product-hunt" aria-hidden="true"></i> Sản phẩm</a>
            </li>
            <li>
                <a href="{{route('admin.listOrder')}}" class="waves-effect"><i class="fa fa-table" aria-hidden="true"></i> Đơn hàng</a>
            </li>
            <!-- <li>
                <a href="{{route('admin.listTransaction')}}" class="waves-effect"><i class="fa fa-history" aria-hidden="true"></i> Lịch sử giao dịch</a>
            </li> -->
            <li>
                <a href="{{route('admin.listVoucher')}}" class="waves-effect"><i class="fa fa-tags" aria-hidden="true"></i> Voucher</a>
            </li>
            <li>
                <a href="{{route('admin.wishlist.index')}}" class="waves-effect"><i class="fa fa-heart" aria-hidden="true"></i> Yêu thích</a>
            </li>
            <li>
                <a href="{{route('admin.listUser')}}" class="waves-effect"><i class="fa fa-users" aria-hidden="true"></i> Tài khoản</a>
            </li>
            <li>
                <a href="{{route('admin.listComment')}}" class="waves-effect"><i class="fa fa-comments-o" aria-hidden="true"></i> Bình luận</a>
            </li>
            <li>
                <a href="{{route('admin.listSlider')}}" class="waves-effect"><i class="fa fa-sliders" aria-hidden="true"></i> Slider</a>
            </li>
            <li>
                <a href="{{route('admin.listAbout')}}" class="waves-effect"><i class="fa fa-sliders" aria-hidden="true"></i> Giới Thiệu</a>
            </li>
        </ul>
        <div class="center p-20">
            <a href="{{route('Auth.Logout')}}" target="_blank" class="btn btn-danger btn-block waves-effect waves-light">Đăng Xuất <i
                    class="fa fa-sign-out" aria-hidden="true"></i></a>
        </div>
    </div>

</div>