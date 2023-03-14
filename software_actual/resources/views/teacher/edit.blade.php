@extends('layouts.master')

@section('title', 'Edit Teacher - European IT Solutions Institute')

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
                        <h4>Edit Teacher</h4>
                    </span>
                    <span class="float-right">
                        <a href="{{ route('teacher.show', $teacher->id) }}" class="btn btn-info btn-sm">Back</a>
                    </span>
                </div>

                <div class="card-body">
                    
                    <div class="row">
                        <div class="col-md-8 offset-md-2">
                            <form action="{{ route('teacher.update') }}" method="POST" enctype="multipart/form-data" class="form-horizontal">
                                @csrf

                                <input type="hidden" name="id" value="{{ $teacher->id }}">

                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label">Teacher Name <span class="text-danger">*</span> </label>
                                    <div class="col-md-9">
                                        <input type="text" name="name" value="{{ $teacher->name }}" class="form-control form-control-success">
                                        @if ($errors->has('name'))
                                            <span class="text-danger">{{ $errors->first('name') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label">Photo</label>
                                    <div class="col-md-9">
                                        @if (!empty($teacher->photo) && file_exists($teacher->photo))
                                            <span id="old_image">
                                                <img src="{{ asset($teacher->photo) }}" class="mb-1" width="80" alt="Photo">
                                            </span>
                                        @endif
                                        <div id="image-preview"></div>
                                        <input type="file" name="photo" id="photo" class="form-control-file form-control-success">
                                        @if ($errors->has('photo'))
                                            <span class="text-danger">{{ $errors->first('photo') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label">Designation <span class="text-danger">*</span> </label>
                                    <div class="col-md-9">
                                        <input type="text" name="designation" value="{{ $teacher->designation }}" class="form-control form-control-success">
                                        @if ($errors->has('designation'))
                                            <span class="text-danger">{{ $errors->first('designation') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label">Institute <span class="text-danger">*</span> </label>
                                    <div class="col-md-9">
                                        <select name="institute" id="institute" class="form-control form-control-success">
                                            <option value="">Choose...</option>
                                            @foreach ($institutes as $institute)
                                                <option value="{{ $institute->id }}">{{ $institute->name }}</option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('institute'))
                                            <span class="text-danger">{{ $errors->first('institute') }}</span>
                                        @endif
                                        <script>document.getElementById('institute').value="{{ $teacher->institute_id }}";</script>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label">Phone <span class="text-danger">*</span> </label>
                                    <div class="col-md-9" id="teacher_phone">
                                        @if (count($teacher->phones) > 0)

                                            @foreach ($teacher->phones as $pk => $phone)
                                                @if ($loop->first)
                                                    <div class="dynamic-input">
                                                        <div class="input-group mb-1">
                                                            <input type="text" name="phone[]" value="{{ $phone->phone }}" class="form-control form-control-success">
                                                            <div class="input-group-append">
                                                                <button class="btn btn-outline-success btn-sm" type="button" id="add_phone"><i class="fa fa-plus"></i></button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @else
                                                    <div class="dynamic-input">
                                                        <div class="input-group mb-1">
                                                            <input type="text" name="phone[]" value="{{ $phone->phone }}" class="form-control form-control-success">
                                                            <div class="input-group-append">
                                                                <button class="btn btn-outline-danger btn-sm remove-input" type="button">
                                                                    <i class="fa fa-minus"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                            @endforeach
                                        @else
                                            <div class="dynamic-input">
                                                <div class="input-group mb-1">
                                                    <input type="text" name="phone[]" class="form-control form-control-success">
                                                    <div class="input-group-append">
                                                        <button class="btn btn-outline-success btn-sm" type="button" id="add_phone"><i class="fa fa-plus"></i></button>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label">E-Mail</label>
                                    <div class="col-md-9" id="teacher_email">
                                        @if (count($teacher->emails) > 0)
                                            @foreach ($teacher->emails as $email)
                                                @if ($loop->first)
                                                    <div class="dynamic-input">
                                                        <div class="input-group mb-1">
                                                            <input type="text" name="email[]" value="{{ $email->email }}" class="form-control form-control-success">
                                                            <div class="input-group-append">
                                                                <button class="btn btn-outline-success btn-sm" type="button" id="add_email"><i class="fa fa-plus"></i></button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @else
                                                    <div class="dynamic-input">
                                                        <div class="input-group mb-1">
                                                            <input type="text" name="email[]" value="{{ $email->email }}" class="form-control form-control-success">
                                                            <div class="input-group-append">
                                                                <button class="btn btn-outline-danger btn-sm remove-input" type="button">
                                                                    <i class="fa fa-minus"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                            @endforeach
                                        @else
                                            <div class="dynamic-input">
                                                <div class="input-group mb-1">
                                                    <input type="text" name="email[]" class="form-control form-control-success">
                                                    <div class="input-group-append">
                                                        <button class="btn btn-outline-success btn-sm" type="button" id="add_email"><i class="fa fa-plus"></i></button>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label">Short Bio</label>
                                    <div class="col-md-9">
                                        <textarea name="short_bio" id="" class="form-control form-control-success">{{ $teacher->biography }}</textarea>
                                        @if ($errors->has('short_bio'))
                                            <span class="text-danger">{{ $errors->first('short_bio') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label">Present Address</label>
                                    <div class="col-md-9">
                                        <textarea name="present_address" id="" class="form-control form-control-success">{{ $teacher->present_address }}</textarea>
                                        @if ($errors->has('present_address'))
                                            <span class="text-danger">{{ $errors->first('present_address') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label">Permanent Address</label>
                                    <div class="col-md-9">
                                        <textarea name="permanent_address" id="" class="form-control form-control-success">{{ $teacher->permanent_address }}</textarea>
                                        @if ($errors->has('permanent_address'))
                                            <span class="text-danger">{{ $errors->first('permanent_address') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label">Comment</label>
                                    <div class="col-md-9">
                                        <textarea name="comments" id="" class="form-control form-control-success">{{ $teacher->comments }}</textarea>
                                        @if ($errors->has('comments'))
                                            <span class="text-danger">{{ $errors->first('comments') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-9 ml-auto">
                                        <input type="submit" value="Update" class="btn btn-primary">
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
    <script src="https://cdn.ckeditor.com/4.13.0/basic/ckeditor.js"></script>

    <script type="text/javascript">
        $("#institute").select2();
    </script>

    <script>
        $(document).on('click', '#add_phone', function () {
            var input = `
                <div class="dynamic-input">
                    <div class="input-group mb-1">
                        <input type="text" name="phone[]" class="form-control form-control-success">
                        <div class="input-group-append">
                            <button class="btn btn-outline-danger btn-sm remove-input" type="button">
                                <i class="fa fa-minus"></i>
                            </button>
                        </div>
                    </div>
                </div>
            `;
            $('#teacher_phone').append(input);
        });

        $(document).on('click', '#add_email', function () {
            var input = `
                <div class="dynamic-input">
                    <div class="input-group mb-1">
                        <input type="text" name="email[]" class="form-control form-control-success">
                        <div class="input-group-append">
                            <button class="btn btn-outline-danger btn-sm remove-input" type="button">
                                <i class="fa fa-minus"></i>
                            </button>
                        </div>
                    </div>
                </div>
            `;
            $('#teacher_email').append(input);
        });

        $(document).on('click', '.remove-input', function (f) {
            $(f.target).closest('.dynamic-input').remove();
        });

        CKEDITOR.replace('short_bio', {height: 100});
        CKEDITOR.replace('present_address', {height: 100});
        CKEDITOR.replace('permanent_address', {height: 100});
        CKEDITOR.replace('comments', {height: 100});

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
                $('#old_image').remove();
                $('#image-preview').html(img);
            };
            reader.readAsDataURL(file);
        });
    </script>
@endpush