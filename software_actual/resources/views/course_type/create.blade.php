@extends('layouts.master')

@section('title', 'Create Course Type - European IT Solutions Institute')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <span class="float-left">
                        <h4>Add Course Sector</h4>
                    </span>
                    <span class="float-right">
                        <a href="{{ route('course_types') }}" class="btn btn-info btn-sm">Back</a>
                    </span>
                </div>

                <div class="card-body">
                    
                    <div class="row">
                        <div class="col-md-8 offset-md-2">
                            <form action="{{ route('course_type.store') }}" method="POST" class="form-horizontal">
                                @csrf

                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label">Type Name <span class="text-danger">*</span> </label>
                                    <div class="col-md-9">
                                        <input type="text" name="type_name" value="{{ old('type_name') }}" class="form-control form-control-success">
                                        @if ($errors->has('type_name'))
                                            <span class="text-danger">{{ $errors->first('type_name') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-9 ml-auto">
                                        <input type="submit" value="Submit" class="btn btn-primary">
                                    </div>
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

