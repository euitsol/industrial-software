@extends('layouts.master')

@section('title', 'Student Certificates - European IT Solutions Institute')
@push('css')
    <link rel="stylesheet" href="{{ asset('certificate/style.css') }}">
    <style>
        /* .landscape {
                                    transform: rotate(90deg);
                                    width: 100vw;
                                    height: 100vh;
                                    overflow: hidden;
                                    position: relative;
                                    left: -50%;
                                } */
        @media print {

            /* .landscape {
                                    transform: rotate(-90deg);
                                    transform-origin: left top;
                                    width: 100vh; / Using the viewport height to set the width /
                                    height: 100vw; / Using the viewport width to set the height /
                                    position: absolute;
                                    top: 100%; / Move the rotated div out of the printable area /
                                    page-break-before: always; / Optional: add a page break before the div /
                                    } */
            /* @page {
                                    size: landscape;
                                    }

                                    .landscape {
                                        transform: rotate(90deg);
                                        width: 100vw;
                                        height: 100vh;
                                        overflow: hidden;
                                        position: relative;
                                        left: -50%;
                                    } */
            @page {
                size: A4 landscape;
                margin: 0;
            }
        }

        .country-d {
            position: relative;
        }

        .country-d:after {
            content: '';
            position: absolute;
            background: url({{ asset('certificate/img/Mamun_Sir_Signature.png') }});
            width: 105px;
            height: 65px;
            background-size: 100%;
            background-repeat: no-repeat;
            top: -150%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        .coordinator {
            position: relative;
        }

        .coordinator:after {
            content: '';
            position: absolute;
            background: url({{ asset('certificate/img/faruk_sig.png') }});
            width: 80px;
            height: 58px;
            background-size: 100%;
            background-repeat: no-repeat;
            top: -130%;
            left: 50%;
            transform: translate(-50%, -50%);
        }
    </style>
@endpush

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-12 col-lg-12">

                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between">
                        <span class="float-left">
                            <h4>Student Certificates</h4>
                        </span>
                        <button type="button" onclick="printT('print')"
                            class="btn btn-dark btn-sm text-center hide float-right"><i class="fa fa-print"></i>
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="certificate landscape p-0 m-0 d-none d-md-block" id="print">
                            @foreach ($students as $student)
                                @foreach ($student->student->batches as $batch)
                                    {{-- @if (!empty($batch->end_date) && $batch->end_date < Carbon\Carbon::now()) --}}
                                    <div class="certificater-main-content">
                                        <!--*****Certificate Header Part******-->
                                        <div class="certificate-head-content">
                                            <div class="left-col">
                                                <p class="sl-no">SL No:
                                                    {{ $student->student->year . $student->student->reg_no }}</p>
                                            </div>

                                            <div class="middle-col">
                                                <img src="{{ asset('certificate/img/euit_logo.svg') }}">
                                                <h2>CERTIFICATE</h2>
                                                <h3>OF COMPLETION</h3>
                                                <h4>THIS IS TO CERTIFY THAT</h4>
                                            </div>

                                            <div class="right-col">
                                                <div class="qr-code">
                                                    <img src="{{ asset('certificate/img/qr-code.png') }}" alt="QR-Code" />
                                                </div>
                                            </div>
                                        </div>

                                        <!--*****Certificate Body Part******-->
                                        <div class="certificate-body-content">
                                            <div class="certificate-name">
                                                <h2>{{ $student->student->name }}</h2>
                                            </div>

                                            <div class="certificate-details">
                                                <p>
                                                    Roll No. <span class="roll">{{ $student->student->board_roll }}</span>
                                                    Reg.
                                                    No. <span class="Reg">{{ $student->student->board_reg }}</span> of
                                                    <span class="institute">{{ $student->student->institute->name }}</span>
                                                    has
                                                    participated and successfully
                                                    completed the course of
                                                    <span class="course">Industrial Attachment -
                                                        {{ $batch->course->title }}</span>
                                                </p>

                                                <p></p>
                                            </div>
                                        </div>

                                        <!--*****Certificate Footer Part******-->
                                        <div class="certificate-footer-content">
                                            <div class="left-col">
                                                <span class="daynamic_date">
                                                    {{-- {{Carbon\Carbon::now()->format('d-m-Y')}} --}}
                                                    {{-- 06-11-2023 --}}
                                                    {{ $batch->certificate_issue_date ? date('d-m-Y', strtotime($batch->certificate_issue_date)) : 'N/A' }}
                                                </span>
                                                <span class="date">DATE OF ISSUE</span>
                                            </div>
                                            <div class="middle-col">
                                                <span class="country-d">COUNTRY DIRECTOR, BANGLADESH</span>
                                            </div>
                                            <div class="right-col">
                                                <span class="coordinator">COURSE CO-ORDINATOR</span>
                                            </div>
                                        </div>
                                        <div class="company text-center mt-4">
                                            <p>European IT Solutions Institute, Dhaka, Bangladesh</p>
                                            <a href="www.europeanit-inst.com">www.europeanit-inst.com</a>
                                        </div>
                                    </div>
                                    {{-- @else
                                    <span class="text-center">You get your certificate after completing your course</span>
                                @endif --}}
                                @endforeach
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script>
        // Id Card Print
        function printT(el, title = '') {
            console.log(el);
            var rp = document.body.innerHTML;
            var pc = document.getElementById(el).innerHTML;
            document.body.innerHTML = pc;
            // document.body.style.transform = 'rotate(90deg)';
            document.body.style.width = '100vw';
            document.body.style.height = '100vh';
            document.title = 'Student Certificate - European IT Solution Institute';
            window.print();
            document.body.innerHTML = rp;


        }
    </script>
@endpush
