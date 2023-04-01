@extends('layouts.master')

@section('title', 'Student Job Placement Info')

@push('css')
    <style>
        fieldset {
            width: 100% !important;
            padding: 5px !important;
            border: 1px solid lightgray;
        }

        legend {
            width: auto;
            font-size: 20px;
        }

        table, tr, td {
            margin: 0 !important;
            padding: 5px !important;
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
                        <h4>Student Information With Job Placement</h4>
                    </span>
                        <span class="float-right">
                        <a href="{{ route('job_placement.profile') }}" class="btn btn-dark btn-sm">Back</a>
                    </span>
                    </div>

                    <div class="card-body">

                        <fieldset class="mb-3">
                            <legend>Student Information</legend>
                            <div class="row">
                                <div class="col">
                                    <div class="table-responsive">
                                        <table class="table table-borderless">
                                            <tr>
                                                <td>ID</td>
                                                <td>:</td>
                                                <td>{{ $student->year.$student->reg_no }}</td>
                                            </tr>
                                            <tr>
                                                <td>Name</td>
                                                <td>:</td>
                                                <td>{{ $student->name }}</td>
                                            </tr>
                                            <tr>
                                                <td>Father's Name</td>
                                                <td>:</td>
                                                <td>{{ $student->fathers_name }}</td>
                                            </tr>
                                            <tr>
                                                <td>Course</td>
                                                <td>:</td>
                                                <td>
                                                    @foreach($courses as $key => $course)
                                                    <span class="badge badge-secondary">{{$course->title}}</span>
                                                    @endforeach
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Student As</td>
                                                <td>:</td>
                                                <td>{{ $student->student_as }}</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="table-responsive">
                                        <table class="table table-borderless">
                                            <tr>
                                                <td>Phone</td>
                                                <td>:</td>
                                                <td>{{ $student->phone }}</td>
                                            </tr>
                                            <tr>
                                                <td>Institute</td>
                                                <td>:</td>
                                                <td>{{ optional($student->institute)->name }} ({{ $student->shift() }})</td>
                                            </tr>
                                            <tr>
                                                <td>Board Roll</td>
                                                <td>:</td>
                                                <td>{{ $student->board_roll }}</td>
                                            </tr>
                                            <tr>
                                                <td>Batch</td>
                                                <td>:</td>
                                                <td>
                                                    @foreach($courses as $key => $course)
                                                        <span class="badge badge-secondary">
                                                            @if(isset($student->batches))
                                                                @foreach($student->batches as $_batch)
                                                                    @if($_batch->course_id == $course->id)
                                                                        {{batch_name($course->title_short_form, $_batch->year, $_batch->month, $_batch->batch_number)}}
                                                                        @break
                                                                    @endif
                                                                @endforeach
                                                            @endif
                                                        </span>
                                                    @endforeach
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Present Address</td>
                                                <td>:</td>
                                                <td>{{ $student->present_address }}</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </fieldset>

                        @if(session('success'))
                            <p class="alert alert-success text-center">
                                {{ session('success') }}
                            </p>
                        @elseif(session('error'))
                            <p class="alert alert-danger text-center">
                                {{ session('error') }}
                            </p>
                        @endif

                        
                        <div class="table-responsive mt-3">
                            <table class="table table-striped">
                                <thead>
                                    <div class="d-flex justify-content-between align-items-center my-4">
                                        <h4 class="m-0">Job Placement Information</h4>
                                        @if(!$job_placement)
                                        <a href="{{route('job_placement.create', $student->id)}}" class="btn btn-sm btn-info">Add Job Placement</a>
                                        @endif
                                    </div>
                                </thead>
                                <tbody>
                                    <tr>
                                        <th>SL</th>
                                        <th>Company</th>
                                        <th>Designation</th>
                                        {{-- <th>Department</th> --}}
                                        <th>Joining Date</th>
                                        <th>Company Website</th>
                                        <th>Company Address</th>
                                        {{-- <th>Company Phone</th> --}}
                                        {{-- <th>Company Email</th> --}}
                                        <th>Action</th>
                                    </tr>
                                    @if($job_placement)
                                    <tr>
                                        <td>{{$key + 1}}</td>
                                        <td>{{$job_placement->company_name}}</td>
                                        <td>{{$job_placement->designation}}</td>
                                        {{-- <td>{{$job_placement->department ?? "N/A"}}</td> --}}
                                        <td>{{date('jS, F, Y', strtotime($job_placement->joining_date))}}</td>
                                        <td>{{$job_placement->company_web_url ?? "N/A"}}</td>
                                        <td>{{$job_placement->company_address}}</td>
                                        {{-- <td>{{$job_placement->company_phone ?? "N/A"}}</td> --}}
                                        {{-- <td>{{$job_placement->company_email ?? "N/A"}}</td> --}}
                                        <td style="min-width: 88px;">
                                            <a href="{{ route('job_placement.show', $job_placement->id) }}"
                                                class="btn btn-sm btn-dark">
                                                 <i class="fa fa-eye"></i>
                                             </a>
                                            <a href="{{ route('job_placement.edit', $job_placement->id) }}"
                                                class="btn btn-sm btn-info">
                                                 <i class="fa fa-edit"></i>
                                             </a>
                                        </td>
                                    </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                        

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')

@endpush

