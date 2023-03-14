
@extends('layouts.master')

@section('title', 'European IT Solutions Institute')

@push('css')
    <link rel="stylesheet" href="{{ asset('assets/vendor/data-table/css/jquery.dataTables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/data-table/css/buttons.dataTables.min.css') }}">
    <style>
        .input{
            border-top-style: hidden;
            border-right-style: hidden;
            border-left-style: hidden;
            border-bottom-style: none;
            background-color: #fff;
        }

        .no-outline:focus{

            outline: none;
        }
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
@php
@endphp
<div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <span>
                            <h4>Information View</h4>
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
                        <div class="row">
                            <div class="col-md-12 ">                                                   
                                <div class="table-responsive">
                                <table class="table table-bordered text-center dataTable">
                                    <tr>
                                        @foreach($columns as $column_name)
                                        @if(($column_name != "created_at")&&($column_name != "updated_at")&&($column_name != "id")&&($column_name != "promotion_type_id"))
                                        <th>{{$column_name}}</th>
                                        @endif
                                        @endforeach
                                    </tr>
                                
                                @foreach($data as $dt)
                                    <tr>
                                        @foreach($columns as $column_name)
                                        @if(($column_name != "created_at")&&($column_name != "updated_at")&&($column_name != "id")&&($column_name != "promotion_type_id"))
                                        <td>{{$dt->$column_name}}</td>
                                        @endif
                                        @endforeach                                                          
                                    </tr>
                                @endforeach
                                </table>
                                </div>                                                                                  
                            
                            </div>
                        </div>                   
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection





