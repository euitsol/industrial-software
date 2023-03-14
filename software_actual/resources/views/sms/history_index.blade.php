
@extends('layouts.master')

@section('title', 'SMS - European IT Solutions Institute')

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
$sl = 1;
@endphp
<div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <span>
                            <h4>SMS History</h4>
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

                                            
                                <div class="table-responsive" >  
                                <table class="table table-bordered text-center display"  id = "table" >
                                    <thead>
                                        <tr>
                                            <th class="align-middle">SL</th>
                                            <th class="align-middle">Purpose</th>
                                            <th class="align-middle">Sent to</th>
                                            <th class="align-middle">Sent By</th>
                                            <th class="align-middle">Status</th>
                                            <th class="align-middle">Send Time</th>
                                            <th class="align-middle">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                            @if(count($data) > 0)
                                                @foreach($data as $dt)
                                            
                                                <tr>
                                                    <td class="align-middle">{{ $sl++ }}</td>
                                                    <td class="align-middle">{{ $dt->type }}</td>
                                                    <td class="align-middle">{{ $dt->receiver_no }}</td>
                                                    @foreach($user_data as $ud)
                                                        @if($ud->id == $dt->user_id)
                                                            <td class="align-middle">{{ $ud->name }}</td>
                                                        @endif
                                                    @endforeach
                                                    @if($dt->status == "1")
                                                        <td class="align-middle"><span class="badge badge-success">Successful</span></td>
                                                    @else
                                                        <td class="align-middle"><span class="badge badge-danger">{{ $dt->status }}</span></td>
                                                    @endif
                                                    <td class="align-middle">{{ $dt->created_at }}</td>
                                                    <td class="align-middle">
                                                        <div class="btn-group">
                                                            <a href="{{ route('sms.history.view',$dt->id)}}" class="btn btn-sm btn-dark">
                                                            <i class="fa fa-eye"></i>
                                                            </a>
                                                        </div>
                                                    </td>
                                                </tr>
                                            
                                                @endforeach
                                            @endif
                                        
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
<script src="{{ asset('assets/vendor/data-table/js/buttons.html5.min.js') }}"></script>
<script>
    $(document).ready(function() {
        $('#table').DataTable( {
            dom: 'Bfrtip',
            buttons: [
                 'pageLength'
            ]
        });
    } );
</script>
@endpush




