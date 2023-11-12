@extends('layouts.backend')

@section('content')

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-title">
                <h4>Permissions </h4>
                <div class="pull-right">
                    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#permissionaddmodel">Add New</button>
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
            <div class="bootstrap-data-table-panel">
                <div class="table-responsive">
                    <table id="row-select" class="mb-4 table table-borderd">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Function</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($permissions as $permission)
                            <tr>
                                <td>{{$permission->id}}</td>
                                <td>{{$permission->name}}</td>
                                <td>{{$permission->function}}</td>
                                <td class="text-center">
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-primary btn-sm editpermission" data-id="{{$permission->id}}">Edit</button>
                                        <button type="button" class="btn btn-danger btn-sm" onClick="if(confirm('Are you sure you want to delete this ??.')){
                                            document.getElementById('deleteForm_{{$permission->id}}').submit();
                                        }"
                                        >Delete</button>
                                        <form id="deleteForm_{{$permission->id}}" action="{{route('permission.destroy',$permission->id)}}" method="post">
                                            <input type="hidden" name="_method" value="DELETE">
                                            @csrf
                                        </form>
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
    
    <!--Add permission Model -->

    <div class="modal" id="permissionaddmodel">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header bg-warning">
                    <h4 class="modal-title">Add Permissions</h4>
                    <button type="button" class="close" data-dismiss="modal">X</button>
                </div>

                <!-- Modal body -->
                <form action="{{route('permission.store')}}" method="post">
                @csrf
                    <div class="modal-body">
                        <div class="form-group row">
                            <div class="col-md-12">
                                <label for="name">Name *</label>
                                <input class="form-control" type="text" name="name" id="" />
                            </div>
                        </div>
                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary px-5">Save</button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <!-- Edit permission Model -->

    <div class="modal" id="permissioneditmodel">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header bg-warning">
                    <h4 class="modal-title">Edit Permissions</h4>
                    <button type="button" class="close" data-dismiss="modal">X</button>
                </div>

                <!-- Modal body -->
                <form id="EditFormId" action="" method="post">
                    <input type="hidden" name="_method" value="PUT">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group row">
                            <div class="col-md-12">
                                <label for="name">Name *</label>
                                <input class="form-control" type="text" name="name" id="name" />
                            </div>
                        </div>
                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary px-5">Save</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function(){
                $('.editpermission').click(function(){
                    var id = $(this).data('id');
                    var get_url = "{{url('permission')}}/"+id+"/edit";
                    var post_url = "{{url('permission')}}/"+id;
                    $('#EditFormId').attr('action',post_url);
                    $.ajax({url: get_url, success: function(result){
                        var permission = JSON.parse(result);
                        $('#name').val(permission.name);
                        $('#permissioneditmodel').modal('show');
                    }});
                });
            });
    </script>
@endsection