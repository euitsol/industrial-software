@extends('layouts.master')

@section('title', 'Edit Session - European IT Solutions Institute')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <span class="float-left">
                        <h4>Edit Session</h4>
                    </span>
                    <span class="float-right">
                        <a href="{{ route('session') }}" class="btn btn-info btn-sm">Back</a>
                    </span>
                </div>

                <div class="card-body">
                    
                    <div class="row">
                        <div class="col-md-8 offset-md-2">
                            <form action="{{ route('session.update') }}" method="POST" class="form-horizontal">
                                @csrf

                                <input type="hidden" name="id" value="{{ $session->id }}">

                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label">Session Name <span class="text-danger">*</span> </label>
                                    <div class="col-md-9">
                                        <input type="text" name="name" value="{{ $session->name }}" class="form-control form-control-success" required>
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
                                                <input type="text" name="start_date" id="start_date" placeholder="Start" value="{{ $session->start_time }}"
                                                       class="form-control" autocomplete="off">
                                                @if ($errors->has('start_date'))
                                                    <span class="text-danger">{{ $errors->first('start_date') }}</span>
                                                @endif
                                            </div>
                                            <div class="col">
                                                <input type="text" name="end_date" id="end_date" placeholder="End" value="{{ $session->end_time }}"
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

