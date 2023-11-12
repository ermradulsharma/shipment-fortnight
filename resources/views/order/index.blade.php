@extends('layouts.backend')

@section('content')

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-title">
                <h4>Order </h4>
                <div class="pull-right">
                    <a href="{{route('order.create')}}" class="btn btn-success">Add New</a>
                </div>
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

            <div>
                <form action="" method="get">
                    <input type="hidden" value="{{$status}}" name="status" />
                    <div class="row">
                        <div class="col-md-3">
                            <select class="form-control" name="userid">
                                <option value=""></option>
                                @foreach($users as $user)
                                    <option value="{{$user->id}}" {{ $user->id == $userid ? 'selected' : '' }}>{{$user->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <input type="date" class="form-control" name="start" value="{{$start}}" />
                        </div>
                        <div class="col-md-2">
                            <input type="date" class="form-control" name="end" value="{{$end}}" />
                        </div>
                        <div class="col-md-2">
                            <button class="btn btn-primary btn-block"><i class="fa fa-search"></i> Search</button>
                        </div>
                    </div>
                </form>
            </div>

            <div class="bootstrap-data-table-panel">
                <div class="table-responsive">
                    <table id="row-select" class="mb-4 table table-borderd">
                        <thead>
                            <tr>
                                <th>ID</th>
                                @if(Auth::user()->roleid==1)
                                <th>Seller</th>
                                @endif
                                <th>Order ID</th>
                                <th>Date</th>
                                <th>Name</th>
                                <th>Phone</th>
                                <th>Amount</th>
                                <th>Zip</th>
                                <th>Tracking No</th>
                                <th>Charge</th>
                                <th>Mode</th>
                                <th>Status</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($orders as $key => $order)
                            <tr>
                                <td>{{$key+1}}</td>
                                @if(Auth::user()->roleid==1)
                                    <td>{{@$order->user->name}}</td>
                                @endif
                                <td>#{{$order->orderid}}</td>
                                <td>{{date('d-m-Y, H:i:s',strtotime($order->created_at))}}</td>
                                <td>{{$order->name}}</td>
                                <td>{{$order->phone}}</td>
                                <td>{{$order->price}}</td>
                                <td>{{$order->pin}}</td>
                                @php $service = $order->sendBy == 'Dehlivery'?'delhivery':'ecom_express'; @endphp
                                <td><a href="{{url('/'.$service.'/get_status/'.$order->trackingNo)}}">{{$order->trackingNo}}</a></td>
                                <td>{{$order->shipingcost}}</td>
                                <td>{{$order->paymenttype}}</td>
                                <td>{!!$order->status == 1 ? '<span class="btn btn-info btn-sm">New</span>' : '' !!} {!!$order->status == 2 ? '<span class="btn btn-warning btn-sm">In-Transit</span>' : '' !!} {!!$order->status == 3 ? '<span class="btn btn-primary sm">OFD</span>' : '' !!} {!! $order->status == 4 ? '<span class="btn btn-success btn-sm">Delivered</span>' : '' !!} {!! $order->status == 5 ? '<span class="btn btn-danger btn-sm">Return</span>' : ''!!}</td>
                                <td class="text-center">
                                    <div class="btn-group">
                                        <a href="{{route('order.show',$order->id)}}" class="btn btn-info btn-sm">Show</a>
                                        @if($order->trackingNo)
                                            <a href="{{url('orderprint/'.$order->id)}}" class="btn btn-success btn-sm">Print</a>
                                            @php $service = $order->sendBy == 'Dehlivery'?'delhivery':'ecom_express'; @endphp
                                            {{-- <button type="button" class="btn btn-danger btn-sm" onClick="if(confirm('Are you sure you want to cancel this?.')){
                                            document.getElementById('cancelForm_{{$order->id}}').submit();
                                        }">Cancel</button> --}}
                                        <form id="cancelForm_{{$order->id}}" action="{{url('/'.$service.'/cancel/'.$order->trackingNo)}}" method="post">
                                            @csrf
                                        </form>
                                        @else
                                        <button type="button" class="btn btn-primary btn-sm sendOrder" data-id="{{$order->id}}">send</button>
                                        <a href="{{route('order.edit',$order->id)}}" class="btn btn-warning btn-sm">Edit</a>
                                        <button type="button" class="btn btn-danger btn-sm" onClick="if(confirm('Are you sure you want to delete this?.')){
                                            document.getElementById('deleteForm_{{$order->id}}').submit();
                                        }">Delete</button>
                                        <form id="deleteForm_{{$order->id}}" action="{{route('order.destroy',$order->id)}}" method="post">
                                            <input type="hidden" name="_method" value="DELETE">
                                            @csrf
                                        </form>
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

    <!--Add role Model -->

    <div class="modal" id="sendOrderModel">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="pull-right pr-3 pt-3">
                    <button type="button" class="close" data-dismiss="modal">X</button>
                </div>
                <!-- Modal body -->
                <form id="SendOrderFormId" action="" method="post">
                <input type="hidden" name="dehliveryCharge" id="dehliveryCharge">
                <input type="hidden" name="ecomeCharge" id="ecomeCharge">
                @csrf
                    <div class="modal-body">
                        <div class="form-group row alert alert-warning dehliveryDiv">
                            <div class="col-md-12">
                                <p class="d-flex mb-0 text-dark">
                                    <input class="mr-2" type="radio" name="sendBy" id="" value="Dehlivery" style="width:25px; height:25px;" required>
                                    Send By Dehlivery in&nbsp; &#X20B9;<span class="deliveyPrice"></span>
                                </p>
                            </div>
                        </div>
                        <div class="form-group row alert alert-warning ecomeDiv">
                            <div class="col-md-12">
                                <p class="d-flex mb-0 text-dark">
                                    <input class="mr-2" type="radio" name="sendBy" id="" value="Ecome" style="width:25px; height:25px;" required>
                                    Send By Ecome in&nbsp; &#X20B9;<span class="ecomePrice"></span>
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary px-5">Send Order</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function(){
            $('.sendOrder').click(function(){
                var id = $(this).data('id');
                $.ajax({url: '{{route("calculationEcome")}}?orderId='+id, success: function(result){
                    if(result.ecome != null){
                        $('#ecomeCharge').val(result.ecome);
                        $('.ecomePrice').html(result.ecome);
                        $('.ecomeDiv').show();
                    }else{
                        $('.ecomeDiv').hide();
                    }

                    if(result.dehlivery != null){
                        $('#dehliveryCharge').val(result.dehlivery);
                        $('.deliveyPrice').html(result.dehlivery);
                        $('.dehliveryDiv').show();
                    }else{
                        $('.dehliveryDiv').hide();
                    }
                    $('#sendOrderModel').modal('show');
                    $('#SendOrderFormId').attr('action', '{{url('orderstatus')}}/'+id);
                }});
            });
        });
    </script>
@endsection
