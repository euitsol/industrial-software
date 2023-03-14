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
    <div class="container">
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
                        <fieldset class="mb-3">
                            <legend>Course  Information</legend>
                            <div class = "col-md-3 m-auto ">
                                <h4><u>Select Course</U></h4>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="table-responsive">
                                        <table class="table table-borderless">
                                        </table>
                                    </div>

                                <form action="{{ route('web.post-checkout')}}" method="post" class="mt-3">
                                    @csrf
                                    <input type="hidden" name="student_id"value="{{ $student->id }}">

                                    <div class="row">
                                    @foreach ($course_types as $course_type)
                                    <div class="col-md-6 mb-2">
                                        <p class="font-weight-bold">{{ $course_type->type_name }}</p>

                                            @foreach ($course_type->courses as $k => $course)
                                            <div class="ml-3 mb-2">
                                           

                                                    <div class="custom-control custom-checkbox mr-sm-2">
                                                        <input type="radio" name="course" value="{{ $course->id }}"
                                                        id="course_{{ $course->id }}" class="custom-control-input">
                                                        <label class="custom-control-label"
                                                               for="course_{{ $course->id }}">{{ $course->title }}.</label>


                                                                                                                   
                                                    </div>
                                                    <div  id="batches_{{ $course->id }}"class="ml-2  batches">

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
                                                                                                                                    

                                            </div>
                                        @endforeach
                                    </div>
                                @endforeach
                            </div>

                            <div class="form-group mt-3">
                                <input type="submit" value="Continue" class="btn btn-primary btn-block">
                            </div>

                        </form>

                                </div>
                            </div>
                        </fieldset>
                        

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')

    <script src="{{ asset('assets/vendor/select2/select2.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/ckeditor/ckeditor.js') }}"></script>


<script>
        $(document).on('change', 'input[type=radio]', function () {
            let this_id = $(this).attr('id');
            let checked = $('#' + this_id).is(":checked");
            let split_id = this_id.split('_');
            let batch_id = $('#batches_' + split_id[1]);
            if (checked) {
                batch_id.slideDown();
            } else {
                
                batch_id.slideUp();
            }
        });
    </script>
@endpush
