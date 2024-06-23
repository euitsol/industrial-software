@extends('layouts.master')

@section('title', 'Student - European IT Solutions Institute')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <span class="float-left">
                            <h4>Pre Admitted Student Admission</h4>
                        </span>
                        <span class="float-right">
                            <a href="{{ route('pr.edit', $student->id) }}" class="btn btn-sm btn-info">
                                <i class="fa fa-edit"></i>
                            </a>
                            <a href="{{ url()->previous() }}" class="btn btn-info btn-sm">Back</a>
                        </span>
                    </div>
                    <div class="card-body">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <form action="{{ route('student.store') }}" method="POST" enctype="multipart/form-data"
                            class="form-horizontal">
                            @csrf
                            <div class="row">
                                <div class="col-md-12">
                                    <input type="hidden" name="pre_sid" value="{{ $student->id }}">
                                    <p class="text-center">
                                        @if (!empty($student->photo) && file_exists($student->photo))
                                            <img src="{{ asset($student->photo) }}" height="200" alt="Photo">
                                            <input type="hidden" name="pre_photo" value="{{ $student->image }}">
                                        @endif
                                    </p>
                                    <div class="row">
                                        <div class="col">
                                            <table class="table table-borderless">
                                                <tr>
                                                    <td>Name</td>
                                                    <td>:</td>
                                                    <td>
                                                        {{ $student->name }}
                                                        <input type="hidden" name="name" value="{{ $student->name }}">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Father's Name</td>
                                                    <td>:</td>
                                                    <td>
                                                        {{ $student->fathers_name }}
                                                        <input type="hidden" name="fathers_name"
                                                            value="{{ $student->fathers_name }}">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Mother's Name</td>
                                                    <td>:</td>
                                                    <td>
                                                        {{ $student->mothers_name }}
                                                        <input type="hidden" name="mothers_name"
                                                            value="{{ $student->mothers_name }}">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Phone</td>
                                                    <td>:</td>
                                                    <td>
                                                        {{ $student->phone }}
                                                        <input type="hidden" name="phone" value="{{ $student->phone }}">
                                                    </td>
                                                </tr>
                                                @if ($student->email)
                                                    <tr>
                                                        <td>E-Mail</td>
                                                        <td>:</td>
                                                        <td>
                                                            {{ $student->email }}
                                                            <input type="hidden" name="email"
                                                                value="{{ $student->email }}">
                                                        </td>
                                                    </tr>
                                                @endif
                                                <tr>
                                                    <td>Gender</td>
                                                    <td>:</td>
                                                    <td>
                                                        {{ ucfirst($student->gender) }}
                                                        <input type="hidden" name="gender"
                                                            value="{{ $student->gender }}">
                                                    </td>
                                                </tr>
                                                @if ($student->parents_phone)
                                                    <tr>
                                                        <td>Parent's Phone</td>
                                                        <td>:</td>
                                                        <td>
                                                            {{ $student->parents_phone }}
                                                            <input type="hidden" name="parents_phone"
                                                                value="{{ $student->parents_phone }}">
                                                        </td>
                                                    </tr>
                                                @endif
                                                @if ($student->blood_group)
                                                    <tr>
                                                        <td>Blood Group</td>
                                                        <td>:</td>
                                                        <td>
                                                            {{ $student->blood_group }}
                                                            <input type="hidden" name="blood_group"
                                                                value="{{ $student->blood_group }}">
                                                        </td>
                                                    </tr>
                                                @endif
                                                @if ($student->nid)
                                                    <tr>
                                                        <td>NID No.</td>
                                                        <td>:</td>
                                                        <td>
                                                            {{ $student->nid }}
                                                            <input type="hidden" name="nid"
                                                                value="{{ $student->nid }}">
                                                        </td>
                                                    </tr>
                                                @elseif ($student->birth)
                                                    <tr>
                                                        <td>Birth Certificate No.</td>
                                                        <td>:</td>
                                                        <td>{{ $student->birth }}
                                                            <input type="hidden" name="birth"
                                                                value="{{ $student->birth }}">
                                                        </td>
                                                    </tr>
                                                @endif
                                                <tr>
                                                    <td>Student As</td>
                                                    <td>:</td>
                                                    <td>
                                                        <span class="badge badge-blue">{{ $student->student_as }}</span>
                                                        <input type="hidden" name="student_as"
                                                            value="{{ $student->student_as }}">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Year</td>
                                                    <td>:</td>
                                                    <td>{{ $student->year }}
                                                        <input type="hidden" name="year" value="{{ $student->year }}">
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                        <div class="col">
                                            <table class="table table-borderless">
                                                <tr>
                                                    <td>Present Address</td>
                                                    <td>:</td>
                                                    <td>{{ $student->present_address }}
                                                        <input type="hidden" name="present_address"
                                                            value="{{ $student->present_address }}">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Permanent Address</td>
                                                    <td>:</td>
                                                    <td>{{ $student->permanent_address }}
                                                        <input type="hidden" name="permanent_address"
                                                            value="{{ $student->permanent_address }}">
                                                    </td>
                                                </tr>
                                                @if ($student->district)
                                                    <tr>
                                                        <td>District</td>
                                                        <td>:</td>
                                                        <td>{{ $student->district }}
                                                            <input type="hidden" name="district"
                                                                value="{{ $student->district }}">
                                                        </td>
                                                    </tr>
                                                @endif
                                                <tr>
                                                    <td>Date of Birth</td>
                                                    <td>:</td>
                                                    <td>{{ date('D d F, Y', strtotime($student->dob)) }}
                                                        <input type="hidden" name="dob" value="{{ $student->dob }}">
                                                    </td>
                                                </tr>
                                                @if ($student->institute)
                                                    <tr>
                                                        <td>Institute Name</td>
                                                        <td>:</td>
                                                        <td>{{ optional($student->institute)->name }}
                                                            ({{ $student->shift() }})
                                                            <input type="hidden" name="institute"
                                                                value="{{ $student->institute_id }}">
                                                            <input type="hidden" name="shift"
                                                                value="{{ $student->shift }}">
                                                        </td>
                                                    </tr>
                                                @endif
                                                @if ($student->board_roll)
                                                    <tr>
                                                        <td>Board Roll</td>
                                                        <td>:</td>
                                                        <td>{{ $student->board_roll }}
                                                            <input type="hidden" name="board_roll"
                                                                value="{{ $student->board_roll }}">
                                                        </td>
                                                    </tr>
                                                @endif
                                                @if ($student->board_reg)
                                                    <tr>
                                                        <td>Board Reg.</td>
                                                        <td>:</td>
                                                        <td>{{ $student->board_reg }}
                                                            <input type="hidden" name="board_reg"
                                                                value="{{ $student->board_reg }}">
                                                        </td>
                                                    </tr>
                                                @endif
                                                @if ($student->nationality)
                                                    <tr>
                                                        <td>Nationality</td>
                                                        <td>:</td>
                                                        <td>{{ $student->nationality }}
                                                            <input type="hidden" name="nationality"
                                                                value="{{ $student->nationality }}">
                                                        </td>
                                                    </tr>
                                                @endif
                                                @if ($student->note)
                                                    <tr>
                                                        <td>Note</td>
                                                        <td>:</td>
                                                        <td>{!! $student->note !!}
                                                            <input type="hidden" name="note"
                                                                value="{{ $student->note }}">
                                                        </td>
                                                    </tr>
                                                @endif
                                                <tr>
                                                    <td>Added By</td>
                                                    <td>:</td>
                                                    <td>{{ $student->name }}</td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>

                                    <h6 class="text-center border py-2">Emergency Contact</h6>

                                    <div class="row">
                                        <div class="col">
                                            <table class="table table-borderless">
                                                @if ($student->emergency_contact_name)
                                                    <tr>
                                                        <td>Name</td>
                                                        <td>:</td>
                                                        <td>{{ $student->emergency_contact_name }}
                                                            <input type="hidden" name="emergency_contact_name"
                                                                value="{{ $student->emergency_contact_name }}">
                                                        </td>
                                                    </tr>
                                                @endif
                                                @if ($student->emergency_contact_address)
                                                    <tr>
                                                        <td>Address</td>
                                                        <td>:</td>
                                                        <td>{{ $student->emergency_contact_address }}
                                                            <input type="hidden" name="emergency_contact_address"
                                                                value="{{ $student->emergency_contact_address }}">
                                                        </td>
                                                    </tr>
                                                @endif
                                            </table>
                                        </div>
                                        <div class="col">
                                            <table class="table table-borderless">
                                                @if ($student->emergency_contact_relation)
                                                    <tr>
                                                        <td>Relation</td>
                                                        <td>:</td>
                                                        <td>{{ $student->emergency_contact_relation }}
                                                            <input type="hidden" name="emergency_contact_relation"
                                                                value="{{ $student->emergency_contact_relation }}">
                                                        </td>
                                                    </tr>
                                                @endif
                                                @if ($student->emergency_contact_phone)
                                                    <tr>
                                                        <td>Phone</td>
                                                        <td>:</td>
                                                        <td>{{ $student->emergency_contact_phone }}
                                                            <input type="hidden" name="emergency_contact_phone"
                                                                value="{{ $student->emergency_contact_phone }}">
                                                        </td>
                                                    </tr>
                                                @endif
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <input type="hidden" name="source" value="9">
                            <div class="form-group row">
                                <div class="col-md-12">
                                    <input type="submit" value="Admission Now" class="float-right btn btn-primary">
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
