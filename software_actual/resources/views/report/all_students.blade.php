@extends('layouts.master')

@section('title', '')

@push('css')
    <style>
        .course_type {
            list-style-type: upper-roman;
            margin-left: 15px;
            font-weight: bold;
        }

        .course_name {
            list-style-type: upper-alpha;
            margin-left: 20px;
            font-weight: normal;
        }

        .batch_number {
            list-style-type: decimal;
            margin-left: 20px;
        }

        ol {
            padding-left: 0px;
            margin-top: 7px;
        }

        .table-responsive {
            width: calc(100% + 16px);
            margin-left: -16px;
            margin-top: 7px;
            margin-bottom: 10px;
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
                        <h4> Report </h4>
                    </span>
                        <span class="float-right">
                        <h4> All Students </h4>
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

                        <ol>
                            @forelse($course_types as $ct)
                                <li class="course_type">
                                    <h6>{{$ct->type_name}}</h6>
                                    <ol>
                                        @forelse($ct->courses as $course)
                                            @if ($course->batches->count() > 0 && $course->students->count() > 0)
                                                <li class="course_name">
                                                    {{$course->title}}
                                                    <ol>
                                                        @foreach ($course->batches as $batch)
                                                            @if ($batch->students->count() > 0)
                                                                <li class="batch_number">
                                                                    {{batch_name($batch->course->title_short_form, $batch->year, $batch->month, $batch->batch_number)}}
                                                                    <div class="table-responsive">
                                                                        <table class="table table-bordered">
                                                                            <tr>
                                                                                <th>SL</th>
                                                                                <th>Name</th>
                                                                                <th>Phone</th>
                                                                                <th>Institute</th>
                                                                            </tr>
                                                                            @if ($batch->students->count() > 0)
                                                                                @foreach($batch->students as $key => $student)
                                                                                    <tr>
                                                                                        <td>{{++$key}}</td>
                                                                                        <td>{{$student->name}}</td>
                                                                                        <td>{{$student->phone}}</td>
                                                                                        <td>{{optional($student->institute)->name}}</td>
                                                                                    </tr>
                                                                                @endforeach
                                                                            @endif
                                                                        </table>
                                                                    </div>
                                                                </li>
                                                            @endif
                                                        @endforeach
                                                    </ol>
                                                </li>
                                            @endif
                                        @empty

                                        @endforelse
                                    </ol>
                                </li>
                            @empty

                            @endforelse
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')

@endpush