@extends('layouts.master')

@section('title', 'CSV')

@push('css')
<link rel="stylesheet" href="{{ asset('assets/vendor/jquery-ui/jquery-ui.css') }}">
    <style>
        .btn-custom {
            border: 1px solid #9e9b9b73;
            background: #d2cfcf5c !important;
            border-radius: 0 !important;
            padding: 4px 22px !important;
            color: #000;
            opacity: 1 !important;
            text-align: center;
            cursor: pointer;
            transition: .4s;
        }

        a {
            text-decoration: none !important;
        }

        .btn-custom:hover {
            background: #19A4D0 !important;
            color: #ffffff !important;
        }
    </style>
@endpush

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <span class="float-left">
                            <h4>Add Promotion Type</h4>

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
                            <div class="col-md-8 offset-md-2">

                                <form class="form-horizontal" method="POST" action="{{ route('promotion_type.update', $pt->id)}}">
                                    @csrf

                                                                                                                     
                                        <div class="form-group row">
                                        <label for="promotion_type " class="col-md-3 form-control-label">Promotion Type</label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" id="promotion_type" name = "promotion_type" value = "{{$pt->type}}">
                                        </div>
                                        </div>
                                        <div class="form-group row">
                                        <div class="col-md-9 ml-auto">                                                                                                                        
                                            <input type="submit" value="Add Type" class="btn-custom">
                                            <input type="reset" value="Reset" class="btn-custom">
                                        </div>
                                        </div>                                   
                                </form>

                            </div>
                            

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')

@endpush