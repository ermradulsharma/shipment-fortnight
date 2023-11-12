@extends('layouts.backend')

@section('content')

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-title">
                <h4>Order Details</h4>
                <div class="pull-right">
                    <div class="btn-group">
                        <a href="{{route('order.index')}}" class="btn btn-info px-4">back</a>
                        <a href="{{route('order.create')}}" class="btn btn-success px-4">Add New</a>
                        @if($order->trackingNo)
                        <a href="{{url('orderprint/'.$order->id)}}" class="btn btn-primary px-4">Print</a>
                        @else
                        <a href="{{route('order.edit',$order->id)}}" class="btn btn-warning px-4">Edit</a>
                        <button type="button" class="btn btn-danger px-4" onClick="if(confirm('Are you sure you want to delete this ??.')){
                            document.getElementById('deleteForm_{{$order->id}}').submit();
                        }"
                        >Delete</button>
                        <form id="deleteForm_{{$order->id}}" action="{{route('order.destroy',$order->id)}}" method="post">
                            <input type="hidden" name="_method" value="DELETE">
                            @csrf
                        </form>
                        @endif
                    </div>
                </div>
            </div>
            <hr/>
            <div class="bootstrap-data-table-panel my-5">
                <div class="table-responsive">
                    <table class="table table-borderd">
                        <thead style="border-top:1px solid gray;">
                            <tr>
                                <th>Order ID</th>
                                <th>Date</th>
                                <th>Name</th>
                                <th>Phone</th>
                                <th>Amount</th>
                                <th class="text-left">Zip</th>
                            </tr>
                        </thead>
                        <tbody style="border-top:1px solid gray;">
                            <tr>
                                <th>#{{$order->orderid}}</th>
                                <th>{{date('d-m-Y, H:i:s',strtotime($order->created_at))}}</th>
                                <th>{{$order->name}}</th>
                                <th>{{$order->phone}}</th>
                                <th>₹{{$order->price}}</th>
                                <th class="text-left">{{$order->pin}}</th>
                            </tr>
                        <tbody>
                        <thead style="border-top:1px solid gray;">
                            <tr>
                                <th>City</th>
                                <th>State</th>
                                <th>Country</th>
                                <th class="text-left" colspan="3">Address</th>
                            </tr>
                        </thead>
                        <tbody style="border-top:1px solid gray;">
                            <tr>
                                <th>{{$order->city}}</th>
                                <th>{{$order->state}}</th>
                                <th>{{$order->country}}</th>
                                <td class="text-left" colspan="3">{{$order->address}}</td>
                            </tr>
                        </thead>
                        <thead style="border-bottom:1px solid gray;">
                            <tr>
                                <th>manifested at</th>
                                <th>Tracking No</th>
                                <th>Shipping Charge</th>
                                <th>Payment Mode</th>
                                <th>Weight</th>
                                <th  class="text-left">Description</th>
                            </tr> 
                            <tr> 
                                <td>{{$order->manifested_at!=''? date('d-m-Y,H:i:s',strtotime($order->manifested_at)): ''}}</td>
                                @php $service = $order->sendBy == 'Dehlivery'?'delhivery':'ecom_express'; @endphp
                                <td><a href="{{url('/'.$service.'/get_status/'.$order->trackingNo)}}">{{$order->trackingNo}}</a></td>
                                <td>{{$order->shipingcost}}</td>
                                <td>{{$order->paymenttype}}</td>
                                <td>{{$order->weight}}</td>
                                <td class="text-left" colspan="2">{{$order->products_desc}}</td>
                            </tr>
                        </thead>
                        <thead style="border-top:1px solid gray;">
                            <tr>
                                <th>Quantity</th>
                                <th>Height</th>
                                <th>Length</th>
                                <th colspan="3" class="text-left">Breadth</th>
                            </tr>
                        </thead>
                        <tbody style="border-top:1px solid gray;">
                            <tr>
                                <th>{{$order->quantity}}</th>
                                <th>{{$order->height}}</th>
                                <th>{{$order->length}}</th>
                                <td colspan="3" class="text-left">{{$order->breadth}}</td>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
        <!-- /# card -->
    </div>
    <!-- /# column -->
</div>

@endsection
