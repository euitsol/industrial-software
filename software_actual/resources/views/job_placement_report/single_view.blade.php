@extends('layouts.master')

@section('title', 'Student Job Placement Report View')

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
                        <h4>Student Job Placement Report View</h4>
                    </span>
                        <span class="float-right">
                        <a href="{{ url()->previous() }}" class="btn btn-dark btn-sm">Back</a>
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
                                                <td>{{ $jp->student->year.$jp->student->reg_no }}</td>
                                            </tr>
                                            <tr>
                                                <td>Name</td>
                                                <td>:</td>
                                                <td>{{ $jp->student->name }}</td>
                                            </tr>
                                            <tr>
                                                <td>Father's Name</td>
                                                <td>:</td>
                                                <td>{{ $jp->student->fathers_name }}</td>
                                            </tr>
                                            <tr>
                                                <td>Course</td>
                                                <td>:</td>
                                                <td>
                                                    @foreach($jp->student->courses as $key => $course)
                                                    <span class="badge badge-secondary">{{$course->title}}</span>
                                                    @endforeach
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Student As</td>
                                                <td>:</td>
                                                <td>{{ $jp->student->student_as }}</td>
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
                                                <td>{{ $jp->student->phone }}</td>
                                            </tr>
                                            <tr>
                                                <td>Institute</td>
                                                <td>:</td>
                                                <td>{{ optional($jp->student->institute)->name }} ({{ $jp->student->shift() }})</td>
                                            </tr>
                                            <tr>
                                                <td>Board Roll</td>
                                                <td>:</td>
                                                <td>{{ $jp->student->board_roll }}</td>
                                            </tr>
                                            <tr>
                                                <td>Batch</td>
                                                <td>:</td>
                                                <td>
                                                    @foreach($jp->student->courses as $key => $course)
                                                        <span class="badge badge-secondary">
                                                            @if(isset($jp->student->batches))
                                                                @foreach($jp->student->batches as $_batch)
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
                                                <td>{{ $jp->student->present_address }}</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </fieldset>

                        <div class="table-responsive">
                            <table class="table table-borderless table-striped">
                                <tr>
                                    <th>Company Name</th>
                                    <td>:</td>
                                    <td>{{$jp->company_name}}</td>
                                </tr>
                                <tr>
                                    <th>Designation</th>
                                    <td>:</td>
                                    <td>{{$jp->designation}}</td>
                                </tr>
                                <tr>
                                    <th>Department</th>
                                    <td>:</td>
                                    <td>{{$jp->department ?? "N/A"}}</td>
                                </tr>
                                <tr>
                                    <th>Joining Date</th>
                                    <td>:</td>
                                    <td>{{date('jS, F, Y', strtotime($jp->joining_date))}}</td>
                                </tr>
                                    <th>Company Website</th>
                                    <td>:</td>
                                    <td>{{$jp->company_web_url ?? "N/A"}}</td>
                                <tr>
                                <tr>
                                    <th>Company Address</th>
                                    <td>:</td>
                                    <td>{{$jp->company_address}}</td>
                                </tr>
                                <tr>
                                    <th>Company Phone</th>
                                    <td>:</td>
                                    <td>{{$jp->company_phone ?? "N/A"}}</td>
                                </tr>
                                <tr>
                                    <th>Company Email</th>
                                    <td>:</td>
                                    <td>{{$jp->company_email ?? "N/A"}}</td>
                                </tr>
                                <tr>
                                    <th>Created By</th>
                                    <td>:</td>
                                    <td>{{$jp->created_user->name}}</td>
                                </tr>
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

