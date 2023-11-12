@extends('layouts.backend')

@section('content')

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-title">
                <h4>Transaction History</h4>
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
                                <th>Amount</th>
                                <th>Image</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($payments as $payment)
                            <tr>
                                <td>{{$payment->id}}</td>
                                <td>{{$payment->user->name ?? ""}}</td>
                                <td>{{$payment->user->phone ?? ""}}</td>
                                <td>{{$payment->amount}}</td>
                                <td><a href="{{$payment->image}}" target="_blank"><img src="{{$payment->image}}" width="100px"/></a></td>
                                <td class="text-center">
                                    <div class="btn-group">
                                        @if($payment->status==0)
                                            @if(Auth::user()->roleid==1)
                                                <a href="javascript:void(0);" class="btn btn-warning btn-sm paymentVerify" data-id="{{$payment->id}}" data-amount="{{$payment->amount}}">Verify</a>
                                            @else
                                                <a href="javascript:void(0);" class="btn btn-primary btn-sm">Pending</a>
                                            @endif
                                        @else
                                            <a href="javascript:void(0);" class="btn btn-success btn-sm">Verified</a>
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

    <div class="modal" id="paymentVerifyModel">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header bg-warning">
                    <h4 class="modal-title">Verify Amount</h4>
                    <button type="button" class="close pull-right" data-dismiss="modal">X</button>
                </div>

                <!-- Modal body -->
                <form class="verifyPaymentForm" action="" method="post">
                     <input type="hidden" name="_method" value="PUT">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group row">
                            <div class="col-md-12">
                                <label for="name">Amount</label>
                                <input class="form-control" type="number" name="amount" id="verifyAmount" />
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
        $('.paymentVerify').click(function(){
            var id = $(this).data('id');
            var amount = $(this).data('amount');
            $('#verifyAmount').val(amount);
            var url = "{{route('payment.index')}}/"+id;
            $('.verifyPaymentForm').attr('action', url);
            $('#paymentVerifyModel').modal('show');
        });
    </script>
@endsection