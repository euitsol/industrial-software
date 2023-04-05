@extends('layouts.master')

@section('title', 'Job Placement info')

@push('css')

@endpush

@section('content')
<div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <span class="float-left">
                            <h4>Job Placement Information View</h4>
                        </span>
                            <span class="float-right">
                            <a href="{{ route('job_placement.edit', $jp->id) }}" class="btn btn-sm btn-info">
                                <i class="fa fa-edit"></i>
                            </a>
                            <a href="{{ route('job_placement.profile.student.info', $jp->student_id) }}" class="btn btn-dark btn-sm">Back</a>
                        </span>
                    </div>

                    <div class="card-body">

                        <div class="row">
                            <div class="col-md-8 offset-md-2">
                                <div class="table-responsive">
                                    <table class="table table-borderless table-striped">
                                        <tr>
                                            <th>Company Name</th>
                                            <td>:</td>
                                            <td>{{$jp->linkageIndustry->company_name}}</td>
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
                                            <td>{{$jp->linkageIndustry->company_website ?? "N/A"}}</td>
                                        <tr>
                                        <tr>
                                            <th>Company Address</th>
                                            <td>:</td>
                                            <td>{{$jp->linkageIndustry->company_address}}</td>
                                        </tr>
                                        <tr>
                                            <th>Company Phone</th>
                                            <td>:</td>
                                            <td>{{$jp->linkageIndustry->contact_number ?? "N/A"}}</td>
                                        </tr>
                                        <tr>
                                            <th>Company Email</th>
                                            <td>:</td>
                                            <td>{{$jp->linkageIndustry->contact_email ?? "N/A"}}</td>
                                        </tr>
                                        <tr>
                                            <th>Created By</th>
                                            <td>:</td>
                                            <td>{{$jp->created_user->name}}</td>
                                        </tr>
                                        <tr>
                                            <th>Created Date</th>
                                            <td>:</td>
                                            <td>
                                                {{date('jS, F, Y', strtotime($jp->created_at))}}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Updated By</th>
                                            <td>:</td>
                                            <td>{{$jp->updated_user->name ?? "N/A"}}</td>
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

