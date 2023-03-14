@extends('layouts.master')

@section('title', 'Account - European IT Solutions Institute')

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
                        <h4>Search Student For Assign Courses</h4>
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
                        <div class="col-md-8 offset-md-2">
                            <form action="{{ route('student.search.process') }}" method="POST" class="form-horizontal">
                                @csrf

                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label">Student</label>
                                    <div class="col-md-9">
                                        <select name="student" id="student" class="form-control form-control-success">
                                            <option value="">Choose...</option>
                                            @foreach ($students as $student)
                                                <option value="{{ $student->id }}">{{ $student->name }} ({{ $student->phone }})</option>
                                            @endforeach
                                        </select>
                                        <small>* Search by Student Name or Phone Number</small> <br>
                                        @if ($errors->has('student'))
                                            <span class="text-danger">{{ $errors->first('student') }}</span>
                                        @endif
                                        <script>document.getElementById('student').value="{{ old('student') }}";</script>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-9 ml-auto">
                                        <input type="submit" value="Search" class="btn btn-primary">
                                    </div>
                                </div>
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
    <script src="{{ asset('assets/vendor/select2/select2.min.js') }}"></script>
    <script type="text/javascript">
        $("#student").select2();
    </script>
@endpush