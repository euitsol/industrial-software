@extends('layouts.master')

@section('title', 'Create Student - European IT Solutions Institute')

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
                        <h4>Add Student</h4>
                    </div>

                    <div class="card-body">

                        @if (session('error'))
                            <p class="alert alert-danger text-center">
                                {{ session('error') }}
                            </p>
                        @endif

                        <div class="row">
                            <div class="col-md-8 offset-md-2">
                                <form action="{{ route('student.store') }}" method="POST" enctype="multipart/form-data"
                                      class="form-horizontal">
                                    @csrf

                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label">Name <span
                                                    class="text-danger">*</span> </label>
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
                                                    class="text-danger">*</span> </label>
                                        <div class="col-md-9">
                                            <input type="text" name="fathers_name" value="{{ old('fathers_name') }}"
                                                   class="form-control form-control-success" id="fathers_name">
                                            @if ($errors->has('fathers_name'))
                                                <span class="text-danger">{{ $errors->first('fathers_name') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label">Mother's Name <span
                                                    class="text-danger">*</span> </label>
                                        <div class="col-md-9">
                                            <input type="text" name="mothers_name" value="{{ old('mothers_name') }}"
                                                   class="form-control form-control-success">
                                            @if ($errors->has('mothers_name'))
                                                <span class="text-danger">{{ $errors->first('mothers_name') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label">Photo</label>
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
                                        <label class="col-md-3 form-control-label">Present Address <span
                                                    class="text-danger">*</span> </label>
                                        <div class="col-md-9">
                                            <input type="text" name="present_address"
                                                   value="{{ old('present_address') }}"
                                                   class="form-control form-control-success">
                                            @if ($errors->has('present_address'))
                                                <span class="text-danger">{{ $errors->first('present_address') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label">Permanent Address <span
                                                    class="text-danger">*</span> </label>
                                        <div class="col-md-9">
                                            <input type="text" name="permanent_address"
                                                   value="{{ old('permanent_address') }}"
                                                   class="form-control form-control-success" id="permanent_address">
                                            @if ($errors->has('permanent_address'))
                                                <span class="text-danger">{{ $errors->first('permanent_address') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label">Date of Birth <span
                                                    class="text-danger">*</span> </label>
                                        <div class="col-md-9">
                                            <input type="date" name="dob" value="{{ old('dob') }}"
                                                   class="form-control form-control-success">
                                            @if ($errors->has('dob'))
                                                <span class="text-danger">{{ $errors->first('dob') }}</span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label">Gender <span
                                                    class="text-danger">*</span> </label>
                                        <div class="col-md-9">
                                            <div class="custom-control custom-radio custom-control-inline">
                                                <input type="radio" name="gender" value="male" id="male"
                                                       {{old('gender') == 'male' ? 'checked' : ''}} class="custom-control-input">
                                                <label class="custom-control-label" for="male">Male</label>
                                            </div>
                                            <div class="custom-control custom-radio custom-control-inline">
                                                <input type="radio" name="gender" value="female" id="female"
                                                       {{old('gender') == 'female' ? 'checked' : ''}} class="custom-control-input">
                                                <label class="custom-control-label" for="female">Female</label>
                                            </div>
                                            @if ($errors->has('gender'))
                                                <br><span class="text-danger">{{ $errors->first('gender') }}</span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label">Phone <span
                                                    class="text-danger">*</span> </label>
                                        <div class="col-md-9">
                                            <input type="text" name="phone" value="{{ old('phone') }}"
                                                   class="form-control form-control-success">
                                            @if ($errors->has('phone'))
                                                <span class="text-danger">{{ $errors->first('phone') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label">Parent's Phone </label>
                                        <div class="col-md-9">
                                            <input type="text" name="parents_phone" value="{{ old('parents_phone') }}"
                                                   class="form-control form-control-success" id="parents_phone">
                                            @if ($errors->has('parents_phone'))
                                                <span class="text-danger">{{ $errors->first('parents_phone') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label">E-Mail</label>
                                        <div class="col-md-9">
                                            <input type="email" name="email" value="{{ old('email') }}"
                                                   class="form-control form-control-success">
                                            @if ($errors->has('email'))
                                                <span class="text-danger">{{ $errors->first('email') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label">Nationality </label>
                                        <div class="col-md-9">
                                            <input type="text" name="nationality" value="Bangladeshi"
                                                   class="form-control form-control-success">
                                            @if ($errors->has('nationality'))
                                                <span class="text-danger">{{ $errors->first('nationality') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label">NID</label>
                                        <div class="col-md-9">
                                            <input type="text" name="nid" value="{{ old('nid') }}"
                                                   class="form-control form-control-success">
                                            @if ($errors->has('nid'))
                                                <span class="text-danger">{{ $errors->first('nid') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label">Birth Certificate No.</label>
                                        <div class="col-md-9">
                                            <input type="text" name="birth" value="{{ old('birth') }}"
                                                   class="form-control form-control-success">
                                            @if ($errors->has('birth'))
                                                <span class="text-danger">{{ $errors->first('birth') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label">Blood Group</label>
                                        <div class="col-md-9">
                                            <input type="text" name="blood_group" value="{{ old('blood_group') }}"
                                                   class="form-control form-control-success">
                                            @if ($errors->has('blood_group'))
                                                <span class="text-danger">{{ $errors->first('blood_group') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label">Student As <span class="text-danger">*</span>
                                        </label>
                                        <div class="col-md-9">
                                            <span>Industrial</span>
                                            <input type="hidden" name="student_as" id="student_as" value="Industrial">
                                            <!--<select name="student_as" id="student_as"-->
                                            <!--        class="form-control form-control-success" required>-->
                                            <!--    <option value="Industrial" selected>Industrial</option>-->
                                            <!--</select>-->
                                            @if ($errors->has('student_as'))
                                                <span class="text-danger">{{ $errors->first('student_as') }}</span>
                                            @endif
                                            <!--<script>document.getElementById('student_as').value = "{{ old('student_as') }}";</script>-->
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="year" class="col-md-3 form-control-label">Year <span class="text-danger">*</span> </label>
                                        <div class="col-md-9">
                                            <select name="year" id="year" class="form-control form-control-success">
                                                @foreach(range(date('Y') + 1, 2017) as $date)
                                                    <option value="{{$date}}" {{ date('Y') == $date ? 'selected' : '' }}>{{$date}}</option>
                                                @endforeach
                                            </select>
                                            @if ($errors->has('year'))
                                                <span class="text-danger">{{ $errors->first('year') }}</span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group row" id="district" style="display: none;">
                                        <label class="col-md-3 form-control-label">District <span class="text-danger">*</span> </label>
                                        <div class="col-md-9">
                                            <input type="text" name="district" value="{{ old('district') }}"
                                                   class="form-control form-control-success">
                                            @if ($errors->has('district'))
                                                <span class="text-danger">{{ $errors->first('district') }}</span>
                                            @endif
                                        </div>
                                    </div>

                                    <div id="institute_wrapper" style="display: block;">
                                        <div class="form-group row">
                                            <label class="col-md-3 form-control-label">Institute <span
                                                        class="text-danger">*</span>
                                            </label>
                                            <div class="col-md-9">
                                                <select name="institute" id="institute"
                                                        class="form-control form-control-success">
                                                    <option value="">Choose...</option>
                                                    @foreach ($institutes as $institute)
                                                        <option value="{{ $institute->id }}">{{ $institute->name }}</option>
                                                    @endforeach
                                                </select>
                                                @if ($errors->has('institute'))
                                                    <span class="text-danger">{{ $errors->first('institute') }}</span>
                                                @endif
                                                <script>document.getElementById('institute').value = "{{ old('institute') }}";</script>

                                                <div class="clearfix">
                                                    <small>If institute not exist then you can add</small>
                                                    <a href="javascript:void(0)" id="new_institute" class="float-right">
                                                        + New Institute
                                                    </a>
                                                </div>
                                                <div id="new_institute_form" class="border p-2" style="display:none">
                                                    <div class="form-group">
                                                        <label class="form-control-label">Institute Name <span
                                                                    class="text-danger">*</span> </label>
                                                        <input type="text" name="institute_name"
                                                               value="{{ old('institute_name') }}"
                                                               class="form-control form-control-sm">
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-control-label">Address </label>
                                                        <input type="text" name="institute_address"
                                                               value="{{ old('institute_address') }}"
                                                               class="form-control form-control-sm">
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-control-label">District <span
                                                                    class="text-danger">*</span> </label>
                                                        <input type="text" name="institute_district"
                                                               value="{{ old('institute_district') }}"
                                                               class="form-control form-control-sm">
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-control-label">Division <span
                                                                    class="text-danger">*</span> </label>
                                                        <input type="text" name="institute_division"
                                                               value="{{ old('institute_division') }}"
                                                               class="form-control form-control-sm">
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-control-label">Website</label>
                                                        <input type="text" name="institute_website"
                                                               value="{{ old('institute_website') }}"
                                                               class="form-control form-control-sm">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-md-3 form-control-label">Shift <span class="text-danger">*</span>
                                            </label>
                                            <div class="col-md-9">
                                                <select name="shift" id="shift" class="form-control form-control-success">
                                                    <option selected disabled value="">Choose...</option>
                                                        <option value="1" @if(old('shift') != null && old('shift') == 1) selected @endif >1st Shift</option>
                                                        <option value="2" @if(old('shift') != null && old('shift') == 2) selected @endif>2nd Shift</option>
                                                        <option value="" @if(old('shift') == null || old('shift') == "") selected @endif> Other </option>
                                                </select>
                                                @if ($errors->has('shift'))
                                                    <span class="text-danger">{{ $errors->first('shift') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-md-3 form-control-label">Board Roll <span
                                                        class="text-danger">*</span>
                                            </label>
                                            <div class="col-md-9">
                                                <input type="text" name="board_roll" id="board_roll" value="{{ old('board_roll') }}"
                                                       class="form-control form-control-sm form-control-success">
                                                @if ($errors->has('board_roll'))
                                                    <span class="text-danger">{{ $errors->first('board_roll') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-md-3 form-control-label">Board Reg. <span
                                                        class="text-danger">*</span>
                                            </label>
                                            <div class="col-md-9">
                                                <input type="text" name="board_reg" id="board_reg" value="{{ old('board_reg') }}"
                                                       class="form-control form-control-sm form-control-success">
                                                @if ($errors->has('board_reg'))
                                                    <span class="text-danger">{{ $errors->first('board_reg') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label">Note</label>
                                        <div class="col-md-9">
                                            <textarea name="note" id="note"
                                                      class="form-control form-control-success">{{ old('note') }}</textarea>
                                            @if ($errors->has('note'))
                                                <span class="text-danger">{{ $errors->first('note') }}</span>
                                            @endif
                                        </div>
                                    </div>

                                    {{-- ------------------------------------------ --}}
                                    <p class="text-center bg-gray-100 border py-2">Emergency Contact</p>
                                    {{-- ------------------------------------------ --}}

                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label">Name
                                            <!-- <span class="text-danger">*</span> -->
                                        </label>
                                        <div class="col-md-9">
                                            <input type="text" name="emergency_contact_name"
                                                   value="{{ old('emergency_contact_name') }}"
                                                   class="form-control form-control-success" id="emergency_contact_name">
                                            @if ($errors->has('emergency_contact_name'))
                                                <span class="text-danger">{{ $errors->first('emergency_contact_name') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label">Address
                                            <!-- <span class="text-danger">*</span> -->
                                        </label>
                                        <div class="col-md-9">
                                            <input type="text" name="emergency_contact_address"
                                                   value="{{ old('emergency_contact_address') }}"
                                                   class="form-control form-control-success" id="emergency_contact_address">
                                            @if ($errors->has('emergency_contact_address'))
                                                <span class="text-danger">{{ $errors->first('emergency_contact_address') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label">Relation
                                            <!--<span class="text-danger">*</span> -->
                                        </label>
                                        <div class="col-md-9">
                                            <input type="text" name="emergency_contact_relation"
                                                   value="Father"
                                                   class="form-control form-control-success" id="emergency_contact_relation">
                                            @if ($errors->has('emergency_contact_relation'))
                                                <span class="text-danger">{{ $errors->first('emergency_contact_relation') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label">Phone
                                            <!--  <span class="text-danger">*</span> -->
                                        </label>
                                        <div class="col-md-9">
                                            <input type="text" name="emergency_contact_phone"
                                                   value="{{ old('emergency_contact_phone') }}"
                                                   class="form-control form-control-success" id="emergency_contact_phone">
                                            @if ($errors->has('emergency_contact_phone'))
                                                <span class="text-danger">{{ $errors->first('emergency_contact_phone') }}</span>
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
        $("#new_institute").click(function () {
            $("#new_institute_form").toggle(500);
        });

        let student_as = '{{old('student_as')}}';
        if (student_as === 'Industrial') {
            $('#institute_wrapper').show();
        } else if (student_as === 'Professional') {
            $('#district').show();
        }

        $(document).on('change', '#student_as', function () {
            if ('Industrial' === $(this).val()) {
                $('#institute_wrapper').show();
                $('#district').hide();
            } else if ('Professional' === $(this).val()) {
                $('#district').show();
                $("#select2-institute-container").text('');
                $('#board_roll').val('');
                $('#board_reg').val('');
                $('#institute_wrapper').hide();
            }  else {
                $('#institute_wrapper').hide();
                $('#district').hide();
            }
        });

        function isEmpty(str) {
            return (!str || 0 === str.length);
        }

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
        
        $(document).on('change', '#fathers_name', function (e) { 
            $('#emergency_contact_name').val($(this).val());
        });
        $(document).on('change', '#permanent_address', function (e) { 
            $('#emergency_contact_address').val($(this).val());
        });
        $(document).on('change', '#parents_phone', function (e) { 
            $('#emergency_contact_phone').val($(this).val());
        });
    </script>
@endpush
