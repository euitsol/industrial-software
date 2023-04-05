@extends('layouts.master')

@section('title', 'Linkage With Industry Information - European IT Solutions Institute')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10 col-lg-12">
                <div class="card">
                    <div class="card-header">
                    <span class="float-left">
                        <h4>Linkage With Industry Information</h4>
                    </span>
                        <span class="float-right">
                        <a href="{{ route('linkage_industry.info.edit', $data->id) }}" class="btn btn-sm btn-info">
                            <i class="fa fa-edit"></i>
                        </a>
                        <a href="{{ route('linkage_industry.info') }}" class="btn btn-info btn-sm">Back</a>
                    </span>
                    </div>

                    <div class="card-body">

                        <div class="row">
                            <div class="col-md-12">

                                <div class="row" id="info">
                                    <div class="col-md-8 m-auto">
                                        <div class="table-responsive">
        
                                            <table class="table table-striped table-borderless mt-3">
                                                <tbody>
                                                    <tr>
                                                        <th>Company Name</th>
                                                        <td>:</td>
                                                        <td> {{ $data->company_name }} </td>
                                                    </tr>
                                                    <tr>
                                                        <th>Company Logo</th>
                                                        <td>:</td>
                                                        <td>
                                                            @if (!empty($data->company_logo) && file_exists($data->company_logo))
                                                                <img src="{{ asset($data->company_logo) }}" height="50" width="50" alt="Company Logo">
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th>Company Website</th>
                                                        <td>:</td>
                                                        <td> {{ $data->company_website }} </td>
                                                    </tr>
                                                    <tr>
                                                        <th>Company Address</th>
                                                        <td>:</td>
                                                        <td> {{ $data->company_address }} </td>
                                                    </tr>
                                                    <tr>
                                                        <th>Contact Person Name</th>
                                                        <td>:</td>
                                                        <td> {{ $data->contact_person_name }} </td>
                                                    </tr>
                                                    <tr>
                                                        <th>Contact Number</th>
                                                        <td>:</td>
                                                        <td> {{ $data->contact_number }} </td>
                                                    </tr>
                                                    <tr>
                                                        <th>Contact email</th> 
                                                        <td>:</td>
                                                        <td> {{ $data->contact_email }} </td>
                                                    </tr>
                                                    <tr>
                                                        <th>Description</th> 
                                                        <td>:</td>
                                                        <td> {{ $data->description ?? '' }} </td>
                                                    </tr>
                                                    <tr>
                                                        <th>Created By</th>
                                                        <td>:</td>
                                                        <td> {{ $data->created_user->name }} </td>
                                                    </tr>
                                                    <tr>
                                                        <th>Created Date</th> 
                                                        <td>:</td>
                                                        <td> {{ date('jS, F, Y', strtotime($data->created_at)) }} </td>
                                                    </tr>
                                                    <tr>
                                                        <th>Updated By</th> 
                                                        <td>:</td>
                                                        <td> {{ $data->updated_user->name }} </td>
                                                    </tr>
                                            </tbody>
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
    </div>
@endsection

