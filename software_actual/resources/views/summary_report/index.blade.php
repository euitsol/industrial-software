@extends('layouts.master')
@section('title', 'Summary Report - European IT Solutions Institute')

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
                        <h4> Summary report </h4>
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

                                    <form action="{{route('summary_report.search')}}" method="post">
                                        @csrf

                                        <label for="course_type">Course Type</label>
                                        <select name="course_type" id="course_type" class="form-control  mb-2">
                                            <option value="all">All</option>
                                            <option value="Professional">Professional</option>
                                            <option value="Industrial">Industrial</option>
                                        </select>

                                        <label for="course">Course</label>
                                        <select name="course" id="course" class="form-control  mb-2">
                                            <option value="" hidden selected>All</option>
                                        </select>

                                        <label for="batch">Batch</label>
                                        <select name="batch" id="batch" class="form-control  mb-2">
                                            <option value="" hidden selected>All</option>
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
@endsection

@push('js')
    <script src="{{ asset('assets/vendor/jquery-ui/jquery-ui.js') }}"></script>
<!--     

<script>
        let dateToday = new Date();
        $('#from_date, #to_date').datepicker({
            dateFormat: 'dd-mm-yy',
            maxDate: dateToday
        }).datepicker('setDate', new Date());

        function printT(el, title = '') {
            let rp = document.body.innerHTML;
            let pc = document.getElementById(el).innerHTML;
            document.body.innerHTML = pc;
            document.title = title ? title : '';
            window.print();
            document.body.innerHTML = rp;
        }
    </script>


     -->



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
                                let output = '<option value="" hidden selected">All</option>' + response;
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
                                let output = '<option value="" hidden selected">All</option>' + response;
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


