<base href="{{asset('')}}">
<nav class="navbar navbar-default navbar-static-top m-b-0">
    <div class="navbar-header">
        <div class="top-left-part">
            <!-- Logo -->
            <a class="logo" href="{{route('admin.dashboard')}}"><b>
                    <img src="plugins/images/admin-logo.png" alt="home" class="dark-logo" />
                    <!--This is light logo icon--><img src="{{asset('assets/admin/plugins/images/admin-logo-dark.png')}}" alt="home"
                        class="light-logo" />
                </b>
                <span class="hidden-xs">
                    <img src="plugins/images/admin-text.png" alt="home" class="dark-logo" />
                    <!--This is light logo text--><img src="{{asset('assets/admin/plugins/images/admin-text-dark.png')}}" alt="home"
                        class="light-logo" />
                </span> </a>
        </div>
        <!-- /Logo -->
        <ul class="nav navbar-top-links navbar-right pull-right">
            <li>
                <a class="profile-pic" href="{{route('admin.profile')}}"> <img src="@if(Auth::user()) {{asset(Auth::user()->avatar)}} @endif" alt="user-img"
                        width="35" class="img-circle"><b class="hidden-xs">@if(Auth::user()) {{Auth::user()->name}} @endif</b></a>
            </li>
        </ul>
    </div>
</nav>