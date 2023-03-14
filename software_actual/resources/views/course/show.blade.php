@extends('layouts.master')

@section('title', 'Course')

@push('css')

@endpush

@section('content')
<div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <span class="float-left">
                            <h4>Course</h4>
                        </span>
                            <span class="float-right">
                            <a href="{{ route('course.edit', $course->id) }}" class="btn btn-sm btn-info">
                                <i class="fa fa-edit"></i>
                            </a>
                            <a href="{{ route('courses') }}" class="btn btn-dark btn-sm">Back</a>
                        </span>
                    </div>

                    <div class="card-body">

                        <div class="row">
                            <div class="col-md-8 offset-md-2">
                                <div class="table-responsive">
                                    <table class="table table-borderless table-striped">
                                        <tr>
                                            <td>Title</td>
                                            <td>:</td>
                                            <td>
                                                <span class="font-weight-bold">{{ $course->title }}</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Course Sector</td>
                                            <td>:</td>
                                            <td>{{ optional($course->course_type)->type_name }}</td>
                                        </tr>
                                        <tr>
                                            <td>Duration</td>
                                            <td>:</td>
                                            <td>{{ $course->duration }}</td>
                                        </tr>
                                        <tr>
                                            <td>Weekly <small>(Days)</small> </td>
                                            <td>:</td>
                                            <td>{{ $course->weekly_days }} Day(s)</td>
                                        </tr>
                                        <td>Total Class </td>
                                            <td>:</td>
                                            <td>{{ $course->total_class}}</td>
                                        <tr>
                                        <tr>
                                            <td>Time <small>(Hours)</small> </td>
                                            <td>:</td>
                                            <td>{{ $course->class_total_time }} Hour(s)</td>
                                        </tr>
                                        <tr>
                                            <td>Type</td>
                                            <td>:</td>
                                            <td>
                                                <span class="badge badge-blue">{{ $course->type }}</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Fee</td>
                                            <td>:</td>
                                            <td>{{ $course->fee }} Tk</td>
                                        </tr>
                                        <tr>
                                            <td>Added By</td>
                                            <td>:</td>
                                            <td>{{ optional($course->user)->name }}</td>
                                        </tr>
                                    </table>
                                </div>
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

