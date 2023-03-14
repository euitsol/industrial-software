@extends('layouts.master')

@section('title', 'Find Teachers - European IT Solutions Institute')

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
                <div class="card" id="print">
                    <div class="card-header text-center">
                        <span class="float-left"><h4>Teacher Payment</h4></span>
                        {{--                        <h4 class="float-left">Teacher Payment</h4>--}}
                        <button type="button" onclick="printT('print')"
                                class="btn btn-dark btn-sm hide"><i class="fa fa-print"></i>
                        </button>
                        <span class="float-right hide">
                            <a href="{{ url()->previous() }}" class="btn btn-info btn-sm">Back</a>
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
                            <div class="col-md-8 offset-md-2">

                                <div class="form-group row">
                                    <label for="" class="col-sm-4 font-weight-bold">Institute</label>
                                    <div class="col-sm-8">
                                        {{ $tpi->institute->name }}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="" class="col-sm-4 font-weight-bold">Responsible Teacher</label>
                                    <div class="col-sm-8">
                                        {{ $tpi->teacher->name }} <br>
                                        <mark>( {{ $tpi->teacher->designation }} )</mark>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="" class="col-sm-4 font-weight-bold">Year</label>
                                    <div class="col-sm-8">
                                        {{ $tpi->year }}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="" class="col-sm-4 font-weight-bold">History</label>
                                    <div class="col-sm-8">
                                        <table>
                                            <tr>
                                                <td>No. of Students</td>
                                                <td>:</td>
                                                <td>{{ $total_students }}</td>
                                            </tr>
                                            <tr>
                                                <td>Per Student Payment</td>
                                                <td>:</td>
                                                <td>{{ number_format($tpi->per_student_payment, 2) }}</td>
                                            </tr>
                                            <tr>
                                                <td>Total Amount</td>
                                                <td>:</td>
                                                <td>{{ number_format($total_students * $tpi->per_student_payment, 2) }}</td>
                                            </tr>
                                            <tr>
                                                <td>Total Paid</td>
                                                <td>:</td>
                                                <td>{{ number_format($tpi->teacher_payments->sum('amount'), 2) }}</td>
                                            </tr>
                                            <tr>
                                                <td>Due</td>
                                                <td>:</td>
                                                <td>{{ number_format(($total_students * $tpi->per_student_payment) - ($tpi->teacher_payments->sum('amount')), 2) }}</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>

                                @if ($tpi->teacher_payments->count() > 0 && ($tpi->teacher_payments->sum('amount') >= ($total_students * $tpi->per_student_payment)))
                                    <div class="text-center p-2 text-success">
                                        <p style="font-size: 50px"><i class="fas fa-check"></i></p>
                                        <p>Payment Status : Completed</p>
                                    </div>
                                @elseif(($total_students * $tpi->per_student_payment) > 0)
                                    <form action="{{ route('teacher.payment.process') }}" method="post">
                                        @csrf
                                        <input type="hidden" name="tpiid" value="{{ $tpi->id }}">
                                        <input type="hidden" name="_total_due"
                                               value="{{ ($total_students * $tpi->per_student_payment) - ($tpi->teacher_payments->sum('amount')) }}">
                                        <div class="form-group row hide">
                                            <label for="now_payment" class="col-sm-4 font-weight-bold">New
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
                                        <div class="form-group row hide">
                                            <label for="" class="col-sm-4"></label>
                                            <div class="col-sm-8">
                                                <input type="submit" value="Submit" class="btn btn-primary">
                                            </div>
                                        </div>
                                    </form>
                                @endif

                                @if ($tpi->teacher_payments->count() > 0)
                                    <div class="table-responsive mt-4">
                                        <table class="table table-bordered">
                                            <tr>
                                                <th>SL</th>
                                                <th>Date</th>
                                                <th>Amount</th>
                                            </tr>
                                            @foreach ($tpi->teacher_payments as $pk => $payment)
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
    <script>
        function printT(el) {
            var rp = document.body.innerHTML;
            $(".hide").addClass('d-none');
            var pc = document.getElementById(el).innerHTML;
            document.body.innerHTML = pc;
            document.title = 'teacher-pay';
            window.print();
            document.body.innerHTML = rp;
        }
    </script>
@endpush
