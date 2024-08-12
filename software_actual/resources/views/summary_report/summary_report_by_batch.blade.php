@extends('layouts.master')
@section('title', 'Summary - European IT Solutions Institute')
@push('css')
    <link rel="stylesheet" href="{{ asset('assets/vendor/data-table/css/jquery.dataTables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/data-table/css/buttons.dataTables.min.css') }}">
@endpush
@section('content')
    @php
        $discount = 0;
        $total_due = 0;
        $actual_due = 0;
    @endphp
    <div class="container" id="print">
        <div class="row justify-content-center">
            <div class="col-md-10 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <span class="text-center">
                            <h4>Summary - <span class="text-danger">{{ $batch_name }}</span></h4>
                        </span>
                    </div>
                    <div class="card-body">

                        <div class="mb-4 text-center">
                            <button type="button" onclick="printT('print')" class="btn btn-dark btn-sm text-center hide"><i
                                    class="fa fa-print"></i>
                            </button>
                        </div>

                        <div class="tab-content" id="nav-tabContent">
                            <div class="tab-pane fade show active" id="industrial" role="tabpanel"
                                aria-labelledby="nav-home-tab">
                                <div class="table-responsive">
                                    <table id="table_one" class="table table-bordered text-center table-sm" style = "">
                                        <thead>
                                            <tr>
                                                <th class="align-middle">Course Name</th>
                                                <th class="align-middle">Batch Number</th>
                                                <th class="align-middle">
                                                    Total Course Fee<small>(BDT)</small>
                                                </th>
                                                <th class="align-middle">
                                                    Total paid<small>(BDT)</small>
                                                </th>
                                                <th class="align-middle">
                                                    Total Due <small>(BDT)</small>
                                                </th>
                                                <th class="align-middle">
                                                    Additional Fee <small>(BDT)</small>
                                                </th>
                                                <th class="align-middle">
                                                    Actual Due <small>(BDT)</small>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if (count($all_batches) > 0)
                                                @foreach ($all_batches as $key1 => $in_batch)
                                                    <tr>
                                                        <td class="align-middle">
                                                            <!-- *************course name********** -->
                                                            {{ $key1 }}
                                                        </td>

                                                        @forelse ($in_batch as $ib)
                                                            <td> <!-- *************Batch Number********** -->
                                                                {{ batch_name(optional($ib->course)->title_short_form, $ib->year, $ib->month, $ib->batch_number) }}
                                                                @php
                                                                    $total_student = $ib->students->count();
                                                                    $total_discount = 0;
                                                                    $total_additional_fee = 0;
                                                                    $total_fee = $ib->course->fee;
                                                                @endphp
                                                            </td>
                                                            <td> <!-- *************Total Course Fee(BDT)********** -->
                                                                @forelse($ib->students as $key => $student)
                                                                    @forelse($student->accounts as $key2 => $acc)
                                                                        @php

                                                                            if (
                                                                                isset($acc->discount_percent) &&
                                                                                $acc->discount_percent > 0
                                                                            ) {
                                                                                $discount =
                                                                                    ($acc->discount_percent *
                                                                                        $total_fee) /
                                                                                    100;
                                                                            } elseif (
                                                                                isset($acc->discount_amount) &&
                                                                                $acc->discount_amount > 0
                                                                            ) {
                                                                                $discount = $acc->discount_amount;
                                                                            } else {
                                                                                $discount = 0;
                                                                            }

                                                                            $total_discount += $discount;
                                                                            $total_additional_fee += !empty(
                                                                                $acc->additional_fee
                                                                            )
                                                                                ? $acc->additional_fee
                                                                                : 0;
                                                                        @endphp
                                                                    @empty
                                                                    @endforelse
                                                                @empty
                                                                @endforelse

                                                                {{ $total_course_fee = $total_student * $total_fee - $total_discount }}
                                                            </td>
                                                            <td>@php
                                                                $total_paid = 0;
                                                            @endphp
                                                                @forelse($ib->students as $key => $student)
                                                                    @php
                                                                        $total_payment = 0;
                                                                    @endphp
                                                                    @forelse($student->accounts as $key3 => $acc)
                                                                        @if ($acc->course_id == $ib->course->id)
                                                                            @forelse($acc->payments as $key4 => $pmt)
                                                                                @php

                                                                                    $payment = $pmt->amount;
                                                                                    $total_payment += $payment;

                                                                                @endphp
                                                                            @empty
                                                                            @endforelse
                                                                        @endif
                                                                        @php
                                                                            $total_paid += $total_payment;
                                                                        @endphp

                                                                    @empty
                                                                    @endforelse
                                                                @empty
                                                                @endforelse
                                                                {{ $total_paid }}
                                                            </td>
                                                            <td>
                                                                {{ $total_due = $total_course_fee - $total_paid }}
                                                            </td>
                                                            <td>
                                                                {{ $total_additional_fee }}
                                                            </td>
                                                            <td>
                                                                {{ $total_due + $total_additional_fee }}

                                                            </td>
                                                    </tr>
                                                @empty
                                                @endforelse
                                            @endforeach
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
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
