@extends('layouts.master')

@section('title', 'Edit Course Type - European IT Solutions Institute')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <span class="float-left">
                        <h4>Edit Course Sector</h4>
                    </span>
                    <span class="float-right">
                        <a href="{{ route('course_types') }}" class="btn btn-info btn-sm">Back</a>
                    </span>
                </div>

                <div class="card-body">
                    
                    <div class="row">
                        <div class="col-md-8 offset-md-2">
                            <form action="{{ route('course_type.update') }}" method="POST" class="form-horizontal">
                                @csrf

                                <input type="hidden" name="id" value="{{ $ct->id }}">

                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label">Type Name <span class="text-danger">*</span> </label>
                                    <div class="col-md-9">
                                        <input type="text" name="type_name" value="{{ $ct->type_name }}" class="form-control form-control-success">
                                        @if ($errors->has('type_name'))
                                            <span class="text-danger">{{ $errors->first('type_name') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-9 ml-auto">
                                        <input type="submit" value="Update" class="btn btn-info">
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

