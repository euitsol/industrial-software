@extends('layouts.master')

@section('title', 'Institute info - European IT Solutions Institute')

@push('css')

@endpush

@section('content')

<div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <span class="float-left">
                            <h4>Institute</h4>
                        </span>
                        <span class="float-right">
                            <a href="{{ route('institute.edit', $institute->id)
                            }}"
                               class="btn btn-sm btn-info">
                                <i class="fa fa-edit"></i>
                            </a>
                            <a href="{{ route('institutes') }}" class="btn btn-dark
                            btn-sm">Back</a>
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
                                            <td>
                                        <span class="font-weight-bold">{{
                                        $institute->name }}</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Website</td>
                                            <td>:</td>
                                            <td>{{ $institute->website }}</td>
                                        </tr>
                                        <tr>
                                            <td>District</td>
                                            <td>:</td>
                                            <td>{{ $institute->district }}</td>
                                        </tr>
                                        <tr>
                                            <td>Division</td>
                                            <td>:</td>
                                            <td>{{ $institute->division }}</td>
                                        </tr>
                                        <tr>
                                            <td>Address</td>
                                            <td>:</td>
                                            <td>{{ $institute->address }}</td>
                                        </tr>
                                        <tr>
                                            <td>Added By</td>
                                            <td>:</td>
                                            <td>{{ optional($institute->user)->name }}</td>
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