@extends('layouts.master')

@section('title', 'Mentor Payment History - European IT Solutions Institute')

@push('css')
    <link rel="stylesheet" href="{{ asset('assets/vendor/data-table/css/jquery.dataTables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/data-table/css/buttons.dataTables.min.css') }}">
@endpush

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Mentor Payment History</h4>
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

                        <div class="table-responsive">
                            <table class="table" id="table">
                                <thead>
                                <tr>
                                    <th>SL</th>
                                    <th>Year</th>
                                    <th>Mentor</th>
                                    <th>Phone</th>
                                    <th>Course</th>
                                    <th>Batch</th>
                                    <th>Payable Amount</th>
                                    <th>Paid</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse ($mpis as $mpi_k => $mpi)
                                    <tr>
                                        <td>{{ ++$mpi_k }}</td>
                                        <td>{{ $mpi->year }}</td>
                                        <td>{{ $mpi->mentor_name }}</td>
                                        <td>{{ $mpi->mentor_phone }}</td>
                                        <td>{{ $mpi->course->title }}</td>
                                        <td>{{ batch_name($mpi->course->title_short_form, $mpi->batch->year, $mpi->batch->month, $mpi->batch->batch_number) }}</td>
                                        <td>
                                            @if ($mpi->per_class_payment)
                                                {{ number_format($mpi->per_class_payment * $mpi->total_class, 2) }}
                                            @elseif ($mpi->batch_wise_payment)
                                                {{ number_format($mpi->batch_wise_payment, 2) }}
                                            @endif
                                        </td>
                                        <td>{{ $mpi->mentor_payments->sum('amount') }}</td>
                                    </tr>
                                @empty
                                @endforelse
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
<script src="{{ asset('assets/vendor/data-table/js/jquery-3.3.1.js') }}"></script>
<script src="{{ asset('assets/vendor/data-table/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/vendor/data-table/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('assets/vendor/data-table/js/buttons.html5.min.js') }}"></script>
<script>
    $(document).ready(function() {
        $('#table').DataTable( {
            dom: 'Bfrtip',
            buttons: [
                 'pageLength'
            ]
        });
    } );
</script>
@endpush