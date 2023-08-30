@extends('layouts.master')

@section('title', 'Student ID Cards - European IT Solutions Institute')

@push('css')
<link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
<style>

.main_column{
    display: grid;
    grid-template-columns: 1fr 1fr 1fr;
    background: #f4f4fb;
    row-gap: 69.5px;
}
.main_card{
    width: 290px;
    height: 454px;
    position: relative;

}
.card_header{
    background: #18182B;
    height:4.5%;
}
.card_footer {
    background-color: #00a9ff;
    height: 4%;
    position: absolute;
    width: 100%;
    bottom: 0;
}

.logo_area{
    height: 30%;
    text-align: center;
}

.logo_area img{
    margin-top: 23px;
    width: 90% !impotant;
}

.body_area {
    height: 61.5%;
    background: #18182B;
    padding-top: 77px;
    padding-left: 10px;
    padding-right: 10px;
}

.student_name{
    text-align: center;
}

.id_logo {
    width: 248px;
    margin: 0 auto;

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
    border-radius: 50%;
    position: absolute;
    top: 100px;
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
    height: 25px;
    background: #00a9ff;
    position: absolute;
    bottom: 0px;
    left: 0;
}
.student_details {
    display: flex;
    flex-wrap: wrap;
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
      <div class="row">
        @if(count($students))
        <div class="col-md-11 mx-auto" id="print">
            <div class="my-4 text-center hide">
                <button type="button" onclick="printT('print')"
                        class="btn btn-dark btn-sm text-center hide"><i class="fa fa-print"></i>
                </button>
            </div>
            @foreach($students->chunk(9) as $students)
            <div class="main_column mb-4">
                @forelse ($students as $batch_student)
                    <div class="main_card mx-auto">
                        <div class="card_header"></div>
                        <div class="logo_area bg-white">
                        <div class="id_logo">
                                <img class="img-fluid" src="{{asset('images/EUITSols Institute New.png')}}" alt="logo">
                        </div>

                        </div>
                        @if(isset($batch_student->student->photo))
                            <img src="{{asset($batch_student->student->photo)}}" alt="" class="profile-pic">
                            @else
                                @if( $batch_student->student->gender == 'male')
                                <img src="{{asset('images/avatar-male.jpg')}}" alt="" class="profile-pic">
                                @else
                                <img src="{{asset('images/avater-female.jpg')}}" alt="" class="profile-pic">
                                @endif
                            @endif
                        <div class="body_area">

                        <div class="body_content">
                                <div class="student_name">
                                    <h2 class="mt-1 text-capitalize">{{strtolower($batch_student->student->name)}}</h2>
                                    @foreach($batch_student->student->batches as $batch)
                                        <p>{{$batch->course->title}}</p>
                                    @endforeach
                                </div>
                                <div class="student_details">
                                    <div class="left_column">
                                        <ul>
                                            <li>ID NO</li>
                                            <li>Batch No</li>
                                            <li>Phone</li>
                                            <li>Blood Group</li>
                                            <li>Email</li>
                                        </ul>
                                    </div>
                                    <div class="right_column">
                                        <ul>
                                            <li><span>:</span>{{$batch_student->student->year.$batch_student->student->reg_no}}</li>
                                            @foreach($batch_student->student->batches as $batch)
                                                <li><span>:</span>{{batch_name($batch->course->title_short_form, $batch->year, $batch->month, $batch->batch_number)}}</li>
                                            @endforeach
                                            <li><span>:</span>+88{{$batch_student->student->phone}}</li>
                                            <li><span>:</span>{{$batch_student->student->blood_group ?? 'N/A'}}</li>
                                            <li><span>:</span>{{$batch_student->student->email ?? 'N/A'}}</li>
                                        </ul>
                                    </div>

                                </div>
                        </div>
                        </div>
                        <div class="card_footer"></div>
                    </div>
                @empty
                @endforelse
            </div>
            @endforeach

        </div>
        @else
        <h4 class="text-center mx-auto text-danger">Empty</h4>
        @endif
      </div>
</div>
@endsection

@push('js')
<script>
    function printT(el, title = '') {
        console.log(el);
        var rp = document.body.innerHTML;
        $('.hide').addClass("d-none");
        var pc = document.getElementById(el).innerHTML;
        document.body.innerHTML = pc;
        document.title = 'Student ID Cards';
        window.print();
        document.body.innerHTML = rp;
    }
</script>
@endpush
