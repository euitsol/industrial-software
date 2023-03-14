@extends('layouts.web')

@section('title', 'Checkout-Info - European IT Solutions Institute')

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
 
@endpush


@section('content')
    <div class="container" style="width:100% !important">
        <div class="row justify-content-center">
            <div class="col-md-10 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Checkout Information</h4>
                    </div>

                    <div class="card-body">

                        @if (session('error'))
                            <p class="alert alert-danger text-center">
                                {{ session('error') }}
                            </p>
                        @endif
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        
                        <fieldset class="mb-3">
                            <legend>Student Information</legend>
                            <div class="row">
                                <div class="col">
                                    <div class="table-responsive">
                                        <table class="table table-borderless">
                                            <tr>
                                                <td>ID</td>
                                                <td>:</td>
                                                <td>00{{ $student->year.$student->reg_no ?? '' }}</td>
                                            </tr>
                                            <tr>
                                                <td>Name</td>
                                                <td>:</td>
                                                <td>{{ $student->name  ?? ''}}</td>
                                            </tr>
                                            <tr>
                                                <td>Father's Name</td>
                                                <td>:</td>
                                                <td>{{ $student->fathers_name  ?? ''}}</td>
                                            </tr>
                                            <tr>
                                                <td>Mother's Name</td>
                                                <td>:</td>
                                                <td>{{ $student->mothers_name  ?? ''}}</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="table-responsive">
                                        <table class="table table-borderless">
                                            <tr>
                                                <td>Phone</td>
                                                <td>:</td>
                                                <td>{{ $student->phone  ?? ''}}</td>
                                            </tr>
                                            <tr>
                                                <td>Emergency Contact</td>
                                                <td>:</td>
                                                <td>{{ $student->emergency_contact_phone  ?? ''}}</td>
                                            </tr>
                                            <tr>
                                                <td>Present Address</td>
                                                <td>:</td>
                                                <td>{{ $student->present_address  ?? '' }}</td>
                                            </tr>
                                            <tr>
                                                <td>Student As</td>
                                                <td>:</td>
                                                <td>{{ $student->student_as  ?? '' }}</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                        @foreach($courses as $key => $course)
                        <fieldset class="mb-3 position-relative">
                            <legend>Course  Information - {{$key+1}}</legend>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="table-responsive">
                                        <table class="table table-borderless">
                                            <tr>
                                                <td>Course Name</td>
                                                <td>:</td>
                                                <td>{{ $course->title }}</td>
                                            </tr>
                                            <tr>
                                                <td>Course Type</td>
                                                <td>:</td>
                                                <td>{{ $course->course_type->type_name }}</td>
                                            </tr>
                                            <tr>
                                                <td>Total Course Fee</td>
                                                <td>:</td>
                                                <td>{{ $course->fee }} Tk</td>
                                            </tr>
                                            
                                        </table>
                                    </div>
                                </div>
                                <div class="col-md-6">
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
                            <button class="btn btn-primary payBtn" style="position: absolute;top: -5%;right: 2%;" data-coursename="{{ $course->title }}" data-courseid="{{ $course->id }}" data-fee="{{ $course->fee }}">Pay</button>
                                                                                                                                                                                                                                                                                             
                        </fieldset>
                        @endforeach

                        

                    </div>
                </div>
            </div>
        </div>
    </div>
    
        <div>
            <img src="https://securepay.sslcommerz.com/public/image/SSLCommerz-Pay-With-logo-All-Size-01.png" style="width: 100%; height: auto; object-fit: cover;">
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
            <input type="hidden" class="d-none" id="student_id" name = "student_id" value="{{ $student->id }}">
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