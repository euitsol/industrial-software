@extends('layouts.master')

@section('title', 'Edit Industrial Marketing Student - European IT Solutions Institute')

@push('css')
    <link rel="stylesheet" href="{{ asset('assets/vendor/select2/select2.min.css') }}">
    <style>
        .select2 {
            width: 100% !important;
        }
    </style>
@endpush

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Edit Industrial Marketing Student</h4>
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
                        <div class="row">
                            <div class="col-md-8 offset-md-2">
                                <form action="
                                {{ route('industrial.marketing.student.update',$student->id) }}
                                " method="POST" class="form-horizontal">
                                    @csrf
                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label">Name <span
                                                    class="text-danger">*</span> </label>
                                        <div class="col-md-9">
                                            <input type="text" name="name" value="{{ $student->name }}"
                                                   class="form-control form-control-success" required>
                                            <small>Please enter the name of student</small>
                                            @if ($errors->has('name'))
                                                <span class="text-danger">{{ $errors->first('name') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label">Phone <span
                                                    class="text-danger">*</span> </label>
                                        <div class="col-md-9">
                                            <input type="text" name="phone" value="{{ $student->phone }}"
                                                   class="form-control form-control-success" required>
                                            <small>Please enter the phone number of student</small>
                                            @if ($errors->has('phone'))
                                                <span class="text-danger">{{ $errors->first('phone') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div id="institute_wrapper">
                                        <div class="form-group row">
                                            <label class="col-md-3 form-control-label">Institute <span
                                                        class="text-danger">*</span>
                                            </label>
                                            <div class="col-md-9">
                                                <select name="institute" id="institute"
                                                        class="form-control form-control-success" >
                                                    @foreach ($institutes as $institute)
                                                        <option value="{{ $institute->id }}" @if($student->institute == $institute->id) selected @endif>
                                                            {{ $institute->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @if ($errors->has('institute'))
                                                    <span class="text-danger">{{ $errors->first('institute') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label">Interested Course <span class="text-danger">*</span>
                                        </label>
                                        <div class="col-md-9">
                                            <select name="course" id="course" class="form-control form-control-success" required>
                                                @foreach($courses as $course)
                                                    <option value="{{ $course->id }}" @if($student->course == $course->id) selected @endif>
                                                        {{ $course->title }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <small>Please select a course</small>
                                            @if ($errors->has('course'))
                                                <span class="text-danger">{{ $errors->first('course') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label">Shift <span class="text-danger">*</span>
                                        </label>
                                        <div class="col-md-9">
                                            <select name="shift" id="shift" class="form-control form-control-success" required>
                                                <option selected disabled value="">Choose...</option>
                                                    <option value="1" @if($student->shift ==1) selected @endif>1st Shift</option>
                                                    <option value="2" @if($student->shift ==2) selected @endif>2nd Shift</option>
                                            </select>
                                            <small>Please select a shift</small>
                                            @if ($errors->has('shift'))
                                                <span class="text-danger">{{ $errors->first('shift') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label">Note</label>
                                        <div class="col-md-9">
                                            <textarea name="note" id="note"
                                                      class="form-control form-control-success">{{ $student->note }}</textarea>
                                            <small>Please add note if you want</small>
                                            @if ($errors->has('note'))
                                                <span class="text-danger">{{ $errors->first('note') }}</span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <div class="col-md-9 ml-auto">
                                            <input type="submit" value="Submit" class="btn btn-primary">
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="{{ asset('assets/vendor/select2/select2.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/ckeditor/ckeditor.js') }}"></script>
    <script type="text/javascript">
        ClassicEditor.create(document.querySelector( '#note' ));

        $("#institute").select2();

        function isEmpty(str) {
            return (!str || 0 === str.length);
        }

    </script>
@endpush