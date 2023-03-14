@extends('layouts.master')

@section('title', 'Mentor Payment Info - European IT Solutions Institute')

@push('css')
    <link rel="stylesheet" href="{{ asset('assets/vendor/select2/select2.min.css') }}">
@endpush

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Mentor Payment Info</h4>
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

                        <div class="clearfix">
                            <div class="float-left">
                                <p>Mentor Name : <b>{{ $mentor->name }}</b></p>
                                <p>Mentor Phone : {{ $mentor->phone }}</p>
                            </div>
                            <div class="float-right">
                                <img src="{{ asset($mentor->photo) }}" height="100" alt="Mentor Photo">
                            </div>
                        </div>

                        @if ($mpis->count())
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <tr>
                                        <th>SL</th>
                                        <th>Year</th>
                                        <th>Course</th>
                                        <th>Batch</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                    @foreach ($mpis as $mpi_k => $mpi)
                                        <tr>
                                            <td>{{ ++$mpi_k }}</td>
                                            <td>{{ $mpi->year }}</td>
                                            <td>{{ $mpi->course->title }} ({{ $mpi->course->type }})</td>
                                            <td>{{ batch_name($mpi->course->title_short_form, $mpi->batch->year, $mpi->batch->month, $mpi->batch->batch_number) }}</td>
                                            <td>
                                                @if ($mpi->per_class_payment && (($mpi->total_class * $mpi->per_class_payment) <= $mpi->mentor_payments->sum('amount')))
                                                    <div class="badge badge-success">Paid</div>
                                                @elseif($mpi->batch_wise_payment && ($mpi->batch_wise_payment <= $mpi->mentor_payments->sum('amount')))
                                                    <div class="badge badge-success">Paid</div>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('mentor.payment.p', $mpi->id) }}"
                                                   class="btn btn-info btn-sm">Payment</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </table>
                            </div>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="{{ asset('assets/vendor/select2/select2.min.js') }}"></script>
@endpush