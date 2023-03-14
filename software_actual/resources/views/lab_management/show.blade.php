@extends('layouts.master')

@section('title', 'Lab Management - European IT Solutions Institute')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10 col-lg-12">
                <div class="card">
                    <div class="card-header">
                    <span class="float-left">
                        <h4>Lab Management</h4>
                    </span>
                        <span class="float-right">
                        <a href="{{ route('lab-management.edit', $lab->id) }}" class="btn btn-sm btn-info">
                            <i class="fa fa-edit"></i>
                        </a>
                        <a href="{{ url()->previous() }}" class="btn btn-info btn-sm">Back</a>
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
                                                        <td>Lab Name</td>
                                                        <td>:</td>
                                                        <td>{{ $lab->lab_name }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Capacity</td>
                                                        <td>:</td>
                                                        <td>{{ $lab->capacity }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Status</td>
                                                        <td>:</td>
                                                        <td>{{ $lab->getStatus() }}</td>
                                                    </tr>
                                                    @if ($lab->note)
                                                        <tr>
                                                            <td>note</td>
                                                            <td>:</td>
                                                            <td>{{ $lab->note }}</td>
                                                        </tr>
                                                    @endif
                                                    <tr>
                                                        <td>Created at</td>
                                                        <td>:</td>
                                                        <td>{{ $lab->created_at}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Created by</td>
                                                        <td>:</td>
                                                        <td>{{ $lab->created_user->name}}</td>
                                                    </tr>
                                                    @if ($lab->updated_at)
                                                        <tr>
                                                            <td>Updated at</td>
                                                            <td>:</td>
                                                            <td>{{ $lab->updated_at}}</td>
                                                        </tr>
                                                    @endif
                                                    @if ($lab->updated_by)
                                                        <tr>
                                                            <td>Updated by</td>
                                                            <td>:</td>
                                                            <td>{{ $lab->updated_user->name}}</td>
                                                        </tr>
                                                    @endif
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

