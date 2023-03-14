@extends('layouts.master')

@section('title', 'Teacher - European IT Solutions Institute')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <span class="float-left">
                        <h4>Teacher</h4>
                    </span>
                    <span class="float-right">
                        <a href="{{ route('teacher.edit', $teacher->id) }}" class="btn btn-dark btn-sm">Edit</a>
                        <a href="{{ route('teachers.found', $teacher->institute_id) }}" class="btn btn-info btn-sm">Back</a>
                    </span>
                </div>

                <div class="card-body">
                    
                    <div class="row">
                        <div class="col-md-12">

                            @if (isset($teacher->photo))
                                <p class="text-center">
                                    <img src="{{asset($teacher->photo)}}" height="130" alt="">
                                </p>
                            @endif
                            
                            <div class="row">
                                <div class="col">
                                    <table class="table table-borderless">
                                        <tr>
                                            <td>Name</td>
                                            <td>:</td>
                                            <td>{{ $teacher->name }}</td>
                                        </tr>
                                        <tr>
                                            <td>Designation</td>
                                            <td>:</td>
                                            <td>{{ $teacher->designation }}</td>
                                        </tr>
                                        <tr>
                                            <td>Institute</td>
                                            <td>:</td>
                                            <td>{{ optional($teacher->institute)->name }}</td>
                                        </tr>
                                        <tr>
                                            <td>Biography</td>
                                            <td>:</td>
                                            <td>{!! $teacher->biography !!}</td>
                                        </tr>
                                        <tr>
                                            <td>Comments</td>
                                            <td>:</td>
                                            <td>{!! $teacher->comments !!}</td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="col">
                                    <table class="table table-borderless">
                                        <tr>
                                            <td>Phone</td>
                                            <td>:</td>
                                            <td>
                                                @foreach ($teacher->phones as $phone)
                                                    {{ $phone->phone }} <br>
                                                @endforeach
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Email</td>
                                            <td>:</td>
                                            <td>
                                                @foreach ($teacher->emails as $email)
                                                    {{ $email->email }} <br>
                                                @endforeach
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Present Address</td>
                                            <td>:</td>
                                            <td>{!! $teacher->present_address !!}</td>
                                        </tr>
                                        <tr>
                                            <td>Permanent Address</td>
                                            <td>:</td>
                                            <td>{!! $teacher->permanent_address !!}</td>
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
</div>
@endsection