@extends('layouts.master')

@section('title', 'Createv Student - European IT Solutions Institute')

@push('css')
    <link rel="stylesheet"
          href="{{ asset('assets/vendor/select2/select2.min.css') }}">
    <style>
        fieldset {
            width: 100% !important;
            padding: 5px !important;
            border: 1px solid lightgray;
        }

        legend {
            width: auto;
            font-size: 20px;
        }

        table, tr, td {
            margin: 0 !important;
            padding: 5px !important;
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
                        <h4>Assign Course For Student</h4>
                    </span>
                        <span class="float-right">
                        <a href="{{ route('student.search') }}"
                           class="btn btn-info btn-sm">Back</a>
                    </span>
                    </div>

                    <div class="card-body">

                        <fieldset class="mb-3">
                            <legend>Student Information</legend>
                            <div class="row">
                                <div class="col">
                                    <div class="table-responsive">
                                        <table class="table table-borderless">
                                            <tr>
                                                <td>ID</td>
                                                <td>:</td>
                                                <td>{{ $student->year.$student->reg_no }}</td>
                                            </tr>
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
                                        </table>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="table-responsive">
                                        <table class="table table-borderless">
                                            <tr>
                                                <td>Phone</td>
                                                <td>:</td>
                                                <td>{{ $student->phone }}</td>
                                            </tr>
                                            <tr>
                                                <td>Institute</td>
                                                <td>:</td>
                                                <td>{{ optional($student->institute)->name }}  ( {{ $student->shift() }} )</td>
                                            </tr>
                                            <tr>
                                                <td>Present Address</td>
                                                <td>:</td>
                                                <td>{{ $student->present_address }}</td>
                                            </tr>
                                            <tr>
                                                <td>Student As</td>
                                                <td>:</td>
                                                <td>{{ $student->student_as }}</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </fieldset>

                        @if (session('success'))
                            <p class="alert alert-success text-center">{{ session('success') }}</p>
                        @endif

                        @if ($student->batches->count() > 0)
                            <div class="table-responsive mb-3">
                                <table class="table table-bordered table-striped">
                                    <tr>
                                        <th>SL</th>
                                        <th>Course</th>
                                        <th>Batch</th>
                                        @if (Auth::user()->role == 'admin' || Auth::user()->role == 'superadmin')
                                            <th>Action</th>
                                        @endif
                                    </tr>
                                    @foreach($student->batches as $k => $batch)
                                        <tr>
                                            <td>{{++$k}}</td>
                                            <td>{{$batch->course->title}}</td>
                                            <td>{{batch_name($batch->course->title_short_form, $batch->year, $batch->month, $batch->batch_number)}}</td>
                                            @if (Auth::user()->role == 'admin' || Auth::user()->role == 'superadmin')
                                                <td>
                                                    @if (isset($batch->migrate))
                                                        @if ($batch->migrate->new_course_id == $batch->course->id)
                                                            <a href="{{route('student.course.previous', [$student->id, $batch->migrate->old_course_id])}}"
                                                               class="btn btn-info btn-sm">Migrated</a>
                                                        @endif
                                                    @else
                                                        <a href="{{route('student.course.migration', [$student->id, $batch->id])}}"
                                                           class="btn btn-danger btn-sm"
                                                           onclick="return confirm('Are you sure?')">Migration</a>
                                                    @endif
                                                </td>
                                            @endif
                                        </tr>
                                    @endforeach
                                </table>
                            </div>
                        @endif

                        @if ($errors->has('course'))
                            <p class="alert alert-danger text-center">{{ $errors->first('course') }}</p>
                        @elseif ($errors->has('batch'))
                            <p class="alert alert-danger text-center">{{ $errors->first('batch') }}</p>
                        @elseif (session('error'))
                            <p class="alert alert-danger text-center">{{ session('error') }}</p>
                        @endif

                        <form action="{{ route('student.course.add') }}"
                              method="post" class="mt-3">
                            @csrf
                            <input type="hidden" name="student_id"
                                   value="{{ $student->id }}">

                            <div class="row">
                                @foreach ($course_types as $course_type)
                                    <div class="col-md-6 mb-2">
                                        <p class="font-weight-bold">{{ $course_type->type_name }}</p>

                                        @foreach ($course_type->courses as $k => $course)
                                        @if($course->running == 1)
                                            <div class="ml-3 mb-2">

                                                @if (in_array($course->id, $student_course_exist))

                                                    <div class="custom-control custom-checkbox mr-sm-2">
                                                        <input type="checkbox" class="custom-control-input" checked
                                                               disabled="disabled">
                                                        <label class="custom-control-label">{{ $course->title }}</label>

                                                        @foreach ($course->batches as $bk => $batch)
                                                            @if (in_array($batch->id, $student_batch_ids))
                                                                <span class="border py-1 px-3 ml-2">
                                                                {{batch_name($course->title_short_form, $batch->year, $batch->month, $batch->batch_number)}} {{'('.$batch->students->count().')'}}
                                                            </span>
                                                            @endif
                                                        @endforeach
                                                    </div>

                                                @else

                                                    <div class="custom-control custom-checkbox mr-sm-2">
                                                        <input type="checkbox" name="course[]" value="{{ $course->id }}"
                                                               id="course_{{ $course->id }}"
                                                               {{$course->batches->count() > 0 ? '' : 'disabled'}} class="custom-control-input">
                                                        <label class="custom-control-label"
                                                               for="course_{{ $course->id }}">{{ $course->title }}</label>

                                                        @if ($course->batches->count() > 0)
                                                            <select name="batch[]" id="batches_{{ $course->id }}"
                                                                    class="ml-2 form-control-sm batches">
                                                                <option selected disabled hidden> Choose Batch</option>
                                                                @foreach ($course->batches as $bk => $batch)
                                                                @if($batch->status == 1)
                                                                    <option value="{{ $batch->id }}">
                                                                        {{batch_name($course->title_short_form, $batch->year, $batch->month, $batch->batch_number)}}
                                                                        {{'('.$batch->students->count().')'}}
                                                                    </option>
                                                                @endif
                                                                @endforeach
                                                            </select>
                                                        @else
                                                            <span class="border py-1 px-3 ml-2 text-danger"> No batch found </span>
                                                        @endif
                                                    </div>

                                                @endif

                                            </div>
                                        @endif
                                        @endforeach
                                    </div>
                                @endforeach
                            </div>

                            <div class="form-group mt-3">
                                <input type="submit" value="Submit" class="btn btn-primary btn-block">
                            </div>

                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push("js")
    <script src="{{ asset('assets/vendor/select2/select2.min.js') }}"></script>
    <script type="text/javascript">
        $("#institute").select2();
    </script>
    <script>
        $(document).on('change', 'input[type=checkbox]', function () {
            let this_id = $(this).attr('id');
            let checked = $('#' + this_id).is(":checked");
            let split_id = this_id.split('_');
            let batch_id = $('#batches_' + split_id[1]);
            if (checked) {
                batch_id.slideDown();
            } else {
                batch_id.val('Choose Batch');
                batch_id.slideUp();
            }
        });
    </script>
@endpush