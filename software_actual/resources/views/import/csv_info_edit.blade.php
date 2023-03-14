
@extends('layouts.master')

@section('title', 'SMS promotion type')

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
<form action = "{{route('csv_info.update')}}" method="POST" >
<div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10 col-lg-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <span>
                            <h4>Edit CSV data</h4>
                        </span>
                        <span class="float-right">          
                            
                                                                                                                                                       
                                    <input type="submit" value="Update" class="btn-custom">
                                    <input type="reset" value="Reset" class="btn-custom">
                                    
                                
                            
                        </span>  
                    </div>
                    <div class="card-body">
                    

                        <div class="row">
                            <div class="col-md-12 ">
                            
                            <input type="hidden" name="id" value="{{$id}}">

                            @csrf 
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
                                                <td> <input type="text" name="{{$column_name}}" value ="{{ $dt->$column_name }}" class="form-control"></td>
                                            @endif
                                        @endforeach
                                    
                                    
                                    </tr>
                                    <input type="hidden" name="promotion_type_id" value="{{$dt->promotion_type_id}}">
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
</form>
@endsection





