@extends('layouts.master')
@section('title', 'Attendance - European IT Solutions Institute')

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
                <div class="card">

                    @if(session('success'))
                        <p class="alert alert-success text-center">
                            {{ session('success') }}
                        </p>
                    @elseif(session('error'))
                        <p class="alert alert-danger text-center">
                            {{ session('error') }}
                        </p>
                    @endif

                    <div class="card-header">
                        <span class="float-left">
                            <h4>Classes for {{ $minfo->course->title }}</h4>
                        </span>
                        <span class="float-right">
                                <a href="{{ route('attendance') }}" class="btn btn-info">Back</a>
                        </span>

                    </div>
                    <div class="card-body">
                        <div class="info row">
                            <div class="col-md-12 mx-auto d-flex justify-content-around">
                                <p><i class="fa fa-check-circle"></i><span> Course Type: </span>
                                    {{ $minfo->course_type }}
                                </p>
                                <p><i class="fa fa-check-circle"></i> <span> Course: </span>
                                    {{ $minfo->course->title }}
                                </p>
                                <p><i class="fa fa-check-circle"></i> <span> Batch: </span>
                                    {{batch_name($minfo->batch->course->title_short_form, $minfo->batch->year, $minfo->batch->month, $minfo->batch->batch_number)}}
                                </p>
                                <p><i class="fa fa-check-circle"></i> <span> Mentor: </span>
                                    {{$minfo->mentorName($minfo->batch->id)}}
                                </p>
                                <span >
                                    <a href="{{ route('attendance.report',[$minfo->id]) }}" class="btn btn-info">Report</a>
                                </span>
                            </div>
                            <div class="col-md-6 mx-auto mt-4">
                                <div class="card">
                                    <table id='table' class="table w-100">
                                        <thead>
                                            <tr>
                                                <th>Class</th>
                                                <th>Date</th>
                                                <th class="text-center">Attendance</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @for ($i = 1; $i <= $minfo->course->total_class/2; $i++)
                                                
                                                    <tr>
                                                        <td> {{ 'Class-' . $i }}</td>
                                                        <td id='date{{ $i }}'>{{ $minfo->getDate($i)->date ?? '' }}</td>
                                                        <td class="text-center">
                                                            <span
                                                                class="btn btn-sm @if (isset($minfo->getDate($i)->date)) btn-info @else btn-warning @endif">{{ $minfo->countStd($minfo->batch->id) ?? '' }}/{{ $minfo->countPresentStd($i) ?? '' }}
                                                            </span>
                                                            
                                                            @if(Auth::user()->role == 'admin' || Auth::user()->role == 'admin')
                                                            <a class="btn btn-sm btn-success" title="Click for attendance"href="{{ route('attendance.create', [$minfo->id, $i]) }}"><i class="fas fa-arrow-right text-white"></i></a>
                                                            @elseif((empty($minfo->getDate($i)->date) || $minfo->getDate($i)->date == date('Y-m-d')) && Auth::user()->mentor_id != null)
                                                            <a class="btn btn-sm btn-success" title="Click for attendance"href="{{ route('attendance.create', [$minfo->id, $i]) }}"><i class="fas fa-arrow-right text-white"></i></a>
                                                            @endif
                                                        </td>
                                                    </tr>
                                            @endfor
                                        </tbody>
                                    </table>                           
                                </div>
                            </div>
                            <div class="col-md-6 mx-auto mt-4">
                                <div class="card">
                                    <table id='table' class="table w-100">
                                        <thead>
                                            <tr>
                                                <th>Class</th>
                                                <th>Date</th>
                                                <th class="text-center">Attendance</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @for ($i =($minfo->course->total_class/2) + 1; $i <= $minfo->course->total_class; $i++)
                                                
                                                    <tr>
                                                        <td> {{ 'Class-' . $i }}</td>
                                                        <td>{{ $minfo->getDate($i)->date ?? '' }}</td>
                                                        <td class="text-center">
                                                            <span
                                                                class="btn btn-sm @if (isset($minfo->getDate($i)->date)) btn-info @else btn-warning @endif">{{ $minfo->countStd($minfo->batch->id) ?? '' }}/{{ $minfo->countPresentStd($i) ?? '' }}
                                                            </span>
                                                            <a class="btn btn-sm btn-success" title="Click for attendance"
                                                                href="{{ route('attendance.create', [$minfo->id, $i]) }}"><i class="fas fa-arrow-right text-white"></i></a>
                                                        </td>
                                                    </tr>
                                            @endfor
                                        </tbody>
                                    </table>                           
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection
    @push('page_scripts')
    @endpush
