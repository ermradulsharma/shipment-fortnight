@extends('layouts.backend')

@section('content')
<style>
.razorpay-payment-button {
    padding: 10px 3em;
    background: green;
    margin: 1em;
    color: white;
    border-radius: 5px;
    font-size: 20px;
    cursor: pointer;
}
</style>
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <div class="user-profile">
                    <div class="row">
                        <div class="col-lg-2">
                            <div class="user-photo m-b-30">
                                <div class="card text-center bg-danger">
                                    <div class="stat-widget-one">
                                        <div class="stat-icon dib">
                                            <i class="ti-wallet color-white border-white"></i>
                                        </div>
                                        <div class="stat-content dib" style="margin-left: 0px;">
                                            <div class="stat-text text-white">Wallet Points</div>
                                            <div class="stat-digit text-white">{{$user->points}}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="user-photo m-b-30">
                                <div class="card text-center bg-primary">
                                    <div class="stat-widget-one">
                                        <div class="stat-icon dib">
                                            <i class="ti-shopping-cart color-white border-white"></i>
                                        </div>
                                        <div class="stat-content dib" style="margin-left: 0px;">
                                            <div class="stat-text text-white">Total O. F. D.</div>
                                            <div class="stat-digit text-white">
                                                {{$user->orders->where('status',3)->count()}}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="user-photo m-b-30">
                                <div class="card text-center bg-success">
                                    <div class="stat-widget-one">
                                        <div class="stat-icon dib">
                                            <i class="ti-shopping-cart color-white border-white"></i>
                                        </div>
                                        <div class="stat-content dib" style="margin-left: 0px;">
                                            <div class="stat-text text-white">Rimmit AMOUNT</div>
                                            <div class="stat-digit text-white">{{$user->payment->amount ?? 0}}</div>
                                            <div class="text-white">@if(@$user->payment->date) Date - {{date('d-m-Y',strtotime($user->payment->date)) ?? ''}} @endif</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
<!--
                            <div class="user-photo m-b-30">
                                <div class="card text-center bg-danger">
                                    <div class="stat-widget-one">
                                        <div class="stat-icon dib">
                                            <i class="ti-shopping-cart color-white border-white"></i>
                                        </div>
                                        <div class="stat-content dib" style="margin-left: 0px;">
                                            <div class="stat-text text-white">PAY AMOUNT</div>
                                            <div class="stat-digit text-white">{{$user->orders->where('status','4')->where('paymenttype','COD')->sum('price')-$user->remittances->where('status','Complete')->sum('amount')}}</div>
                                        </div>
                                    </div>
                                </div>
                            </div> -->
                        </div>
                        <div class="col-lg-2">
                            <div class="user-photo m-b-30">
                                <div class="card text-center bg-warning">
                                    <div class="stat-widget-one">
                                        <div class="stat-icon dib">
                                            <i class="ti-shopping-cart color-white border-white"></i>
                                        </div>
                                        <div class="stat-content dib" style="margin-left: 0px;">
                                            <div class="stat-text text-white">Total Order</div>
                                            <div class="stat-digit text-white">{{$user->orders->count()}}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="user-photo m-b-30">
                                <div class="card text-center bg-success">
                                    <div class="stat-widget-one">
                                        <div class="stat-icon dib">
                                            <i class="ti-shopping-cart color-white border-white"></i>
                                        </div>
                                        <div class="stat-content dib" style="margin-left: 0px;">
                                            <div class="stat-text text-white">Total Complete</div>
                                            <div class="stat-digit text-white">
                                                {{$user->orders->where('status',4)->count()}}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- <div class="user-photo m-b-30">
                                <div class="card text-center bg-primary">
                                    <div class="stat-widget-one">
                                        <div class="stat-icon dib">
                                            <i class="ti-shopping-cart color-white border-white"></i>
                                        </div>
                                        <div class="stat-content dib" style="margin-left: 0px;">
                                            <div class="stat-text text-white">Remit AMOUNT</div>
                                            <div class="stat-digit text-white">{{$user->remittances->where('status','Complete')->sum('amount')}}</div>
                                        </div>
                                    </div>
                                </div>
                            </div> -->
                        </div>

                        <div class="col-lg-8 pt-3" style="border-left:1px solid lightgray;">
                            <div class="user-profile-name">{{$user->name}}  &nbsp;&nbsp;<a href="#" data-toggle="modal" data-target="#editprofilemodel"><i class="ti-pencil-alt"></i>&nbsp; Edit Profile</a></div>
                            <div class="pull-right">
                                @if(session('payamount'))
                                    <form action="{{ route('payment.store') }}" method="POST">
                                        @csrf
                                        <script src="https://checkout.razorpay.com/v1/checkout.js"
                                            data-key="{{ Config::get('custom.razor_key') }}" 
                                            data-amount="{{session('payamount')*100}}"
                                            data-buttontext="Pay {{session('payamount')}} INR" 
                                            data-name="Merashiping"
                                            data-description="Shipping Parcel"
                                            data-prefill.name="{{Auth::user()->name}}" 
                                            data-prefill.email="{{Auth::user()->email}}"
                                            data-theme.color="#ff7529">
                                        </script>
                                    </form>
                                @endif
                            </div>
                            <div class="custom-tab user-profile-tab">
                                <ul class="nav nav-tabs" role="tablist">
                                    <li role="presentation" class="active pb-2">
                                        <a >About</a>
                                    </li>
                                </ul>
                                <div class="tab-content pl-3">
                                    <div role="tabpanel" class="tab-pane active" id="1">
                                        <div class="contact-information">
                                            <h4>Contact information</h4>
                                            <div class="phone-content">
                                                <span class="contact-title">Phone:</span>
                                                <span class="phone-number">{{$user->phone}}</span>
                                            </div>
                                            <div class="address-content">
                                                <span class="contact-title">Address:</span>
                                                <span class="mail-address">{{$user->address}}, {{$user->city}},
                                                    {{$user->state}}, {{$user->pin}}</span>
                                            </div>
                                            <div class="email-content">
                                                <span class="contact-title">Email:</span>
                                                <span class="contact-email">{{$user->email}}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-content pl-3">
                                    <div role="tabpanel" class="tab-pane active" id="1">
                                        <div class="contact-information">
                                            <h4>A/C information</h4>
                                            <div class="phone-content">
                                                <span class="contact-title">A/C Name:</span>
                                                <span class="phone-number">{{$user->ac_name}}</span>
                                            </div>
                                            <div class="address-content">
                                                <span class="contact-title">A/C No:</span>
                                                <span class="mail-address">{{$user->ac_no}}</span>
                                            </div>
                                            <div class="email-content">
                                                <span class="contact-title">IFSC:</span>
                                                <span class="contact-email">{{$user->ac_ifsc}}</span>
                                            </div>
                                            <div class="email-content">
                                                <span class="contact-title">Bank:</span>
                                                <span class="contact-email">{{$user->bank}}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <ul class="nav nav-tabs mb-4" role="tablist">
                                    <li role="presentation" class="active pb-2">
                                        <a href="#1">Change Password</a>
                                    </li>
                                </ul>

                                <form class="pl-3" action="{{route('user.changepassword')}}" method="post">
                                    @csrf
                                    <div class="form-group row">
                                        <div class="col-md-5">
                                            <input class="form-control" type="password" name="password" id="password" placeholder="Password *"/>
                                        </div>

                                        <div class="col-md-5">
                                            <input class="form-control" type="password" name="password_confirmation" placeholder="Confirm Password *"
                                                id="password_confirmation" />
                                        </div>
                                        <div class="col-md-2">
                                            <button type="submit" class="btn btn-primary btn-block">Save</button>
                                        </div>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
                <hr/>
                <div class="bootstrap-data-table-panel">
                    <div>
                        <table id="row-select" class="mb-4 table table-borderd">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Date</th>
                                    <th>Transaction Id</th>
                                    <th class="text-left">Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($transactions as $transaction)
                                    <tr>
                                        <td>{{$transaction->id}}</td>
                                        <td>{{$transaction->user->name}}</td>
                                        <td>{{date('d-m-Y, H:i:s',strtotime($transaction->created_at))}}</td>
                                        <td>{{$transaction->transactionid}}</td>
                                        <td class="text-left">{{$transaction->amount}}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
