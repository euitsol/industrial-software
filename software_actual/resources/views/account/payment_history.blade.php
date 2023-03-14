@extends('layouts.master')

@section('title', '')

@push('css')
    <style>
        .table td, .table th {
            padding: 5px;
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
                        <h4>Student</h4>
                    </span>
                        <span class="float-right">
                        <a href="{{ route('student.edit', $student->id) }}" class="btn btn-sm btn-info">
                            <i class="fa fa-edit"></i>
                        </a>
                        <a href="{{ route('students') }}" class="btn btn-dark btn-sm">Back</a>
                    </span>
                    </div>

                    <div class="card-body">

                        <div class="media">
                            @if (!empty($student->photo) && file_exists($student->photo))
                                <img src="{{ asset($student->photo) }}" class="mr-3" alt="Photo">
                            @endif
                            <div class="media-body">
                                <div class="row">
                                    <div class="col">
                                        <table class="table table-borderless">
                                            <tr>
                                                <td>Student ID</td>
                                                <td>:</td>
                                                <td>{{ $student->id }}</td>
                                            </tr>
                                            <tr>
                                                <td>Name</td>
                                                <td>:</td>
                                                <td>{{ $student->name }}</td>
                                            </tr>
                                            <tr>
                                                <td>Phone</td>
                                                <td>:</td>
                                                <td>{{ $student->phone }}</td>
                                            </tr>
                                        </table>
                                    </div>
                                    <div class="col">
                                        <table class="table table-borderless">
                                            <tr>
                                                <td>Student As</td>
                                                <td>:</td>
                                                <td>
                                                    <span class="badge badge-blue">{{ $student->student_as }}</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Present Address</td>
                                                <td>:</td>
                                                <td>{{ $student->present_address }}</td>
                                            </tr>
                                            <tr>
                                                <td>Institute Name</td>
                                                <td>:</td>
                                                <td>{{ optional($student->institute)->name }}</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        @forelse($student->courses as $course)
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-5">
                                        <table class="table table-borderless">
                                            <tr>
                                                <td>Course</td>
                                                <td>:</td>
                                                <td>
                                                    <span class="font-weight-bold">{{$course->title}}</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Batch</td>
                                                <td>:</td>
                                                <td>{{batch_name($course->title_short_form, $course->_batch->year, $course->_batch->month, $course->_batch->batch_number)}}</td>
                                            </tr>
                                            <tr>
                                                <td>Course Fee</td>
                                                <td>:</td>
                                                <td>{{$course->fee}}</td>
                                            </tr>
                                            <tr>
                                                <td>Payable Fee</td>
                                                <td>:</td>
                                                <td>{{$course->_total_fee}}</td>
                                            </tr>
                                        </table>
                                    </div>
                                    <div class="col-md-5">
                                        <table class="table table-bordered">
                                            @isset($course->_account)
                                                <tr>
                                                    <th>SL</th>
                                                    <th>Payment Date</th>
                                                    <th>Amount</th>
                                                </tr>
                                                @forelse($course->_account->payments as $k => $payment)
                                                    <tr>
                                                        <td>{{++$k}}</td>
                                                        <td>{{date('d M, Y', strtotime($payment->created_at))}}</td>
                                                        <td>{{$payment->amount}}</td>
                                                    </tr>
                                                @empty
                                                    No payments found!
                                                @endforelse
                                                <tr>
                                                    <td colspan="2" class="text-right">Total =</td>
                                                    <td>{{$course->_account->payments->sum('amount')}}</td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2" class="text-right">Due =</td>
                                                    <td>{{$course->_total_fee - $course->_account->payments->sum('amount')}}</td>
                                                </tr>
                                            @endisset
                                        </table>
                                    </div>
                                    <div class="col-md-2">
                                        <table class="table table-bordered">
                                            @isset($course->_account)
                                                @if($course->_account->installment_dates->count() > 0)
                                                    <tr>
                                                        <th>
                                                            <small>Installment</small>
                                                            Date
                                                        </th>
                                                    </tr>
                                                    @forelse($course->_account->installment_dates as $i => $i_date)
                                                        <tr>
                                                            <td>{{$i_date->installment_date}}</td>
                                                        </tr>
                                                    @empty
                                                        No installment dates found!
                                                    @endforelse
                                                @endif
                                            @endisset
                                        </table>
                                    </div>
                                </div>
                            </div>
                        @empty
                            No course found!
                        @endforelse

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')

@endpush

