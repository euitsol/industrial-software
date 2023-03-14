@extends('layouts.master')

@section('title', 'Mentor Batch Setup - European IT Solutions Institute')

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
                        <h4>Mentor Batch Setup</h4>
                    </span>
                        <span class="float-right">
                        <a href="{{ url()->previous() }}" class="btn btn-info btn-sm">Back</a>
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

                        @if ($mentors->count())
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <tr>
                                        <th>SL</th>
                                        <th>Name</th>
                                        <th>Phone</th>
                                        <th>E-Mail</th>
                                        <th>Action</th>
                                    </tr>
                                    @foreach ($mentors as $mk => $mentor)
                                        <tr>
                                            <td>{{ ++$mk }}</td>
                                            <td>{{ $mentor->name }}</td>
                                            <td>{{ $mentor->phone }}</td>
                                            <td>{{ $mentor->email }}</td>
                                            <td><a href="{{ route('mentor.batch.setup', $mentor->id) }}"
                                                   class="btn btn-primary btn-sm">Setup Batch</a></td>
                                        </tr>
                                    @endforeach
                                </table>
                            </div>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')

@endpush

