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
@php
$sl = 0;
@endphp
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <span class="float-left">
                            <h4>Information Entry</h4>
                        </span>
                            <span class="float-right">
                            <a href="{{ route('add_promotion_type') }}"
                            class="btn btn-primary btn-sm">Add Promotion Type</a>
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
                            <div class="col-md-5">

                                <form class="form-horizontal" method="POST" action="{{ route('import_parse') }}" enctype="multipart/form-data">
                                    @csrf

                                        <label for="promotion_type">Promotion Type<span style="color:red;">*</span></label>                                                                              
                                        <select name="promotion_type" id="promotion_type" class="form-control  mb-2" required>
                                            <option value="" >Select Promotion Type....</option>
                                        @foreach($data as $dt_1)
                                            <option value="{{$dt_1->id}}">{{$dt_1->type}}</option>
                                        @endforeach
                                        </select>
                                        <label for="promotion_type">Insert .CSV file<span style="color:red;">*</span></label> 

                                            <input id="csv_file" type="file" class="form-control" name="csv_file" required>
                                                 @if ($errors->has('csv_file'))
                                                <span class="help-block">
                                                <strong>{{ $errors->first('csv_file') }}</strong>
                                                </span>
                                                @endif 
                                                <div class="mt-4">                                                                                                                          
                                                    <input type="submit" value="Parse CSV" class="btn-custom">
                                                    <input type="reset" value="Reset" class="btn-custom">
                                                </div>                                   
                                </form>

                            </div>
                            <div class="col-md-7">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered">
                                        <tr>
                                            <th>SL</th>
                                            <th>Promotion Type</th>
                                            <th>Created at</th>
                                            <th>Action</th>
                                        </tr>
                                        @foreach($data as $dt)
                                            @php
                                                $sl++;
                                            @endphp
                                            <tr>
                                                <td>{{$sl}}</td>
                                                <td>{{$dt->type}}</td>
                                                <td>{{$dt->created_at->toDateString()}}</td>
                                                <td>
                                                    <div class="btn-group">
                                                        <a href="{{ route('promotion_type.show', $dt->id) }}"
                                                        class="btn btn-sm btn-dark">
                                                            <i class="fa fa-eye"></i>
                                                        </a>
                                                        <a href="{{ route('promotion_type.edit', $dt->id)}}"
                                                        class="btn btn-sm btn-info">
                                                            <i class="fa fa-edit"></i>
                                                        </a>
                                                        <a href="{{route('promotion_type.delete', $dt->id)}}"
                                                        onclick="return confirm('Deleting your promotion type will delete all the informations related to this promotion type including csv file data(if any) . Are you sure?')"
                                                        class="btn btn-sm btn-danger">
                                                            <i class="fa fa-trash"></i>
                                                        </a>
                                                    </div>
                                                </td>
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

@push('js')

@endpush