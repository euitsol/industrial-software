@extends('layouts.master')

@section('title', 'Create Mentor - European IT Solutions Institute')

@push('css')

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
                                <p class="font-weight-bold">Academic Qualification</p>
                                <form action="{{ route('mentor.academic-q-store.store') }}" method="POST"
                                             enctype="multipart/form-data"
                                             class="form-horizontal">
                                    @csrf

                                    <input type="hidden" name="mid" value="{{$mentor->id}}">

                                    <div id="block-wrapper">

                                        @if (old('exam_title'))
                                            @for ($i = 0; $i < count(old('exam_title')); $i++)
                                                <div class="shadow-sm border px-3 pt-3 block mb-2">

                                                    @if ($i !== 0)
                                                        <div class="btn-close"><i class="fa fa-times"></i></div>
                                                    @endif

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
                                                        <label class="col-md-3 form-control-label">Institute</label>
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
                                                        <label class="col-md-3 form-control-label">Passing Year <span
                                                                    class="text-danger">*</span></label>
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
                                                        <label class="col-md-3 form-control-label">Duration <span
                                                                    class="text-danger">*</span></label>
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
                                        @else
                                            <div class="shadow-sm border px-3 pt-3 block mb-2">

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
                                                    <label class="col-md-3 form-control-label">Institute</label>
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
                                                    <label class="col-md-3 form-control-label">Passing Year <span
                                                                class="text-danger">*</span></label>
                                                    <div class="col-md-9">
                                                        <input type="text" name="passing_year[]" value=""
                                                               class="form-control form-control-success">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-md-3 form-control-label">Duration <span
                                                                class="text-danger">*</span></label>
                                                    <div class="col-md-9">
                                                        <input type="text" name="duration[]" value=""
                                                               class="form-control form-control-success">
                                                    </div>
                                                </div>
                                            </div>
                                        @endif

                                    </div>

                                    <p class="">
                                        <input type="submit" value="Submit" class="btn btn-primary">
                                        <button type="button" id="add-block"
                                                class="btn btn-outline-dark btn-sm float-right">
                                            <i class="fa fa-plus-square"></i> Add Another Education
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
    <script src="https://cdn.ckeditor.com/4.13.0/basic/ckeditor.js"></script>
    <script>
        $(document).on('click', '#add-block', function () {
            let block = `
            <div class="shadow-sm border px-3 pt-3 block mb-2">

                <div class="btn-close"><i class="fa fa-times"></i></div>

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
                    <label class="col-md-3 form-control-label">Institute</label>
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
                    <label class="col-md-3 form-control-label">Passing Year <span
                                class="text-danger">*</span></label>
                    <div class="col-md-9">
                        <input type="text" name="passing_year[]" value=""
                               class="form-control form-control-success">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-3 form-control-label">Duration <span
                                class="text-danger">*</span></label>
                    <div class="col-md-9">
                        <input type="text" name="duration[]" value=""
                               class="form-control form-control-success">
                    </div>
                </div>
            </div>
            `;
            $($('#block-wrapper')).append(block);
        });

        $(document).on('click', '.btn-close', function () {
            $(this).closest('.block').remove();
        });
    </script>
@endpush