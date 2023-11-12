@extends('layouts.backend')

@section('content')

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-title">
                <h4>Customer </h4>
            </div>
            <hr/>

            <div class="bootstrap-data-table-panel">
                <div class="table-responsive">
                    <table id="row-select" class="mb-4 table table-borderd">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Phone</th>
                                <th>Date</th>
                                <th>Estimated Amount</th>
                                <th>Transaction Id</th>
                                <th class="text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($remittances as $remittance)
                            <tr>
                                <td>{{$remittance->user->name}}</td>
                                <td>{{$remittance->user->phone}}</td>
                                <td>{{date('d-m-Y,H:i:s',strtotime($remittance->created_at))}}</td>
                                <td>{{$remittance->amount}}</td>
                                <td>{{$remittance->transactionid}}</td>
                                <td class="text-center">{{$remittance->status}}</td>
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
