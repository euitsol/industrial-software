@extends('layouts.master')

@section('title', 'Students - European IT Solutions Institute')

@push('css')
    <style>
        .btn-custom {
            border: 1px solid #9e9b9b73;
            background: #d2cfcf5c !important;
            border-radius: 0 !important;
            padding: 4px 22px !important;
            color: #000;
            opacity: 1 !important;
            text-align: center;

        }

        a {
            text-decoration: none !important;
        }

        .btn-custom:hover {
            background: #428bca !important;
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
                        <h4> Student Report - Division </h4>
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

                        <div class="row justify-content-center">
                            <div class="col-md-6">
                                <form action="{{ route('report.division.institute.find') }}" method="post">
                                    @csrf
                                    <div class="form-group">
                                        <label for="">Year</label><span class="text-danger">*</span>
                                        <select name="year" id="" class="form-control" required>
                                            <option value="" disabled hidden selected> Choose...</option>
                                            @foreach($years as $year)
                                                <option value="{{ $year }}">{{ $year }}</option>
                                            @endforeach
                                        </select>
                                        <small>Student Admission Year</small><br>
                                        @if ($errors->has('year'))
                                            <span class="text-danger">{{ $errors->first('year') }}</span> <br>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                            <label for="division">Division</label>
                                            <select name="division" id="division" class="form-control mb-2">
                                                <option value="" selected hidden>Choose...</option>
                                                @foreach ($divisions as $division)
                                                    <option value="{{$division->division}}">{{$division->division}}</option>
                                                @endforeach
                                            </select>
                                            @if ($errors->has('division'))
                                                <p class="text-danger">{{$errors->first('division')}}</p>
                                            @endif
                                    </div>
                                    <input type="submit" name="btn" value="Submit" class="btn-custom mt-2">
                                    <input type="reset" name="btn" value="Reset" class="btn-custom mt-2">
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('js')
    <script>

    </script>
@endpush