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
                        <h4> Transaction Report</h4>
                        {{-- - {{'('.$session->name.')' }}  --}}
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
                                Transaction Report - 
                                @if($user == 'all')
                                    <b>All Users</b>
                                @else
                                    by <b>{{ $user->name }}</b>
                                @endif
                                 - {{'('.$session->name.')' }}
                                <br>
                                <span><b>Professional Students</b></span>
                            </p>
                            <p class="float-right">
                                <b>Print Date : </b> {{ date('D d F, Y') }}
                            </p>
                        </div>

                        @if (!empty($results))

                            @php
                            $total = 0;
                            @endphp

                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                    <tr>
                                        <th>SL</th>
                                        <th>Name</th>
                                        <th>Phone</th>
                                        <th style="width:8em">Student Type</th>
                                        <th>Payment Type</th>
                                        <th>Course Batch</th>
                                        <th>Paid</th>
                                        <th>Due</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($results as $pk => $result)

                                        @php
                                        $total += $result->amount;
                                        @endphp

                                        <tr>
                                            <td>{{ ++$pk }}</td>
                                            <td>{{ $result->account->student->name }}</td>
                                            <td>{{ $result->account->student->phone }}</td>
                                            <td>{{ $result->account->get_student_type( $result->account->student->id) }}</td>
                                            <td>{{ $result->account->get_payment_type( $result->account->id ,$result->id) }}</td>
                                            @php 
                                            $batch = $result->account->student->batches->where('course_id', $result->account->course_id)->first();
                                            @endphp
                                            <td>{{ $result->account->course->title }} ( {{ batch_name($result->account->course->title_short_form, $batch->year, $batch->month, $batch->batch_number) }} )</td>
                                            <td>{{ $result->amount }}</td>
                                            <td>{{ $result->account->get_due($result->id) }}</td>

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
