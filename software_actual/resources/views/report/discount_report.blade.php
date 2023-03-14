@extends('layouts.master')

@section('title', 'Discount Report')

@push('css')
    <link rel="stylesheet" href="{{ asset('assets/vendor/select2/select2.min.css') }}">
@endpush

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10 col-lg-12">
                <div class="card">
                    <div class="card-header">
                    <span class="float-left">
                        <h4> Report </h4>
                    </span>
                        <span class="float-right">
                        <h4> Discount Report </h4>
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
                            <div class="col-md-4">
                               <div class="form-group">
                                    <label class="year">Year</label>
                                    <select name="year" id="year" class="form-control form-control-success select2">
                                    <option value="">Choose...</option>
                                    @foreach ($years as $year)
                                            <option value="{{ $year }}">{{ $year }}</option>
                                    @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                               <div class="form-group">
                                    <label class="course">Course</label>
                                    <select name="course" id="course" class="form-control form-control-success select2">
                                    <option value="">Choose...</option>
                                    @foreach ($courses as $course)
                                            <option value="{{ $course->id }}">{{ $course->title }}</option>
                                    @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                               <div class="form-group">
                                    <label class="user">User</label>
                                    <select name="user" id="user" class="form-control form-control-success select2">
                                    <option value="">Choose...</option>
                                    @foreach ($users as $user)
                                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                                    @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 m-auto">
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="table">
                                        <tr>
                                            <th>SL</th>
                                            <th>Name</th>
                                            <th>Phone</th>
                                            <th>Institute</th>
                                            <th>Course</th>
                                            <th>Discount</th>
                                        </tr>
                                        @foreach ($data as $count => $account)
                                            <tr>
                                                <td>{{++$count}}</td>
                                                <td>{{$account->student->name}}</td>
                                                <td>{{$account->student->phone}}</td>
                                                <td>{{$account->student->institute->name}}</td>
                                                <td>{{$account->course->title}}</td>
                                                <td>
                                                    @if($account->discount_percent > 0)
                                                        {{ $account->discount_percent }} %
                                                    @else
                                                        {{ number_format($account->discount_amount) }} tk
                                                    @endif
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
    <script src="{{ asset('assets/vendor/select2/select2.min.js') }}"></script>
    <script>
    $(document).ready(function() {
        $(".select2").select2();

    } );
    </script>
@endpush