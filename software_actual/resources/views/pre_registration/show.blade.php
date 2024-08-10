@extends('layouts.master')

@section('title', 'Student - European IT Solutions Institute')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <span class="float-left">
                            <h4>Pre Admitted Student Details</h4>
                        </span>
                        <span class="float-right">
                            <a href="{{ route('pr.edit', $student->id) }}" class="btn btn-sm btn-info">
                                <i class="fa fa-edit"></i>
                            </a>
                            <a href="{{ url()->previous() }}" class="btn btn-info btn-sm">Back</a>
                        </span>
                    </div>

                    <div class="card-body">

                        <div class="row">
                            <div class="col-md-12">
                                <p class="text-center">
                                    @if (!empty($student->photo) && file_exists($student->photo))
                                        <img src="{{ asset($student->photo) }}" height="200" alt="Photo">
                                    @endif
                                </p>
                                <div class="row">
                                    <div class="col">
                                        <table class="table table-borderless">
                                            <tr>
                                                <td>Name</td>
                                                <td>:</td>
                                                <td>{{ $student->name }}</td>
                                            </tr>
                                            <tr>
                                                <td>Father's Name</td>
                                                <td>:</td>
                                                <td>{{ $student->fathers_name }}</td>
                                            </tr>
                                            <tr>
                                                <td>Mother's Name</td>
                                                <td>:</td>
                                                <td>{{ $student->mothers_name }}</td>
                                            </tr>
                                            <tr>
                                                <td>Phone</td>
                                                <td>:</td>
                                                <td>{{ $student->phone }}</td>
                                            </tr>
                                            @if ($student->email)
                                                <tr>
                                                    <td>E-Mail</td>
                                                    <td>:</td>
                                                    <td>{{ $student->email }}</td>
                                                </tr>
                                            @endif
                                            <tr>
                                                <td>Gender</td>
                                                <td>:</td>
                                                <td>{{ ucfirst($student->gender) }}</td>
                                            </tr>
                                            @if ($student->parents_phone)
                                                <tr>
                                                    <td>Parent's Phone</td>
                                                    <td>:</td>
                                                    <td>{{ $student->parents_phone }}</td>
                                                </tr>
                                            @endif
                                            @if ($student->blood_group)
                                                <tr>
                                                    <td>Blood Group</td>
                                                    <td>:</td>
                                                    <td>{{ $student->blood_group }}</td>
                                                </tr>
                                            @endif
                                            @if ($student->nid)
                                                <tr>
                                                    <td>NID No.</td>
                                                    <td>:</td>
                                                    <td>{{ $student->nid }}</td>
                                                </tr>
                                            @elseif ($student->birth)
                                                <tr>
                                                    <td>Birth Certificate No.</td>
                                                    <td>:</td>
                                                    <td>{{ $student->birth }}</td>
                                                </tr>
                                            @endif
                                            <tr>
                                                <td>Student As</td>
                                                <td>:</td>
                                                <td>
                                                    <span class="badge badge-blue">{{ $student->student_as }}</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Year</td>
                                                <td>:</td>
                                                <td>{{ $student->year }}</td>
                                            </tr>
                                        </table>
                                    </div>
                                    <div class="col">
                                        <table class="table table-borderless">
                                            <tr>
                                                <td>Present Address</td>
                                                <td>:</td>
                                                <td>{{ $student->present_address }}</td>
                                            </tr>
                                            <tr>
                                                <td>Permanent Address</td>
                                                <td>:</td>
                                                <td>{{ $student->permanent_address }}</td>
                                            </tr>
                                            @if ($student->district)
                                                <tr>
                                                    <td>District</td>
                                                    <td>:</td>
                                                    <td>{{ $student->district }}</td>
                                                </tr>
                                            @endif
                                            <tr>
                                                <td>Date of Birth</td>
                                                <td>:</td>
                                                <td>{{ date('D d F, Y', strtotime($student->dob)) }}</td>
                                            </tr>
                                            @if ($student->institute)
                                                <tr>
                                                    <td>Institute Name</td>
                                                    <td>:</td>
                                                    <td>{{ optional($student->institute)->name }}
                                                        ({{ $student->shift() }})</td>
                                                </tr>
                                            @endif
                                            @if ($student->board_roll)
                                                <tr>
                                                    <td>Board Roll</td>
                                                    <td>:</td>
                                                    <td>{{ $student->board_roll }}</td>
                                                </tr>
                                            @endif
                                            @if ($student->board_reg)
                                                <tr>
                                                    <td>Board Reg.</td>
                                                    <td>:</td>
                                                    <td>{{ $student->board_reg }}</td>
                                                </tr>
                                            @endif
                                            @if ($student->nationality)
                                                <tr>
                                                    <td>Nationality</td>
                                                    <td>:</td>
                                                    <td>{{ $student->nationality }}</td>
                                                </tr>
                                            @endif
                                            @if ($student->note)
                                                <tr>
                                                    <td>Note</td>
                                                    <td>:</td>
                                                    <td>{!! $student->note !!}</td>
                                                </tr>
                                            @endif
                                            <tr>
                                                <td>Added By</td>
                                                <td>:</td>
                                                <td>{{ $student->name }}</td>
                                            </tr>
                                            @if ($student->district)
                                                <tr>
                                                    <td>Year</td>
                                                    <td>:</td>
                                                    <td>{{ $student->year }}</td>
                                                </tr>
                                            @endif
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
                                                    <td>{{ $student->emergency_contact_name }}</td>
                                                </tr>
                                            @endif
                                            @if ($student->emergency_contact_address)
                                                <tr>
                                                    <td>Address</td>
                                                    <td>:</td>
                                                    <td>{{ $student->emergency_contact_address }}</td>
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
                                                    <td>{{ $student->emergency_contact_relation }}</td>
                                                </tr>
                                            @endif
                                            @if ($student->emergency_contact_phone)
                                                <tr>
                                                    <td>Phone</td>
                                                    <td>:</td>
                                                    <td>{{ $student->emergency_contact_phone }}</td>
                                                </tr>
                                            @endif
                                        </table>
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
