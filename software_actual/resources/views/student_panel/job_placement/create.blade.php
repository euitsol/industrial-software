@extends('student_panel.layouts.master')

@section('title', 'Create Job Placement - European IT Solutions Institute')

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
                    <span class="float-left">
                        <h4>Add Job Placement</h4>
                    </span>
                    <span class="float-right">
                        <a href="{{ route('student.job_placement.info',$student_id) }}" class="btn btn-info btn-sm">Back</a>
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
                    
                    <div class="row">
                        <div class="col-md-8 offset-md-2">
                            <form action="{{ route('student.job_placement.store') }}" method="POST" class="form-horizontal" enctype="multipart/form-data">
                                @csrf

                                <input type="hidden" name="student_id" value="{{ $student_id }}">



                                <div id="company_wrapper">
                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label">Company Name <span class="text-danger">*</span> </label>
                                        <div class="col-md-9">
                                            <select name="linkage_industry_info_id" id="company" class="form-control form-control-success">
                                                <option selected value="">Choose...</option>
                                                @foreach ($linkage_industries as $linkage_industry)
                                                    <option value="{{ $linkage_industry->id }}">{{ $linkage_industry->company_name }}</option>
                                                @endforeach
                                            </select>
                                            @if ($errors->has('linkage_industry_info_id'))
                                                <span class="text-danger">{{ $errors->first('linkage_industry_info_id') }}</span>
                                            @endif
                                            <div class="clearfix">
                                                <small>If company not exist then you can add</small>
                                                <a href="javascript:void(0)" id="new_company" class="float-right">
                                                    + New Company
                                                </a>
                                            </div>
                                            <div id="new_company_form" class="border p-2" style="display:none">
                                                <div class="form-group">
                                                    <label class="form-control-label">Company Name <span
                                                                class="text-danger">*</span> </label>
                                                    <input type="text" name="company_name"
                                                        value="{{ old('company_name') }}"
                                                        class="form-control form-control-sm">
                                                    @if ($errors->has('company_name'))
                                                        <span class="text-danger">{{ $errors->first('company_name') }}</span>
                                                    @endif
                                                </div>
                                                
                                                <div class="form-group">
                                                    <label class="form-control-label">Company Logo <span
                                                        class="text-danger">*</span></label>
                                                    <div id="image-preview"></div>
                                                    <input type="file" name="company_logo" id="photo"
                                                        value="{{ old('company_logo') }}"
                                                        class="form-control form-control-sm">
                                                    @if ($errors->has('company_logo'))
                                                        <span class="text-danger">{{ $errors->first('company_logo') }}</span>
                                                    @endif
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-control-label">Company Website URL <span
                                                                class="text-danger">*</span> </label>
                                                    <input type="text" name="company_website" value="{{ old('company_website') }}"
                                                        class="form-control form-control-sm">
                                                    @if ($errors->has('company_website'))
                                                        <span class="text-danger">{{ $errors->first('company_website') }}</span>
                                                    @endif
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-control-label">Company Address <span class="text-danger">*</span> </label>
                                                    <input type="text" name="company_address" value="{{ old('company_address') }}"
                                                        class="form-control form-control-sm">
                                                    @if ($errors->has('company_address'))
                                                        <span class="text-danger">{{ $errors->first('company_address') }}</span>
                                                    @endif
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-control-label">Contact Person Name <span class="text-danger">*</span></label>
                                                    <input type="text" name="contact_person_name" value="{{ old('contact_person_name') }}"
                                                        class="form-control form-control-sm">
                                                    @if ($errors->has('contact_person_name'))
                                                        <span class="text-danger">{{ $errors->first('contact_person_name') }}</span>
                                                    @endif
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-control-label">Contact Number <span class="text-danger">*</span></label>
                                                    <input type="number" name="contact_number" value="{{ old('contact_number') }}"
                                                        class="form-control form-control-sm">
                                                    @if ($errors->has('contact_number'))
                                                        <span class="text-danger">{{ $errors->first('contact_number') }}</span>
                                                    @endif
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-control-label">Contact Email <span class="text-danger">*</span></label>
                                                    <input type="email" name="contact_email" value="{{ old('contact_email') }}"
                                                        class="form-control form-control-sm">
                                                    @if ($errors->has('contact_email'))
                                                        <span class="text-danger">{{ $errors->first('contact_email') }}</span>
                                                    @endif
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-control-label">Short Description <span class="text-danger">*</span></label>
                                                    <textarea name="description" id="description"
                                                    class="form-control form-control-sm">{{ old('description') }}</textarea>
                                                    @if ($errors->has('description'))
                                                        <span class="text-danger">{{ $errors->first('description') }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label">Designation <span class="text-danger">*</span> </label>
                                    <div class="col-md-9">
                                        <input type="text" name="designation" value="{{ old('designation') }}" id="designation" class="form-control form-control-success">
                                        @if ($errors->has('designation'))
                                            <span class="text-danger">{{ $errors->first('designation') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label">Department</label>
                                    <div class="col-md-9">
                                        <input type="text" name="department" value="{{ old('department') }}" id="department" class="form-control form-control-success">
                                        @if ($errors->has('department'))
                                            <span class="text-danger">{{ $errors->first('department') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label">Joining Date <span class="text-danger">*</span></label>
                                    <div class="col-md-9">
                                        <input type="date" name="joining_date" value="{{ old('joining_date') }}" id="joining_date" class="form-control form-control-success">
                                        @if ($errors->has('joining_date'))
                                            <span class="text-danger">{{ $errors->first('joining_date') }}</span>
                                        @endif
                                    </div>
                                </div>
                                {{-- <div class="form-group row">
                                    <label class="col-md-3 form-control-label">Website URL</label>
                                    <div class="col-md-9">
                                        <input type="text" name="company_web_url" value="{{ old('company_web_url') }}" id="company_web_url" class="form-control form-control-success">
                                        @if ($errors->has('company_web_url'))
                                            <span class="text-danger">{{ $errors->first('company_web_url') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label">Company Address <span class="text-danger">*</span></label>
                                    <div class="col-md-9">
                                        <input type="text" name="company_address" value="{{ old('company_address') }}" id="company_address" class="form-control form-control-success" required>
                                        @if ($errors->has('company_address'))
                                            <span class="text-danger">{{ $errors->first('company_address') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label">Contact Number</label>
                                    <div class="col-md-9">
                                        <input type="number" name="company_phone" value="{{ old('company_phone') }}" id="company_phone" class="form-control form-control-success">
                                        @if ($errors->has('company_phone'))
                                            <span class="text-danger">{{ $errors->first('company_phone') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label">Contact Email</label>
                                    <div class="col-md-9">
                                        <input type="email" name="company_email" value="{{ old('company_email') }}" id="company_email" class="form-control form-control-success">
                                        @if ($errors->has('company_email'))
                                            <span class="text-danger">{{ $errors->first('company_email') }}</span>
                                        @endif
                                    </div>
                                </div> --}}
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
    <script>

        title_short_form();

        $(document).on('keyup change focusout', '#title', function () {
            title_short_form();
        });

        function title_short_form() {
            let title = $('#title');
            let title_short = $('#title_short');
            if ('' !== title.val()) {
                let split_title = title.val().split(/[\s,_&-]+/);
                let wordFirstCharStr = '';
                for (const i in split_title) {
                    wordFirstCharStr += split_title[i][0];
                }
                title_short.val(wordFirstCharStr);
                title_short.prop('disabled', false);
            } else {
                title_short.val('');
                title_short.prop('disabled', true);
            }
        }
    </script>
    <script>
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
    <script>
        $("#company").select2();
        $("#new_company").click(function () {
            $("#new_company_form").toggle(500);
        });
    </script>
@endpush