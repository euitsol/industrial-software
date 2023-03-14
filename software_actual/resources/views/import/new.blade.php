
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
$count_1 = 1;
@endphp
<div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10 col-lg-12">
                <div class="card">
                    <div class="card-header justify-content-between">
                        <span class = "float-left">
                            <h4>Information View</h4>
                        </span>
                        <span class="float-right">
                            <a href="{{ route('promotion_type.sms',$id)}}"
                            class="btn btn-primary btn-sm">Send Sms</a>
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
                            <div class="mb-5">
                            <div class="table-responsive">
                                <table class="table table-bordered text-center dataTable" id = "table_one" >
                                <thead>
                                    <tr>
                                        <th class="align-middle">Sl</th>
                                        <th class="align-middle">Message</th>
                                        <th class="align-middle">Send date & time</th>
                                        <th class="align-middle">Send by</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($message_data as $md)
                                    <tr>                                       
                                            <td class="align-middle">{{$count_1}}</td>  
                                            <td class="text-left align-middle">{{$md->message}}</td>
                                            <td class="align-middle">{{$md->created_at}}</td>
                                            @foreach($user_data as $ud)
                                                @if($ud->id == $md->user_id)
                                                <td class="align-middle">{{$ud->name}}</td>
                                                @endif
                                            @endforeach
                                        
                                    </tr>
                                    @php
                                        $count_1++;
                                    @endphp
                                @endforeach
                                </tbody>
                                </table>
                                </div>
                            </div>                                                   
                                <div class="table-responsive">
                                <table class="table table-bordered text-center " id = "table_two">
                                <thead>
                                    <tr>
                                        <th>SL</th>
                                        @foreach($columns as $column_name)
                                            @if(($column_name != "created_at")&&($column_name != "updated_at")&&($column_name != "id")&&($column_name != "promotion_type_id"))
                                            <th class="align-middle">{{$column_name}}</th>
                                            @endif
                                        @endforeach
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                
                                @foreach($data as $key_1 => $dt)
                                    <tr>
                                    <td class= "align-midle">
                                            {{$key_1 + 1}}
                                        </td>
                                        @foreach($columns as  $column_name)
                                        
                                        @if(($column_name != "created_at")&&($column_name != "updated_at")&&($column_name != "id")&&($column_name != "promotion_type_id"))
                                        <td class="align-middle">{{$dt->$column_name}}</td>
                                        @endif
                                        @endforeach
                                        <td class="align-middle">
                                                    <div class="btn-group">
                                                        <a href="{{ route('csv_info.edit', $dt->id)}}"
                                                        class="btn btn-sm btn-info">
                                                            <i class="fa fa-edit"></i>
                                                        </a>
                                                        <a href="{{route('csv_info.delete', $dt->id)}}"
                                                        onclick="return confirm('Are you sure?')"
                                                        class="btn btn-sm btn-danger">
                                                            <i class="fa fa-trash"></i>
                                                        </a>
                                                    </div>
                                                </td>                                                          
                                    </tr>
                                @endforeach
                                    
                                </tbody>
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

@push('js')
    <script src="{{ asset('assets/vendor/data-table/js/jquery-3.3.1.js') }}"></script>
    <script src="{{ asset('assets/vendor/data-table/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/data-table/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/data-table/js/pdfmake.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/data-table/js/vfs_fonts.js') }}"></script>
    <script src="{{ asset('assets/vendor/data-table/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/data-table/js/buttons.print.min.js') }}"></script>
    <script>
        $(document).ready(function () {
            $('#table_one').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'pdfHtml5',
                        title: 'Message'
                    },
                    {
                        extend: 'print',
                        exportOptions: {
                            columns: [0,1,2,3,4]
                        }
                    }, 'pageLength'
                ]
            });

            $('#table_two').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'pdfHtml5',
                        title: 'Message'
                    },
                    {
                        extend: 'print',
                        exportOptions: {
                            columns: [0,1,2,3,4]
                        }
                    }, 'pageLength'
                ]
            });
        });
    </script>
@endpush




