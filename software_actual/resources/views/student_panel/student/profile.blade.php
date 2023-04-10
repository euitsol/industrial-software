@extends('student_panel.layouts.master')

@section('title', 'Session Wise Students - European IT Solutions Institute')

@push('third_party_css')
    <link rel="stylesheet" href="{{ asset('assets/vendor/jquery-ui/jquery-ui.css') }}">
@endpush
@push('css')
<style>
    a {
        text-decoration: none !important;
    }
    body {
        margin: 0;
        padding: 0;
    }
    body {
        background: white !important;
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
                    <div class="card-header">
                    <span class="float-left">
                        <h4> My Profile </h4>
                    </span>
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
                                                        <a href="#!" class="btn btn-md btn-outline-info mt-4" data-toggle="modal" data-target="#StudentImgModal">Edit Photo</a>
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
    <div class="modal fade" id="StudentImgModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
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
                    <div class="mb-1">
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
                    <div class="mb-1">
                        <input type="file" accept="image/*" name="photo" onchange="loadFile(event)" class="form-control-file form-control-success">
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
    <!-- End Student Image Modal -->
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
    {{-- <script>
        function previewImage() {
        const file = fileInput.files[0];
        if (file) {
            const reader = new FileReader();
            reader.addEventListener('load', () => {
            previewImage.src = reader.result;
            });
            reader.readAsDataURL(file);
        }
        }
    </script> --}}
@endpush

