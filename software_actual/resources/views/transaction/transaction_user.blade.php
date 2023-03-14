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
                        <h4> Transaction Report </h4>
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

                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                    <tr>
                                        <th>SL</th>
                                        <th>Name</th>
                                        <th>Phone</th>
                                        <th>Institute</th>
                                        <th>Batch</th>
                                        <th>Student As</th>
                                        <th>Amount</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($payments as $pk => $payment)

                                        @php($total += $payment->amount)

                                        <tr>
                                            <td>{{ ++$pk }}</td>
                                            <td>{{ $payment->student_name }}</td>
                                            <td>{{ $payment->student_phone }}</td>
                                            <td>{{ $payment->institute }}</td>
                                            <td>{{ $payment->batch }}</td>
                                            <td>{{ $payment->student_as }}</td>
                                            <td>{{ $payment->amount }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <p class="text-center" style="font-size: 20px;">
                                <b>Total Transaction :</b> {{ number_format($total, 2) }} Taka
                            </p>
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
