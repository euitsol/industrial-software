@extends('layouts.master')

@section('title', 'Cash To Bank - European IT Solutions Institute')

@push('css')

@endpush

@section('content')

@php
$serial = 1;
@endphp

<form action={{ route('ctb.add') }} method="POST">
@csrf
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10 col-lg-12">
                <div class="card">
                    <div class="card-header">
                    <span class="float-left">
                        <h4> Cash in hand 
                        <span class="text-danger">
                            {{$user->name ?? ''}}  {{ ucfirst($type) }}  {{$date}}
                        </span>
                        </h4>
                    </span>
                    <span class="float-right">
                        <a href="{{ route('ctb.detail') }}" class="btn btn-primary">Detailed report</a>
                        <a href="{{ route('ctb') }}" class="btn btn-success ml-1">Back</a>
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


                        @if ($payments->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                    <tr>
                                        <th class="text-center align-middle">SL</th>
                                        <th class="text-center align-middle">Student Name</th>
                                        <th class="text-center align-middle">Phone</th>
                                        <th class="text-center align-middle">Course</th>
                                        <th class="text-center align-middle">Batch</th>
                                        <th class="text-center align-middle">Amount</th>
                                        <th class="text-center align-middle">Done by</th>
                                        <th class="text-center align-middle">Action</th>
                                    </tr>
                                    @forelse($payments as $key => $payment)
                                    @if(optional($payment->account)->student->student_as == ucfirst($type) )
                                        <tr>
                                            <td class="text-center align-middle">{{$serial++}}</td>
                                            <td class="text-center align-middle">{{optional($payment->account)->student->name}}</td>
                                            <td class="text-center align-middle">{{optional($payment->account)->student->phone}}</td>
                                            <td class="text-center align-middle">{{optional($payment->account)->course->title}}</td>
                                            <td class="text-center align-middle">
                                                {{
                                                    batch_name(optional($payment->account)->course->title_short_form, $payment->account->student->batches->where('course_id', optional($payment->account)->course->id)->first()->year, $payment->account->student->batches->where('course_id', optional($payment->account)->course->id)->first()->month, $payment->account->student->batches->where('course_id', optional($payment->account)->course->id)->first()->batch_number)

                                                }}
                                            </td>
                                            <td class="text-center align-middle">{{number_format($payment->amount,2)}}</td>
                                            <td class="text-center align-middle">{{optional($payment->user)->name}}</td>
                                            <td class="text-center align-middle"><input type="checkbox" name="payment_id[]" value="{{ $payment->id }}" class="form-controll" style="height: 35px;width: 35px;" checked></td>
                                        </tr>
                                    @endif
                                    @empty

                                    @endforelse
                                </table>
                            </div>
                            <div>
                                 <a href="javascript:void(0)" class="btn btn-lg btn-primary w-100"  data-toggle="modal" data-target="#confirmTransfer">Transfer to Bank</a>
                            </div>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="confirmTransfer" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Confirm Transfer</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
                <div class="form-group">
                    <label for="note">Please add a note<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="note" id="note" required>
                    <small id="noteHelp" class="form-text">Please add a note for this transfer.</small>
                </div>
          </div>
          <div class="modal-footer">
            <a href="javascript:void(0)" class="btn btn-danger" data-dismiss="modal" style="width:49%">Close</a>
            <button type="submit" class="btn btn-primary" style="width:49%">Transfer Balance</button>
          </div>
        </div>
      </div>
    </div>
    
    
    
</form>    
@endsection

@push('js')

@endpush