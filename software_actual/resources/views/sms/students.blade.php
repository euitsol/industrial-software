
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
        .nav{
            padding-bottom: 20px !important;
            
        }

        .nav-item a{
            /* border: 1px solid grey !important; */
            /* background-color: #4680FF !important; */
            border-radius:0px !important;
            font-weight: 400  !important;
            color: #000000 !important;
        }
        .nav-tabs .nav-link.active{
            letter-spacing: 0px !important;
            background-color: #4680FF ;
            color : #FFFFFF !important;
            opacity: 1 !important;
        }

        

</style>

<link rel="stylesheet" href="{{ asset('assets/vendor/select2/select2.min.css') }}">


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
                            <h4>Send SMS to Students</h4>
                        </span>
                        <!-- <span class="float-right">
                            <a href=""
                            class="btn btn-primary btn-sm">Send Sms</a>
                        </span> -->
                    </div>
                    <div class="card-body " style="height:100vh">
                    @if (session('error'))
                            <p class="alert alert-danger text-center">
                                {{ session('error') }}
                            </p>
                    @elseif(session('success'))
                            <p class="alert alert-success text-center">
                                {{ session('success') }}
                            </p>
                    @endif                   
                    <div class="col-md-10 col-lg-12">
							<div class="card">
								<div class="card-header">
									<ul class="nav nav-tabs card-header-tabs pull-right" role="tablist">
                                    <li class="nav-item ">
											<a class="nav-link active" data-toggle="tab" href="#tab-1">Indivisual Student</a>
										</li>
										<li class="nav-item">
											<a class="nav-link " data-toggle="tab" href="#tab-2"> Batch Students</a>
										</li>
										
										<li class="nav-item">
											<a class="nav-link" data-toggle="tab" href="#tab-3">Course Students</a>
										</li>
									</ul>
								</div>
								<div class="card-body " >
									<div class="tab-content">
										<div class="tab-pane fade show active " id="tab-1" role="tabpanel">
                                        
                                            <div class="col-md-8 offset-md-2">
                                                <form action="{{route('sms.sms_students.search')}}" method="POST" >
                                                @csrf
                                                        <div class="form-group row">
                                                        <label class="col-md-3 form-control-label">Student</label>
                                                            <div class="col-md-9">
                                                                <select name="student_id" id="student" class="form-control" required>
                                                                    <option value="">Choose...</option>
                                                                    @foreach ($students as $student)
                                                                        <option value="{{ $student->id }}">{{ $student->name }} ({{ $student->phone }})---{{$student->student_as}}</option>
                                                                    @endforeach
                                                                </select>
                                                                <small>* Existing students search by Student Name or Phone Number</small> <br>
                                                                @if ($errors->has('student'))
                                                                    <span class="text-danger">{{ $errors->first('student') }}</span>
                                                                @endif
                                                                <script>document.getElementById('student').value="{{ old('student') }}";</script>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <div class="col-md-9 ml-auto">
                                                                <input type="submit" value="Go" class="btn btn-primary">
                                                            </div>
                                                        </div>
                                                </form>
                                            </div>
                                        
										</div>
										<div class="tab-pane fade " id="tab-2" role="tabpanel">
                                        <div class="row">
                                            <div class="col-md-8 offset-md-3">

                                                    <form action="{{route('sms.sms_students.search')}}" method="post">
                                                        @csrf

                                                        <label for="course_type">Course Type</label>
                                                        <select name="course_type" id="course_type" class="form-control  mb-2" required>
                                                            <option value="" hidden selected>Choose...</option>
                                                            <option value="Professional">Professional</option>
                                                            <option value="Industrial">Industrial</option>
                                                        </select>

                                                        <label for="course">Course</label>
                                                        <select name="course" id="course" class="form-control  mb-2" required>
                                                            <option value="" hidden selected>Choose...</option>
                                                        </select>

                                                        <label for="batch">Batch</label>
                                                        <select name="batch" id="batch" class="form-control  mb-2" required>
                                                            <option value="" hidden selected>Choose...</option>
                                                        </select>
                                                        <div class="mt-4">
                                                        <input type="submit" value="Search" class="btn-custom ">
                                                        <input type="reset" value="Reset" class="btn-custom">
                                                        </div>
                                                    </form>

                                            </div>
                                        </div>
										</div>
										<div class="tab-pane fade " id="tab-3" role="tabpanel">
                                        <div class="row">
                                            <div class="col-md-8 offset-md-3">

                                                    <form action="{{route('sms.sms_students.search')}}" method="post">
                                                        @csrf

                                                        <label for="course_type">Course Type</label>
                                                        <select name="course_type" id="course_type_2" class="form-control  mb-2" required>
                                                            <option value="" hidden selected>Choose...</option>
                                                            <option value="Professional">Professional</option>
                                                            <option value="Industrial">Industrial</option>
                                                        </select>

                                                        <label for="course">Course</label>
                                                        <select name="course" id="course_2" class="form-control  mb-2" required>
                                                            <option value="" hidden selected>Choose...</option>
                                                        </select>
                                                        <div class="mt-4">
                                                            <input type="submit" value="Search" class="btn-custom ">
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
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script src="{{ asset('assets/vendor/select2/select2.min.js') }}"></script>
    <script type="text/javascript">
        $("#student").select2();
    </script>
    <script src="{{ asset('assets/vendor/jquery-ui/jquery-ui.js') }}"></script>
    <script>
        $(function () {
            if ('' !== $('#course_type')) {
                $('#course').prop('disabled', true);
                $('#course_2').prop('disabled', true);
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

// for Course Students
            $(document).on('change', '#course_type_2', function () {
                let course_type = $(this).val();
                if ('' !== course_type) {
                    let _url = "{{route('courses.type', ':course_type')}}";
                    let __url = _url.replace(':course_type', course_type);
                    $.ajax({
                        url: __url,
                        method: "GET",
                        success: function (response) {
                            if ('' !== response) {
                                $('#course_2').prop('disabled', false);
                                let output = '<option value="" hidden selected">Choose...</option>' + response;
                                $('#course_2').html(output);
                            }
                        }
                    });
                }
            });
        });
    </script>
@endpush




