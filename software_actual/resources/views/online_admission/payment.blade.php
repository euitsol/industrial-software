@extends('layouts.web')

@section('title', 'Payment - European IT Solutions Institute')

@push('css')
<link rel="stylesheet" href="{{ asset('assets/vendor/select2/select2.min.css') }}">
<style>
    .container {
        color: hsl(207deg 37% 37%);
        font-family: "Teko", Sans-serif;
        font-size: 20px;
        font-weight: 400;
    }

    .container .card h4{
        color: hsl(207deg 37% 37%);
        font-family: "Teko", Sans-serif;
        font-size: 35px;
        font-weight: 600;
    }
      
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
    .batches p{
        font-size: 18px;
        font-weight: 200;
    }
    input[type=submit]{
        font-size: 25px;
        font-weight: 400;
    }
</style>

    <meta name="csrf-token" content="{{ csrf_token() }}">
 
@endpush


@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Payment</h4>
                    </div>

                    <div class="card-body">

                        @if (session('error'))
                            <p class="alert alert-danger text-center">
                                {{ session('error') }}
                            </p>
                        @endif
                        <div class="col-md-8">

                                @if(session('success'))
                                    <p class="alert alert-success text-center">
                                        {{ session('success') }}
                                    </p>
                                @elseif(session('error'))
                                    <p class="alert alert-danger text-center" id = "error">
                                        {{ session('error') }}
                                    </p>
                                @endif                           
                        </div>

                        <fieldset class="mb-3">
                            <legend>Course Information</legend>
                            <div class = "col-md-3 m-auto ">
                                <h4><u>{{ $course->title }}</U></h4>
                            </div>

                            <div class="row">
                                <div class="col">
                                    <div class="table-responsive">
                                        <table class="table table-borderless">
                                            <tr>
                                                <td>Course Fee</td>
                                                <td>:</td>
                                                <td>{{ $course->fee }} Tk</td>
                                            </tr>
                                            @php
                                                $currency = "";
                                                $dis_1 = 0;
                                                $dis_2 = 0;
                                                $fee = $course->fee;
                                                $query = App\Models\Discount::where('course_id',$course->id)
                                                                                        ->latest()
                                                                                        ->get();
                                                foreach($query as $discount)
                                                {
                                                    if ($discount->end == '')
                                                    {
                                                        if (isset($discount->discount_percent) && $discount->discount_percent > 0) {
                                                            $dis_1 = $discount->discount_percent;
                                                            $currency = "Persent";
                                                            $dis_2 = ($discount->discount_percent * $fee) / 100  ;
                                                        } elseif (isset($discount->discount_amount) && $discount->discount_amount > 0) {
                                                            $dis_1 = $discount->discount_amount;
                                                            $currency = "Tk";
                                                            $dis_2 = $discount->discount_amount;
                                                        } else {
                                                            $dis_1 = 0;
                                                            $currency = "Tk";
                                                            $dis_2 = 0;
                                                        }
                                                    }
                                                }
                                                
                                                $total_fee =  $fee - $dis_2;  

                                            @endphp
                                            <tr>
                                                <td>Discount</td>
                                                <td>:</td>
                                                <td>{{$dis_1}} {{$currency}}</td>
                                            </tr>
                                            <tr>
                                                <td>Total Course Fee</td>
                                                <td>:</td>
                                                <td>{{$total_fee }} Tk</td>
                                            </tr>
                                            
                                        </table>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="table-responsive">
                                        <table class="table table-borderless">
                                            <tr>
                                                <td>Course Duration</td>
                                                <td>:</td>
                                                <td>{{ $course->duration   ?? ''}}</td>
                                            </tr>
                                            <tr>
                                                <td>Weekly Class</td>
                                                <td>:</td>
                                                <td>{{ $course->weekly_days   ?? ''}} Days</td>
                                            </tr>
                                            <tr>
                                                <td>Class Duration</td>
                                                <td>:</td>
                                                <td>{{ $course->class_total_time  ?? '' }} Hours</td>
                                            </tr>
                                            
                                        </table>
                                    </div>
                                </div>
                            </div>                                                                                                                                                                                                                                                              
                            </div>
                        </fieldset>
                        <div class="col-md-8">

                            
                                
                                                       
                        </div>
                        <!--<div class = "mb-5">-->
                        <!--    <div class = "col-md-3 m-auto border ">-->
                        <!--        <form >-->
                        <!--            <div class="form-group mt-1">-->
                        <!--                <label for="payment-amount" class = "align-middle">Enter Amount to Pay</label>-->
                        <!--                <label></label>-->
                                        
                        <!--                <input type="number" class="form-control-file" id="payment-amount" name = "payment-amount" value = "{{$total_fee }}">-->
                        <!--            </div>-->
                        <!--            <div class="form-group mt-1 mb-0">                                       -->
                        <!--                <span class="text-danger">*Please pay at least 50% of your fee.</span>                                                                        -->
                        <!--            </div>-->
                        <!--            <div class="form-group ">                                       -->
                        <!--                <span class="text-danger">*50% of your fee is: {{$total_fee/2 }} Tk.</span>                                                                        -->
                        <!--            </div>-->
                        <!--            <div class="form-group mt-3">-->
                        <!--                <input type="submit" value="Procced to Pay" class="btn btn-primary btn-block" onclick="return handleChange()">-->
                        <!--            </div>-->
                        <!--        </form>  -->
                                
                             
                        <!--    </div>-->
                        <!--</div>-->
                        
                        <div class = "mb-5">
                            <div class = "col-md-12 m-auto row">
                                
                                <div class="col-md-6 mt-3"><button type="button" class="btn btn-success btn-lg w-100" data-toggle="modal" data-target="#exampleModal">Pay Offline</button></div>
                                <div class="col-md-6 mt-3"><button type="button" class="btn btn-primary btn-lg w-100 payBtn" data-coursename="{{ $course->title }}" data-courseid="{{ $course->id }}" data-fee="{{ $course->fee }}">Pay Online</button></div>
                             
                            </div>
                        </div>
                        
                        
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    
    
           </div>
    <!-- Modal -->
<div class="modal fade" id="paymentModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Pay for - <span id="modal_course_name"></span></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="{{ url('/online-payment/pay') }}" method="POST" id="payment-form">
        @csrf    
        <div class="form-group mt-1">
            <label for="payment-amount" class = "align-middle">Enter Amount to Pay</label>
            <label></label>
            <input type="number" class="form-control-file" id="payment-amount" name = "payment_amount" min="10">
            <input type="hidden" class="d-none" id="course_id" name = "course_id">
            <input type="hidden" class="d-none" id="student_id" name = "online_reg_id" value="{{ $student->id }}">
        </div>
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary btn-block">Procced to Pay</button>
        </form>
      </div>
    </div>
  </div>
</div>



<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Offline Payment</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>Please contact to our admission officer with your phone number and registration documents(NID Card/Birth Certificate/Admit Card/Registration Card)</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
@endsection

@push('js')
<script>
    $( document ).ready(function() {
        $('.payBtn').click(function (){
            $('#modal_course_name').html($(this).data('coursename'));
            $('#course_id').val($(this).data('courseid'));
            $('#payment-amount').attr('max',$(this).data('fee'));
            
            $('#paymentModal').modal().show();
        });
        
        $('.btn-procced').click(function (){
            $('#payment-form').submit();
        });
    });
</script>

@endpush
