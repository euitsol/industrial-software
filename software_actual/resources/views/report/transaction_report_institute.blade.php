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
                            <h4> Transaction Report - Institute </h4>
                        </span>
                    </div>

                    <div class="card-body">

                        @if (session('success'))
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

                                        <label for="year">Year</label><span class="text-danger">*</span>
                                        <select name="year" id="year" class="form-control">
                                            <option value="" disabled hidden selected> Choose...</option>
                                            @foreach ($years as $year)
                                                <option value="{{ $year }}">{{ $year }}</option>
                                            @endforeach
                                        </select>
                                        <small>Student Admission Year</small><br>
                                        @if ($errors->has('year'))
                                            <span class="text-danger">{{ $errors->first('year') }}</span> <br>
                                        @endif

                                    </div>
                                    <div class="form-group">
                                        <label for="institute">Institute</label><span class="text-danger">*</span>
                                        <select name="institute" id="institute" class="form-control mb-2" required disabled>
                                            <option value="" selected hidden>Choose...</option>
                                        </select>
                                        @if ($errors->has('institute'))
                                            <p class="text-danger">{{ $errors->first('institute') }}</p>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label for="shift">Shift</label><span class="text-danger">*</span>
                                        <select name="shift" id="shift" class="form-control mb-2" required>
                                            <option value="" selected hidden>Choose...</option>
                                            <option value="all"> All Shift</option>
                                            <option value="1"> 1st Shift</option>
                                            <option value="2"> 2nd Shift</option>
                                            <option value=""> Other Shift</option>
                                        </select>
                                        @if ($errors->has('shift'))
                                            <p class="text-danger">{{ $errors->first('shift') }}</p>
                                        @endif
                                    </div>
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
    <script>
        $(document).ready(function() {
            $("#year_s").on('change', function() {
                var year = $(this).val();
                var _url = "{{ route('report.get_year_institute', ':year') }}";
                _url = _url.replace(':year', year);
                $.ajax({
                    url: _url,
                    method: "GET",
                    success: function(institutes) {
                        var result = '';
                        institutes.forEach(institute => {
                            result += '<option value="' + institute.id + '">' +
                                institute.name + '</option>';
                        })
                        $("#institute").prop("disabled", false);
                        $("#institute").html(result);
                    }
                });

            });
        });
    </script>
@endpush
