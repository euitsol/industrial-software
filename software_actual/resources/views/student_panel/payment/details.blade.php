@extends('student_panel.layouts.master')

@section('title', 'Payment Details - European IT Solutions Institute')
@push('css')
    <style>
        .t_head_title {
        background-image: linear-gradient(to right, rgba(159, 158, 158, 0.09) 6%, rgb(12, 159, 206), rgb(12, 159, 206), rgb(12, 159, 206), rgba(159, 158, 158, 0.09) 94%);
    }
    </style>
@endpush

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-10">
            
            <div class="card mb-4">
                <div class="card-header">
                    <span class="float-left">
                        <h4>Payment Details</h4>
                    </span>
                    <div class="clearfix mb-3">
                        <div class="float-right" title="Print Report">
                            <a href="{{route('student.payment.receipt',['aid'=>$account->id, 'pid' => 'null' ])}}" class="btn btn-sm btn-outline-info">Money Receipt</a>
                        </div>
                    </div>
                </div>
                @foreach($payments as $key=>$payment)
                <div class="card-body mb-4">
                    <div class="row">
                        <div class="col-md-12 mx-auto">
                            <h2 class="t_head_title text-white text-center py-2">European IT Solution Institute</h2>
                            <p class="text-center"><b>Payment-{{$key+1}}</b></p>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="table-responsive">
                                        <table id="table" class="table table-borderless">
                                                
                                                <tr>
                                                    <th style="min-width: 9.3em">Name</th>
                                                    <th>:</th>
                                                    <td>{{$student->name}}</td>
                                                </tr>
                                                
                                                <tr>
                                                    <th style="min-width: 9.3em">Course</th>
                                                    <th>:</th>
                                                    <td>{{$course->title}}</td>
                                                </tr>
                                                <tr>
                                                    <th style="min-width: 9.3em">Student Type</th>
                                                    <th>:</th>
                                                    <td>{{$account->get_student_type($student->id)}}</td>
                                                </tr>
                                                <tr>
                                                    <th style="min-width: 9.3em">Payment Amount</th>
                                                    <th>:</th>
                                                    <td>{{$payment->amount}}Tk</td>
                                                </tr>
                                        </table>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="table-responsive">
                                        <table id="table" class="table table-borderless">
                                                <tr>
                                                    <th style="min-width: 9.3em">Phone</th>
                                                    <th>:</th>
                                                    <td>{{$student->phone}}</td>
                                                </tr>
                                                <tr>
                                                    <th style="min-width: 9.3em">Batch</th>
                                                    <th>:</th>
                                                    <td>
                                                        @foreach($student->batches as $batch)
                                                            @if($batch->course_id == $course->id)
                                                                {{batch_name($batch->course->title_short_form, $batch->year, $batch->month, $batch->batch_number)}}
                                                            @endif
                                                        @endforeach
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th style="min-width: 9.3em">Payment Type</th>
                                                    <th>:</th>
                                                    <td>{{$account->get_payment_type( $account->id ,$payment->id)}}</td>
                                                </tr>
                                                <tr>
                                                    <th style="min-width: 9.3em">Payment Date</th>
                                                    <th>:</th>
                                                    <td>{{date('jS, F, Y', strtotime($payment->created_at))}}</td>
                                                </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
@push('js')
@endpush
