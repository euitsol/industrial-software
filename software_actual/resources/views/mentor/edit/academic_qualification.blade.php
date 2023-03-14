@extends('layouts.master')

@section('title', 'Create Mentor - European IT Solutions Institute')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10 col-lg-12">
                <div class="card">
                    <div class="card-header">
                    <span class="float-left">
                        <h4>Edit Mentor</h4>
                    </span>
                        <span class="float-right">
                        <a href="{{ route('mentor.show', $mentor->id) }}" class="btn btn-info btn-sm">Show</a>
                        <a href="{{ route('mentors') }}" class="btn btn-info btn-sm">Back</a>
                    </span>
                    </div>

                    <div class="card-body">

                        @include('partial.mentor_edit_nav')

                        <div class="row">
                            <div class="col-md-8 offset-md-2">

                                <p class="font-weight-bold">Academic Qualification</p>

                                @if(session('success'))
                                    <p class="alert alert-success text-center">
                                        {{ session('success') }}
                                    </p>
                                @elseif(session('error'))
                                    <p class="alert alert-danger text-center">
                                        {{ session('error') }}
                                    </p>
                                @endif

                                @if ($mentor->educations->count() > 0)
                                    @foreach ($mentor->educations as $edu)

                                        <div class="shadow-sm border px-3 pt-3 block mb-2 old">

                                            <form action="{{ route('mentor.academic-qualification.update') }}"
                                                  method="POST" class="form-horizontal">
                                                @csrf

                                                <a href="{{route('mentor.academic-qualification.delete', $edu->id)}}"
                                                   class="btn-close"
                                                   onclick="return confirm('Are you sure?')"><i class="fa fa-times"></i></a>

                                                <input type="hidden" name="a_q_id" value="{{$edu->id}}">

                                                <div class="form-group row">
                                                    <label class="col-md-3 form-control-label">Exam Title <span
                                                                class="text-danger">*</span></label>
                                                    <div class="col-md-9">
                                                        <input type="text" name="exam_title"
                                                               value="{{$edu->exam_title}}"
                                                               class="form-control form-control-success">
                                                        @if ($errors->has('exam_title'))
                                                            <span class="text-danger">{{ error_clean($errors->first('exam_title')) }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-md-3 form-control-label">Major <span
                                                                class="text-danger">*</span></label>
                                                    <div class="col-md-9">
                                                        <input type="text" name="major"
                                                               value="{{$edu->major}}"
                                                               class="form-control form-control-success">
                                                        @if ($errors->has('major'))
                                                            <span class="text-danger">{{ error_clean($errors->first('major')) }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-md-3 form-control-label">Institute <span
                                                                class="text-danger">*</span></label>
                                                    <div class="col-md-9">
                                                        <input type="text" name="institute"
                                                               value="{{$edu->institute}}"
                                                               class="form-control form-control-success">
                                                        @if ($errors->has('institute'))
                                                            <span class="text-danger">{{ error_clean($errors->first('institute')) }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-md-3 form-control-label">Result</label>
                                                    <div class="col-md-9">
                                                        <input type="text" name="result"
                                                               value="{{$edu->result}}"
                                                               class="form-control form-control-success">
                                                        @if ($errors->has('result'))
                                                            <span class="text-danger">{{ error_clean($errors->first('result')) }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-md-3 form-control-label">Passing Year</label>
                                                    <div class="col-md-9">
                                                        <input type="text" name="passing_year"
                                                               value="{{$edu->passing_year}}"
                                                               class="form-control form-control-success">
                                                        @if ($errors->has('passing_year'))
                                                            <span class="text-danger">{{ error_clean($errors->first('passing_year')) }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-md-3 form-control-label">Duration</label>
                                                    <div class="col-md-9">
                                                        <input type="text" name="duration"
                                                               value="{{$edu->duration}}"
                                                               class="form-control form-control-success">
                                                        @if ($errors->has('duration'))
                                                            <span class="text-danger">{{ error_clean($errors->first('duration')) }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-md-3"></div>
                                                    <div class="col-md-9">
                                                        <input type="submit" value="Update" class="btn btn-info">
                                                    </div>
                                                </div>

                                            </form>

                                        </div>

                                    @endforeach

                                @endif

                                <form action="{{ route('mentor.academic-q-store.store') }}" method="POST"
                                      class="form-horizontal">
                                    @csrf

                                    <input type="hidden" name="mid" value="{{$mentor->id}}">
                                    <input type="hidden" name="_mode" value="edit">

                                    <div id="block-wrapper">

                                        @if (old('exam_title'))
                                            @for ($i = 0; $i < count(old('exam_title')); $i++)
                                                <div class="shadow-sm border px-3 pt-3 block mb-2">

                                                    <div class="btn-close btn-close-new"><i class="fa fa-times"></i>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label class="col-md-3 form-control-label">Exam Title <span
                                                                    class="text-danger">*</span></label>
                                                        <div class="col-md-9">
                                                            <input type="text" name="exam_title[]"
                                                                   value="{{old('exam_title.'.$i)}}"
                                                                   class="form-control form-control-success">
                                                            @if ($errors->has('exam_title.'.$i))
                                                                <span class="text-danger">{{ error_clean($errors->first('exam_title.'.$i)) }}</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-md-3 form-control-label">Major <span
                                                                    class="text-danger">*</span></label>
                                                        <div class="col-md-9">
                                                            <input type="text" name="major[]"
                                                                   value="{{old('major.'.$i)}}"
                                                                   class="form-control form-control-success">
                                                            @if ($errors->has('major.'.$i))
                                                                <span class="text-danger">{{ error_clean($errors->first('major.'.$i)) }}</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-md-3 form-control-label">Institute <span
                                                                    class="text-danger">*</span></label>
                                                        <div class="col-md-9">
                                                            <input type="text" name="institute[]"
                                                                   value="{{old('institute.'.$i)}}"
                                                                   class="form-control form-control-success">
                                                            @if ($errors->has('institute.'.$i))
                                                                <span class="text-danger">{{ error_clean($errors->first('institute.'.$i)) }}</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-md-3 form-control-label">Result</label>
                                                        <div class="col-md-9">
                                                            <input type="text" name="result[]"
                                                                   value="{{old('result.'.$i)}}"
                                                                   class="form-control form-control-success">
                                                            @if ($errors->has('result.'.$i))
                                                                <span class="text-danger">{{ error_clean($errors->first('result.'.$i)) }}</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-md-3 form-control-label">Passing Year</label>
                                                        <div class="col-md-9">
                                                            <input type="text" name="passing_year[]"
                                                                   value="{{old('passing_year.'.$i)}}"
                                                                   class="form-control form-control-success">
                                                            @if ($errors->has('passing_year.'.$i))
                                                                <span class="text-danger">{{ error_clean($errors->first('passing_year.'.$i)) }}</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-md-3 form-control-label">Duration</label>
                                                        <div class="col-md-9">
                                                            <input type="text" name="duration[]"
                                                                   value="{{old('duration.'.$i)}}"
                                                                   class="form-control form-control-success">
                                                            @if ($errors->has('duration.'.$i))
                                                                <span class="text-danger">{{ error_clean($errors->first('duration.'.$i)) }}</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            @endfor

                                        @endif

                                    </div>

                                    <p>
                                        <input type="submit" value="Submit" id="submit-btn" style="display: none;"
                                               class="btn btn-primary">
                                        <button type="button" id="add-block"
                                                class="btn btn-outline-dark btn-sm float-right">
                                            <i class="fa fa-plus-square"></i> Add <span id="changeable">Another</span>
                                            Education
                                        </button>
                                    </p>

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
    <script>
        if ($('#block-wrapper').children('.block').length > 0) {
            $('#submit-btn').show();
        } else {
            $('#submit-btn').hide();
        }

        $(document).on('click', '#add-block', function () {
            let block = `
            <div class="shadow-sm border px-3 pt-3 block mb-2">

                <div class="btn-close btn-close-new"><i class="fa fa-times"></i></div>

                <div class="form-group row">
                    <label class="col-md-3 form-control-label">Exam Title <span
                                class="text-danger">*</span></label>
                    <div class="col-md-9">
                        <input type="text" name="exam_title[]" value=""
                               class="form-control form-control-success">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-3 form-control-label">Major <span
                                class="text-danger">*</span></label>
                    <div class="col-md-9">
                        <input type="text" name="major[]" value=""
                               class="form-control form-control-success">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-3 form-control-label">Institute <span
                                class="text-danger">*</span></label>
                    <div class="col-md-9">
                        <input type="text" name="institute[]" value=""
                               class="form-control form-control-success">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-3 form-control-label">Result</label>
                    <div class="col-md-9">
                        <input type="text" name="result[]" value=""
                               class="form-control form-control-success">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-3 form-control-label">Passing Year</label>
                    <div class="col-md-9">
                        <input type="text" name="passing_year[]" value=""
                               class="form-control form-control-success">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-3 form-control-label">Duration</label>
                    <div class="col-md-9">
                        <input type="text" name="duration[]" value=""
                               class="form-control form-control-success">
                    </div>
                </div>
            </div>
            `;
            $($('#block-wrapper')).append(block);
            if ($('#block-wrapper').children('.block').length > 0) {
                $('#submit-btn').show();
                $('#changeable').text('Another');
            }
        });

        $(document).on('click', '.btn-close-new', function () {
            $(this).closest('.block').remove();
            if ($('#block-wrapper').children('.block').length < 1) {
                $('#submit-btn').hide();
                $('#changeable').text('New');
            }
        });

        if ($('.old').length === 0) {
            $('#changeable').text('New');
        }

        $('#edit-mentor a').filter(function () {
            return this.href === location.href;
        }).addClass('text-light').closest("div").addClass('bg-primary');
    </script>
@endpush