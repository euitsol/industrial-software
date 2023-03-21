@extends('layouts.master')
@section('title', 'Attendance Report - European IT Solutions Institute')

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
@if (!empty($message)) 
    <p class="message">{{$message}}</p>
@endif

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4> Student Attendance </h4>
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
                            <div class="col-md-6 offset-md-3">

                                    <form action="{{route('attendance_batch.search')}}" method="post">
                                        @csrf

                                        <label for="course_type">Course Type</label>
                                        <select name="course_type" id="course_type" class="form-control  mb-2" required ='required'>
                                            <option value ='' hidden selected>Select Course Type</option>
                                            <option value="Industrial">Industrial</option>
                                        </select>

                                        <label for="course">Course</label>
                                        <select name="course" id="course" class="form-control  mb-2" required='required'>
                                            <option value ='' selected>Select Course Type</option>
                                        </select>

                                        <label for="batch">Batch</label>
                                        <select name="batch" id="batch" class="form-control  mb-2" required='required'>
                                            <option value ='' selected>Select Batch</option>
                                        </select>

                                        <input type="submit" onClick="CheckEmpty()" value="Search" class="btn-custom">
                                        <input type="reset" value="Reset" class="btn-custom">
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
    <script src="{{ asset('assets/vendor/jquery-ui/jquery-ui.js') }}"></script>
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
                                let output = '<option value="" hidden selected">Select Course</option>' + response;
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
                                let output = '<option value="" hidden selected">Select Batch</option>' + response;
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
    <script>
        // Reqired Script
        function CheckEmpty(){
            var course_type = document.getElementById('course_type');
            var couse = document.getElementById('course');
            var batch = document.getElementById('batch');
            var e = 0;
            if(course_type.value == ''){
                e++;
                course_type.reportValidity();
            }
            else if(couse.value == ''){
                e++;
                course.reportValidity();
            }
            else if(batch.value == ''){
                e++;
                batch.reportValidity();
            }
            if(e == 0){
                return true;
            }else{
                return false;
            }
        }
    </script>


@endpush


