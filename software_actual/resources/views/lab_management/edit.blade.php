@extends('layouts.master')

@section('title', 'Edit Lab Management - European IT Solutions Institute')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <span class="float-left">
                        <h4>Edit Lab Management</h4>
                    </span>
                    <span class="float-right">
                        <a href="{{ route('lab-management') }}" class="btn btn-info btn-sm">Back</a>
                    </span>
                </div>

                <div class="card-body">
                    
                    <div class="row">
                        <div class="col-md-8 offset-md-2">
                            <form action="{{ route('lab-management.update') }}" method="POST" class="form-horizontal">
                                @csrf

                                <input type="hidden" name="id" value="{{ $lab->id }}">

                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label">Lab Name <span class="text-danger">*</span> </label>
                                    <div class="col-md-9">
                                        <input type="text" name="lab_name" value="{{ $lab->lab_name }}" class="form-control form-control-success" required>
                                        @if ($errors->has('lab_name'))
                                            <span class="text-danger">{{ $errors->first('lab_name') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label">Student Capacity <span class="text-danger">*</span> </label>
                                    <div class="col-md-9">
                                        <input type="number" name="capacity" value="{{ $lab->capacity }}" class="form-control form-control-success" required>
                                        @if ($errors->has('capacity'))
                                            <span class="text-danger">{{ $errors->first('capacity') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label">Note</label>
                                    <div class="col-md-9">
                                        <textarea name="note" class="form-control form-control-success">{{ $lab->note }}</textarea>
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

