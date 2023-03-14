@extends('layouts.master')

@section('title', 'Migration Payment - European IT Solutions Institute')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10 col-lg-12">
                <div class="card">
                    <div class="card-header">
                    <span class="float-left">
                        <h4>Payment</h4>
                    </span>
                        <span class="float-right">
                        <a href="{{ route('student.course.assign', $student->id) }}"
                           class="btn btn-info btn-sm">Back</a>
                    </span>
                    </div>

                    <div class="card-body">

                        <div class="row">
                            <div class="col-md-8">

                                @if(session('success'))
                                    <p class="alert alert-success text-center">
                                        {{ session('success') }}
                                    </p>
                                @elseif(session('error'))
                                    <p class="alert alert-danger text-center">
                                        {{ session('error') }}
                                    </p>
                                @endif

                                @if($errors->has('installment_date.*'))
                                    <p class="alert alert-danger text-center">
                                        The installment date fields are required
                                    </p>
                                @endif

                                <form action="{{ route('payment.new.receive') }}" method="POST" class="form-horizontal">
                                    @csrf

                                    <input type="hidden" name="student_id" value="{{ $student->id }}">
                                    <input type="hidden" name="course_id" value="{{ $course->id }}">
                                    <input type="hidden" name="course_fee" value="{{ $course->fee }}">
                                    <input type="hidden" name="batch_name" value="{{batch_name($course->title_short_form, $batch->year, $batch->month, $batch->batch_number)}}">
                                    
                                    <div class="form-group row d-flex align-items-center">
                                        <label class="col-md-3 form-control-label">Course Fee</label>
                                        <div class="col-md-2">{{$course->fee}} TK</div>
                                        <div class="col-md-1">+</div>
                                        <div class="col-md-3">                                                
                                            <input type="number" name="migration_fee" id="migration_fee" value="{{ old('migration_fee') }}" min="0" placeholder="Migration Fee" class="form-control">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label">Discount</label>
                                        <div class="col-md-9">

                                            <label for="discount_yes" class="mr-2">
                                                <input type="radio" name="discount_radio" id="discount_yes" value="yes">
                                                Yes</label>

                                            <label for="discount_no">
                                                <input type="radio" name="discount_radio" id="discount_no" value="no"
                                                       checked> No</label>

                                            <div class="input-group" id="discount" style="display: none">

                                                <input type="number" name="discount_percent" id="discount_percent"
                                                       value="{{ old('discount_percent') }}" min="0"
                                                       placeholder="Percent"
                                                       class="form-control">

                                                <div class="input-group-append">
                                                    <span class="input-group-text"
                                                          style="width: 36px !important;">%</span>
                                                </div>

                                                <span class="ml-2 mr-2 mt-2">OR</span>

                                                <input type="number" name="discount_amount" id="discount_amount"
                                                       value="{{ old('discount_amount') }}" min="0" placeholder="Amount"
                                                       class="form-control">
                                            </div>

                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label">Total Fee</label>
                                        <div class="col-md-9">
                                            <span id="total_fee"></span> TK
                                            <input type="hidden" name="total_fee" id="_total_fee">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label">Payment Method</label>
                                        <div class="col-md-9">

                                            <label for="method_installment" class="mr-2">
                                                <input type="radio" name="method_radio" id="method_installment"
                                                       value="installment"> Installment</label>

                                            <label for="method_fullPayment">
                                                <input type="radio" name="method_radio" id="method_fullPayment"
                                                       value="full_payment" checked> Full Payment</label>

                                            <div class="input-group w-50" id="payment_method" style="display: none">

                                                <input type="number" name="installment_quantity"
                                                       id="installment_quantity"
                                                       value="{{ old('installment_quantity') }}" min="0"
                                                       placeholder="How many installment"
                                                       class="form-control form-control-sm">
                                            </div>

                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="" class="col-md-3 form-control-label"> Amount </label>
                                        <div class="col-md-9">
                                            <input type="text" name="amount" id="today_payable"
                                                   class="form-control w-50">
                                            @if ($errors->has('amount'))
                                                <span class="text-danger">{{$errors->first('amount')}}</span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        {{-- Installment Dates --}}
                                        <div id="installment_dates"></div>
                                    </div>

                                    <div class="form-group row">
                                        <div class="col-md-9 ml-auto">
                                            <input type="submit" value="Submit" class="btn btn-primary">
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="col-md-4">
                                <table class="table table-borderless border table-striped">
                                    <tr>
                                        <td>Student ID</td>
                                        <td>:</td>
                                        <td>{{ $student->year.$student->reg_no }}</td>
                                    </tr>
                                    <tr>
                                        <td>Name</td>
                                        <td>:</td>
                                        <td>{{ $student->name }}</td>
                                    </tr>
                                    <tr>
                                        <td>Father's Name</td>
                                        <td>:</td>
                                        <td>{{ $student->fathers_name }}</td>
                                    </tr>
                                    <tr>
                                        <td>Course</td>
                                        <td>:</td>
                                        <td>{{$course->title}}</td>
                                    </tr>
                                    <tr>
                                        <td>Batch</td>
                                        <td>:</td>
                                        <td>{{batch_name($course->title_short_form, $batch->year, $batch->month, $batch->batch_number)}}</td>
                                    </tr>
                                    <tr>
                                        <td>Phone</td>
                                        <td>:</td>
                                        <td>{{ $student->phone }}</td>
                                    </tr>
                                    @if (isset($student->photo))
                                        <tr>
                                            <td>Photo</td>
                                            <td>:</td>
                                            <td><img src="{{asset($student->photo)}}" style="height: 120px;" alt="">
                                            </td>
                                        </tr>
                                    @endif
                                </table>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')

    @if (old('discount_percent') || old('discount_amount'))
        <script>$("#discount").show(100);</script>
    @endif

    @if (old('installment_quantity') || old('installment_next_days'))
        <script>$("#payment_method").show(100);</script>
    @endif

    <script>
        let $course_fee = ("{{ $course->fee }}" * 1);

        $("#discount_yes").click(function () {
            $("#discount").show(100);
            payment_calculation();
        });
        $("#discount_no").click(function () {
            $("#discount_percent").val('');
            $("#discount_amount").val('');
            $("#discount").hide(100);
            $('#total_fee').html($course_fee);
            payment_calculation();
        });
        $("#method_installment").click(function () {
            $("#payment_method").show(100);
            payment_calculation();
        });
        $("#method_fullPayment").click(function () {
            $("#installment_quantity").val('');
            $("#payment_method").hide(100);
            payment_calculation();
        });

        $('#today_payable').val($course_fee);
        $('#total_fee').html($course_fee);
        $('#_total_fee').val($course_fee);

        let total_fee = 0;
        let total = 0;

        function payment_calculation() {
            let discount_percent = $("#discount_percent");
            let discount_percent_val = $("#discount_percent").val();
            let discount_amount = $("#discount_amount");
            let discount_amount_val = $("#discount_amount").val();
            let installment_quantity_val = $("#installment_quantity").val();
            let migration_fee = $("#migration_fee");
            let migration_fee_val = parseInt($("#migration_fee").val());

            if (($course_fee != '') && (discount_percent_val != '')) {
                total = $course_fee - (($course_fee * discount_percent_val) / 100);
                total_fee = $course_fee - (($course_fee * discount_percent_val) / 100);
            } else {
                total = $course_fee;
                total_fee = $course_fee;
            }   
            
            if(migration_fee_val != '' && migration_fee_val > 0){
                total_fee = total_fee + migration_fee_val;
                console.log(total_fee);
            }else{
                total_fee = total_fee;
            }
            
            if (discount_percent_val) {
                discount_amount.val('');
                discount_amount.attr('disabled', 'disabled');
            } else {
                discount_amount.removeAttr('disabled', 'disabled');
            }
            if (discount_amount_val) {
                discount_percent.val('');
                discount_percent.attr('disabled', 'disabled');
            } else {
                discount_percent.removeAttr('disabled', 'disabled');
            }
            if (discount_percent_val && discount_amount_val) {
                discount_amount.val('');
                discount_percent.val('');
                discount_amount.removeAttr('disabled', 'disabled');
                discount_percent.removeAttr('disabled', 'disabled');
            }
            if (discount_amount_val != '' && total > 0) {
                total = total - discount_amount_val;
                total_fee = total_fee - discount_amount_val;
            }
            if ((installment_quantity_val * 1) > 0) {
                total = total / (installment_quantity_val * 1);
            }
            $('#today_payable').val(Math.ceil(total));
            $('#total_fee').html(total_fee.toFixed(2));
            $('#_total_fee').val(total_fee.toFixed(2));
            installmentDatesGenerate(total_fee, total);
        }

        payment_calculation();

        $(document).on('keyup change focusout', "#discount_percent, #discount_amount, #installment_quantity, #migration_fee", function () {
            payment_calculation();
        });

        $(document).on('keyup change focusout', '#today_payable', function () {
            installmentDatesGenerate($('#total_fee').text(), ($(this).val() * 1));
        });

        function installmentDatesGenerate(_total_fee, _total) {
            let installment_quantity_val = $('#installment_quantity').val();
            if ('' !== installment_quantity_val && installment_quantity_val > 0) {
                let installment_fee_total = _total_fee - _total;
                let output = '<table class="mt-4 table table-bordered">';
                output += '<tr><td rowspan="' + (parseInt(installment_quantity_val) + 1) + '" class="gray">Installment Dates</td></tr>';
                let installment_fee = installment_fee_total / parseInt(installment_quantity_val);
                for (let i = 0; i < parseInt(installment_quantity_val); i++) {
                    output += '<tr><td><input type="date" name="installment_date[]" class="form-control form-control-sm"></td>';
                    output += '<td>' + Math.ceil(installment_fee) + '</td></tr>';
                }
                output += '</table>';
                $('#installment_dates').html(output);
            } else {
                $('#installment_dates').html('');
            }
        }

        /*function dateIncrease($date, $increaseNumber) {
            let date = new Date($date);
            let newDate = new Date(date.setDate(date.getDate() + $increaseNumber));
            return newDate.getFullYear() + '-' + (newDate.getMonth() + 1) + '-' + newDate.getDate();
        }

        function dateFormatReverse($date) {
            let date = new Date($date);
            return ((date.getDate()) <= 9 ? '0' + date.getDate() : date.getDate()) + '-' + (date.getMonth() + 1) + '-' + date.getFullYear();
        }*/

        function end(array) {
            return array[array.length - 1];
        }

    </script>
@endpush