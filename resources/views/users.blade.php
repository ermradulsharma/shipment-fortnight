@extends('layouts.backend')

@section('content')

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-title">
                <h4>Users </h4>
                <div class="pull-right">
                    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#useraddmodel">Add New</button>
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
                                <th>Phone</th>
                                <th>Email</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                            <tr>
                                <td>{{$user->id}}</td>
                                <td>{{$user->name}}</td>
                                <td>{{$user->phone}}</td>
                                <td>{{$user->email}}</td>
                                <td class="text-center">
                                    <div class="btn-group">
                                        <a href="{{url('profile/'.$user->id)}}" class="btn btn-info btn-sm">View</a>
                                        <button type="button" class="btn btn-primary btn-sm editUser" data-id="{{$user->id}}">Edit</button>
                                        <button type="button" class="btn btn-danger btn-sm" onClick="if(confirm('Are you sure you want to delete this ??.')){
                                            document.getElementById('deleteForm_{{$user->id}}').submit();
                                        }"
                                        >Delete</button>
                                        <form id="deleteForm_{{$user->id}}" action="{{route('user.destroy',$user->id)}}" method="post">
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
    
    <!--Add user Model -->

    <div class="modal" id="useraddmodel">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header bg-warning">
                    <h4 class="modal-title">Add User</h4>
                    <button type="button" class="close" data-dismiss="modal">X</button>
                </div>

                <!-- Modal body -->
                <form action="{{route('user.store')}}" method="post">
                @csrf
                    <div class="modal-body">
                        <div class="form-group row">
                            <div class="col-md-6">
                                <label for="name">Role *</label>
                                <select class="form-control" name="roleid" />
                                    <option value="">select</option>
                                    @foreach($roles as $role)
                                        <option value="{{$role->id}}">{{$role->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="name">Name *</label>
                                <input class="form-control" type="text" name="name" id="" />
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-6">
                                <label for="phone">Phone *</label>
                                <input class="form-control" type="number" name="phone" id="" />
                            </div>
                        
                            <div class="col-md-6">
                                <label for="email">Email *</label>
                                <input class="form-control" type="email" name="email" id="" />
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-6">
                                <label for="password">Password *</label>
                                <input class="form-control" type="password" name="password" id="" />
                            </div>
                        
                            <div class="col-md-6">
                                <label for="password">Confirm Password *</label>
                                <input class="form-control" type="password" name="password_confirmation" id="" />
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

    <!-- Edit User Model -->

    <div class="modal" id="usereditmodel">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header bg-warning">
                    <h4 class="modal-title">Edit User</h4>
                    <button type="button" class="close" data-dismiss="modal">X</button>
                </div>

                <!-- Modal body -->
                <form id="EditFormId" action="" method="post">
                    <input type="hidden" name="_method" value="PUT">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group row">
                            <div class="col-md-6">
                                <label for="name">Role *</label>
                                <select class="form-control" name="roleid" id="roleid" />
                                    <option value="">select</option>
                                    @foreach($roles as $role)
                                        <option value="{{$role->id}}">{{$role->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="name">Name *</label>
                                <input class="form-control" type="text" name="name" id="name" />
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-6">
                                <label for="phone">Phone *</label>
                                <input class="form-control" type="number" name="phone" id="phone" />
                            </div>
                        
                            <div class="col-md-6">
                                <label for="email">Email *</label>
                                <input class="form-control" type="email" name="email" id="email" />
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-6">
                                <label for="password">Change Password *</label>
                                <input class="form-control" type="password" name="password" id="password" />
                            </div>
                        
                            <div class="col-md-6">
                                <label for="password">Confirm Password *</label>
                                <input class="form-control" type="password" name="password_confirmation" id="password_confirmation" />
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
                $('.editUser').click(function(){
                    var id = $(this).data('id');
                    var get_url = "{{url('user')}}/"+id+"/edit";
                    var post_url = "{{url('user')}}/"+id;
                    $('#EditFormId').attr('action',post_url);
                    $.ajax({url: get_url, success: function(result){
                        var user = JSON.parse(result);
                        $('#roleid').val(user.roleid);
                        $('#name').val(user.name);
                        $('#phone').val(user.phone);
                        $('#email').val(user.email);
                        $('#usereditmodel').modal('show');
                    }});
                });
            });
    </script>
@endsection