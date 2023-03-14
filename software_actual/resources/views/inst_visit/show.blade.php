@extends('layouts.master')

@section('title', ' Visited Institute Show - European IT Solutions Institute')

@push('css')
    <link rel="stylesheet" href="{{ asset('assets/vendor/data-table/css/jquery.dataTables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/data-table/css/buttons.dataTables.min.css') }}">
@endpush

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10 col-lg-12">
                <div class="card">
                    <div class="card-header">
                    <span class="float-left">
                        <h4>Show visited institute details</h4>
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

                        <div class="row" id="info">
                            <div class="col-md-8 m-auto">
                                <p class = "text-center bg-gray-100 border py-2">Institute Details</p>
                                <div class="table-responsive">

                                    <table class="table table-striped table-borderless mt-3">
                                        <tr>
                                            <td>Id</td>
                                            <td>:</td>
                                            <td>{{$institute_visit->id}}</td>
                                        </tr>
                                        <tr>
                                            <td>Institute Name</td>
                                            <td>:</td>
                                            <td>{{$institute_visit->name}}</td>
                                        </tr>
                                        <tr>
                                            <td>Institute Type</td>
                                            <td>:</td>
                                            <td>{{ $institute_visit->getType() }}</td>
                                        </tr>
                                        <tr>
                                            <td>Division</td>
                                            <td>:</td>
                                            <td>
                                                {{ $institute_visit->division }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>District</td>
                                            <td>:</td>
                                            <td>
                                                {{ $institute_visit->district }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Address</td>
                                            <td>:</td>
                                            <td>
                                                {{ $institute_visit->address }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Year</td>
                                            <td>:</td>
                                            <td>
                                                {{ $institute_visit->year }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Created at</td>
                                            <td>:</td>
                                            <td>
                                                {{ date('d-M-Y, h:i A', strtotime($institute_visit->created_at)) }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Created by</td>
                                            <td>:</td>
                                            <td>
                                                {{ $institute_visit->user() }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Updated at</td>
                                            <td>:</td>
                                            <td>
                                                {{ date('d-M-Y, h:i A', strtotime($institute_visit->updated_at)) }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Updated by</td>
                                            <td>:</td>
                                            <td>
                                                {{ $institute_visit->user2() }}
                                            </td>
                                        </tr>
                                    </table>
                                    
                                </div>
                            </div>
                            <div class="col-md-12 m-auto">
                                <p class = "text-center bg-gray-100 border py-2">Contact Details</p>
                                <div class="row">
                                @foreach($contacts as $key2 => $ct)
                                <div class="col-md-6">
                                    <p class="text-center mt-2 mb-2">Contact Person - {{$key2+1}}</p>
                                    <div class="table-responsive">

                                        <table class="table table-striped table-borderless mt-3">
                                            <tr>
                                                <td>Id</td>
                                                <td>:</td>
                                                <td>{{$ct->id}}</td>
                                            </tr>
                                            <tr>
                                                <td>Name</td>
                                                <td>:</td>
                                                <td>{{$ct->name ?? 'Not provided'}}</td>
                                            </tr>
                                            <tr>
                                                <td>Designation</td>
                                                <td>:</td>
                                                <td>{{$ct->designation ?? 'Not provided'}}</td>
                                            </tr>
                                            <tr>
                                                <td>Phone</td>
                                                <td>:</td>
                                                <td><a href="tel:{{$ct->phone ?? '#'}}" target="_blank">{{$ct->phone ?? 'Not provided'}}</a></td>
                                            </tr>
                                            <tr>
                                                <td>Email</td>
                                                <td>:</td>
                                                <td><a href="mailto:{{$ct->email ?? '#'}}" target="_blank">{{$ct->email ?? 'Not provided'}}</a></td>
                                            </tr>
                                            <tr>
                                                <td>Comment</td>
                                                <td>:</td>
                                                <td>{{$ct->comment ?? 'Not provided'}}</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                                @endforeach
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



        });
    </script>

@endpush