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
            background: #000 !important;
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
                        <h4> General Report </h4>
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
                            <div class="col-md-6">


                                <form action="{{ route('report.payment.status.search') }}" method="post">
                                    @csrf

                                    <label for="">Course Type</label>
                                    <select name="course_type" id="" class="form-control">
                                        <option value="" disabled hidden selected> Choose...</option>
                                        <option value="Professional">Professional</option>
                                        <option value="Industrial">Industrial</option>
                                    </select>
                                    @if ($errors->has('course_type'))
                                        <span class="text-danger">{{ $errors->first('course_type') }}</span> <br>
                                    @endif
                                    <input type="submit" name="btn" value="Due" class="btn-custom mt-2">
                                    <input type="submit" name="btn" value="Paid" class="btn-custom mt-2">
                                </form>

                                <div class="my-3 border p-3">
                                    <form action="{{route('report.division.institute.find')}}" method="post">
                                        @csrf

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
                                        <div class="form-group">
                                            <label for="institute">Institute</label>
                                            <select name="institute" id="institute" class="form-control mb-2">
                                                <option value="" selected hidden>Choose...</option>
                                                @foreach ($institutes as $institute)
                                                    <option value="{{$institute->id}}">{{$institute->name}}</option>
                                                @endforeach
                                            </select>
                                            @if ($errors->has('institute'))
                                                <p class="text-danger">{{$errors->first('institute')}}</p>
                                            @endif
                                        </div>
                                        <input type="submit" value="Search" class="btn-custom">
                                        <input type="reset" value="Reset" class="btn-custom">
                                    </form>
                                </div>

                            </div>
                            <div class="col-md-6">

                                <div class="my-3 p-3 border form-design">
                                    <form action="{{route('report.students.search')}}" method="post">
                                        @csrf

                                        <label for="course_type">Course Type</label>
                                        <select name="course_type" id="course_type" class="form-control  mb-2">
                                            <option value="all">All</option>
                                            <option value="Professional">Professional</option>
                                            <option value="Industrial">Industrial</option>
                                        </select>

                                        <label for="course">Course</label>
                                        <select name="course" id="course" class="form-control  mb-2">
                                            <option value="" hidden selected>Choose...</option>
                                        </select>

                                        <label for="batch">Batch</label>
                                        <select name="batch" id="batch" class="form-control  mb-2">
                                            <option value="" hidden selected>Choose...</option>
                                        </select>

                                        <input type="submit" value="Search" class="btn-custom">
                                        <input type="reset" value="Reset" class="btn-custom">
                                    </form>
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
    <script>
        $(function () {
            if ('' !== $('#course_type')) {
                $('#course').prop('disabled', true);
                $('#batch').prop('disabled', true);
            }

            $(document).on('change', '#course_type', function () {
                let course_type = $(this).val();
                if ('' !== course_type) {
                    let _url = "{{route('courses.type', ':course_type')}}";
                    let __url = _url.replace(':course_type', course_type);
                    $.ajax({
                        url: __url,
                        method: "GET",
                        success: function (response) {
                            if ('' !== response) {
                                $('#course').prop('disabled', false);
                                let output = '<option value="" hidden selected">Choose...</option>' + response;
                                $('#course').html(output);
                            }
                        }
                    });
                }
            });
            $(document).on('change', '#course', function () {
                let course = $(this).val();
                if ('' !== course) {
                    let _url = "{{route('course.batches', ':course')}}";
                    let __url = _url.replace(':course', course);
                    $.ajax({
                        url: __url,
                        method: "GET",
                        success: function (response) {
                            if ('' !== response) {
                                $('#batch').prop('disabled', false);
                                let output = '<option value="" hidden selected">Choose...</option>' + response;
                                $('#batch').html(output);
                            } else {
                                $('#batch').prop('disabled', true);
                            }
                        }
                    });
                }
            });
        });
    </script>
@endpush
