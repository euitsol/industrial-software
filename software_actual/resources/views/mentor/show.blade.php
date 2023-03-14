@extends('layouts.master')

@section('title', 'Mentor - European IT Solutions Institute')

@push('css')
    <style>
        p {
            padding: 0 !important;
            margin: 5px 0 !important;
        }

        hr {
            margin-top: 0.5rem !important;
        }

        .c-obj {
            text-align: justify;
        }

        .personal-info table tr {
            margin: 0;
            padding: 0;
        }

        .personal-info table tr p {
            margin: 0 0 !important;
        }

        .personal-info table tr td {
            padding: 6px !important;
        }

        .personal-info table tr th {
            width: 33%;
            padding: 6px !important;
        }

        .address p {
            margin: 0 0 0 0px !important;
            margin-right: 5px !important;
        }

        .personal-info table tr th {
            padding-left: 0 !important;
        }

        .specialization table tr th, .specialization table tr td {
            padding: 5px 15px !important;
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
                        <h4>Mentor</h4>
                    </span>
                        <span class="float-right">
                        <a href="{{ route('mentor.personal-info.edit', $mentor->id) }}" class="btn btn-sm btn-dark">
                            <i class="fa fa-edit"></i> Edit
                        </a>
                        <a href="{{ route('mentors') }}" class="btn btn-info btn-sm">Back</a>
                    </span>
                    </div>

                    <div class="card-body">

                        <p>
                            <button type="button" class="btn btn-dark" onclick="printT('cv')">
                                <i class="fa fa-print"></i>
                            </button>
                        </p>

                        <div id="cv">
                            <div class="row" style="margin-top: 80px; font-size: 20px">
                                <div class="col-md-10 offset-md-1">

                                    <div class="row">
                                        <div class="col-md-9">
                                            <h3>{{$mentor->name}}</h3>
                                            <div class="address"><p class="float-left">Address :</p> {!! $mentor->present_address !!}</div>
                                            <div>Mobile : {{$mentor->phone}}</div>
                                            <div>E-Mail : {{$mentor->email}}</div>
                                        </div>
                                        <div class="col-md-3">
                                            <p class="text-right">
                                                @if (isset($mentor->photo))
                                                    <img src="{{asset($mentor->photo)}}" height="130" alt="">
                                                @else
                                                    <img src="" height="130" alt="Photo">
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                    <hr>

                                    <div class="career-objective">
                                        <p class="font-weight-bold">
                                            <u>Career Objective :</u>
                                        </p>
                                        <div class="c-obj"> {!! $mentor->career_objective !!} </div>
                                    </div>

                                    <div class="employment-history mt-4">
                                        <p class="font-weight-bold">
                                            <u>Employment History :</u>
                                        </p>
                                        @if ($mentor->employmentHistories)
                                            @foreach($mentor->employmentHistories as $eh)
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <p>{{$eh->from}} {{isset($eh->from) && empty($eh->to) ? ' - Present' : $eh->to}}</p>
                                                    </div>
                                                    <div class="col-md-8">
                                                        <p>{{$eh->office_name}}</p>
                                                        <p>{{$eh->address}}</p>
                                                        <p><i>{{$eh->designation}}</i></p>
                                                        <p><b>Responsibility :</b> {{$eh->responsibility}}</p>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>

                                    <div class="academic-qualification mt-4">
                                        <p class="font-weight-bold">
                                            <u>Academic Qualification :</u>
                                        </p>
                                        @if ($mentor->educations)
                                            @foreach($mentor->educations as $edu)
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <p>{{$edu->exam_title}}</p>
                                                    </div>
                                                    <div class="col-md-8">
                                                        <p>{!! $edu->institute ? '<b>Institute : </b>'.$edu->institute : '' !!}</p>
                                                        <p>{!! $edu->major ? '<b>Major : </b>'.$edu->major : '' !!}</p>
                                                        <p>{!! $edu->result ? '<b>Result : </b>'.$edu->result : '' !!}</p>
                                                        <p>{!! $edu->passing_year ? '<b>Passing Year : </b>'.$edu->passing_year : '' !!}</p>
                                                        <p>{!! $edu->duration ? '<b>Duration : </b>'.$edu->duration.' Years' : '' !!}</p>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>

                                    <div class="specialization mt-4">
                                        <p class="font-weight-bold mb-3">
                                            <u>Specialization :</u>
                                        </p>
                                        <table class="table table-bordered">
                                            <tr>
                                                <th style="width: 33%">Fields of Specialization</th>
                                                <th>Description</th>
                                            </tr>
                                            @if ($mentor->specializations)
                                                @foreach($mentor->specializations as $spe)
                                                    <tr>
                                                        <td>{{$spe->field_title}}</td>
                                                        <td>{{$spe->description}}</td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                        </table>
                                    </div>

                                    <div class="personal-info mt-4">
                                        <p class="font-weight-bold">
                                            <u>Personal Info :</u>
                                        </p>
                                        <table class="table table-borderless">
                                            <tr>
                                                <th>Father's Name</th>
                                                <td>:</td>
                                                <td>{{$mentor->fathers_name}}</td>
                                            </tr>
                                            <tr>
                                                <th>Mother's Name</th>
                                                <td>:</td>
                                                <td>{{$mentor->mothers_name}}</td>
                                            </tr>
                                            @if ($mentor->parents_phone)
                                                <tr>
                                                    <th>Parent's Phone</th>
                                                    <td>:</td>
                                                    <td>{{$mentor->parents_phone}}</td>
                                                </tr>
                                            @endif
                                            @if ($mentor->nid)
                                                <tr>
                                                    <th>NID</th>
                                                    <td>:</td>
                                                    <td>{{$mentor->nid}}</td>
                                                </tr>
                                            @endif
                                            <tr>
                                                <th>Present Address</th>
                                                <td>:</td>
                                                <td>{!! $mentor->present_address !!}</td>
                                            </tr>
                                            <tr>
                                                <th>Permanent Address</th>
                                                <td>:</td>
                                                <td>{!! $mentor->permanent_address !!}</td>
                                            </tr>
                                        </table>
                                    </div>

                                    <p>
                                        <u class="mr-3"><b>Declaration : </b></u> All the information given above is true.
                                    </p>

                                    <p>
                                        <b>Date : </b> {{date('d F, Y')}}
                                    </p>

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
    <script>
        function printT(el) {
            var rp = document.body.innerHTML;
            $(".dn").addClass('d-none');
            var pc = document.getElementById(el).innerHTML;
            document.body.innerHTML = pc;
            window.print();
            document.body.innerHTML = rp;
        }
    </script>
@endpush