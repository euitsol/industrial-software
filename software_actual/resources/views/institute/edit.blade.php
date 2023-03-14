@extends('layouts.master')

@section('title', 'Edit Institute - European IT Solutions Institute')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <span class="float-left">
                        <h4>Edit Institute</h4>
                    </span>
                    <span class="float-right">
                        <a href="{{ url()->previous() }}" class="btn btn-info
                        btn-sm">Back</a>
                    </span>
                </div>

                <div class="card-body">
                    
                    <div class="row">
                        <div class="col-md-8 offset-md-2">
                            <form action="{{ route('institute.update') }}" method="POST" class="form-horizontal">
                                @csrf

                                <input type="hidden" name="id" value="{{ $institute->id }}">

                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label">Institute Name <span class="text-danger">*</span> </label>
                                    <div class="col-md-9">
                                        <input type="text" name="name" value="{{ $institute->name }}" class="form-control form-control-success">
                                        @if ($errors->has('name'))
                                            <span class="text-danger">{{ $errors->first('name') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label">Website</label>
                                    <div class="col-md-9">
                                        <input type="text" name="website" value="{{ $institute->website }}" class="form-control form-control-success">
                                        @if ($errors->has('website'))
                                            <span class="text-danger">{{ $errors->first('website') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label">District <span class="text-danger">*</span> </label>
                                    <div class="col-md-9">
                                        <input type="text" name="district" value="{{ $institute->district }}" class="form-control form-control-success">
                                        @if ($errors->has('district'))
                                            <span class="text-danger">{{ $errors->first('district') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label">Division <span class="text-danger">*</span> </label>
                                    <div class="col-md-9">
                                        <input type="text" name="division" value="{{ $institute->division }}" class="form-control form-control-success">
                                        @if ($errors->has('division'))
                                            <span class="text-danger">{{ $errors->first('division') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label">Address</label>
                                    <div class="col-md-9">
                                        <textarea name="address" id="" class="form-control form-control-success">{{ $institute->address }}</textarea>
                                        @if ($errors->has('address'))
                                            <span class="text-danger">{{ $errors->first('address') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-9 ml-auto">
                                        <input type="submit" value="Update" class="btn btn-primary">
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

