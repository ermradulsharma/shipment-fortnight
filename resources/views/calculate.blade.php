@extends('layouts.backend')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-title">
                    <h4>Fill the form to calculate Package Rate</h4>
                </div>
                <hr />
                <form action="{{ route('calculate') }}" method="get">
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-8">
                                <div class="form-group row">
                                    <div class="col-md-6">
                                        <label for="name">Destination Pincode *</label>
                                        <input class="form-control" type="number" name="destinationPincode"
                                            value="{{ old('destinationPincode', request()->query('destinationPincode')) }}"
                                            required />
                                    </div>
                                    <div class="col-md-6">
                                        <label for="phone">Origin Pincode *</label>
                                        <input class="form-control" type="number" name="originPincode"
                                            value="{{ old('originPincode', request()->query('originPincode')) }}"
                                            required />
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-6">
                                        <label for="name">Package Type *</label>
                                        <select class="form-control" name="packageStatus" required />
                                        <option disabled=""></option>
                                        <option value="Delivered"
                                            {{ old('packageStatus', request()->query('packageStatus')) == 'Delivered' ? 'selected' : '' }}>
                                            Forward (Delivered)</option>
                                        <option value="RTO"
                                            {{ old('packageStatus', request()->query('packageStatus')) == 'RTO' ? 'selected' : '' }}>
                                            Return (RTO)</option>
                                        <option value="DTO"
                                            {{ old('packageStatus', request()->query('packageStatus')) == 'DTO' ? 'selected' : '' }}>
                                            Reverse (DTO)</option>
                                        </select>
                                    </div>

                                    <div class="col-md-6">
                                        <label for="City">Delivery Speed *</label>
                                        <select class="form-control" name="deliveryMode" id="" required />
                                        <option value="S"
                                            {{ old('deliveryMode', request()->query('deliveryMode')) == 'S' ? 'selected' : '' }}>
                                            Surface</option>
                                        <option value="E"
                                            {{ old('deliveryMode', request()->query('deliveryMode')) == 'E' ? 'selected' : '' }}>
                                            Express</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-6">
                                        <label for="State">Weight in gms *</label>
                                        <input class="form-control" type="number" name="weight"
                                            value="{{ old('weight', request()->query('weight')) }}" required />
                                    </div>
                                    <div class="col-md-6">
                                        <label for="Country">Payment Mode *</label>
                                        <select class="form-control packageType" name="packageType" id=""
                                            required />
                                        <option value="COD"
                                            {{ old('packageType', request()->query('packageType')) == 'COD' ? 'selected' : '' }}>
                                            COD</option>
                                        <option value="Pre-paid"
                                            {{ old('packageType', request()->query('packageType')) == 'Pre-paid' ? 'selected' : '' }}>
                                            Pre-paid</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 amountDiv">
                                        <label for="State">COD Amount *</label>
                                        <input class="form-control amountInput" type="number" name="amount"
                                            value="{{ old('amount', request()->query('amount')) }}" required />
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary px-5">check</button>
                                </div>
                            </div>
                            @if (@$data['details'])
                                <div class="col-md-4 border-left {{ @$gross_amount != '' ? 'bg-warning pt-2' : '' }}">
                                    <p class="text-center">Calculated Rate including GST</p>
                                    @php($details = $data['details'])
                                    @php($gst = $data['gst'])
                                    <table class="table table-bordered ">
                                        <tr>
                                            <td>Fwd. Amount</td>
                                            <td>₹{{ $details->charge_DL ? $details->charge_DL + 10 : 0.0 }}</td>
                                        </tr>
                                        <tr>
                                            <td>RTO Charge</td>
                                            <td>₹{{ $details->charge_RTO ? $details->charge_RTO : 0.0 }}</td>
                                        </tr>
                                        <tr>
                                            <td>COD Charge</td>
                                            <td>₹{{ $data['cod'] }}</td>
                                        </tr>
                                        <tr>
                                            <td>Fuel Surcharge</td>
                                            <td>₹{{ $data['charge_FS'] }}</td>
                                        </tr>
                                        <tr>
                                            <td>DTO Charge</td>
                                            <td>₹{{ $details->charge_DTO ?? 0.0 }}</td>
                                        </tr>
                                        <tr>
                                            <td>GST</td>
                                            <td>₹{{ $details->tax_data->IGST > 0 ? $details->tax_data->IGST + $gst : $details->tax_data->SGST + $details->tax_data->CGST + $gst }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Total Amount</th>
                                            <th class="text-right">₹{{ $details->total_amount + $data['cod'] + $gst + 10 + $data['charge_FS'] }}</th>
                                        </tr>
                                    </table>
                                </div>
                            @endif
                        </div>
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
            $('.packageType').change(function() {
                var type = $(this).val();
                if (type == 'COD') {
                    $('.amountDiv').show();
                    $('.amountInput').attr('required', 'true');
                } else {
                    $('.amountDiv').hide();
                    $('.amountInput').removeAttr('required');
                }
            });
        });
    </script>
@endsection
