@extends('layouts.master')

@section('title', 'SMS  - European IT Solutions Institute')

@push('js')
    <link rel="stylesheet" href="{{asset('assets/vendor/jquery-ui/jquery-ui.css')}}">
@endpush

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10 col-lg-12">
                <div class="card">
                    <div class="card-header">
                    <span class="float-left">
                        <h4>SMS Info</h4>
                    </span>
                    <span class="float-right">
                        <a href="{{ redirect()->back()->getTargetUrl() }}" class="btn btn-info btn-sm">Back</a>
                    </span>
                        
                    </div>

                    <div class="card-body">

                        <div class="row" id="info">
                            <div class="col-md-8 offset-md-2">
                                <div class="table-responsive">

                                    <table class="table table-striped table-borderless mt-3">
                                        <tr>
                                            <td>Id</td>
                                            <td>:</td>
                                            <td>{{$data->id}}</td>
                                        </tr>
                                        <tr>
                                            <td>Type</td>
                                            <td>:</td>
                                            <td>{{$data->type}}</td>
                                        </tr>
                                        <tr>
                                            <td>Message</td>
                                            <td>:</td>
                                            <td>{{$data->message}}</td>
                                        </tr>
                                        <tr>
                                            <td>Status</td>
                                            <td>:</td>
                                                @if($data->status == "1")
                                                    <td class="align-middle"><span class="badge badge-success">Successful</span></td>
                                                @else
                                                    <td class="align-middle"><span class="badge badge-danger">{{ $data->status }}</span></td>
                                                @endif
                                        </tr>
                                        <tr>
                                            <td>Receiver No</td>
                                            <td>:</td>
                                            <td>
                                                {{$data->receiver_no}}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Sending time</td>
                                            <td>:</td>
                                            <td>
                                                {{$data->created_at}}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Sender</td>
                                            <td>:</td>
                                            @foreach($user_data as $ud)
                                                @if($ud->id == $data->user_id)
                                                        <td class="align-middle">{{ $ud->name }}</td>
                                                @endif
                                            @endforeach
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
