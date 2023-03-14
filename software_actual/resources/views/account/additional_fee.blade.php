@extends('layouts.master')

@section('title', 'Late fee - European IT Solutions Institute')

@push('css')
@endpush

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <span class="float-left">
                        <h4>Assign late fee</h4>
                    </span>

                    </div>
                    <div class="card-body">
                        @if(session('success'))
                            <p class="alert alert-success text-center">
                                {{ session('success') }}
                            </p>
                        @elseif(session('error'))
                            <p class="alert alert-danger text-center">
                                {{ session('error') }}
                            </p>
                        @endif
                        
                        
                        
                        <div class="row">

                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                    <tr>
                                        <th class="align-middle text-center">Name</th>
                                        <th class="align-middle text-center">Phone</th>
                                        <th class="align-middle text-center">Batch</th>
                                        <th class="align-middle text-center">Total Due</th>
                                        <th class="align-middle text-center">Late Installment Date</th>
                                        <th class="align-middle text-center">Action</th>
                                    </tr>
                                    @foreach($data as $key => $dts)
                                        @foreach($dts as $details)
                                        <tr>
                                            <td class="align-middle text-center">{{ $details['student_name'] }}</td>
                                            <td class="align-middle text-center">{{ $details['student_phone'] }}</td>
                                            <td class="align-middle text-center">{{ $details['batch'] }}</td>
                                            <td class="align-middle text-center">{{ number_format($details['due']) }}</td>
                                            <td class="align-middle text-center">{{ date('d-m-y', strtotime($details['installment_date'])) }}</td>
                                            <td class="align-middle text-center">Action</td>
                                        </tr>
                                        @endforeach
                                    @endforeach
                                </table>
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