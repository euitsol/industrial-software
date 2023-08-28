@extends('layouts.master')

@section('title', 'Create User - European IT Solutions Institute')

@push('css')

@endpush

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>User</h4>
                    </div>

                    <div class="card-body">

                        @if (session('error'))
                            <p class="alert alert-danger text-center">
                                {{ session('error') }}
                            </p>
                        @elseif(session('success'))
                            <p class="alert alert-success text-center">
                                {{ session('success') }}
                            </p>
                        @endif

                        <div class="row">
                            <div class="col-md-6">
                                @if ($errors->any())
                                    <div class="alert alert-danger form-group">
                                        <ul style="margin-bottom: 0px;">
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                                <form action="{{route('user.store')}}" method="post">
                                    @csrf

                                    <div class="form-group">                                       
                                            <label class="form-control-label">User Role <span class="text-danger">*</span>
                                            </label>
                                            
                                                <select name="role" id="role"class="form-control form-control-success">
                                                    <option value="">Choose...</option>
                                                    @foreach($users->unique('role') as $us)
                                                        @if(Auth::user()->role == 'superadmin')
                                                            <option value="{{$us->role}}">{{$us->role}}</option>     
                                                        @else
                                                            @if($us->role != 'superadmin' && $us->role != 'admin')
                                                                <option value="{{$us->role}}">{{$us->role}}</option>                                                               
                                                            @endif
                                                        @endif
                                                    @endforeach
                                                    
                                                </select>
                                                @if ($errors->has('role'))
                                                    <span class="text-danger">{{ $errors->first('role') }}</span>
                                                @endif
                                                

                                                <div class="clearfix">
                                                    <small></small>
                                                    <a href="javascript:void(0)" id="new_role" class="float-right">
                                                        + New Role
                                                    </a>
                                                </div>
                                                <div id="new_role_form" class="border p-2" style="display:none">
                                                    <div class="form-group">
                                                        <label class="form-control-label">New Role<span class="text-danger">*</span> </label>
                                                        <input type="text" name="new_role" value="{{old('new_role')}}" class="form-control form-control-sm">
                                                    </div>
                                                    @if ($errors->has('role'))
                                                        <span class="text-danger">{{ $errors->first('new_role') }}</span>
                                                    @endif
                                                    
                                                </div>
                                        
                                    </div>

                                    <div class="form-group " id = "name_div">
                                        <label for="name" class="form-control-label">Name <span class="text-danger">*</span> </label>
                                        <input type="text" name="name" value="{{old('name')}}" id="name" class="form-control">
                                        @if ($errors->has('name'))
                                            <span class="text-danger">{{ $errors->first('name') }}</span>
                                        @endif
                                    </div>
                                    <div class="form-group " id = "mentor_div" style="display: none;">
                                        <label for="mentor_name" class="form-control-label">Mentor's Name <span class="text-danger">*</span> </label>
                                        <select name="mentor_name" id="mentor_name"class="form-control form-control-success">
                                                    <option value="">Choose...</option>
                                                    @foreach($mentor as $mn)                                                                                                                   
                                                          
                                                        <option value="{{$mn->id}}">{{$mn->name}}</option>                                                                                                                                                                         
                                                        
                                                    @endforeach
                                                    
                                                </select>
                                        @if ($errors->has('name'))
                                            <span class="text-danger">{{ $errors->first('name') }}</span>
                                        @endif
                                    </div>

                                    

                                    <div class="form-group">
                                        <label for="username" class="form-control-label">Username <span class="text-danger">*</span> </label>
                                        <input type="text" name="username" value="{{old('username')}}" id="username" class="form-control">
                                        @if ($errors->has('username'))
                                            <span class="text-danger">{{ $errors->first('username') }}</span>
                                        @endif
                                    </div>

                                    <div class="form-group">
                                        <label for="password" class="form-control-label">Password <span class="text-danger">*</span> </label>
                                        <input type="password" name="password" id="password" class="form-control">
                                        @if ($errors->has('password'))
                                            <span class="text-danger">{{ $errors->first('password') }}</span>
                                        @endif
                                    </div>

                                    <div class="form-group">
                                        <label for="confirm_password" class="form-control-label">Confirm Password <span class="text-danger">*</span> </label>
                                        <input type="password" name="password_confirmation" id="confirm_password" class="form-control">
                                        @if ($errors->has('password_confirmation'))
                                            <span class="text-danger">{{ $errors->first('password_confirmation') }}</span>
                                        @endif
                                    </div>

                                    <div class="form-group">
                                        <input type="submit" value="Submit" class="btn btn-primary">
                                    </div>

                                </form>

                            </div>
                            <div class="col-md-6">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered">
                                        <tr>
                                            <th>SL</th>
                                            <th>Name</th>
                                            <th>Username</th>
                                            <th>Role</th>
                                            <th>Mentor Status</th>
                                            <th>Action</th>
                                        </tr>
                                        @forelse ($users as $key => $user)
                                            <tr>
                                                <td>{{++$key}}</td>
                                                <td>{{$user->name}}</td>
                                                <td>{{$user->username}}</td>
                                                <td>{{$user->role}}</td>
                                                <td><span class='badge {{$user->mentor_id ? "badge-success" : "badge-primary" }}'>{{$user->mentor_id ? 'Yes' : 'N/A' }}</span></td>
                                                <td>
                                                    <div class="btn-group">
                                                        @if(Auth::user()->role == 'superadmin')

                                                        <a href="{{route('user.edit', $user->id)}}" class="btn btn-info btn-sm">
                                                            <i class="fa fa-edit"></i>
                                                            </a>
                                                            <a href="{{route('user.destroy', $user->id)}}" onclick="return confirm('Are you sure?')" class="btn btn-danger btn-sm">
                                                                <i class="fa fa-trash"></i>
                                                            </a>
                                                        
                                                        @elseif($user->role != 'admin' && $user->role != 'superadmin')
                                                            <a href="{{route('user.edit', $user->id)}}" class="btn btn-info btn-sm">
                                                                <i class="fa fa-edit"></i>
                                                                </a>
                                                                
                                                                
                                                        @else
                                                        @endif
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4" class="text-center">
                                                    No user found!
                                                </td>
                                            </tr>
                                        @endforelse
                                    </table>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')


    <script type="text/javascript">
       
        $("#new_role").click(function () {
            $("#new_role_form").toggle(500);
        });
        $("#role").click(function () {
            
            $("#new_role").hide();
        });
        $("#new_role").click(function () {
            
            $("#role").prop("disabled", true);
        });
        $(function(){
        $("select#role").on("change", function(){
            if(this.value == "mentor"){
                $("#name").attr('disabled','disabled');
                
                $("#mentor_div").show();
            }   
        })
        })

        
        
        

    </script>
@endpush