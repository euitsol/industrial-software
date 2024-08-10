@extends('layouts.web')

@section('title', 'Registration - European IT Solutions Institute')

@push('css')    
<link rel="stylesheet" href="{{ asset('assets/vendor/select2/select2.min.css') }}">
<style>
    .select2 {
        width: 100% !important;
    }
    .container .card h4{
        color: hsl(207deg 37% 37%);
        font-family: "Teko", Sans-serif;
        font-size: 35px;
        font-weight: 600;
    }
    .container .card .row label{
        color: hsl(207deg 37% 37%);
        font-family: "Teko", Sans-serif;
        font-size: 20px;
        font-weight: 400;
    }


</style>
 
@endpush


@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Online Registration Form - European IT Institute</h4>
                    </div>

                    <div class="card-body">

                        @if (session('error'))
                            <p class="alert alert-danger text-center">
                                {{ session('error') }}
                            </p>
                        @endif 
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="row">
                            <div class="col-md-8 offset-md-2">
                                <form action="{{ route('pre.reg.store') }}" method="POST" enctype="multipart/form-data"
                                      class="form-horizontal">
                                    @csrf

                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label">Name <span
                                                    class="text-danger">*</span> </label>
                                        <div class="col-md-9">
                                            <input type="text" name="name" value="{{ old('name') }}"
                                                   class="form-control form-control-success" required>
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
                                                   class="form-control form-control-success" required>
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
                                                   class="form-control form-control-success" required>
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
                                                   class="form-control form-control-success" id="permanent_address" required>
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
                                                   class="form-control form-control-success" required>
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
                                                   class="form-control form-control-success" required>
                                            @if ($errors->has('phone'))
                                                <span class="text-danger">{{ $errors->first('phone') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label">Parent's Phone </label>
                                        <div class="col-md-9">
                                            <input type="number" name="parents_phone" value="{{ old('parents_phone') }}" id="parents_phone"
                                                   class="form-control form-control-success">
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
                                            <input type="text" name="nationality" value="{{ old('nationality') }}"
                                                   class="form-control form-control-success">
                                            @if ($errors->has('nationality'))
                                                <span class="text-danger">{{ $errors->first('nationality') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label">NID/Birth Certificate No.  <span
                                                    class="text-danger">*</span></label>
                                        <div class="col-md-9">
                                            <input type="text" name="nid" value="{{ old('nid') }}"
                                                   class="form-control form-control-success" required>
                                            @if ($errors->has('nid'))
                                                <span class="text-danger">{{ $errors->first('nid') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <!--<div class="form-group row">-->
                                    <!--    <label class="col-md-3 form-control-label">Birth Certificate No. <span-->
                                    <!--                class="text-danger">*</span></label>-->
                                    <!--    <div class="col-md-9">-->
                                    <!--        <input type="text" name="birth" value="{{ old('birth') }}"-->
                                    <!--               class="form-control form-control-success" required>-->
                                    <!--        @if ($errors->has('birth'))-->
                                    <!--            <span class="text-danger">{{ $errors->first('birth') }}</span>-->
                                    <!--        @endif-->
                                    <!--    </div>-->
                                    <!--</div>-->
                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label">Blood Group</label>
                                        <div class="col-md-9">

                                            <select name="blood_group" id="blood_group" class="form-control form-control-success">
                                                    <option value="A+" @if(old('blood_group') != null && old('blood_group') == "A+") selected @endif>A+</option>
                                                    <option value="A-" @if(old('blood_group') != null && old('blood_group') == "A-") selected @endif>A-</option>
                                                    <option value="B+" @if(old('blood_group') != null && old('blood_group') == "B+") selected @endif>B+</option>
                                                    <option value="B-" @if(old('blood_group') != null && old('blood_group') == "B-") selected @endif>B-</option>
                                                    <option value="AB+" @if(old('blood_group') != null && old('blood_group') == "AB+") selected @endif>AB+</option>
                                                    <option value="AB-" @if(old('blood_group') != null && old('blood_group') == "AB-") selected @endif>AB-</option>
                                                    <option value="O+" @if(old('blood_group') != null && old('blood_group') == "O+") selected @endif>O+</option>
                                                    <option value="O-" @if(old('blood_group') != null && old('blood_group') == "O-") selected @endif>O-</option>
                                            </select>
                                            @if ($errors->has('blood_group'))
                                                <span class="text-danger">{{ $errors->first('blood_group') }}</span>
                                            @endif

                                        </div>
                                    </div>
                                    
                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label">Student As <span class="text-danger">*</span>
                                        </label>
                                        <div class="col-md-9">
                                            <input type="text" name="student_as" id="student_as" value="Industrial" class="form-control" readonly>
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
                                            <select name="year" id="year" class="form-control form-control-success" disabled="disabled">
                                                @foreach(range(date('Y') + 1, 2017) as $date)
                                                    <option value="{{$date}}" {{ date('Y') == $date ? 'selected' : '' }}>{{$date}}</option>
                                                @endforeach
                                            </select>
                                            @if ($errors->has('year'))
                                                <span class="text-danger">{{ $errors->first('year') }}</span>
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
                                            <div class = "">
                                            <input type="submit" value="Continue" class=" submit_btn btn btn-primary" style="width: 100%;font-size: 20px;">
                                            </div>
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
    </script>
    <script>
            $("#institute").select2();    
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
