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
            <form action="{{route('order.store')}}" method="post">
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
                                <input class="form-control" type="text" name="name" id="" required/>
                            </div>
                            <div class="col-md-4">
                                <label for="phone">Phone *</label>
                                <input class="form-control" type="number" name="phone" id="" required/>
                            </div>
                            <div class="col-md-4">
                                <label for="name">Amount *</label>
                                <input class="form-control" type="number" name="price" id="" required/>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-4">
                                <label for="Zip">Zip *</label>
                                <input class="form-control pincodekeyup" type="number" name="pin" id="" required/>
                                <p id="pincode_exists"></p>
                            </div>
                    
                            <div class="col-md-8">
                                <label for="name">Address *</label>
                                <input class="form-control" type="text" name="address" id="" required/>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-4">
                                <label for="City">City *</label>
                                <input class="form-control" type="text" name="city" id="" required/>
                            </div>
                        
                            <div class="col-md-4">
                                <label for="State">State *</label>
                                <input class="form-control" type="text" name="state" id="" required/>
                            </div>
                            <div class="col-md-4">
                                <label for="Country">Country *</label>
                                <input class="form-control" type="text" name="country" value="india" id="" required/>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-4">
                                <label for="weight">Weight (in grams) *</label>
                                <input class="form-control" type="number" name="weight" id="" required/>
                            </div>
                        
                            <div class="col-md-4">
                                <label for="paymenttype">Payment Mode *</label>
                                <select class="form-control" type="text" name="paymenttype" id="" required/>
                                    <option value="COD">COD</option>
                                    <option value="Prepaid">Prepaid</option>
                                    <option value="Pickup">Pickup</option>
                                    <option value="REPL">REPL</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="name">Package Type *</label>
                                <select class="form-control" name="packagetype" required/>
                                    <option disabled=""></option>
                                    <option value="Delivered" {{old('packagetype')=='Delivered' ? 'selected' : ''}}>Forward (Delivered)</option>
                                    <option value="RTO" {{old('packagetype')=='RTO' ? 'selected' : ''}}>Return (RTO)</option>
                                    <option value="DTO" {{old('packagetype')=='DTO' ? 'selected' : ''}}>Reverse (DTO)</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-3">
                                <label for="quantity">Quantity *</label>
                                <input class="form-control" type="text" name="quantity" value="1" required/>
                            </div>
                            <div class="col-md-3">
                                <label for="length">Length (CM)*</label>
                                <input class="form-control" type="number" name="length" id="" required/>
                            </div>
                        
                            <div class="col-md-3">
                                <label for="breadth">Breadth (CM)*</label>
                                <input class="form-control" type="number" name="breadth" id="" required/>
                            </div>
                            <div class="col-md-3">
                                <label for="height">Height (CM)*</label>
                                <input class="form-control" type="number" name="height" id="" required/>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-12">
                                <label for="password">Product Description <span class="text-danger">( Min 10 letter )</span> *</label>
                                <input class="form-control" type="text" name="products_desc" id="" required/>
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
        $('.pincodekeyup').keyup(function(){
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