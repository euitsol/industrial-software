@extends('layouts.master')
@section('title', 'Attendance Management - European IT Solutions Institute')


@push('css')
    <link rel="stylesheet" href="{{asset('assets/vendor/icheck-bootstrap/icheck-bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/vendor/jquery-ui/jquery-ui.css')}}">
@endpush



@push('css')
    <style>
        .info p i {
            color: #fb00ff;
            font-size: 15px;
        }
        .info p span {
            font-weight: 800;
            font-size: 15px;
            color: blue;
        }

        .info {
            margin-bottom: 25px;
            font-size: 17px;
        }

        .info p {
            margin-bottom: 1px !important;
        }
    </style>
@endpush

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-10 col-lg-12">
                <form action="{{ route('attendance.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="class" value="{{ $class }}">
                    <input type="hidden" name="batch_attendance_id" value="{{ $minfo->id }}">
                    <div class="card">
                        <div class="card-header">
                            <span class="float-left">
                                <h4>Attendance</h4>
                            </span>
                            <span class="float-right">
                                <a href="{{ route('attendance.page',$minfo->id) }}" class="btn btn-info">Back</a>
                            </span>
                        </div>
                        <div class="card-body">
                            <div class="info row d-flex justify-content-around">
                                <p><i class="fa fa-check-circle"></i><span> Course Type: </span>
                                    {{ $minfo->course_type }}
                                </p>
                                <p><i class="fa fa-check-circle"></i><span> Course: </span>
                                    {{ $minfo->course->title }}
                                </p>
                                <p><i class="fa fa-check-circle"></i> <span> Batch: </span>
                                    {{batch_name($minfo->batch->course->title_short_form, $minfo->batch->year, $minfo->batch->month, $minfo->batch->batch_number)}}
                                </p>
                                <p><i class="fa fa-check-circle"></i> <span> Mentor: </span>
                                    {{$minfo->mentorName($minfo->batch->id)}}
                                </p>
                                <p><i class="fa fa-check-circle"></i> <span>Total student:</span>
                                    {{ $minfo->countStd($minfo->batch->id) }}
                                </p>
                                <p><i class="fa fa-check-circle"></i> <span>Class:</span>
                                    {{ 'Class-' . $class }}
                                </p>
                            </div>
                            <div class="row justify-center">
                                <div class="col-md-2 text-center mb-3 mx-auto">
                                    <input type="text" name="date" id="date" placeholder="Select Date"
                                           class="form-control text-center" autocomplete="off" value="{{ $attendance_taken->date ?? date('Y-m-d') }}" disabled>
                                    @if ($errors->has('date'))
                                        <span class="text-danger">{{ $errors->first('date') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div >
                                <table id="table" class="table">
                                    <thead>
                                        <tr>
                                            <th>SL</th>
                                            <th>Student Name</th>
                                            <th>Student Phone</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($students as $key => $student)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $student->student->name }}</td>
                                                <td>{{ $student->student->phone }}</td>
                                                <input type="hidden" name="student[{{ $key }}][id]"
                                                    value="{{ $student->student->id }}">
                                                <td>
                                                    <div class="icheck-success d-inline">
                                                        <input type="radio"
                                                            name="student[{{ $key }}][attendance_status]"
                                                            id="attendance_check_{{ $key }}" value="1"
                                                            checked>
                                                        <label for="attendance_check_{{ $key }}" class="font-weight-bold">P </label>
                                                    </div>
                                                    <div class="icheck-danger d-inline">&nbsp;
                                                        <input type="radio"
                                                            name="student[{{ $key }}][attendance_status]"
                                                            id="attendance_check_a{{ $key }}" value="-1"
                                                            @isset($attendance_taken) @if ($attendance_taken->attendance($minfo->id, $student->student->id)) checked @endif
                                                            @endisset>
                                                        <label for="attendance_check_a{{ $key }}" class="font-weight-bold"> A</label>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-5">
                        <div class="col-md-3 text-center mx-auto">
                            @if(!empty($attendance_taken->date))
                                <button type="submit" class="btn btn-success mt-3">Update Attendance</button>
                            @else
                                <button type="submit" class="btn btn-success mt-3">Save Attendance</button>
                            @endif
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('js')
<script src="{{asset('assets/vendor/jquery-ui/jquery-ui.js')}}"></script>
<script>
    $("#date").datepicker({dateFormat: 'yy-mm-dd'});
</script>
@endpush
