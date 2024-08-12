@extends('layouts.master')
@include('phpqrcode.qrlib')
@section('title', 'Money Receipt - European IT Solutions Institute')

@push('css')
    <style>
        .header-right p {
            font-size: 14px !important;
        }
        .header-right h2 {
            font-size: 30px !important;
            color: #0C9FCE !important;
        }
        .header-right h5 {
            font-size: 15px !important;
            color: #0C9FCE !important;
        }
        .registration-title{
            margin-bottom: 25px;
        }
        .registration-title h2 {
            background-image: linear-gradient(to right, rgba(159, 158, 158, 0.09) 2%, rgb(12, 159, 206), rgb(12, 159, 206), rgb(12, 159, 206), rgba(159, 158, 158, 0.09) 90%);
            
        }



        

        .table td, .table th {
            padding: 5px 10px !important;
        }

        .student-copy {
            margin :10px 0px 0px 0px;
            font-size: 20px;
            
        }

        .institute-copy {
            margin-top: 100px;
            font-size: 20px
        }

        body {
            background: white;
        }
        .clr table tr th{
                background : #ECECEC !important;
            }
        .qr{
            width: 200px;
            height: 200px;
            border: 5px solid #ECECEC;
        }
        .qr img{
            width:100%;
            height:100%;
            object-fit: cover;
        }
        .header_image img{
            margin-left: -3px;    
            height: 60px;
        }
        #separator{
            border-top: 2px dashed #0f0f0f;
        }
        

        @media print {
            .clr tr th{
                background : #ECECEC !important;
            }
            .container-content-inner {
                display: block !important;
            }
            .student-copy {
                margin-left: -110px !important;
                font-size: 14px;
                
            }
            
            .header_image img{
                margin-left: -2px;
                margin-bottom: 5px;
                height: 65px;
            }
            table tr th{
                font-weight: 400;
            }
            .qr{
                width: 180px;
                height: 180px;
                border: 5px solid #ECECEC;
            }
            .table td, .table th {
                padding: 5px 10px !important;
            }

        }
    </style>
@endpush

@section('content')

    <div class="row d-flex justify-content-center">
        <div class="col-md-10 text-right">
            <button type="button" onclick="print_money_receipt()" class="btn btn-dark">
                <i class="fa fa-print"></i>
            </button>
        </div>
    </div>

    <div id="student_copy" >
        <div class="row student-copy d-flex justify-content-center">
            <div class="col-md-10 offset-md-1">

                
                <div class="row mt-3">

                    <div class="col-md-3 header_image">
                        <img src="{{asset('images/EUITSols Institute New.png')}}"  alt="logo">
                    </div>

                    <div class="col-md-8 offset-1 header-right">
                        <h2 class="text-right  p-0 m-0 font-weight-bold">
                            European IT Solutions Institute
                        </h2>
                        <p class="text-right p-0 m-0">
                            Noor Mansion (3rd Floor), Plot#04, Main Road#01, Mirpur-10,
                            Dhaka-1216
                        </p>
                        <p class="text-right p-0 m-0">
                            <strong>Mobile:</strong> +880 188 9977 950, +880 188 9977 951</p>
                        <p class="text-right p-0 m-0">
                            <strong>Email:</strong> info@europeanit-inst.com,
                            <strong>Web:</strong> www.europeanit-inst.com
                        </p>
                    </div>

                </div>
                

                <div class="mt-2">
                
                    <div class="registration-title col-md-6 offset-md-3" style="margin-top: 50px;margin-bottom: 50px;" >
                        <h2 class="text-center text-white py-2">Money Receipt</h2>
                    </div>
                </div>
                
<div id="mainReceipt">
                <div class="mb-2">                        
                    <div class="border p-1 mb-2">
                        <div class="clearfix">
                            <div class="float-left"><b>Receipt Number:</b> {{$receipt_no}}</div>
                            <div class="float-right"><b>Date:</b> {{date('D d F, Y')}}</div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 cls">
                        <table class="table table-borderless">
                            <tr >
                                <th>ID</th>
                                <td>:</td>
                                <td>{{$student->year.$student->reg_no}}</td>
                            </tr>
                            <tr>
                                <th>Name</th>
                                <td>:</td>
                                <td>{{$student->name}}</td>
                            </tr>
                            <tr>
                                <th>Phone</th>
                                <td>:</td>
                                <td>{{$student->phone}}</td>
                            </tr>
                            <tr>
                                <th>Course</th>
                                <td>:</td>
                                <td>{{$course->title}}</td>
                            </tr>
                            <tr>
                                <th>Batch</th>
                                <td>:</td>
                                <td>{{$batch_name}}</td>
                            </tr>
                        </table>
                        
                    </div>
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr>
                                <th>Course Fee</th>
                                <td>:</td>
                                <td>{{number_format($course->fee, 2)}} BDT</td>
                            </tr>
                            @if ($account->discount_percent > 0 || $account->discount_amount > 0)
                                <tr>
                                    <th>Discount</th>
                                    <td>:</td>
                                    <td>
                                        @if($account->discount_percent > 0)
                                            {{$account->discount_percent}} %
                                        @elseif($account->discount_amount > 0)
                                            {{number_format($account->discount_amount, 2)}}
                                        @endif 
                                        BDT
                                    </td>
                                </tr>
                            @endif
                            @if($additional_fee > 0)
                                <tr>
                                    <th>Additional Fee</th>
                                    <td>:</td>
                                    <td>{{number_format($additional_fee, 2)}} BDT</td>
                                </tr>
                            @endif
                            @if ($account->installment_quantity > 0)
                                <tr>
                                    <th>Installment</th>
                                    <td>:</td>
                                    <td>{{$account->installment_quantity}}</td>
                                </tr>
                            @endif
                            <tr>
                                <th>Total Course Fee</th>
                                <td>:</td>
                                <td>{{number_format($total_fee+$additional_fee, 2)}} BDT</td>
                            </tr>
                        </table>

                    </div>
                    <div class="col-md-7 clr">
                        
                            <table class="table ">
                            <tr>
                                <th><b>Payment Date</b></th>
                                <th><b>Amount</b></th>
                            </tr>
                            @if ($payments->count() > 0)
                                @foreach($payments as $_payment)
                                    <tr class="amount_rel">
                                        <td>{{date('D d F, Y', strtotime($_payment->created_at))}}<br>
                                        <div class="amount">*Amount in word : 
                                        {{convert_number_to_words(ceil($_payment->amount))}}</div></td>
                                        <td>{{number_format(ceil($_payment->amount),2)}} BDT</td>
                                        
                                    </tr>
                                    <tr>
                                    
                                    
                                @endforeach
                            @endif
                        </table>
                        @if($due > 0 && count($_installment_dates) > 0)
                                <table class="table">
                                    <tr>
                                        <th><b>Installment Date</b></th>
                                        <th><b>Amount</b></th>
                                    </tr>
                                    @foreach($_installment_dates as $installment_date)
                                        <tr>
                                            <td>{{ date('D d F, Y', strtotime($installment_date)) }}</td>
                                            <td>{{ number_format(ceil($installment_amount),2) }} BDT</td>
                                        </tr>
                                    @endforeach
                                </table>
                            @endif
                        <p class="text-left mt-4 mb-0" style="padding-left: 12px;">
                            <b>Total Paid : </b> {{number_format($total_payments, 2)}} BDT
                            
                        </p>
                        <p class="text-left mt-2" style="padding-left: 12px;">
                            <b class="">Total Due : </b> {{number_format($due+$additional_fee, 2)}} BDT
                        </p>
                    </div>
                    <div class="col-md-5 clr">
                        
                        <div class="qr m-auto">
                            

                            @if(null !==($student->year.$student->reg_no))
                                @php
                                    
                                    $text=$student->year.$student->reg_no.$receipt_no;

                                    $folder="images/QRcode/";

                                    $file_name="$text.png";

                                    $file_name=$folder.$file_name;

                                    QRcode::png($text,$file_name);

                                    
                                    
                                    
                                @endphp
                                

                            <img src="{{asset($file_name)}}">
                            
                            @endif
                        </div>
                            
                    </div>
                </div>

                <div style="margin-top: 20px">
                    
                    <p class="float-left border-top" style="padding-left: 12px;">Authorized Signature</p>
                    <p class="float-right border-top">Receiver's Signature</p>
                </div>
</div>                                        

                <div style="margin-top: 20px;">
                    
                    <p class="text-center">
                        # Software generated money receipt
                    </p>
                </div>
                
               

            </div>
        </div>
    </div>

@endsection

@push('js')
    <script>
        function print_money_receipt() {
            // document.getElementById('separator').style.borderBottom = "thick dashed  #000000";
            printT('student_copy', 'money_receipt');
        }

        function printT(el, title = '') {
            var rp = document.body.innerHTML;
            var pc = document.getElementById(el).innerHTML;
            
            var xc = '<div class="mt-3 mb-3" id="separator"></div>';
            xc += '<div class="row student-copy d-flex justify-content-center"><div class="col-md-10 offset-md-1">';
            xc += document.getElementById('mainReceipt').innerHTML;
            xc += '</div></div>';
            
            document.body.innerHTML = pc + xc;
            document.title = title ? title : '';
            window.print();
            document.body.innerHTML = rp;
        }
    </script>
@endpush

