<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Mera Shiping : Admin Dashboard</title>
    <!-- ================= Favicon ================== -->
    <!-- Styles -->
    <link href="{{asset('/')}}assets/css/lib/font-awesome.min.css" rel="stylesheet">
    <link href="{{asset('/')}}assets/css/lib/themify-icons.css" rel="stylesheet">
    <link href="{{asset('/')}}assets/css/lib/menubar/sidebar.css" rel="stylesheet">
    <link href="{{asset('/')}}assets/css/lib/bootstrap.min.css" rel="stylesheet">
    <link href="{{asset('/')}}assets/css/lib/toastr/toastr.min.css" rel="stylesheet">
    <link href="{{asset('/')}}assets/css/lib/helper.css" rel="stylesheet">
    <link href="{{asset('/')}}assets/css/style.css" rel="stylesheet">
</head>

<body>

    <div class="sidebar sidebar-hide-to-small sidebar-shrink sidebar-gestures">
        <div class="nano">
            <div class="nano-content">
                <ul>
                    <div class="logo">
                        <a href="{{url('home')}}">
                            <img src="{{asset('/')}}assets/images/logo.png" alt="" width="50px"/> <span>Mera Shiping</span>
                        </a>
                    </div>
                    <li>
                        <a href="{{url('home')}}"><i class="ti-home"></i> Dashboard </a>
                    </li>

                    <li>
                        <a href="{{route('order.create')}}?status=5"><i class="ti-plus"></i> Create Order</a>
                    </li>

                    <li><a class="sidebar-sub-toggle"><i class="ti-shopping-cart"></i> Orders <span class="sidebar-collapse-icon ti-angle-down"></span></a>
                        <ul>
                            <li><a href="{{route('order.index')}}">All</a></li>
                            <li><a href="{{route('order.index')}}?status=1">Pending</a></li>
                            <li><a href="{{route('order.index')}}?status=2">In-transit</a></li>
                            <li><a href="{{route('order.index')}}?status=3">OUT For Delivery</a></li>
                            <li><a href="{{route('order.index')}}?status=4">Delivered</a></li>
                            <li><a href="{{route('order.index')}}?status=5">Return</a></li>
                        </ul>
                    </li>
                    @if(Auth::user()->roleid!=2)
                    <li><a class="sidebar-sub-toggle"><i class="ti-alarm-clock"></i> Pincode
                        <span class="sidebar-collapse-icon ti-angle-down"></span></a>
                        <ul>
                            <li>
                                <a onClick="if(confirm('Are you sure you want to UPDATE DEHLIVEY PINCODE this ??.')){ document.getElementById('updatepincode').submit();}">Update Dehlivery Pincode</a>
                                <form id="updatepincode" action="{{route('pincode.store')}}" method="post" class="hidden">
                                    @csrf
                                </form>
                            </li>
                            <li>
                                <a onClick="if(confirm('Are you sure you want to UPDATE ECOME PINCODE this ??.')){ document.getElementById('updateEcomePincode').submit();}">Update Ecome Pincode</a>
                                <form id="updateEcomePincode" action="{{route('updateEcomePincode')}}" method="post" class="hidden">
                                    @csrf
                                </form>
                            </li>
                        </ul>
                    </li>
                    
                    
                    <li>
                        <a onClick="if(confirm('Are you sure you want to UPDATE ORDER STATUS this ??.')){ document.getElementById('updateOrdersStatus').submit();}"><i class="ti-rss-alt"></i>Update Orders Status</a>
                        <form id="updateOrdersStatus" action="{{route('updateOrdersStatus')}}" method="post" class="hidden">
                            @csrf
                        </form>
                    </li>
                    <li><a class="sidebar-sub-toggle"><i class="ti-user"></i> Users
                        <span class="sidebar-collapse-icon ti-angle-down"></span></a>
                        <ul>
                            {{--<li><a href="{{route('role.index')}}">Role</a></li>--}}
                            <li><a href="{{route('user.index')}}">User</a></li>
                            <li><a href="{{route('user.customer')}}">Customer</a></li>
                            {{--<li><a href="{{route('permission.index')}}">Permission</a></li>--}}
                        </ul>
                    </li>
                    
                    @endif

                    @if(Auth::user()->roleid==2)

                            <li>
                                <a onClick="if(confirm('Are you sure you want to create/update WhareHouse ?')){ document.getElementById('createWharehouse').submit();}"
                                ><i class="ti-alarm-clock"></i>@if(Auth::user()->wharehouse==1) Create WhareHouse @else Update WhareHouse @endif</a>
                                <form id="createWharehouse" action="{{route('createWharehouse')}}" method="post" class="hidden">
                                    @csrf
                                </form>
                            </li>
                    <li><a href="{{url('profile/'.Auth::user()->id)}}"><i class="ti-user"></i> Profile</a></li>
                    <li><a href="#" data-toggle="modal" data-target="#editprofilemodel"><i class="ti-pencil-alt"></i>Edit Profile</a></li>
                    @endif
                    <li><a href="#" data-toggle="modal" data-target="#paymenteditmodel"><i class="ti-wallet"></i> Add Balance</a></li>
                    <li><a href="{{route('payment.index')}}"><i class="ti-money"></i>Payment History</a></li>
                    <li><a href="{{route('remittance.index')}}"><i class="ti-money"></i> Remittance</a></li>
                    <li><a href="{{route('calculate')}}"><i class="ti-calendar"></i> Calculate</a></li>
                    <li>
                        <a href="{{route('logout')}}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="ti-key"></i>Logout</a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <!-- /# sidebar -->

    <div class="header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="float-left">
                        <div class="hamburger sidebar-toggle">
                            <span class="line"></span>
                            <span class="line"></span>
                            <span class="line"></span>
                        </div>
                    </div>
                    <div class="float-right">
                        <div class="dropdown dib">
                            <div class="header-icon" data-toggle="dropdown">
                                <span class="user-avatar">{{Auth::user()->name}} / ₹{{Auth::user()->points}}
                                    <i class="ti-angle-down f-s-10"></i>
                                </span>
                                <div class="drop-down dropdown-profile dropdown-menu dropdown-menu-right">
                                    <div class="dropdown-content-body">
                                        <ul class="py-3">
                                            <li class="mb-2">
                                                <a href="{{route('logout')}}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                                    <i class="ti-power-off"></i>
                                                    <span>Logout</span>
                                                </a>
                                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                                    @csrf
                                                </form>
                                            </li>
                                            <li>
                                                <a href="{{url('profile/'.Auth::user()->id)}}"><i class="ti-user"></i> Profile</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="content-wrap">
        <div class="main">
            <div class="container-fluid">
            @yield('content')
        </div>
    </div>

    @yield('models')
    <!--Add payment Model -->

    <div class="modal" id="paymenteditmodel">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-warning">
                    <h4 class="modal-title">Add Payment</h4>
                    <button type="button" class="close" data-dismiss="modal">X</button>
                </div>
                <form action="{{route('payment.store')}}" method="post" enctype="multipart/form-data">
                @csrf
                    <div class="modal-body">
                        <div class="form-group row">
                            <div class="text-center">
                                <p>Scan & pay or upload slip.</p>
                                <img src="{{asset('assets/images/payment.jpg')}}" class="w-50"/>
                            </div>
                            <div class="col-md-12">
                                <label for="name">Amount *</label>
                                <input class="form-control" type="number" name="amount" required/>
                            </div>
                            <div class="col-md-12">
                                <label for="name">Upload *</label>
                                <input class="form-control" type="file" name="image" required/>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary px-5">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit User Model -->

    <div class="modal" id="editprofilemodel">
        <div class="modal-dialog" style="max-width:90%">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header bg-warning">
                    <h4 class="modal-title">Update Profile</h4>
                    <button type="button" class="close" data-dismiss="modal">X</button>
                </div>

                <!-- Modal body -->
                <form id="EditFormId" action="{{route('updateupdate')}}" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group row">
                            <div class="col-md-4">
                                <label for="name">Name *</label>
                                <input class="form-control" type="text" name="name" value="{{Auth::user()->name}}" required />
                            </div>
                            <div class="col-md-4">
                                <label for="phone">Phone *</label>
                                <input class="form-control" type="number" name="phone" value="{{Auth::user()->phone}}" required />
                            </div>
                            <div class="col-md-4">
                                <label for="email">Pincode *</label>
                                <input class="form-control" type="number" name="pin" value="{{Auth::user()->pin}}" required />
                            </div>

                            <div class="col-md-12">
                                <label for="password">Pickup Address *</label>
                                <input class="form-control" type="text" name="address" value="{{Auth::user()->address}}" required />
                            </div>
                            <div class="col-md-12">
                                <label for="returnadd">Return Address *</label>
                                <input class="form-control" type="text" name="returnadd" value="{{Auth::user()->returnadd}}" required />
                            </div>

                            <div class="col-md-4">
                                <label for="email">Email *</label>
                                <input class="form-control" type="email" name="email" readonly value="{{Auth::user()->email}}" required />
                            </div>
                            <div class="col-md-4">
                                <label for="password">City *</label>
                                <input class="form-control" type="text" name="city"/value="{{Auth::user()->city}}" required />
                            </div>
                            <div class="col-md-4">
                                <label for="password">State *</label>
                                <input class="form-control" type="text" name="state" value="{{Auth::user()->state}}" required/>
                            </div>
                            <div class="col-md-4">
                                <label for="ac_name" class="col-form-label text-md-end">{{ __('A/C Holder Name') }}</label>
                                <input id="ac_name" type="text" class="form-control @error('ac_name') is-invalid @enderror" name="ac_name" value="{{ Auth::user()->ac_name }}" required autocomplete="ac_name" autofocus>
                            </div>

                            <div class="col-md-4">
                                <label for="A/C NO" class="col-form-label text-md-end">{{ __('A/C Number') }}</label>
                                <input id="ac_no" type="text" class="form-control @error('ac_no') is-invalid @enderror" name="ac_no" value="{{ Auth::user()->ac_no }}" required autocomplete="ac_no" autofocus>
                            </div>
                            <div class="col-md-4">
                                <label for="IFSC Code" class="col-form-label text-md-end">{{ __('IFSC Code') }}</label>
                                <input id="ac_ifsc" type="text" class="form-control @error('ac_ifsc') is-invalid @enderror" name="ac_ifsc" value="{{ Auth::user()->ac_ifsc }}" required autocomplete="ac_ifsc" autofocus>
                            </div>
                            <div class="col-md-12">
                                <label for="Bank Name" class="col-form-label text-md-end">{{ __('Bank Name') }}</label>
                                <input id="bank" type="text" class="form-control @error('bank') is-invalid @enderror" name="bank" value="{{ Auth::user()->bank }}" required autocomplete="bank" autofocus>
                            </div>
                        </div>
                        <div class="text-right">
                            <button type="submit" class="btn btn-warning px-5">Save</button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
    <!-- =========================== and payment models -->
    <!-- jquery vendor -->
    <script src="{{asset('/')}}assets/js/lib/jquery.min.js"></script>
    <script src="{{asset('/')}}assets/js/lib/jquery.nanoscroller.min.js"></script>
    <!-- nano scroller -->
    <script src="{{asset('/')}}assets/js/lib/menubar/sidebar.js"></script>
    <script src="{{asset('/')}}assets/js/lib/preloader/pace.min.js"></script>
    <!-- sidebar -->

    <!-- bootstrap -->

    <script src="{{asset('/')}}assets/js/lib/bootstrap.min.js"></script>

    <!-- scripit init-->
    <script src="{{asset('/')}}assets/js/lib/data-table/datatables.min.js"></script>
    <script src="{{asset('/')}}assets/js/lib/data-table/dataTables.buttons.min.js"></script>
    <script src="{{asset('/')}}assets/js/lib/data-table/jszip.min.js"></script>
    <script src="{{asset('/')}}assets/js/lib/data-table/pdfmake.min.js"></script>
    <script src="{{asset('/')}}assets/js/lib/data-table/vfs_fonts.js"></script>
    <script src="{{asset('/')}}assets/js/lib/data-table/buttons.html5.min.js"></script>
    <script src="{{asset('/')}}assets/js/lib/data-table/buttons.print.min.js"></script>
    <script src="{{asset('/')}}assets/js/lib/data-table/buttons.colVis.min.js"></script>
    <script src="{{asset('/')}}assets/js/lib/data-table/datatables-init.js"></script>
    <script>
        $('.dataTables_wrapper').removeClass('form-inline');
    </script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10/dist/sweetalert2.min.css" id="theme-styles">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10/dist/sweetalert2.min.js"></script>

@yield('script')
    {{ csrf_field() }}
    @if(Session::has('status'))
    <script>
        $(function () {
            Swal.fire(
            'Success Message',
            '{{Session::get('status')}}',
            'success');
        });
    </script>
    @endif
    @if(Session::has('error'))
    <script>
        $(function () {
            Swal.fire(
            'Error Message',
            '{{Session::get('error')}}',
            'error');
        });
    </script>
    @endif
</body>

</html>
