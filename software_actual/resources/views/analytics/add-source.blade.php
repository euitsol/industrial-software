@extends('layouts.master')

@section('title', 'Analytics - Add source - European IT Solutions Institute')

@push('css')
@endpush

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <span class="float-left">
                            <h4>Add Source</h4>
                        </span>
                        <span class="float-right">
                            <a class="btn btn-sm btn-info" href="{{ route('analytics') }}">Back</a>
                        </span>
                    </div>

                    <div class="card-body">

                        @if(session('success'))
                            <p class="alert alert-success text-center">
                                {{ session('success') }}
                            </p>
                        @elseif(session('error'))
                            <p class="alert alert-danger text-center">
                                {{ session('error') }}
                            </p>
                        @endif

                        <div class="row">
                            <div class="col-md-8 offset-md-2">
                                <form action="{{ route('analytics.source.store') }}" method="POST" class="form-horizontal">
                                    @csrf
                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label">Source Name</label>
                                        <div class="col-md-9">
                                            <input type="text" name="name" value="{{ old('name') }}" class="form-control" required>
                                            @if ($errors->has('name'))
                                                <span class="text-danger">{{ $errors->first('name') }}</span>
                                            @endif

                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label"></label>
                                        <div class="col-md-9">
                                            <button type="submit" class="btn btn-success">Submit</button>
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
@endpush