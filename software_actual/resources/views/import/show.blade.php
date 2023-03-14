@extends('layouts.master')

@section('title', 'Promotion Type')

@push('css')

@endpush

@section('content')
<div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <span class="float-left">
                            <h4>Promotion Type</h4>
                        </span>
                            <span class="float-right">
                            <a href="{{route('promotion_type.edit', $pt->id)}}" class="btn btn-sm btn-info">
                                <i class="fa fa-edit"></i>
                            </a>
                            <a href="{{ route('import') }}" class="btn btn-dark btn-sm">Back</a>
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
                                                <span class="font-weight-bold">{{ $pt->type }}</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Id</td>
                                            <td>:</td>
                                            <td>{{ $pt->id }}</td>
                                        </tr>                                        
                                        <tr>
                                            <td>Created at</td>
                                            <td>:</td>
                                            <td>{{ $pt->created_at }}</td>
                                        </tr>
                                        <tr>
                                            <td>Updated at</td>
                                            <td>:</td>
                                            <td>{{ $pt->updated_at }} </td>
                                        </tr>
                                        <tr>
                                            <td>Added By</td>
                                            <td>:</td>
                                            <td>{{$added_by->name}}</td>
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

