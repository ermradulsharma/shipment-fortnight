@extends('layouts.backend')

@section('content')

<div class="row">
    <div class="col-lg-4 col-md-6">
        <div class="card">
            <h4 class="mb-1">Charge </h4>
            <hr />
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
            <form id="" action="{{route('setting')}}" method="post">
                <input type="hidden" name="name" value="charge">
                @csrf
                <div class="form-group row">
                    <div class="col-md-12">
                        <input class="form-control" type="number" name="value" value="{{ $charge->value }}"/>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary px-5">Save</button>
            </form>
        </div>
        <!-- /# card -->
    </div>
    <!-- /# column -->
</div>

@endsection


@section('script')

@endsection