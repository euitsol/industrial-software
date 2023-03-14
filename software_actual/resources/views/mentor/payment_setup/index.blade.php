@extends('layouts.master')

@section('title', 'Mentor Payment Setup - European IT Solutions Institute')

@push('css')

@endpush

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10 col-lg-12">
                <div class="card">
                    <div class="card-header">
                    <span class="float-left">
                        <h4>Mentor Payment Setup</h4>
                    </span>
                        <span class="float-right">
                        <a href="{{ route('mentor.payment.setup', $mentor->id) }}" class="btn btn-primary btn-sm">Add New</a>
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
                                        <th>Total Class</th>
                                        <th>Per Class Payment</th>
                                        <th>Batch Payment</th>
                                        <th>Action</th>
                                    </tr>
                                    @foreach ($mpis as $mpi_k => $mpi)
                                        <tr>
                                            <td>{{ ++$mpi_k }}</td>
                                            <td>{{ $mpi->year }}</td>
                                            <td>{{ $mpi->course->title }} ({{ $mpi->course->type }})</td>
                                            <td>{{ batch_name($mpi->course->title_short_form, $mpi->batch->year, $mpi->batch->month, $mpi->batch->batch_number) }}</td>
                                            <td>{{ $mpi->total_class }}</td>
                                            <td>{{ $mpi->per_class_payment ? number_format($mpi->per_class_payment, 2) : '---' }}</td>
                                            <td>{{ $mpi->batch_wise_payment ? number_format($mpi->batch_wise_payment, 2) : '---' }}</td>
                                            <td>
                                                <div class="btn-group">
                                                    <a href="{{ route('mentor.payment-setup.edit', $mpi->id) }}" class="btn btn-info btn-sm">
                                                        <i class="fa fa-edit"></i>
                                                    </a>
                                                    <a href="javascript:void(0)" class="btn btn-sm btn-danger"
                                                       id="delete_button">
                                                        <i class="fa fa-trash"></i>
                                                    </a>

                                                    <form action="{{ route('mentor.payment-setup.delete') }}" method="post"
                                                          id="delete_form">
                                                        @csrf
                                                        <input type="hidden" name="id" value="{{ $mpi->id }}">
                                                    </form>
                                                </div>
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
    <script>
        $(document).on('click', '#delete_button', function () {
            if (confirm('Are you sure?')) {
                $('#delete_form').submit();
            }
        });
    </script>
@endpush
