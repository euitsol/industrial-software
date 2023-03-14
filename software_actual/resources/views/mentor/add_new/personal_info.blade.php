@extends('layouts.master')

@section('title', 'Create Mentor - European IT Solutions Institute')

@push('css')
    <link rel="stylesheet" href="{{ asset('assets/vendor/select2/select2.min.css') }}">
@endpush

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10 col-lg-12">
                <div class="card">
                    <div class="card-header">
                    <span class="float-left">
                        <h4>New Mentor</h4>
                    </span>
                        <span class="float-right">
                        <a href="{{ route('mentors') }}" class="btn btn-info btn-sm">Back</a>
                    </span>
                    </div>

                    <div class="card-body">

                        <div class="row">
                            <div class="col-md-8 offset-md-2">

                                <p class="font-weight-bold">Personal Information</p>

                                @if(session('success'))
                                    <p class="alert alert-success text-center">
                                        {{ session('success') }}
                                    </p>
                                @elseif(session('error'))
                                    <p class="alert alert-danger text-center">
                                        {{ session('error') }}
                                    </p>
                                @endif

                                <form action="{{ route('mentor.store') }}" method="POST" enctype="multipart/form-data"
                                      class="form-horizontal">
                                    @csrf

                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label">Name <span
                                                    class="text-danger">*</span></label>
                                        <div class="col-md-9">
                                            <input type="text" name="name" value="{{ old('name') }}"
                                                   class="form-control form-control-success">
                                            @if ($errors->has('name'))
                                                <span class="text-danger">{{ $errors->first('name') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label">Father's Name <span
                                                    class="text-danger">*</span></label>
                                        <div class="col-md-9">
                                            <input type="text" name="fathers_name" value="{{ old('fathers_name') }}"
                                                   class="form-control form-control-success">
                                            @if ($errors->has('fathers_name'))
                                                <span class="text-danger">{{ $errors->first('fathers_name') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label">Mother's Name <span
                                                    class="text-danger">*</span></label>
                                        <div class="col-md-9">
                                            <input type="text" name="mothers_name" value="{{ old('mothers_name') }}"
                                                   class="form-control form-control-success">
                                            @if ($errors->has('mothers_name'))
                                                <span class="text-danger">{{ $errors->first('mothers_name') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label">Phone <span
                                                    class="text-danger">*</span></label>
                                        <div class="col-md-9">
                                            <input type="text" name="phone" value="{{ old('phone') }}"
                                                   class="form-control form-control-success">
                                            @if ($errors->has('phone'))
                                                <span class="text-danger">{{ $errors->first('phone') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label">E-Mail <span
                                                    class="text-danger">*</span></label>
                                        <div class="col-md-9">
                                            <input type="email" name="email" value="{{ old('email') }}"
                                                   class="form-control form-control-success">
                                            @if ($errors->has('email'))
                                                <span class="text-danger">{{ $errors->first('email') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label">Photo </label>
                                        <div class="col-md-9">
                                            <div id="image-preview"></div>
                                            <input type="file" name="photo" id="photo"
                                                   class="form-control-file form-control-success">
                                            @if ($errors->has('photo'))
                                                <span class="text-danger">{{ $errors->first('photo') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label">Parent's Phone</label>
                                        <div class="col-md-9">
                                            <input type="text" name="parents_phone"
                                                   value="{{ old('parents_phone') }}"
                                                   class="form-control form-control-success">
                                            @if ($errors->has('parents_phone'))
                                                <span class="text-danger">{{ $errors->first('parents_phone') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label">NID No.</label>
                                        <div class="col-md-9">
                                            <input type="text" name="nid" value="{{ old('nid') }}"
                                                   class="form-control form-control-success">
                                            @if ($errors->has('nid'))
                                                <span class="text-danger">{{ $errors->first('nid') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label">Present Address <span
                                                    class="text-danger">*</span></label>
                                        <div class="col-md-9">
                                            <textarea name="present_address"
                                                      class="form-control form-control-success">{{ old('present_address') }}</textarea>
                                            @if ($errors->has('present_address'))
                                                <span class="text-danger">{{ $errors->first('present_address') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label">Permanent Address</label>
                                        <div class="col-md-9">
                                            <textarea name="permanent_address"
                                                      class="form-control form-control-success">{{ old('permanent_address') }}</textarea>
                                            @if ($errors->has('permanent_address'))
                                                <span class="text-danger">{{ $errors->first('permanent_address') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label">Mentor of Course <span
                                                    class="text-danger">*</span></label>
                                        <div class="col-md-9">
                                            <select name="course[]" id="course" multiple="multiple"
                                                    class="form-control form-control-success">
                                                @foreach($courseTypes as $ct)
                                                    <optgroup label="{{$ct->type_name}}">
                                                        @foreach ($ct->courses as $course)
                                                            <option value="{{ $course->id }}">{{ $course->title }} ({{ $course->type }})</option>
                                                        @endforeach
                                                    </optgroup>
                                                @endforeach
                                            </select>
                                            @if ($errors->has('course'))
                                                <span class="text-danger">{{ $errors->first('course') }}</span>
                                            @endif
                                            <script>document.getElementById('course_id').value = "{{  old('course') }}";</script>
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
    <script src="https://cdn.ckeditor.com/4.13.0/basic/ckeditor.js"></script>
    <script src="{{ asset('assets/vendor/select2/select2.min.js') }}"></script>
    <script>
        $('#course').select2({
            multiple: true
        });

        CKEDITOR.replace('present_address', {height: 100});
        CKEDITOR.replace('permanent_address', {height: 100});

        $(document).on('change', '#photo', function (e) {
            const file = e.target.files[0] || e.dataTransfers.files[0];
            let reader = new FileReader();
            reader.onload = function (ev) {
                let img = document.createElement('img');
                img.height = '100';
                img.width = '100';
                img.src = ev.target.result;
                img.style.marginRight = '5px';
                img.style.marginBottom = '5px';
                $('#image-preview').html(img);
            };
            reader.readAsDataURL(file);
        });
    </script>
@endpush