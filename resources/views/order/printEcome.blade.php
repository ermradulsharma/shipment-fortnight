@extends('layouts.backend')

@section('content')
<style>
.table-bordered,.table-bordered th, .table-bordered td {
    border: 2px solid black;
}
.page-break {
    page-break-after: always;
}
</style>
<div class="container-fluid">
    <div class="animated fadeIn">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body" style="border: 2px solid black;">
                    <button class="text-right btn btn-primary" id="printbtn" onclick="printslip()">PRINT SLIP</button>
                          <div class="row justify-content-center">
                            <div class="col-sm-12">
                                <div id="dvContents">
                                    
                                  <div class="row d-flex align-items-center">
                                    <div class="col-sm-4 text-left font-weight-bold" style="font-size:18px;">[ {{ $order->paymenttype }} ]</div>
                                    <div class="col-sm-4 text-center">
                                      <div class="font-weight-bold" style="font-size:16px;">ECOM EXPRESS</div>
                                      <div>
                                        @php echo '<img src="data:image/png;base64,' . DNS1D::getBarcodePNG($order->trackingNo, "C128",2,45) . '" alt="barcode"   />';@endphp
                                      </div>
                                      <div style="font-size:16px;">{{@$order->trackingNo}}</div>
                                    </div>
                                    <div class="col-sm-4 text-right font-weight-bold" style="font-size:18px;">[ {{@$order->ecome->code ?? ''}} ]</div>
                                  </div>
                                  <div class="row">
                                    <div class="col-12">
                                      <table class="table table-bordered w-100">
                                        <tr>
                                          <td class="border-0 font-weight-bold">Shipper : Mera Shiping</td>
                                          <td class="text-right border-0 font-weight-bold">Order No.: {{$order->orderid}}</td>
                                        </tr>
                                      </table>
                                      <table class="table table-bordered">
                                        <tr class="text-center" style="border: 2px solid black;">
                                          <th>Consignee Details</th>
                                          <th> Order Details</th>
                                        </tr>
                                        <tr>
                                          <td>
                                            <span>{{@$order->name}}</span></br>
                                            <span>{{@$order->address}}, </span></br>
                                            <span>PIN - {{@$order->pin}}, </span></br>
                                            <span><strong>City : {{@$order->ecome->city}} </strong></span></br>
                                          </td>
                                          <td>
                                            <span><strong>Amount : </strong>{{@$order->price}}</span></br>
                                            <span><strong>Item Description : </strong>{{$order->products_desc}}</span></br>
                                            <span><strong>Order Date : </strong>{{@$order->updated_at->toDayDateTimeString()}}</span></br>
                                            <span><strong>Manifested Date : </strong>{{date("d-m-Y h:i:s", strtotime(@$order->manifested_at))}}</span></br>
                                          </td>
                                        </tr>
                                      </table>
                                      <table class="table table-bordered">
                                        <tr style="border: 2px solid black;">
                                          <th class="text-center">IF UNDELIVERED RETURN TO :</th>
                                        </tr>
                                        <tr>
                                          <td class="text-center"><strong>{{$order->user->returnadd ?? ''}}</strong></td>
                                        </tr>
                                      </table>
                                    </div>
                                  </div>
                                </div>
                            </div>
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