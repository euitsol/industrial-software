@extends('layouts.master')

@section('title', 'Session - European IT Solutions Institute')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10 col-lg-12">
                <div class="card">
                    <div class="card-header">
                    <span class="float-left">
                        <h4>Session</h4>
                    </span>
                        <span class="float-right">
                        <a href="{{ route('session.edit', $session->id) }}" class="btn btn-sm btn-info"><i class="fa fa-edit"></i></a>
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
                                                        <td>Session Name</td>
                                                        <td>:</td>
                                                        <td>{{ $session->name }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Start Time</td>
                                                        <td>:</td>
                                                        <td>{{ $session->start_time }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>End Time</td>
                                                        <td>:</td>
                                                        <td>{{ $session->end_time }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Status</td>
                                                        <td>:</td>
                                                        <td>{{ $session->getStatus() }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Created at</td>
                                                        <td>:</td>
                                                        <td>{{ $session->created_at}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Created by</td>
                                                        <td>:</td>
                                                        <td>{{ $session->created_user->name}}</td>
                                                    </tr>
                                                    @if ($session->updated_at)
                                                        <tr>
                                                            <td>Updated at</td>
                                                            <td>:</td>
                                                            <td>{{ $session->updated_at}}</td>
                                                        </tr>
                                                    @endif
                                                    @if ($session->updated_by)
                                                        <tr>
                                                            <td>Updated by</td>
                                                            <td>:</td>
                                                            <td>{{ $session->updated_user->name}}</td>
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

