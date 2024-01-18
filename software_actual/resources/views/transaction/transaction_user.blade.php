@extends('layouts.master')

@section('title', 'Students - European IT Solutions Institute')

@push('css')

@endpush

@section('content')
    <div class="container" id="print">
        <div class="row justify-content-center">
            <div class="col-md-10 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4> Transaction Report - Industrial</h4>
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
                            <div class="mb-4 text-center">
                                <button type="button" onclick="printT('print')"
                                        class="btn btn-dark btn-sm text-center hide"><i class="fa fa-print"></i>
                                </button>
                            </div>

                        <div class="clearfix">
                            <p class="float-left">
                                <i class="fa fa-money-bill"></i>
                                @if($user == 'all')
                                    Transactions of all users
                                @else
                                    Transactions By <b>{{ $user->name }}</b>
                                @endif
                            </p>
                            <p class="float-right"><b>Date : </b> {{ $from_date }} - {{ $to_date }}</p>
                        </div>

                        @if (!empty($payments))

                            @php($total = 0)
                            @php($mb = 0)
                            @php($cash = 0)

                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                    <tr>
                                        <th class="text-center align-middle" rowspan="2">SL</th>
                                        <th class="text-center align-middle" rowspan="2">Name</th>
                                        <th class="text-center align-middle" rowspan="2">Phone</th>
                                        <th class="text-center align-middle" rowspan="2">Institute</th>
                                        <th class="text-center align-middle" rowspan="2">Batch</th>
                                        <th class="text-center align-middle" colspan="3">Amount</th>
                                    </tr>
                                    <tr>
                                        <td colspan="1" class="text-center align-middle">Cash</td>
                                        <td colspan="1" class="text-center align-middle">Mobile Banking</td>
                                        <td colspan="1" class="text-center align-middle">Total</td>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($payments as $pk => $payment)

                                        @php($total += $payment->amount)
                                        @php($mb += $payment->mb_payment)
                                        @php($cash += $payment->cash_payment)

                                        <tr>
                                            <td class="text-center align-middle" >{{ ++$pk }}</td>
                                            <td class="text-center align-middle" >{{ $payment->student_name }}</td>
                                            <td class="text-center align-middle" >{{ $payment->student_phone }}</td>
                                            <td class="text-center align-middle" >{{ $payment->institute }}</td>
                                            <td class="text-center align-middle" >{{ $payment->batch }}</td>
                                            <td class="text-center align-middle" >
                                                {{ number_format($payment->cash_payment ?? 0) }}
                                            </td>
                                            <td class="text-center align-middle" >
                                                @if(isset($payment->mb_payment) && !empty($payment->mb_payment))
                                                    {{ number_format($payment->mb_payment ?? 0) }}
                                                    @if(isset($payment->mb_payment_type) && !empty($payment->mb_payment_type))
                                                        ({{ $payment->mb_type() }})
                                                    @endif
                                                    @if(isset($payment->mb_trxn_id) && !empty($payment->mb_trxn_id))
                                                        <br> <p class="m-0" style="font-size:12px"><b>Trxn ID: </b> {{ $payment->mb_trxn_id }} </p>
                                                    @endif
                                                @else
                                                    0
                                                @endif
                                            </td>
                                            <td class="text-center align-middle" >
                                                {{ number_format($payment->amount) }}
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <div class="d-flex align-item-center justify-content-center">
                                <div class="">
                                    <p class="text-left" style="font-size: 15px;">
                                        <b>Total Transaction :</b> {{ number_format($total, 2) }} Taka
                                    </p>      
                                    <p class="text-left" style="font-size: 15px;">
                                        <b>Total Cash Transaction:</b> {{ number_format($cash, 2) }} Taka <br>
                                    </p>
                                    <p class="text-left" style="font-size: 15px;">
                                        <b>Total Mobile Banking Transaction:</b> {{ number_format($mb, 2) }} Taka <br>
                                    </p>
                                </div>
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
        function printT(el, title = '') {
            console.log(el);
            var rp = document.body.innerHTML;
            $('.hide').addClass('d-none');
            var pc = document.getElementById(el).innerHTML;
            document.body.innerHTML = pc;
            document.title = 'Transaction-Report-Summary';
            window.print();
            document.body.innerHTML = rp;
        }
    </script>
@endpush
