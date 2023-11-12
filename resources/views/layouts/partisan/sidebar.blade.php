<div class="sidebar sidebar-hide-to-small sidebar-shrink sidebar-gestures">
        <div class="nano">
            <div class="nano-content">
                <ul>
                    <div class="logo">
                        <a href="{{url('home')}}">
                            <img src="{{asset('/')}}assets/images/logo.png" alt="" width="50px"/> <span>Focus</span>
                        </a>
                    </div>
                    <li>
                        <a href="{{url('home')}}"><i class="ti-home"></i> Dashboard </a>
                    </li>

                    <li><a class="sidebar-sub-toggle"><i class="ti-bar-chart-alt"></i> Orders <span class="sidebar-collapse-icon ti-angle-down"></span></a>
                        <ul>
                            <li><a href="{{route('order.index')}}">List</a></li>
                            <li><a href="{{route('order.create')}}">New</a></li>
                        </ul>
                    </li>
                    <li><a class="sidebar-sub-toggle"><i class="ti-layout"></i> User 
                        <span class="sidebar-collapse-icon ti-angle-down"></span></a>
                        <ul>
                            <li><a href="{{route('role.index')}}">Role</a></li>
                            <li><a href="{{route('user.index')}}">User</a></li>
                            <li><a href="{{route('permission.index')}}">Permission</a></li>
                        </ul>
                    </li>
                    <li><a><i class="ti-close" href="{{route('userWallet')}}"></i> Wallet</a></li>
                    <li><a><i class="ti-close" href="{{route('logout')}}"></i> Logout</a></li>
                </ul>
            </div>
        </div>
    </div>
    <!-- /# sidebar -->