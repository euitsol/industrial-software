@extends('layouts.master')

@section('title', 'Students - European IT Solutions Institute')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="float-left"> Transaction Report </h4>
                        <span class="float-right">
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

                        <p style="font-size: 25px;" class="text-center">
                            {{ date('D d F, Y', strtotime($from_date)) }}
                            <b>-</b> {{ date('D d F, Y', strtotime($to_date)) }}
                        </p>

                        @if ($accounts->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-bordered text-center">
                                    <tr>
                                        <th rowspan="2" class="align-middle">SL</th>
                                        <th rowspan="2" class="align-middle">Sector</th>
                                        <th rowspan="2" class="align-middle">Batch</th>
                                        <th rowspan="2" class="align-middle">Name</th>
                                        <th rowspan="2" class="align-middle">Phone</th>
                                        <th rowspan="2" class="align-middle">Student As</th>
                                        <th colspan="2" class="align-middle">Transaction</th>
                                    </tr>
                                    <tr>
                                        <th>Amount</th>
                                        <th>Received By</th>
                                    </tr>

                                    @php($all_amount_total = 0)

                                    @foreach ($accounts as $ak => $account)
                                        <tr>
                                            <td rowspan="{{ $account->payments->count() ? $account->payments->count() + 1 : '' }}"
                                                class="align-middle">{{ ++$ak }}</td>
                                            <td rowspan="{{ $account->payments->count() ? $account->payments->count() + 1 : '' }}"
                                                class="align-middle">{{ optional($account->course->course_type)->type_name }}</td>
                                            <td rowspan="{{ $account->payments->count() ? $account->payments->count() + 1 : '' }}"
                                                class="align-middle">{{ $account->batch ?? '' }}</td>
                                            <td rowspan="{{ $account->payments->count() ? $account->payments->count() + 1 : '' }}"
                                                class="align-middle">{{ optional($account->student)->name }}</td>
                                            <td rowspan="{{ $account->payments->count() ? $account->payments->count() + 1 : '' }}"
                                                class="align-middle">{{ optional($account->student)->phone }}</td>
                                            <td rowspan="{{ $account->payments->count() ? $account->payments->count() + 1 : '' }}"
                                                class="align-middle">{{ optional($account->student)->student_as }}</td>

                                            @php($total = 0)

                                            @foreach ($account->payments as $payment)
                                                @if ($loop->first)
                                                    @php($total += $payment->amount)
                                                    <td>{{ $payment->amount }}</td>
                                                    <td>{{ $payment->user->name }}</td>
                                        </tr>
                                        @else
                                            @php($total += $payment->amount)
                                            <tr>
                                                <td>{{ number_format($payment->amount, 2) }}</td>
                                                <td>{{ $payment->user->name }}</td>
                                            </tr>
                                        @endif
                                    @endforeach

                                        @php($all_amount_total += $total)

                                        <td colspan="2"> Total = {{ number_format($total, 2) }} </td>
                                    @endforeach
                                </table>
                            </div>
                            <p class="text-center" style="font-size: 20px;">
                                <b>Total Transaction :</b> {{ number_format($all_amount_total, 2) }} Taka
                            </p>
                        @else
                            <p class="text-center text-danger">No transaction history found !</p>
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
            var rp = document.body.innerHTML;
            var pc = document.getElementById(el).innerHTML;
            document.body.innerHTML = pc;
            document.title = title ? title : '';
            window.print();
            document.body.innerHTML = rp;
        }
    </script>
@endpush