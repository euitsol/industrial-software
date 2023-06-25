@extends('student_panel.layouts.master')

@section('title', 'Student ID Card - European IT Solutions Institute')
@push('css')
    <style>
        .t_head_title {
        background-image: linear-gradient(to right, rgba(159, 158, 158, 0.09) 6%, rgb(12, 159, 206), rgb(12, 159, 206), rgb(12, 159, 206), rgba(159, 158, 158, 0.09) 94%);
    }
    </style>
    <style>
        /* Student Card Styles */
        .main_card{
        width: 300px;
        height: 484px;
        position: relative;

        }
        .card_header{
            background: #303140;
            height:6%;
        }
        .card_footer {
            background-color: #0097d5;
            height: 4%;
            position: absolute;
            bottom: 0;
        }

        .logo_area{
            height: 30%;
        }

        .logo_area img{
            margin-top: 23px;
        }

        .body_area {
            height: 60%;
            background: #303140;
            padding-top: 77px;
            padding:77px 10px 0px;
        }
        .id_logo {
            width: 248px;
        }
        .body_area h2 {
            color: #4ebff8;
            font-size: 23px;
            font-weight: 400;
            font-family: "Roboto";
            margin-bottom: 5px;
            line-height: 22px;
        }
        .profile-pic {
            width: 130px;
            height: 130px;
            border: 5px solid;
            position: absolute;
            top: 125px;
            left: 50%;
            transform: translateX(-50%);
        }
            .body_area p {
            font-size: 19px;
            color: #ffffff;
            font-weight: 400;
            font-family: "Roboto";
            line-height: 21px;
        }

        .logo_area{
            position: relative
        }
        .logo_area::after {
            content: '';
            width: 100%;
            height: 32px;
            background: #4ebff8;
            position: absolute;
            bottom: -32px;
            left: 0;
        }
        .student_details {
            justify-content: baseline;
            padding-left:20px;
        }

        .student_details .left_column{
            width: 30%
        }
        .student_details .right_column {
            width: 70%;
            padding-left: 38px;
        }

        .student_details ul li {
            list-style: none;
            color: #ffffff;
            font-size: 12px;
            line-height: 20px;
            overflow-wrap: break-word;
        }
        .student_details ul li span{
            margin-right: 2px;
        }
        .student_details .right_column ul li:last-child{
            line-height: 12px;
        }

        .student_details ul{
            margin: 0;
            padding: 0;
        }
        </style>
@endpush

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-10">

            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between">
                    <span class="float-left">
                        <h4>Student ID Card</h4>
                    </span>
                    <button type="button" onclick="printT('print')"
                            class="btn btn-dark btn-sm text-center hide float-right"><i class="fa fa-print"></i>
                    </button>
                </div>
                <div class="card-body">
                    <div class="id_card w-100" id="print">
                        <div class="main_card mb-2 mx-auto">
                            <div class="card_header"></div>
                            <div class="logo_area bg-white">
                            <div class="id_logo mx-auto">
                                    <img class="img-fluid" src="{{asset('images/EUITSols Institute New.png')}}" alt="logo">
                            </div>

                            </div>
                            @if(isset($student->photo))
                                <img src="{{asset($student->photo)}}" alt="" class="profile-pic rounded-circle">
                                @else
                                    @if( $student->gender == 'male')
                                    <img src="{{asset('images/avatar-male.jpg')}}" alt="" class="profile-pic rounded-circle">
                                    @else
                                    <img src="{{asset('images/avater-female.jpg')}}" alt="" class="profile-pic rounded-circle">
                                    @endif
                                @endif
                            <div class="body_area">

                            <div class="body_content mt-2">
                                <div class="student_name text-center">
                                    <h2>{{$student->name}}</h2>
                                    @foreach($student->batches as $batch)
                                        <p>{{$batch->course->title}}</p>
                                    @endforeach
                                </div>
                                <div class="student_details text-left d-flex flex-wrap">
                                    <div class="left_column">
                                        <ul>
                                            <li>ID NO</li>
                                            <li>Batch No</li>
                                            <li>Phone</li>
                                            <li>Blood</li>
                                            <li>Email</li>
                                        </ul>
                                    </div>
                                    <div class="right_column">
                                        <ul>
                                            <li><span>:</span>{{$student->year.$student->reg_no}}</li>
                                            @foreach($student->batches as $batch)
                                                <li><span>:</span>{{batch_name($batch->course->title_short_form, $batch->year, $batch->month, $batch->batch_number)}}</li>
                                            @endforeach
                                            <li><span>:</span>+88{{$student->phone}}</li>
                                            <li><span>:</span>{{$student->blood ?? 'N/A'}}</li>
                                            <li><span>:</span>{{$student->email ?? 'N/A'}}</li>
                                        </ul>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="card_footer w-100"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
<script>
    // Id Card Print
        function printT(el, title = '') {
            console.log(el);
            var rp = document.body.innerHTML;
            $('.main_card').addClass("mt-5");
            var pc = document.getElementById(el).innerHTML;
            document.body.innerHTML = pc;
            document.title = 'Student ID Card - European IT Solution Institute';
            window.print();
            document.body.innerHTML = rp;
        }
    </script>
