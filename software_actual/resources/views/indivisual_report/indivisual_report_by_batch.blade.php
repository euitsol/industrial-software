@extends('layouts.master')
@section('title', 'Indivisual Summary  - European IT Solutions Institute')
@push('css')
    <link rel="stylesheet" href="{{ asset('assets/vendor/data-table/css/jquery.dataTables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/data-table/css/buttons.dataTables.min.css') }}">
@endpush
@section('content')


@php
    $row_1 = 0;$discount = 0;$all_course_fee = 0;$all_paid = 0;$all_due = 0;$total_due = 0;$total_additional_fee = 0; $actual_due = 0;$all_additional_fee = 0;$all_actual_due = 0;$count = 0;$discount = 0;$course_fee = 0; $total_payment = 0;
    $total_paid = 0;$total_course_fee = 0;$total_student = 0;$total_course_fee = 0;$total_discount = 0;$comment = "nothing"; $status = "not defined";
    $tr_count_1 = 0;$row_span_1 = 0; $row_span_2 = 0; $sl = 0;$table_a = [];$tr_1 = "";$align_middle = "align-middle";$table_active = "table-active";
@endphp
    <div class="container" id="print">
        <div class="row justify-content-center">
            <div class="col-md-10 col-lg-12">
                <div class="card">
                    <div class="card-header">
                            <span class="text-center">
                            	<h4>Indivisual Report<span class="text-danger">  - {{$course->title}} -  {{$batch_name}}</span></h4>
                            </span>
                    </div>
                     <div class="card-body" style = "visibility:hidden;">
                            <div class="mb-4 text-center" style = "visibility:visible;">
                                <button type="button" onclick="printT('print')"
                                        class="btn btn-dark btn-sm text-center hide"><i class="fa fa-print"></i>
                                </button>
                            </div>
                                  <div class="table-responsive">
                                    <table class="table table-bordered text-center" style = "visibility:visible;"  id="table_one">
                                       <thead> <tr >
                                            <th class="align-middle">#SL</th>
                                            <th class="align-middle">Name</th>
                                            <th class="align-middle">Phone Number</th>
                                            <th class="align-middle">Institute</th>
                                            <th class="align-middle">Course Fee</th>
                                            <th class="align-middle">Paid</th>
                                            <th class="align-middle">Due</th>
                                            <th class="align-middle">Additional Fee</th>
                                            <th class="align-middle">Actual Due</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        {{-- {{count($all_batches)}} --}}
                                            @if (count($all_batches) > 0)
                                                @php
                                                    foreach ($all_batches as $key1 => $in_batch)
                                                    {
                                                        $table = "";//*****************************Course Name*************************
                                                        foreach ($in_batch as $ib)
                                                        {
                                                            $total_paid = 0;
                                                            $row_span_2 = count($ib->students)+1;
                                                            $batch_name = batch_name(optional($ib->course)->title_short_form, $ib->year, $ib->month, $ib->batch_number);
                                                            $course_fee = $ib->course->fee;
                                                            foreach($ib->students as $key => $student)
                                                            {
                                                                $total_payment = 0;
                                                                $row_1++;
                                                                $sl++;
                                                                $total_discount = 0;
                                                                $name = $student->name;
                                                                $phone_number = $student->phone;
                                                                if(isset ($student->institute_id)){
                                                                    $inst = optional($student->institute)->name;
                                                                }else{
                                                                    $inst = 'not set yet';
                                                                }
                                                                $student_id = $student->id;
                                                                $table .= "<td class = '".$align_middle."' >".$sl."</td>";//******************************#SL******************************
                                                                $table .= "<td class = '".$align_middle."' >".$name."</td>";//******************************Name******************************
                                                                $table .= "<td class = '".$align_middle."' >".$phone_number."</td>";//******************************Phone Number******************************
                                                                $table .= "<td class = '".$align_middle."' >".$inst."</td>";//******************************Phone Number******************************
                                                                foreach($student->accounts as $key2 => $acc)
                                                                {
                                                                    
                                                                    if (isset($acc->discount_percent) && $acc->discount_percent > 0) {
                                                                            $discount = ($acc->discount_percent * $course_fee) / 100  ;
                                                                        } elseif (isset($acc->discount_amount) && $acc->discount_amount > 0) {
                                                                            $discount = $acc->discount_amount;
                                                                        } else {
                                                                            $discount = 0;
                                                                        }
                                                                    if($acc->course_id == $ib->course->id)
                                                                    {
                                                                        foreach($acc->payments as $key4 => $pmt)
                                                                        {
                                                                            $payment = $pmt->amount ;
                                                                            $total_payment +=  $payment;
                                                                        }
                                                                        
                                                                        $total_paid += $total_payment;
                                                                    }
                                                                    $total_additional_fee += !empty(
                                                                                $acc->additional_fee
                                                                            )
                                                                                ? $acc->additional_fee
                                                                                : 0;
                                                                }
                                                                $total_course_fee = $course_fee - $discount ;
                                                                $all_course_fee += $total_course_fee;
                                                                $table .= "<td class = '".$align_middle."' >".$total_course_fee."</td>";//******************************Course Fee******************************
                                                                $table .= "<td class = '".$align_middle."' >".$total_payment."</td>";//******************************Paid******************************
                                                                    $total_due = $total_course_fee - $total_payment;
                                                                    $total_payment = 0;
                                                                    $all_due +=$total_due;
                                                                    $discount = 0;
                                                                $table .= "<td class = '".$align_middle."' >".$total_due."</td>";//******************************Due******************************
                                                                $table .= "<td class = '".$align_middle."' >".$total_additional_fee."</td>";//******************************Not Interested Due******************************
                                                                    $actual_due = $total_due + $total_additional_fee;
                                                                    $all_additional_fee += $total_additional_fee;
                                                                    $all_actual_due += $actual_due;
                                                                $table .= "<td class = '".$align_middle."' >".$actual_due."</td>";//******************************Actual Due******************************


                                                                $table .= "</tr>";
                                                                $actual_due = 0;
                                                                $total_additional_fee = 0;
                                                            }
                                                            $row_1++;
                                                            $sl = 0;
                                                            $tr_count_1++;
                                                            $table .= "<tr class = '".$table_active."' ><td class = '".$align_middle."' ></td>";//sl
                                                                $table .= " <td class = '".$align_middle."' ></td>";//name
                                                                $table .= " <td class = '".$align_middle."' ></td>";//name
                                                                $table .= "<td class = '".$align_middle."' >Total</td>";//phone
                                                                $table .= "<td class = '".$align_middle."' >".$all_course_fee."</td>";//course_fee
                                                                $all_course_fee = 0;
                                                                $table .= "<td class = '".$align_middle."' >".$total_paid."</td>";//Paid
                                                                $table .= "<td class = '".$align_middle."' >".$all_due."</td>";//due
                                                                $all_due = 0;
                                                                $table .= " <td class = '".$align_middle."' >".$all_additional_fee."</td>";//not interested due
                                                                $all_additional_fee = 0;
                                                                $table .= "<td class = '".$align_middle."' >".$all_actual_due."</td>";//actual due
                                                                $all_actual_due = 0;



                                                        }
                                                        $row_span_1 = $row_1;
                                                        $pre_table = "";
                                                        $row_1 =0;
                                                        $final_table = "".$pre_table. "".$table;
                                                        $table_a[] = $final_table;
                                                    }
                                                    print_r($table_a);
                                                @endphp
                                            @endif
                                            </tbody>
                                    </table>
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


