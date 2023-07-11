@extends('student_panel.layouts.master')

@section('title', 'Student ID Card - European IT Solutions Institute')
@push('css')
    <link rel="stylesheet" href="{{ asset('certificate/style.css') }}">
@endpush

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12 col-lg-12">

                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between">
                        <span class="float-left">
                            <h4>Student Certificate</h4>
                        </span>
                        <button type="button" onclick="printT('print')"
                            class="btn btn-dark btn-sm text-center hide float-right"><i class="fa fa-print"></i>
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="certificate p-0 m-0" id="print">
                            @foreach ($student->batches as $batch)
                                @if ($batch->end_date < Carbon\Carbon::now())
                                    <div class="certificater-main-content">
                                        <!--*****Certificate Header Part******-->
                                        <div class="certificate-head-content">
                                            <div class="left-col">
                                                <p class="sl-no">SL No: 2022194</p>
                                            </div>

                                            <div class="middle-col">
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
                                                <h2>{{ $student->name }}</h2>
                                            </div>

                                            <div class="certificate-details">
                                                <p>
                                                    Roll No. <span class="roll">{{ $student->board_roll }}</span> Reg.
                                                    No. <span class="Reg">{{ $student->board_reg }}</span> of
                                                    <span class="institute">{{ $student->institute->name }}</span> has
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
                                                <span class="date">DATE OF ISSUE</span>
                                            </div>
                                            <div class="middle-col">
                                                <span class="country-d">COUNTRY DIRECTOR, BANGLADESH</span>
                                            </div>
                                            <div class="right-col">
                                                <span class="coordinator">COURSE CO-ORDINATOR</span>
                                            </div>
                                        </div>
                                        <div class="company text-center mt-3">
                                            <p>European IT Solutions Institute, Dhaka, Bangladesh</p>
                                            <a href="www.europeanit-inst.com">www.europeanit-inst.com</a>
                                        </div>
                                    </div>
                                @else
                                    <span class="text-center">You got your certificate after finished your course</span>
                                @endif
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
            document.title = 'Student Certificate - European IT Solution Institute';
            window.print();
            document.body.innerHTML = rp;
        }
    </script>
@endpush
