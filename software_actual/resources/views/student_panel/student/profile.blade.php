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
        height: 250px;
        width: 250px;
        border-radius: 50%;
        object-fit: cover !important;
    }
    .trcolor{
        background-color : #ECECEC !important;
    }
</style>
@endpush

@section('content')
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

                        @if(session('success'))
                            <p class="alert alert-success text-center">
                                {{ session('success') }}
                            </p>
                        @elseif(session('error'))
                            <p class="alert alert-danger text-center">
                                {{ session('error') }}
                            </p>
                        @endif

                        <div id="student-info" style="">

                            <div class="info clearfix">
                                <section class="container-fluid" style="font-size: 20px">
                                    <div class="container-fluid">
                                        <div class="row my-3">
                                            <div class="col-md-6 text-center my-5">
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
                                                <a href="#!" class="btn btn-md btn-outline-info mt-4">Edit Photo</a>
                                            </div>
                                            
                                            <div class="col-md-6">
                                                <h4>Student Status</h4>
                                            </div>
                                        </div>
                                        

                                        <h5 class="my-2 ml-2">Personal Information</h5>
                                        <div class="row emergency_contact">
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
                                        <div class="row emergency_contact">

                                            <div class="col-md-6">
                                                <h5 class="my-2 ml-2">Guerdian Information</h5>
                                                <table class="table table-borderless">
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

                                            <div class="col-md-6">
                                                <h5 class="my-2 ml-2">Institute Information</h5>
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

                                        <h5 class="my-2 ml-2">Address</h5>
                                        <div class="row emergency_contact">
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
                                            @if ($student->note)
                                            <div class="col-md-12">
                                                <table class="table table-borderless">
                                                    <tr class="note">
                                                        <td>Note</td>
                                                        <td>:</td>
                                                        <td>{!! $student->note !!}</td>
                                                    </tr>
                                                </table>
                                            </div>
                                            @endif
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
                                    </div>
                                </section>

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

