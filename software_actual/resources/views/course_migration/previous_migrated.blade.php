@extends('layouts.master')

@section('title', 'Create Student - European IT Solutions Institute')

@push('css')
    <link rel="stylesheet"
          href="{{ asset('assets/vendor/select2/select2.min.css') }}">
    <style>
        fieldset {
            width: 100% !important;
            padding: 5px !important;
            border: 1px solid lightgray;
        }

        legend {
            width: auto;
            font-size: 20px;
        }

        table, tr, td {
            margin: 0 !important;
            padding: 5px !important;
        }
    </style>
@endpush

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10 col-lg-12">
                <div class="card">
                    <div class="card-header">
                    <span class="float-left">
                        <h4>Previous Course</h4>
                    </span>
                        <span class="float-right">
                        <a href="{{ url()->previous() }}" class="btn btn-info btn-sm">Back</a>
                    </span>
                    </div>

                    <div class="card-body">

                        <fieldset class="mb-3">
                            <legend>Student Information</legend>
                            <div class="row">
                                <div class="col">
                                    <div class="table-responsive">
                                        <table class="table table-borderless">
                                            <tr>
                                                <td>ID</td>
                                                <td>:</td>
                                                <td>{{ $student->id }}</td>
                                            </tr>
                                            <tr>
                                                <td>Name</td>
                                                <td>:</td>
                                                <td>{{ $student->name }}</td>
                                            </tr>
                                            <tr>
                                                <td>Father's Name</td>
                                                <td>:</td>
                                                <td>{{ $student->fathers_name }}</td>
                                            </tr>
                                            <tr>
                                                <td>Mother's Name</td>
                                                <td>:</td>
                                                <td>{{ $student->mothers_name }}</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="table-responsive">
                                        <table class="table table-borderless">
                                            <tr>
                                                <td>Phone</td>
                                                <td>:</td>
                                                <td>{{ $student->phone }}</td>
                                            </tr>
                                            <tr>
                                                <td>Institute</td>
                                                <td>:</td>
                                                <td>{{ optional($student->institute)->name }}</td>
                                            </tr>
                                            <tr>
                                                <td>Present Address</td>
                                                <td>:</td>
                                                <td>{{ $student->present_address }}</td>
                                            </tr>
                                            <tr>
                                                <td>Student As</td>
                                                <td>:</td>
                                                <td>{{ $student->student_as }}</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </fieldset>


                        <fieldset>
                            <legend>Course Information</legend>
                            <div class="row">
                                <div class="col">
                                    <div class="table-responsive">
                                        <table class="table table-borderless">
                                            <tr>
                                                <td>Course</td>
                                                <td>:</td>
                                                <td>{{ $course->title }}</td>
                                            </tr>
                                            <tr>
                                                <td>Batch</td>
                                                <td>:</td>
                                                <td>{{ batch_name($course->title_short_form, $batch->year, $batch->month, $batch->batch_number) }}</td>
                                            </tr>
                                            <tr>
                                                <td>Course Fee</td>
                                                <td>:</td>
                                                <td>{{ $course->fee }}</td>
                                            </tr>
                                        </table>
                                        @if (isset($account->installment_dates))
                                            <table class="table table-bordered mt-4">
                                                <tr>
                                                    <th>SL</th>
                                                    <th>Installment Date</th>
                                                    <th>Amount</th>
                                                </tr>
                                                @php($i_amount = ($total_fee - $account->payments->sum('amount')) / count($account->installment_dates))
                                                @foreach ($account->installment_dates as $idk => $i_date)
                                                    <tr>
                                                        <td>{{++$idk}}</td>
                                                        <td>{{date('D d F, Y', strtotime($i_date->installment_date))}}</td>
                                                        <td>{{number_format($i_amount, 2)}}</td>
                                                    </tr>
                                                @endforeach

                                            </table>
                                        @endif
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="table-responsive">
                                        <table class="table table-borderless">
                                            <tr>
                                                <td>Payable Fee</td>
                                                <td>:</td>
                                                <td>{{ $total_fee }}</td>
                                            </tr>
                                            @if (isset($account))
                                                <tr>
                                                    <td>Discount</td>
                                                    <td>:</td>
                                                    <td>
                                                        @if ($account->discount_percent > 0)
                                                            {{$account->discount_percent}} %
                                                        @elseif($account->discount_amount > 0)
                                                            {{$account->discount_amount}} BDT
                                                        @else
                                                            N/A
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Installment</td>
                                                    <td>:</td>
                                                    <td>{{$account->installment_quantity ?? 'N/A'}}</td>
                                                </tr>
                                            @endif
                                        </table>
                                        @if (isset($account->payments))
                                            <table class="table table-bordered mt-4">
                                                <tr>
                                                    <th>SL</th>
                                                    <th>Payment Date</th>
                                                    <th>Amount</th>
                                                </tr>
                                                @foreach ($account->payments as $pk => $payment)
                                                    <tr>
                                                        <td>{{++$pk}}</td>
                                                        <td>{{date('D d F, Y', strtotime($payment->created_at))}}</td>
                                                        <td>{{$payment->amount}}</td>
                                                    </tr>
                                                @endforeach
                                                <tr>
                                                    <td colspan="2" class="text-right">Paid =</td>
                                                    <td>{{$account->payments->sum('amount')}}</td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2" class="text-right">Due =</td>
                                                    <td>{{$total_fee - $account->payments->sum('amount')}}</td>
                                                </tr>
                                            </table>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </fieldset>

                    </div>


                </div>
            </div>
        </div>
    </div>
@endsection

@push("js")

@endpush