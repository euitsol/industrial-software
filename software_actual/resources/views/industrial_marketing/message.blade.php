@extends('layouts.master')
@section('title', 'Message - European IT Solutions Institute')

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

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Industrial student message</h4>
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

                                    <form action="{{ route('marketing.industrial.message.search') }}" method="post">
                                        @csrf

                                        <label for="course_type">Year</label>
                                        <select name="year" id="year" class="form-control  mb-2" required>
                                            <option value="">Choose...</option>
                                            @foreach($years as $year)
                                                <option value="{{ $year->year }}" {{ $current_year == $year->year ? 'selected' : '' }}>{{ $year->year }}</option>
                                            @endforeach
                                        </select>

                                        <label for="institute">Institute</label>
                                        <select name="institute" id="institute" class="form-control  mb-2">
                                            <option value="">All</option>
                                            @foreach($institutes as $institute)
                                            @php $inst = App\Models\Institute::find($institute->institute); @endphp
                                            @if($inst)
                                            <option value="{{ $inst->id }}">{{ $inst->name }}</option>
                                            @endif
                                            @endforeach
                                        </select>

                                        <label for="course">Course</label>
                                        <select name="course" id="course" class="form-control  mb-2">
                                            <option value="">All</option>
                                            @foreach($courses as $course)
                                            <option value="{{ $course->id }}">{{ $course->title }}</option>
                                            @endforeach
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



@endpush

