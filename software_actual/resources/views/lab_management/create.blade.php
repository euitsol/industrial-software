@extends('layouts.master')

@section('title', 'Create New Lab - European IT Solutions Institute')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <span class="float-left">
                        <h4>Add New Lab</h4>
                    </span>
                    <span class="float-right">
                        <a href="{{ route('lab-management') }}" class="btn btn-info btn-sm">Back</a>
                    </span>
                </div>

                <div class="card-body">
                    
                    <div class="row">
                        <div class="col-md-8 offset-md-2">
                            <form action="{{ route('lab-management.store') }}" method="POST" class="form-horizontal">
                                @csrf

                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label">Lab Name <span class="text-danger">*</span> </label>
                                    <div class="col-md-9">
                                        <input type="text" name="lab_name" value="{{ old('lab_name') }}" class="form-control form-control-success" required>
                                        @if ($errors->has('lab_name'))
                                            <span class="text-danger">{{ $errors->first('lab_name') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label">Student Capacity <span class="text-danger">*</span> </label>
                                    <div class="col-md-9">
                                        <input type="number" name="capacity" value="{{ old('capacity') }}" class="form-control form-control-success" required>
                                        @if ($errors->has('capacity'))
                                            <span class="text-danger">{{ $errors->first('capacity') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label">Note</label>
                                    <div class="col-md-9">
                                        <textarea name="note" class="form-control form-control-success" >{{ old('note') }}</textarea>
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

