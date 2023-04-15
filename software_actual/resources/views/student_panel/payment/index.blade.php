@extends('student_panel.layouts.master')

@section('title', 'Student Courses Payment - European IT Solutions Institute')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <span class="float-left">
                        <h4>Student Courses Payment</h4>
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
                    
                    <div class="table-responsive">
                        <table id="table" class="table">
                            <thead>
                                <tr>
                                    <th class="align-middle">SL</th>
                                    <th class="align-middle">Name</th>
                                    <th class="align-middle">Phone</th>
                                    <th class="align-middle">Course</th>
                                    <th class="align-middle">Batch</th>
                                    <th class="align-middle">Course Fee</th>
                                    <th class="align-middle">Paid</th>
                                    <th class="align-middle">Payable</th>
                                    <th class="align-middle text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($student->courses as $key => $course)
                                    <tr>
                                        <td class="align-middle"> {{ $key + 1 }} </td>
                                        <td class="align-middle"> {{ $student->name }} </td>
                                        <td class="align-middle"> {{ $student->phone }} </td>
                                        <td class="align-middle"> {{ $course->title }} </td>
                                        <td class="align-middle"> 
                                            @foreach($student->batches as $batch)
                                                @if($batch->course_id == $course->id)
                                                    {{batch_name($batch->course->title_short_form, $batch->year, $batch->month, $batch->batch_number)}}
                                                @endif
                                            @endforeach
                                        </td>
                                        <td class="align-middle"> {{ $course->fee }} </td>
                                        @php
                                            $accounts = App\Models\Account::where('student_id',$student->id)->where('course_id',$course->id)->get();
                                        @endphp
                                        @foreach ($accounts as $account)
                                        @php
                                            $payments = App\Models\Payment::where('account_id',$account->id)->get();
                                            $paid = 0;
                                        @endphp
                                        @endforeach
                                        @foreach ($payments as $payment)
                                            @php
                                                $paid += $payment->amount;
                                            @endphp
                                        @endforeach
                                        <td class="align-middle"> {{ $paid }} </td>
                                        <td class="align-middle text-center"> {{ $account->get_due($payment->id) }} </td>
                                        <td class="align-middle text-center">
                                                @if($account->get_due($payment->id) == 0)
                                                    <a href="javascript:void(0)"class="btn btn-sm btn-outline-secondary disabled">Paid</a>
                                                @else
                                                    <a href=""class="btn btn-sm btn-outline-success">Payment</a>
                                                @endif
                                                
                                                <a href="" class="btn btn-sm btn-outline-info">Details</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
