@extends('layouts.master')

@section('title', 'Student Courses')

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
                        <h4>Student Courses For Payment</h4>
                    </span>
                        <span class="float-right">
                        <a href="{{ route('account') }}" class="btn btn-dark btn-sm">Back</a>
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
                                <tr>
                                    <th>SL</th>
                                    <th>Course</th>
                                    <th>Batch</th>
                                    <th>Payment</th>
                                    <th>Action</th>
                                </tr>
                                @foreach($courses as $key => $course)
                                    <tr>
                                        <td>{{$key + 1}}</td>
                                        <td>{{$course->title}}</td>
                                        <td>
                                            @if(isset($student->batches))
                                                @foreach($student->batches as $_batch)
                                                    @if($_batch->course_id == $course->id)
                                                        {{batch_name($course->title_short_form, $_batch->year, $_batch->month, $_batch->batch_number)}}
                                                        @break
                                                    @endif
                                                @endforeach
                                            @endif
                                        </td>
                                        <td>
                                            @if($course->payments > 0 && $course->total_fee > $course->payments)
                                                <span class="badge badge-warning">
                                                    Due : {{number_format(($course->total_fee - $course->payments), 2)}} Tk
                                                </span>
                                            @elseif($course->total_fee <= $course->payments)
                                                <span class="badge badge-success">Paid</span>
                                            @else
                                                <span class="badge badge-warning">
                                                    No payment found!
                                                </span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{route('account.payment', ['sid'=>$student->id, 'cid'=>$course->id])}}"
                                               class="btn btn-sm btn-primary">Payment</a>
                                        </td>
                                    </tr>
                                @endforeach
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

