@extends('student_panel.layouts.master')

@section('title', 'Student Profile - European IT Solutions Institute')

@push('third_party_css')
    <link rel="stylesheet" href="{{ asset('assets/vendor/jquery-ui/jquery-ui.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
{{-- <link href="https://fonts.googleapis.com/css2?family=Roboto+Condensed:ital,wght@0,300;0,400;1,300;1,400&family=Teko:wght@300;400;500;600;700&display=swap" rel="stylesheet"> --}}
@endpush
@push('css')
<style>
    a {
        text-decoration: none !important;
    }
    body {
        margin: 0;
        padding: 0;
        background: white !important;
        /* font-family: "Teko", Sans-serif; */
        /* font-size: 20px; */
        /* font-weight: 400; */
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
    .student-photo {
        height: 282px;
        width: 282px;
        border-radius: 50%;
        object-fit: cover !important;
    }
    .trcolor{
        background-color : #ECECEC !important;
    }
    .img-lebel {
        background: #d2cece;
        height: 2em;
        width: 2em;
        line-height: 2em;
        text-align: center;
        font-size: 20px;
        border-radius: 50%;
        position: relative;
        top: -2.3em;
        right: -3em;
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

    @if(session('success'))
    <p class="alert alert-success text-center">
        {{ session('success') }}
    </p>
    @elseif(session('error'))
    <p class="alert alert-danger text-center">
        {{ session('error') }}
    </p>
    @endif
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h4> My Profile </h4>
                        <div class="d-flex align-items-center">
                            <a href="#!" class="btn btn-sm btn-outline-info ml-2">Certificate</a>
                            <button type="button" class="btn btn-sm btn-outline-success ml-2" data-toggle="modal" data-target="#StudentCardModal">ID Card</button>
                        </div>
                    </div>

                    <div class="card-body">
                        <div id="student-info">
                            <div class="info clearfix">
                                <section class="container-fluid" style="font-size: 20px">
                                    <div class="container-fluid">
                                        <div class="row mt-3 mb-5">
                                            <div class="col-md-6 text-center">
                                                <div class="card">
                                                    <div class="card-body my-4">
                                                        <p class="text-center">
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
                                                        <button type="button" class="btn btn-md btn-outline-info mt-4" data-toggle="modal" data-target="#StudentImg" >Edit Photo</button>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-6">
                                                <div class="card">
                                                    <div class="card-header">
                                                        <h4>Student Status</h4>
                                                    </div>
                                                    <div class="card-body">
                                                        @if ($student->courses->count() > 0)
                                                        @foreach($student->courses as $ck => $course)
                                                            <p><i class="fa fa-check-circle"></i> <span> Course Name: </span>
                                                                {{$course->title}}
                                                            </p>
                                                            <p><i class="fa fa-check-circle"></i><span> Batch Name: </span>
                                                                @foreach($student->batches as $bk => $batch)
                                                                {{batch_name($batch->course->title_short_form, $batch->year, $batch->month, $batch->batch_number)}}
                                                                @endforeach
                                                            </p>
                                                            <p><i class="fa fa-check-circle"></i> <span> Mentor Name: </span>
                                                                @foreach($minfo as $infos)
                                                                    @foreach($infos as $info)
                                                                        {{$info->mentorName($info->batch->id)}}
                                                                    @endforeach
                                                                @endforeach
                                                            </p>
                                                            <p><i class="fa fa-check-circle"></i> <span> Total Class: </span>
                                                                {{$course->total_class}}
                                                            </p>
                                                            <p><i class="fa fa-check-circle"></i> <span> Complete Class: </span>
                                                                        @foreach($student->batches as $bk => $batch)
                                                                            @foreach($minfo as $infos)
                                                                                @foreach($infos as $info)
                                                                                    @if($course->id == $info->course_id && $batch->id == $info->batch_id)
                                                                                        {{$info->completeClassCount()}}
                                                                                    @endif
                                                                                @endforeach
                                                                            @endforeach
                                                                        @endforeach
                                                                    
                                                            </p>
                                                            <p><i class="fa fa-check-circle"></i> <span> Total Present: </span>
                                                                @foreach($student->batches as $bk => $batch)
                                                                    @foreach($minfo as $infos)
                                                                        @foreach($infos as $info)
                                                                            @if($course->id == $info->course_id && $batch->id == $info->batch_id)
                                                                                {{$info->studentTotalPresentCount($student->id)}}
                                                                            @endif
                                                                        @endforeach
                                                                    @endforeach
                                                                @endforeach
                                                            </p>
                                                            <p><i class="fa fa-check-circle"></i> <span> Total Absent: </span>
                                                                @foreach($student->batches as $bk => $batch)
                                                                    @foreach($minfo as $infos)
                                                                        @foreach($infos as $info)
                                                                            @if($course->id == $info->course_id && $batch->id == $info->batch_id)
                                                                                {{$info->studentTotalAbsentCount($student->id)}}
                                                                            @endif
                                                                        @endforeach
                                                                    @endforeach
                                                                @endforeach
                                                            </p>
                                                        @endforeach
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-5">
                                            <div class="col personal_information">
                                                <div class="card">
                                                    <div class="card-header">
                                                        <h5 class="my-2 ml-2">Personal Information</h5>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <table class="table table-borderless">
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
                                                                    @if ($student->email)
                                                                        <tr>
                                                                            <td>Email</td>
                                                                            <td>:</td>
                                                                            <td>{{$student->email}}</td>
                                                                        </tr>
                                                                    @endif
                                                                    <tr>
                                                                        <td>Phone</td>
                                                                        <td>:</td>
                                                                        <td>{{$student->phone}}</td>
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
                
                                                            <div class="col-md-6">
                                                                <table class="table _table table-borderless">
                                                                    <tr>
                                                                        <td>Nationality</td>
                                                                        <td>:</td>
                                                                        <td>{{$student->nationality}}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>NID</td>
                                                                        <td>:</td>
                                                                        <td>{{$student->nid ?? 'N/A'}}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Birth Certificate</td>
                                                                        <td>:</td>
                                                                        <td>{{$student->birth ?? 'N/A'}}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Gender</td>
                                                                        <td>:</td>
                                                                        <td>{{ucfirst($student->gender)}}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Blood Group</td>
                                                                        <td>:</td>
                                                                        <td>{{$student->blood_group ?? 'N/A'}}</td>
                                                                    </tr>                       
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row guerdian_information mb-5">
                                            <div class="col-md-6">
                                                <div class="card">
                                                    <div class="card-header">
                                                        <h5 class="my-2 ml-2">Guerdian Information</h5>
                                                    </div>
                                                    <div class="card-body">
                                                        <table class="table table-borderless mb-5">
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
                                                                <td>Parent's Phone</td>
                                                                <td>:</td>
                                                                <td>{{$student->parents_phone}}</td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="card">
                                                    <div class="card-header">
                                                        <h5 class="my-2 ml-2">Institute Information</h5>
                                                    </div>
                                                    <div class="card-body">
                                                        <table class="table table-borderless">
                                                            @if (optional($student->institute)->name)
                                                                <tr>
                                                                    <td>Institute Name</td>
                                                                    <td>:</td>
                                                                    <td>{{optional($student->institute)->name}} ({{$student->shift()}})</td>
                                                                </tr>
                                                            @endif
                                                            <tr>
                                                                <td>Board Roll</td>
                                                                <td>:</td>
                                                                <td>{{$student->board_roll ?? 'N/A'}}</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Reg No.</td>
                                                                <td>:</td>
                                                                <td>{{$student->board_reg ?? 'N/A'}}</td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row address mb-5">
                                            <div class="col">
                                                <div class="card">
                                                    <div class="card-header">
                                                        <h5 class="my-2 ml-2">Address</h5>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="row">
                                                        <div class="col-md-6">
                                                            <table class="table table-borderless">
                                                                <tr>
                                                                    <td>Present Address</td>
                                                                    <td>:</td>
                                                                    <td>{{$student->present_address}}</td>
                                                                </tr>
                                                            </table>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <table class="table table-borderless">
                                                                <tr>
                                                                    <td>Permanent Address</td>
                                                                    <td>:</td>
                                                                    <td>{{$student->permanent_address}}</td>
                                                                </tr>
                                                            </table>
                                                        </div>
                                                    </div>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            @if ($student->note)
                                            <div class="col-md-12 mb-5">
                                                <div class="card">
                                                    <div class="card-header">
                                                        My Note
                                                    </div>
                                                    <div class="card-body">
                                                        <table class="table table-borderless">
                                                            <tr class="note">
                                                                <td>Note</td>
                                                                <td>:</td>
                                                                <td>{!! $student->note !!}</td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                </div>
                                                
                                            </div>
                                            @endif
                                        </div>

                                        @if (
                                            $student->emergency_contact_name
                                         || $student->emergency_contact_address
                                         || $student->emergency_contact_relation
                                         || $student->emergency_contact_phone
                                        )
                                            <div class="row emergency_contact mb-5">
                                                <div class="col">
                                                    <div class="card">
                                                        <div class="card-header">
                                                            <h5 class="my-2 ml-2">Emergency Contact</h5>
                                                        </div>
                                                        <div class="card-body">
                                                            <div class="row">
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
                                                        </div>
                                                    </div>
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
                                    </div>
                                </section>

                            </div>

                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>
    <!-- Start Student Image Modal -->
    <div class="modal fade" id="StudentImg" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Edit Profile Photo</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <div class="modal-body text-center">
                <form action="{{route('student.profile.photo.update')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id" value="{{$student->id}}">
                    <div class="mb-1 profile-image">
                        @if(isset($student->photo))
                        <img src="{{asset($student->photo)}}" id="output"
                            class="upImg1 rounded-circle me-50 border" alt="profile image" height="200" width="200">
                        @else

                            @if( $student->gender == 'male')
                                <img src="{{asset('images/avatar-male.jpg')}}" id="output"
                                class="upImg1 rounded-circle me-50 border" alt="profile image" height="200" width="200">
                            @else
                                <img src="{{asset('images/avater-female.jpg')}}" id="output"
                                class="upImg1 rounded-circle me-50 border" alt="profile image" height="200" width="200">
                            @endif
                        @endif
                    </div>
                    <div class="mb-2" style="height:0px">
                        <label for="profile-picture" class="img-lebel"><i class="fa fa-camera"></i></label>
                        <input type="file" accept="image/*" name="photo" id="profile-picture" onchange="loadFile(event)" class="form-control-file form-control-success invisible">
                        @if ($errors->has('photo'))
                            <span class="text-danger">{{ $errors->first('photo') }}</span>
                        @endif
                    </div>
                    <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    </div>
    <!-- End Student Image Modal -->
    <!-- Start ID Card Modal Modal -->
    <div class="modal fade" id="StudentCardModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">ID Card</h5>
                <div class="text-center ml-3 hide">
                    <button type="button" onclick="printT('print')"
                            class="btn btn-dark btn-sm text-center hide"><i class="fa fa-print"></i>
                    </button>
                </div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <div class="modal-body text-center">
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
                            
                            <div class="body_content">
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
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
        </div>
    </div>
    <!-- End ID Card Modal -->
    
@endsection

@push('js')
    <script>
    // Id Card Print
        function printT(el, title = '') {
            console.log(el);
            var rp = document.body.innerHTML;
            $('.hide').addClass("d-none");
            var pc = document.getElementById(el).innerHTML;
            document.body.innerHTML = pc;
            document.title = 'Student ID Card - European IT Solution Institute';
            window.print();
            document.body.innerHTML = rp;
        }
    </script>
    <script>
      var loadFile = function(event) {
        var reader = new FileReader();
        reader.onload = function(){
          var output = document.getElementById('output');
          output.src = reader.result;
        };
        reader.readAsDataURL(event.target.files[0]);
      };
    </script>
@endpush

