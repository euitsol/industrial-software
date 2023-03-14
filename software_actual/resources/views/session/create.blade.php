@extends('layouts.master')

@section('title', 'Create New Session - European IT Solutions Institute')
@push('css')
    <link rel="stylesheet" href="{{asset('assets/vendor/jquery-ui/jquery-ui.css')}}">
@endpush

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <span class="float-left">
                        <h4>Add New Session</h4>
                    </span>
                    <span class="float-right">
                        <a href="{{ route('session') }}" class="btn btn-info btn-sm">Back</a>
                    </span>
                </div>

                <div class="card-body">
                    
                    <div class="row">
                        <div class="col-md-8 offset-md-2">
                            <form action="{{ route('session.store') }}" method="POST" class="form-horizontal">
                                @csrf

                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label">Session Name <span class="text-danger">*</span> </label>
                                    <div class="col-md-9">
                                        <input type="text" name="name" value="{{ old('name') }}" class="form-control form-control-success" required>
                                        @if ($errors->has('name'))
                                            <span class="text-danger">{{ $errors->first('name') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label">Session Duration <span class="text-danger">*</span></label>
                                    <div class="col-md-9">
                                        <div class="row">
                                            <div class="col">
                                                <input type="text" name="start_date" id="start_date" placeholder="Start"
                                                       class="form-control" autocomplete="off">
                                                @if ($errors->has('start_date'))
                                                    <span class="text-danger">{{ $errors->first('start_date') }}</span>
                                                @endif
                                            </div>
                                            <div class="col">
                                                <input type="text" name="end_date" id="end_date" placeholder="End"
                                                       class="form-control" autocomplete="off">
                                                @if ($errors->has('end_date'))
                                                    <span class="text-danger">{{ $errors->first('end_date') }}</span>
                                                @endif
                                            </div>
                                        </div>
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

@push('js')
<script src="{{asset('assets/vendor/jquery-ui/jquery-ui.js')}}"></script>
<script>
    $("#start_date").datepicker({dateFormat: 'yy-mm-dd'});
    $("#end_date").datepicker({dateFormat: 'yy-mm-dd'});
</script>
@endpush

