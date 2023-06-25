@extends('layouts.master')

@section('title', 'Industrial Marketing Student')

@push('css')

@endpush

@section('content')
<div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <span class="float-left">
                            <h4>Industrial Marketing Student</h4>
                        </span>
                            <span class="float-right">
                            <a href="{{ route('industrial.marketing.student.edit',$student->id) }}" class="btn btn-sm btn-info">
                                <i class="fa fa-edit"></i>
                            </a>
                            <a href="{{ route('industrial.marketing.student') }}" class="btn btn-dark btn-sm">Back</a>
                        </span>
                    </div>

                    <div class="card-body">

                        <div class="row">
                            <div class="col-md-8 offset-md-2">
                                <div class="table-responsive">
                                    <table class="table table-borderless table-striped">
                                        <tr>
                                            <td>Name</td>
                                            <td>:</td>
                                            <td>{{ $student->name }}</td>
                                        </tr>
                                        <tr>
                                            <td>Phone</td>
                                            <td>:</td>
                                            <td>{{ $student->phone }}</td>
                                        </tr>
                                        <tr>
                                            <td>Year</td>
                                            <td>:</td>
                                            <td>{{ $student->year }}</td>
                                        </tr>
                                        <tr>
                                            <td>Institute</td>
                                            <td>:</td>
                                            <td>{{ optional($student->institute())->name }}</td>
                                        </tr>
                                        <tr>
                                            <td>Shift</td>
                                            <td>:</td>
                                            <td>
                                                @if($student->shift == 1)
                                                    1st Shift
                                                @else
                                                    2nd Shift
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Course</td>
                                            <td>:</td>
                                            <td>{{ optional($student->course())->title }}</td>
                                        </tr>
                                        <tr>
                                            <td>Note</td>
                                            <td>:</td>
                                            <td>{{ strip_tags($student->note) ?? '...' }}</td>
                                        </tr>
                                        <tr>
                                            <td>Created By</td>
                                            <td>:</td>
                                            <td>{{ optional($student->created_user)->name }}</td>
                                        </tr>
                                        <tr>
                                            <td>Created Date</td>
                                            <td>:</td>
                                            <td>{{ date('jS, F, Y'),strtotime($student->created_at) }}</td>
                                        </tr>
                                        <tr>
                                            <td>Updated By</td>
                                            <td>:</td>
                                            <td>{{ optional($student->updated_user)->name }}</td>
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

