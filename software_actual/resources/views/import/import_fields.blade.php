
@extends('layouts.master')

@section('title', 'CSV')

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
$j = 1;
@endphp

<div class="container">

        <div class="row justify-content-center">
            <div class="col-md-10 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <span>
                            <h4>{{$promotion_type->type}}</h4>
                        </span>
                    </div>

                    <div class="card-body">

                        <div class="row">
                            <div class="col-md-12 ">
                            <form action = "{{route('import_parse.process',$promotion_type->id)}}" method="POST" >
                            @csrf 
                                <div class="table-responsive">
                                <table class="table table-bordered text-center dataTable">
                                
                                @foreach($data as $cd)
                                    <tr>
                                        
                                    
                                    @foreach($cd as $key => $value)
                                        <td>
                                            <input type="text" value = "{{$value}}" class="input no-outline text-center" name="{{$j}}[]">
                                            
                                            
                                        </td>
                                    @endforeach
                                    </tr>
                                    @php 
                                     $j++;
                                    @endphp
                                    @endforeach
                                    <tr>
                                    
                                    @php
                                        for($i=1 ; $i<=count($cd) ;$i++)
                                        {
                                            echo "<td><div class='input-group mb-3'>";
                                                echo  "<select class= 'custom-select' id='inputGroupSelect01' name = 'c".$i."[]'> ";
                                                echo "<option>none</option>";
                                                    foreach ($columns as $cl)
                                                    {
                                                        if(($cl != "created_at")&&($cl != "updated_at")&&($cl != "id")&&($cl != "promotion_type_id"))
                                                        {

                                                        echo "<option value = '".$cl."' >".$cl."</option>";
                                                        }
                                                        

                                                    }
                                                echo "</select>";
                                            echo  "</td>";
                                            
                                        }
                                    @endphp
                                    </tr>
                                </table>
                                </div>
                                            <input type="hidden" name="j" value="{{$j}}">
                                            <input type="hidden" name="i" value="{{count($cd)}}">
                                            <input type="hidden" name="id" value="{{$promotion_type->id}}">
                                            <div class="mt-4">                                                                                                                          
                                                <input type="submit" value="Save" class="btn-custom">
                                                <input type="reset" value="Reset" class="btn-custom">
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





