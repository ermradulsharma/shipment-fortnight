@extends('layouts.backend')

@section('content')

                <div class="row">
                    <div class="col-lg-8 p-r-0 title-margin-right">
                        <div class="page-header">
                            <div class="page-title">
                                <h1>Hello {{Auth::user()->name}}, <span>Welcome Here</span></h1>
                            </div>
                        </div>
                    </div>
                    <!-- /# column -->
                    <div class="col-lg-4 p-l-0 title-margin-left">
                        <div class="page-header">
                            <div class="page-title">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                                    <li class="breadcrumb-item active">Home</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                    <!-- /# column -->
                </div>
                <!-- /# row -->
                <section id="main-content">
                    <div class="row">
                        @if(Auth::user()->wharehouse==1)
                        <div class="col-lg-12 mb-5">
                            <div class="card">
                                <div class="stat-widget-one">
                                    <div class="stat-icon dib"><i class="ti-pencil-alt color-danger border-danger"></i> </div>
                                    <div class="stat-content dib">
                                        <div class="stat-digit text-danger">Please First update your profile &nbsp;&nbsp;
                                            <a href="#" class="stat-text" data-toggle="modal" data-target="#editprofilemodel">&nbsp;&nbsp;<i class="ti-user"></i> &nbsp;&nbsp;Update Profile</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="stat-widget-one">
                                    <div class="stat-icon dib"><i class="ti-view-grid color-danger border-danger"></i> </div>
                                    <div class="stat-content dib">
                                        <div class="stat-digit text-danger">Please Create Our Wharehouse for shiping orders &nbsp;&nbsp;
                                            <a class="stat-text" href="#" onClick="if(confirm('Are you sure you want to create WhareHouse ?')){ document.getElementById('createWharehouse').submit();}"> &nbsp;&nbsp;<i class="ti-alarm-clock"></i>&nbsp;&nbsp;Create WhareHouse</a>
                                            <form id="createWharehouse" action="{{route('createWharehouse')}}" method="post" class="hidden">
                                                @csrf
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                    @if(Auth::user()->roleid!=2)
                        <div class="card bootstrap-data-table-panel">
                        <div classs="card-title">
                            All Queries
                        </div>
                        <hr/>
                        <div class="card-body table-responsive">
                            <table id="row-select" class="mb-4 table table-borderd">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Phone</th>
                                        <th>Email</th>
                                        <th>Subject</th>
                                        <th>Message</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($queries as $user)
                                    <tr>
                                        <td>{{$user->name}}</td>
                                        <td>{{$user->phone}}</td>
                                        <td>{{$user->email}}</td>
                                        <td>{{$user->subject}}</td>
                                        <td>{{$user->message}}</td>
                                        <td class="text-center">
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-danger btn-sm" onClick="if(confirm('Are you sure you want to delete this ??.')){
                                                    document.getElementById('contactfomtId').submit();
                                                }"
                                                >Delete</button>
                                                <form id="contactfomtId" action="{{url('contact/'.$user->id)}}" method="post">
                                                    @csrf
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @endif
                </section>
                
@endsection