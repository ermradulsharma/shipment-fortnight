@extends('layouts.backend')

@section('content')

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-title">
                <h4>New Order</h4>
                <div class="pull-right">
                    <a href="{{route('order.index')}}" class="btn btn-primary">Back</a>
                </div>
            </div>
            <hr/>
            <form action="{{route('order.update',$order->id)}}" method="post">
                <input type="hidden" name="_method" value="PUT">
                @csrf
                    <div class="card-body">
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
                        <div class="form-group row">
                            <div class="col-md-4">
                                <label for="name">Name  *</label>
                                <input class="form-control" type="text" name="name" value="{{$order->name}}" required/>
                            </div>
                            <div class="col-md-4">
                                <label for="phone">Phone *</label>
                                <input class="form-control" type="number" name="phone" value="{{$order->phone}}" required/>
                            </div>
                            <div class="col-md-4">
                                <label for="name">Amount *</label>
                                <input class="form-control" type="number" name="price" value="{{$order->price}}" required/>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-4">
                                <label for="Zip">Zip *</label>
                                <input class="form-control" type="number" name="pin" value="{{$order->pin}}" id="pincodekeyup" required/>
                                <p id="pincode_exists"></p>
                            </div>
                    
                            <div class="col-md-8">
                                <label for="name">Address *</label>
                                <input class="form-control" type="text" name="address" value="{{$order->address}}" required/>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-4">
                                <label for="City">City *</label>
                                <input class="form-control" type="text" name="city" value="{{$order->city}}" required/>
                            </div>
                        
                            <div class="col-md-4">
                                <label for="State">State *</label>
                                <input class="form-control" type="text" name="state" value="{{$order->state}}" required/>
                            </div>
                            <div class="col-md-4">
                                <label for="Country">Country *</label>
                                <input class="form-control" type="text" name="country" value="{{$order->country}}" required/>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-4">
                                <label for="weight">Weight (in grams) *</label>
                                <input class="form-control" type="number" name="weight" value="{{$order->weight}}" required/>
                            </div>
                        
                            <div class="col-md-4">
                                <label for="paymenttype">Payment Mode *</label>
                                <select class="form-control" type="text" name="paymenttype" id="" required/>
                                    <option value="COD" {{$order->weight=='COD'? 'selected':''}}>COD</option>
                                    <option value="Prepaid" {{$order->weight=='Prepaid'? 'selected':''}}>Prepaid</option>
                                    <option value="Pickup" {{$order->weight=='Pickup'? 'selected':''}}>Pickup</option>
                                    <option value="REPL" {{$order->weight=='REPL'? 'selected':''}}>REPL</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="name">Package Type *</label>
                                <select class="form-control" name="packagetype" required/>
                                    <option disabled=""></option>
                                    <option value="Delivered" {{$order->packagetype=='Delivered' ? 'selected' : ''}}>Forward (Delivered)</option>
                                    <option value="RTO" {{$order->packagetype=='RTO' ? 'selected' : ''}}>Return (RTO)</option>
                                    <option value="DTO" {{$order->packagetype=='DTO' ? 'selected' : ''}}>Reverse (DTO)</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-3">
                                <label for="quantity">Quantity *</label>
                                <input class="form-control" type="text" name="quantity"  value="{{$order->quantity}}" id="" required/>
                            </div>
                            <div class="col-md-3">
                                <label for="length">Length (CM)*</label>
                                <input class="form-control" type="number" name="length"  value="{{$order->length}}" id="" required/>
                            </div>
                        
                            <div class="col-md-3">
                                <label for="breadth">Breadth (CM)*</label>
                                <input class="form-control" type="number" name="breadth"  value="{{$order->breadth}}" id="" required/>
                            </div>
                            <div class="col-md-3">
                                <label for="height">Height (CM)*</label>
                                <input class="form-control" type="number" name="height"  value="{{$order->height}}" id="" required/>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-12">
                                <label for="password">Product Description <span class="text-danger">( Min 20 letter )</span> *</label>
                                <input class="form-control" type="text" name="products_desc" value="{{$order->products_desc}}" required/>
                            </div>
                        </div>
                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary px-5">Save</button>
                    </div>
                </form>
        </div>
        <!-- /# card -->
    </div>
    <!-- /# column -->
</div>

@endsection

@section('script')
<script>
    $(document).ready(function() {
        $('#pincodekeyup').keyup(function(){
             var pincode = $(this).val();
             var token = $("input[name=_token]").val();
             if(pincode.length==6)
             {
                $.get("{{route('pincode.index')}}?pincode="+pincode,
                function(data){
                    if(data!='error'){
                        $("#pincode_exists").html("<div class='text-success'><b>Delivery Available.</b></div>");
                    }else if(data=='error'){
                        $("#pincode_exists").html("<div class='text-danger'><b>PINCODE NOT FOUND.</b></div>");
                    }
                });
             }else{
                 $("#pincode_exists").html("<div class='text-danger'><b>wrong pincode.</b></div>");
             }
        });
    });
</script>
@endsection
