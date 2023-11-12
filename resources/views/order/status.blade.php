@extends('layouts.backend')

@section('content')

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-title">
                <h4>Order Details</h4>
            </div>
            <hr/>
            <div class="bootstrap-data-table-panel my-5">
                <div class="table-responsive">
                    <table class="table">
                            <tr>
                                <th>Customer Name : {{$order->name}}</th>
                                <th>Order No. : {{$order->orderid}}</th>
                                <th>Mobile Nos.: {{$order->phone}}</th>
                            </tr>
                            <tr>
                                <th>Address : {{$order->address}}</th>
                                <th>PIN code : {{$order->pin}}</th>
                                <th></th>
                            </tr>
                        </table>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                Package Scans For AWB# - {{$awb}}
            </div>
            <div class="card-body">
                @if($service == 'delhivery')
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Updated DateTime</th>
                            <th>Scan Type</th>
                            <th>Scan </th>
                            <th>Scanned Location</th>
                            <th>Instructions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($scans as $scan)
                        <tr>
                            <td>{{$scan['ScanDateTime']}}</td>
                            <td>{{$scan['ScanType']}}</td>
                            <td>{{$scan['Scan']}}</td>
                            <td>{{$scan['ScannedLocation']}}</td>
                            <td>{{$scan['Instructions']}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @endif
                @if($service == 'ecom_express')
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Updated DateTime</th>
                            <th>Reason Code</th>
                            <th>Service Center</th>
                            <th>Employee</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($scans as $scan)
                        <tr>
                            <td>{{$scan['updated_on']}}</td>
                            <td>{{$scan['reason_code_number']}}</td>
                            <td>{{$scan['location_type']}}- {{$scan['location']}}</td>
                            <td>{{$scan['Employee']}}</td>
                            <td>{{$scan['status']}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @endif
            </div>
        </div>
    </div>
    <!-- /# column -->
</div>

@endsection
