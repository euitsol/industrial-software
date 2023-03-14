@extends('layouts.master')

@section('title', 'Mentor Payment - European IT Solutions Institute')

@push('css')
    <style>
        table tr td {
            padding: 5px 10px;
        }

        table tr td:first-child {
            padding-left: unset;
        }
    </style>
@endpush

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="float-left">Mentor Payment</h4>
                        <div class="float-right">
                            <a href="{{ url()->previous() }}" class="btn btn-info btn-sm">Back</a>
                        </div>
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
                            <div class="col-md-8 offset-md-2">

                                <div class="form-group row">
                                    <label for="" class="col-sm-4 font-weight-bold">Mentor Name</label>
                                    <div class="col-sm-8">
                                        {{ $mpi->mentor->name }}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="" class="col-sm-4 font-weight-bold">Year</label>
                                    <div class="col-sm-8">
                                        {{ $mpi->year }}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="" class="col-sm-4 font-weight-bold">Course</label>
                                    <div class="col-sm-8">
                                        {{ $mpi->course->title }} ({{ $mpi->course->type }})
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="" class="col-sm-4 font-weight-bold">Batch</label>
                                    <div class="col-sm-8">
                                        {{ batch_name($mpi->course->title_short_form, $mpi->batch->year, $mpi->batch->month, $mpi->batch->batch_number) }}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="" class="col-sm-4 font-weight-bold">History</label>
                                    <div class="col-sm-8">
                                        <table>
                                            @if ($mpi->per_class_payment)
                                                <tr>
                                                    <td>Total Class</td>
                                                    <td>:</td>
                                                    <td>{{ $mpi->total_class }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Per class Payment</td>
                                                    <td>:</td>
                                                    <td>{{ number_format($mpi->per_class_payment, 2) }}</td>
                                                </tr>
                                            @endif
                                            @if ($mpi->batch_wise_payment)
                                                <tr>
                                                    <td>Batch wise Payment</td>
                                                    <td>:</td>
                                                    <td>{{ number_format($mpi->batch_wise_payment, 2) }}</td>
                                                </tr>
                                            @endif
                                            @if ($mpi->total_class && $mpi->per_class_payment)
                                                <tr>
                                                    <td>Total Amount</td>
                                                    <td>:</td>
                                                    <td>{{ number_format($mpi->total_class * $mpi->per_class_payment, 2) }}</td>
                                                </tr>
                                            @endif
                                            <tr>
                                                <td>Total Paid</td>
                                                <td>:</td>
                                                <td>{{ number_format($mpi->mentor_payments->sum('amount'), 2) }}</td>
                                            </tr>
                                            <tr>
                                                <td>Due</td>
                                                <td>:</td>
                                                <td>
                                                    @if ($mpi->per_class_payment)
                                                        {{ number_format(($mpi->total_class * $mpi->per_class_payment) - ($mpi->mentor_payments->sum('amount')), 2) }}
                                                    @elseif($mpi->batch_wise_payment)
                                                        {{ number_format($mpi->batch_wise_payment - ($mpi->mentor_payments->sum('amount')), 2) }}
                                                    @endif
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>

                                @if ($mpi->per_class_payment && (($mpi->total_class * $mpi->per_class_payment) <= $mpi->mentor_payments->sum('amount')))
                                    <div class="text-center p-2 text-success">
                                        <p style="font-size: 50px"><i class="fas fa-check"></i></p>
                                        <p>Payment Status : Completed</p>
                                    </div>
                                @elseif ($mpi->batch_wise_payment && ($mpi->batch_wise_payment <= $mpi->mentor_payments->sum('amount')))
                                    <div class="text-center p-2 text-success">
                                        <p style="font-size: 50px"><i class="fas fa-check"></i></p>
                                        <p>Payment Status : Completed</p>
                                    </div>
                                @else
                                    <form action="{{ route('mentor.payment.receive') }}" method="post">
                                        @csrf

                                        <input type="hidden" name="mpiid" value="{{ $mpi->id }}">
                                        @if ($mpi->per_class_payment)
                                            <input type="hidden" name="_total_due"
                                                   value="{{ ($mpi->total_class * $mpi->per_class_payment) - ($mpi->mentor_payments->sum('amount')) }}">
                                        @elseif($mpi->batch_wise_payment)
                                            <input type="hidden" name="_total_due"
                                                   value="{{ $mpi->batch_wise_payment - ($mpi->mentor_payments->sum('amount')) }}">
                                        @endif

                                        <div class="form-group row">
                                            <label for="now_payment" class="col-sm-4 font-weight-bold">Now
                                                Payment</label>
                                            <div class="col-sm-8">
                                                <input type="number" name="amount" value="{{ old('amount') }}"
                                                       id="now_payment"
                                                       class="form-control form-control-sm w-50">
                                                @if ($errors->has('amount'))
                                                    <span class="text-danger">{{ $errors->first('amount') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="" class="col-sm-4"></label>
                                            <div class="col-sm-8">
                                                <input type="submit" value="Submit" class="btn btn-primary">
                                            </div>
                                        </div>
                                    </form>
                                @endif

                                @if ($mpi->mentor_payments->count() > 0)
                                    <div class="table-responsive mt-4">
                                        <table class="table table-bordered">
                                            <tr>
                                                <th>SL</th>
                                                <th>Date</th>
                                                <th>Amount</th>
                                            </tr>
                                            @foreach ($mpi->mentor_payments as $pk => $payment)
                                                <tr>
                                                    <td>{{ ++$pk }}</td>
                                                    <td>{{ date('D d F, Y', strtotime($payment->created_at)) }}</td>
                                                    <td>{{ number_format($payment->amount, 2) }}</td>
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
        </div>
    </div>
@endsection

@push('js')

@endpush