@extends('layouts.master')

@section('title', 'Teacher Payment History - European IT Solutions Institute')

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
                        <h4>Teacher Payment History</h4>
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
                                    <th>Institute</th>
                                    <th>Teacher</th>
                                    <th>Total Students</th>
                                    <th>Per Student Payment</th>
                                    <th>Amount</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse ($tpis as $tpi_k => $tpi)
                                    <tr>
                                        <td>{{ ++$tpi_k }}</td>
                                        <td>{{ $tpi->year ?? '' }}</td>
                                        <td>{{ $tpi->institute->name  ?? ''}}</td>
                                        <td>{{ $tpi->responsible_teacher_name ?? '' }}</td>
                                        <td>{{ $tpi->total_student ?? '' }}</td>
                                        <td>{{ number_format($tpi->per_student_payment, 2)  ?? ''}}</td>
                                        <td>{{ number_format($tpi->teacher_payments->sum('amount'), 2)  ?? ''}}</td>
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