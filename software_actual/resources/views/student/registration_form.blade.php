@extends('layouts.master')

@section('title', 'Students - European IT Solutions Institute')

@push('css')
    <style>
        a {
            text-decoration: none !important;
        }

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

        .registration-title h2 {
            background-image: linear-gradient(to right, rgba(159, 158, 158, 0.09) 2%, rgb(12, 159, 206), rgb(12, 159, 206), rgb(12, 159, 206), rgba(159, 158, 158, 0.09) 90%);
        }

        .student-information p {
            font-size: 30px !important;
        }

        .name-field span {
            margin-left: 100px !important;
        }

        ._table {
            width: auto !important;
        }

        table {
            background: none !important;
        }

        .info {
            margin-top: 50px;
        }

        body {
            background: white !important;
        }

        .student-photo {
            height: 200px;
            width: 200px;
            object-fit: cover !important;
        }
        .trcolor{
            background-color : #ECECEC !important;
        }
        .header_image img{
            height: 60px !important;
        }
    </style>
    <style>
        body {
            margin: 0;
            padding: 0;
        }

        @font-face {
            font-family: 'hightower';
            src: url({{asset('assets/invitation/font/HTOWERT.TTF')}});
        }

        .full {
            background: #fff;
            position: relative;
            overflow: hidden;
        }

        .full::after {
            content: ' ';
            background-image: url({{ asset('assets/invitation/frame-sm.png') }});
            position: absolute;
            right: 0;
            top: 0;
            background-repeat: no-repeat;
            height: 150px;
            width: 150px;
        }

        .full::before {
            content: ' ';
            background-image: url({{ asset('assets/invitation/frame-sm.png') }});
            position: absolute;
            left: 0;
            top: 0;
            background-repeat: no-repeat;
            height: 150px;
            width: 150px;
            transform: rotate(270deg);
        }

        .full_second {
            position: relative;
            padding: 80px;
        }

        .full_second::after {
            content: ' ';
            background-image: url({{ asset('assets/invitation/frame-sm.png') }});
            position: absolute;
            right: 0;
            bottom: 40px;
            background-repeat: no-repeat;
            height: 150px;
            width: 150px;
            transform: rotate(90deg);
        }

        .full_second::before {
            content: ' ';
            background-image: url({{ asset('assets/invitation/frame-sm.png') }});
            position: absolute;
            left: 0;
            bottom: 40px;
            background-repeat: no-repeat;
            height: 150px;
            width: 150px;
            transform: rotate(180deg);
        }

        .full .heading h3 {
            text-align: center;
            font-size: 31px;
            color: #000;
            line-height: 32px;
            font-family: 'hightower';
            margin: -35px 0 0 0;
            letter-spacing: 1px;
        }

        .letter {
            padding: 7px;
        }

        .letter p {
            font-size: 26px;
            letter-spacing: 1px;
            font-family: 'hightower';
            text-align: justify;
            margin-top: 15px;
        }

        .logo {
            width: 160px;
            margin: 0 auto;
        }

        .logo img {
            width: 160px;
            position: absolute;
        }
        .quote {
            font-size: 15px;
            position: relative;
            top : -10px;
            color : #000000;
        }
        .clr table tr th{
                background : #ECECEC !important;
            }


        @media print {
            .col-md-7 {
                flex: 0 0 58.333333%;
                max-width: 58.333333%;
            }
            .col-md-5{
                flex: 0 0 41.666667%;
                max-width: 41.666667%;
            }
            .emergency_contact .col-md-6 {
                
                flex: 0 0 50% !important;
                max-width: 50% !important;
            }
            .registration-title h2 {
                background-color: linear-gradient(to right, 
                rgba(159, 158, 158, 0.09) 2%, 
                rgb(12, 159, 206), 
                rgb(12, 159, 206),
                rgb(12, 159, 206), 
                rgba(159, 158, 158, 0.09) 90%
                    )  !important;
            }
            .text-white {
                color: #fff!important;
            }
            .body{
                -webkit-print-color-adjust: exact !important;
            }
            .student-photo{
                
                margin-left: 100px;
                margin-bottom: 16px;  
            }
            .student-information p {
                font-size: 30px !important;
            }
            .text-center {
                text-align: center !important;
            }
            .info {
                margin-top: 0px !important;
                margin-left: -5px;
                padding-top: 15px !important;
                padding-bottom: 0px !important;
                padding-left: 15px !important;
                padding-right: 15px !important;
                color-adjust: exact;  
                -webkit-print-color-adjust: exact; 
                print-color-adjust: exact;
            }
            .note
            {
                display: none !important;
            }
            .clr table tr th{
                background : #ECECEC !important;
            }
            .header_image img{
            height: 70px !important;
        }
            
            @page {
            margin-left: 20px;
            margin-right: 20px;
            }
                
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
                        <h4> Registration Form </h4>
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

                        <div class="clearfix">
                            <div class="float-left">
                                <button type="button" onclick="print_registration_form()"
                                        class="btn btn-dark btn-sm"><i class="fa fa-print"></i> Registration Card
                                </button>
                                <button type="button" onclick="printT('invitation-card', '{{$student->name}}')"
                                        class="btn btn-dark btn-sm"><i class="fa fa-print"></i> Invitation Card
                                </button>
                                <a href="{{asset('uploads/documents/Rules & Regulations.pdf')}}" target="_blank"
                                   class="btn btn-info btn-sm">Rules</a>
                                <a href="{{ route('account.student.courses', $student->id) }}" target="_blank"
                                   class="btn btn-primary btn-sm">Payment <i class="fa fa-arrow-right"></i> </a>
                            </div>
                            <div class="float-right">
                                <a href="{{route('student.show', $student->id)}}"
                                   class="btn btn-outline-danger">Cancel</a>
                            </div>
                        </div>

                        <div id="student-info" style="">

                            <div class="info clearfix">

                                <header class="container-fluid">
                                    <div class="container">
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
                                    </div>
                                </header>

                                <section class="container-fluid" style="font-size: 20px">
                                    <div class="container">
                                        <div class="student-information">
                                            <div class="row mt-4">
                                                <div class="registration-title col-md-6 offset-md-3">
                                                    <h2 class="text-center text-white py-2">Registration Form</h2>
                                                </div>
                                            </div>
                                            <p class="text-center mt-3 font-weight-bold">Student Information</p>
                                        </div>

                                        <div class="row mt-3">

                                            <div class="col-md-7">
                                                <table class="table _table table-borderless">
                                                    <tr>
                                                        <td>Student ID</td>
                                                        <td>:</td>
                                                        <td>{{$student->year.$student->reg_no}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Full Name</td>
                                                        <td>:</td>
                                                        <td>{{$student->name}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Father's Name</td>
                                                        <td>:</td>
                                                        <td>{{$student->fathers_name}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Mother's Name</td>
                                                        <td>:</td>
                                                        <td>{{$student->mothers_name}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Present Address</td>
                                                        <td>:</td>
                                                        <td>{{$student->present_address}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Permanent Address</td>
                                                        <td>:</td>
                                                        <td>{{$student->permanent_address}}</td>
                                                    </tr>
                                                    @if (optional($student->institute)->name)
                                                        <tr>
                                                            <td>Institute Name</td>
                                                            <td>:</td>
                                                            <td>{{optional($student->institute)->name}} ({{$student->shift()}})</td>
                                                        </tr>
                                                    @endif
                                                    @if ($student->board_roll)
                                                        <tr>
                                                            <td>Board Roll</td>
                                                            <td>:</td>
                                                            <td>{{$student->board_roll}}</td>
                                                        </tr>
                                                    @endif
                                                    @if ($student->board_reg)
                                                        <tr>
                                                            <td>Reg No.</td>
                                                            <td>:</td>
                                                            <td>{{$student->board_reg}}</td>
                                                        </tr>
                                                    @endif
                                                    <tr>
                                                        <td>Phone</td>
                                                        <td>:</td>
                                                        <td>{{$student->phone}}</td>
                                                    </tr>
                                                    @if ($student->email)
                                                        <tr>
                                                            <td>Email</td>
                                                            <td>:</td>
                                                            <td>{{$student->email}}</td>
                                                        </tr>
                                                    @endif
                                                    @if ($student->nid)
                                                        <tr>
                                                            <td>NID</td>
                                                            <td>:</td>
                                                            <td>{{$student->nid}}</td>
                                                        </tr>
                                                    @elseif ($student->birth)
                                                        <tr>
                                                            <td>Birth Certificate</td>
                                                            <td>:</td>
                                                            <td>{{$student->birth}}</td>
                                                        </tr>
                                                    @endif
                                                    @if ($student->note)
                                                        <tr class="note">
                                                            <td>Note</td>
                                                            <td>:</td>
                                                            <td>{!! $student->note !!}</td>
                                                        </tr>
                                                    @endif
                                                </table>
                                            </div>

                                            <div class="col-md-5 ">
                                                <p class="text-center ">
                                                    @if(isset($student->photo))
                                                        <img src="{{asset($student->photo)}}" class="student-photo" alt="">
                                                    @else

                                                        @if( $student->gender == 'male')
                                                            <img  src="{{asset('images/avatar-male.jpg')}}" class="student-photo" alt="">
                                                        @else
                                                        <img  src="{{asset('images/avater-female.jpg')}}" class="student-photo" alt="">
                                                        @endif

                                                    @endif
                                                </p>
                                                <table class="table _table table-borderless float-right">
                                                    <tr>
                                                        <td>Gender</td>
                                                        <td>:</td>
                                                        <td>{{ucfirst($student->gender)}}</td>
                                                    </tr>
                                                    @if ($student->blood_group)
                                                        <tr>
                                                            <td>Blood Group</td>
                                                            <td>:</td>
                                                            <td>{{$student->blood_group}}</td>
                                                        </tr>
                                                    @endif
                                                    <tr>
                                                        <td>Nationality</td>
                                                        <td>:</td>
                                                        <td>{{$student->nationality}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Parent's Phone</td>
                                                        <td>:</td>
                                                        <td>{{$student->parents_phone}}</td>
                                                    </tr>
                                                    @if ($student->student_as)
                                                        <tr>
                                                            <td>Student As</td>
                                                            <td>:</td>
                                                            <td>{{$student->student_as}}</td>
                                                        </tr>
                                                    @endif
                                                </table>
                                            </div>

                                        </div>

                                        @if (
                                            $student->emergency_contact_name
                                         || $student->emergency_contact_address
                                         || $student->emergency_contact_relation
                                         || $student->emergency_contact_phone
                                        )

                                            <h5 class="my-2 ml-2">Emergency Contact</h5>

                                            <div class="row emergency_contact">

                                                <div class="col-md-6">
                                                    <table class="table table-borderless">
                                                        <tr>
                                                            <td>Name</td>
                                                            <td>:</td>
                                                            <td>{{$student->emergency_contact_name}}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Address</td>
                                                            <td>:</td>
                                                            <td>{{$student->emergency_contact_address}}</td>
                                                        </tr>
                                                    </table>
                                                </div>

                                                <div class="col-md-6">
                                                    <table class="table table-borderless">
                                                        <tr>
                                                            <td>Relation</td>
                                                            <td>:</td>
                                                            <td>{{$student->emergency_contact_relation}}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Phone</td>
                                                            <td>:</td>
                                                            <td>{{$student->emergency_contact_phone}}</td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </div>

                                        @endif

                                        @if ($student->batches->count() > 0)
                                            <div class="mt-3 clr">
                                                <table class="table table-bordered text-center ">
                                                    <tr class = "">
                                                        <th>Course</th>
                                                        <th>Batch</th>
                                                        <th>Duration</th>
                                                        <th>Fee</th>
                                                    </tr>
                                                    @foreach ($student->batches as $b)
                                                        <tr>
                                                            <td>{{$b->course->title}}</td>
                                                            <td>{{batch_name($b->course->title_short_form, $b->year, $b->month, $b->batch_number)}}</td>
                                                            <td>{{$b->course->duration}}</td>
                                                            <td>{{$b->course->fee}}</td>
                                                        </tr>
                                                    @endforeach
                                                </table>
                                            </div>
                                        @endif

                                        <div class="row offset-md-1 mt-4 mb-3">
                                            <div class="col-md-10">
                                                <p class="text-center w-84 font-italic">
                                                <i class="fas fa-quote-left quote"></i> The above information is true to the
                                                    best of my knowledge.  I authorized European IT Solutions Institute
                                                    of Bangladesh to release any information required to process my
                                                    claims. <i class="fas fa-quote-right quote"></i>
                                                </p>
                                            </div>
                                        </div>

                                        <div style="margin-top: 80px">
                                            
                                            <p class="float-left border-top">Authorized Signature</p>
                                            <p class="float-right border-top">Student Signature</p>
                                        </div>
                                        <div style="margin-top: 140px">
                                            <p class="text-center">www.institute.europeanit.org</p>
                                        </div>


                                    </div>
                                </section>

                            </div>

                        </div>

                    </div>

                </div>
                <div class="card mt-4">
                    <div class="card-body">
                        <div id="invitation-card">
                            <div class="full">
                                <div class="full_second">
                                    <div class="content" style="min-height:1380px">
                                        <div class="heading">
                                            <h3>Invitation <br> To <br> Orientation Program for Industrial Attachment – 2022
                                            </h3>
                                        </div>
                                        <div class="letter">
                                            <p>Dear {{$student->name}},</p>
                                            <p><b>European IT</b> would like to take the opportunity to officially invite you to the orientation program for the Industrial Attachment Course of the Polytechnic Institute students. We are very much excited to have diploma engineering students from all over the country join our institute this October as Industrial Trainees. To help facilitate this transition from Polytechnic Institute to Industrial Training, we are hosting an orientation program on 13th November 2022 (Sunday) at 10:00 am at Bangamata Sheikh Fazilatunnecha Mujib Auditorium (Main Auditorium), Bangladesh National Museum, Shahbag, Dhaka, Bangladesh. We hope that you will be able to join us for this informative presentation. In addition, students will have the opportunity to ask questions and converse with mentors. Please carry your ID card as well as the token given by European IT. We look forward to meeting you in person at this orientation session. As always, should you have any specific questions or concerns, please do not hesitate to contact me at – 01889-977950. We hope to see you on 13th November 2022.  
                                               <br>
                                               Please collect your ID card and token from our office.  
                                            </p>
                                            <p>Sincerely yours,<br> Md. Mamun Ur Rashid <br> Country Director & MD, Bangladesh, <br> European IT Solutions & Institute </p>
    
                                        </div>
                                    </div>
    
                                    <div class="logo">
                                        <img src="{{ asset('assets/invitation/logo.png') }}" alt="logo">
                                    </div>
                                </div>
                           </div>

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
    function print_registration_form() {
            printT('student-info', 'student-info');
        }
        function printT(el, title = '') {
            var rp = document.body.innerHTML;
            var pc = document.getElementById(el).innerHTML;
            document.body.innerHTML = pc;
            document.title = title ? title : '';
            window.print();
            document.body.innerHTML = rp;
        }
    </script>
@endpush
