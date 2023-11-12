@extends('layouts.backend')

@section('content')

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-title">
                <h4>Customer </h4>
            </div>
            <hr/>
            @if ($errors->any())
                <div class="alert alert-danger">
                    <button type="button" class="close" data-dismiss="alert">X</button>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="bootstrap-data-table-panel">
                <div class="table-responsive">
                    <table id="row-select-1" class="mb-4 table table-borderd">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Phone</th>
                                <th>Email</th>
                                <th>Points</th>
                                <th>Estimated Amount</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($customers as $user)
                            <tr>
                                <td>{{$user->id}}</td>
                                <td>{{$user->name}}</td>
                                <td>{{$user->phone}}</td>
                                <td>{{$user->email}}</td>
                                <td>{{$user->points}}</td>
                                <td>{{@$user->payment->amount ?? 0}}</td>
                                <td class="text-center">
                                    <div class="btn-group">
                                        <a href="#" class="btn btn-danger btn-sm setPayment" data-id="{{$user->id}}">Set Payment</a>
                                        <a href="{{url('profile/'.$user->id)}}" class="btn btn-info btn-sm">View</a>
                                        @if(Auth::user()->roleid==1)
                                            <button type="button" class="btn btn-primary btn-sm remittance" data-remittance="{{$user->remittance}}" data-id="{{$user->id}}">Remittance</button>
                                            <button type="button" class="btn btn-warning btn-sm shppingcharge" data-id="{{$user->id}}" title="shipping charge">Charge</button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- /# card -->
    </div>
    <!-- /# column -->
</div>

@endsection

@section('models')
    
    <!--Add remittance Model -->

    <div class="modal" id="remittancemodel">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header bg-warning">
                    <h4 class="modal-title">Remittance</h4>
                    <button type="button" class="close" data-dismiss="modal">X</button>
                </div>

                <!-- Modal body -->
                <form id="remittanceform" action="" method="post">
                    @csrf
                    
                    <div class="modal-body">
                        <div class="form-group row">
                            <div class="col-md-12">
                                <label for="password">Transaction Id *</label>
                                <input class="form-control" type="text" name="transactionid" id="" />
                            </div>
                            <div class="col-md-12">
                                <label for="password">Amount *</label>
                                <input class="form-control" type="text" name="amount" id="remittanceid" />
                            </div>
                        </div>
                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary px-5">Save</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
    
    <!--Add user Model -->

    <div class="modal" id="shippingchargemodel">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header bg-warning">
                    <h4 class="modal-title">Shipping Charge</h4>
                    <button type="button" class="close" data-dismiss="modal">X</button>
                </div>

                <!-- Modal body -->
                <form id="shppingchargeform" action="" method="post">
                    @csrf
                    
                    <div class="modal-body">
                        <div class="form-group row">
                            <div class="col-md-12">
                                <label for="password">Amount *</label>
                                <input class="form-control" type="text" name="amount"/>
                            </div>
                        </div>
                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary px-5">Save</button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <div class="modal" id="PaymentSet">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header bg-warning">
                    <h4 class="modal-title">Edit User</h4>
                    <button type="button" class="close" data-dismiss="modal">X</button>
                </div>

                <!-- Modal body -->
                <form id="FromPaymentSet" action="" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group row">
                            <div class="col-md-6">
                                <label for="name">Amount</label>
                                <input class="form-control" type="text" name="amount" id="amount" />
                            </div>
                            <div class="col-md-6">
                                <label for="name">Date</label>
                                <input class="form-control" type="date" name="date" id="date" />
                            </div>
                        </div>
                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary px-5">Save</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function(){
                $('.remittance').click(function(){
                    var post_url = "{{route('remittance.store')}}?userid="+$(this).data('id');
                    var remittanceid = $(this).data('remittance');
                    $('#remittanceid').val(remittanceid);
                    $('#remittanceform').attr('action',post_url);
                    $('#remittancemodel').modal('show');
                });
                
                $('.shppingcharge').click(function(){
                    var post_url = "{{route('shppingcharge')}}?userid="+$(this).data('id');
                    $('#shppingchargeform').attr('action',post_url);
                    $('#shippingchargemodel').modal('show');
                });

                $('.setPayment').click(function(){
                    var id = $(this).data('id');
                    var post_url = "{{route('setPayment.store')}}?user_id="+id;
                    $('#FromPaymentSet').attr('action',post_url);
                    $('#PaymentSet').modal('show');
                });
            });
    </script>
@endsection