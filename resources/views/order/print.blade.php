
@extends('layouts.backend')

@section('content')
        <div class="row">
            <div class="col-sm-12">
                @php $package = $packages[0]  @endphp
                <div class="bg-white">
                    <div class="card-body">
                        
                        <button class="text-right btn btn-primary" id="printbtn" onclick="printslip()">PRINT SLIP</button>
                          <div class="row">
                            <div class="table-responsive">
                                <div id="dvContents">
                                    <table class="table table-bordered" style="width:450px;border: 2px solid black;">
                                        <tr class="text-center" style="border: 2px solid black;">
                                            <td colspan="2" class="align-middle font-weight-bolder" style="font-size:40px;" >                                                
                                                Mera Shiping                                               
                                            </td>
                                            <td style="border: 2px solid black;">
                                                <img src="{{$package->delhivery_logo}}" style="width:100px;">
                                            </td>
                                        </tr>
                                        <tr class="text-center" style="border: 2px solid black;">
                                            <td colspan="3">
                                                <img src="{{$package->barcode}}" alt="barcode" width="300px" height="100" />
                                                <div>
                                                    <span style="float:left;margin-bottom: 0em;">{{$package->pin}}</span>
                                                    <span style="float:right;margin-bottom: 0em;">{{$package->sort_code}}</span>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" style="border: 2px solid black;">
                                                <p class="font-weight-bold mb-1">Shipping Address:</p>
                                                <p class="font-weight-bold mb-1 text-uppercase" style="font-size:16px;" >{{$package->name}}</p>
                                                <p class="mb-0" style="font-size:13px;">{{$package->address}}</br>{{$package->destination}}</p>
                                                <p style="margin-bottom: 0em;">PIN - {{$package->pin}}</p>
                                                <p><strong>Manifested Date : </strong>{{date("d-m-Y h:i:s", strtotime(@$order->manifested_at))}}</p>
                                            </td>
                                            <td class="text-center"><h4 class="mt-4">{{$package->pt}}<br><b>&#8377;  {{$package->rs}}</b></h4></td>
                                        </tr>
                                        <tr style="border: 2px solid black;">
                                            <td style="border: 2px solid black;">
                                                <p style="margin-bottom: 3px;">Seller: {{Auth::user()->name ?? null}} <!--</br>Address: {{$package->sadd}}--></p>
                                            </td>
                                            <td  colspan="2"></td>
                                        </tr>
                                        <tr class="text-center" style="border: 2px solid black;">
                                            <td width="60%" class="text-left">Product</td>
                                            <td width="20%" style="border: 2px solid black;">Price</td>
                                            <td width="20%">Total</td>
                                        </tr>
                                        <tr class="text-center" style="border: 2px solid black;">
                                            <td class="text-left">{{$package->prd}}</td>
                                            <td style="border: 2px solid black;">&#8377;  {{$package->rs}}</td>
                                            <td>&#8377;  {{$package->rs}}</td>
                                        </tr>
                                        <tr class="text-center" style="border: 2px solid black;">
                                            <td class="text-left">Total</td>
                                            <td style="border: 2px solid black;">&#8377;  {{$package->rs}}</td>
                                            <td>&#8377;  {{$package->rs}}</td>
                                        </tr>
                                        <tr style="border: 2px solid black;">
                                            <td  colspan="3" class="text-center">
                                                <img src="{{$package->oid_barcode}}" alt="barcode" width="220px" height="70px" />
                                            </td>
                                        </tr>
                                        <tr style="border: 2px solid black;">
                                            <td colspan="3" class="text-center">
                                                <p style="margin-bottom: 3px;">Return Address : {{Auth::user()->returnadd}}</p>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>    
                    </div>
                </div>
            </div>
        </div>
        <script>
            function printslip() {
              document.getElementById("printbtn").style.display = "none";
              window.print();
            }
        </script>
@endsection