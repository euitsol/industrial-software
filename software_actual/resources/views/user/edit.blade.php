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
                    <span class="float-left">
                        <h4>User Edit</h4>
                    </span>
                        <span class="float-right">
                        <a href="{{ route('users') }}" class="btn btn-info btn-sm">Back</a>
                    </span>
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
                        
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif




                        <div class="row justify-content-center">
                            <div class="col-md-6">

                                <form action="{{route('user.update')}}" method="post">
                                    @csrf

                                    <input type="hidden" name="id" value="{{$user->id}}">

                                    <div class="form-group">
                                        <label for="name" class="form-control-label">Name <span class="text-danger">*</span> </label>
                                        <input type="text" name="name" value="{{$user->name}}" id="name" class="form-control">
                                        @if ($errors->has('name'))
                                            <span class="text-danger">{{ $errors->first('name') }}</span>
                                        @endif
                                    </div>
                                    <div class="form-group">                                       
                                        <label class="form-control-label">Select as a mentor
                                        </label>
                                        
                                        <select name="mentor_id" class="form-control form-control-success">
                                            <option value="" selected hidden>Select Mentor</option>
                                            @foreach($mentors as $mentor)
                                                <option value="{{$mentor->id}}" @if($user->mentor_id == $mentor->id) selected @endif>{{$mentor->name}}</option>     
                                            @endforeach
                                        </select>
                                        @if ($errors->has('mentor_id'))
                                            <span class="text-danger">{{ $errors->first('mentor_id') }}</span>
                                        @endif
                                    </div>
                                    @if(Auth::user()->role == 'admin' || Auth::user()->role == 'superadmin')
                                    <div class="form-group">                                       
                                            <label class="form-control-label">Update User Role <span class="text-danger">*</span>
                                            </label>
                                            
                                                <select name="role" id="role"class="form-control form-control-success">
                                                    @foreach($users->unique('role') as $us)
                                                        @if(Auth::user()->role == 'superadmin')
                                                            <option value="{{$us->role}}">{{$us->role}}</option>     
                                                        @else
                                                            @if($us->role != 'superadmin' && $us->role != 'admin')
                                                                <option value="{{$us->role}}" @if($user->role == $us->role) selected @endif>{{$us->role}}</option>                                                               
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
                                                        <input type="text" name="new_role"value="{{ old('institute_name') }}"class="form-control form-control-sm">
                                                    </div>
                                                    @if ($errors->has('role'))
                                                        <span class="text-danger">{{ $errors->first('new_role') }}</span>
                                                    @endif
                                                    
                                                </div>
                                        
                                    </div>
                                    @endif

                                    <div class="form-group">
                                        <label for="username" class="form-control-label">Username <span class="text-danger">*</span> </label>
                                        <input type="text" name="username" value="{{$user->username}}" id="username" class="form-control">
                                        @if ($errors->has('username'))
                                            <span class="text-danger">{{ $errors->first('username') }}</span>
                                        @endif
                                    </div>

                                    <div class="form-group">
                                        <label for="password" class="form-control-label">Password</label>
                                        <input type="password" name="password" id="password" class="form-control">
                                        @if ($errors->has('password'))
                                            <span class="text-danger">{{ $errors->first('password') }}</span>
                                        @endif
                                    </div>

                                    <div class="form-group">
                                        <label for="confirm_password" class="form-control-label">Confirm Password</label>
                                        <input type="password" name="password_confirmation" id="confirm_password" class="form-control">
                                        @if ($errors->has('password_confirmation'))
                                            <span class="text-danger">{{ $errors->first('password_confirmation') }}</span>
                                        @endif
                                    </div>

                                    <div class="form-group">
                                        <input type="submit" value="Update" class="btn btn-primary">
                                    </div>

                                </form>

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

    </script>
@endpush

