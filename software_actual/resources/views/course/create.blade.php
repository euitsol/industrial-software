@extends('layouts.master')

@section('title', 'Create Course - European IT Solutions Institute')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <span class="float-left">
                        <h4>Add Course</h4>
                    </span>
                    <span class="float-right">
                        <a href="{{ route('courses') }}" class="btn btn-info btn-sm">Back</a>
                    </span>
                </div>

                <div class="card-body">
                    
                    <div class="row">
                        <div class="col-md-8 offset-md-2">
                            <form action="{{ route('course.store') }}" method="POST" class="form-horizontal">
                                @csrf

                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label">Title <span class="text-danger">*</span> </label>
                                    <div class="col-md-9">
                                        <input type="text" name="title" value="{{ old('title') }}" id="title" class="form-control form-control-success">
                                        @if ($errors->has('title'))
                                            <span class="text-danger">{{ $errors->first('title') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label">Short Title <small>(For Batch)</small> <span class="text-danger">*</span> </label>
                                    <div class="col-md-9">
                                        <input type="text" name="title_short_form" value="{{ old('title_short_form') }}" id="title_short" disabled="disabled" class="form-control form-control-success">
                                        @if ($errors->has('title_short_form'))
                                            <span class="text-danger">{{ $errors->first('title_short_form') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label">Sector <span class="text-danger">*</span> </label>
                                    <div class="col-md-9">
                                        <select name="course_type" id="course_type" class="form-control form-control-success">
                                            <option selected disabled value="">Choose...</option>
                                            @foreach ($courseTypes as $courseType)
                                                <option value="{{ $courseType->id }}">{{ $courseType->type_name }}</option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('course_type'))
                                            <span class="text-danger">{{ $errors->first('course_type') }}</span>
                                        @endif
                                        <script>document.getElementById('course_type').value="{{ old('course_type') }}";</script>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label">Duration <span class="text-danger">*</span> </label>
                                    <div class="col-md-9">
                                        <select name="duration" id="duration" class="form-control form-control-success">
                                            <option selected disabled value="">Choose...</option>
                                            @for($i=1; $i <= 6; $i++)
                                                @if($i > 1)
                                                    <option value="{{$i}} Months">{{$i}} Months</option>
                                                @else
                                                    <option value="{{$i}} Month">{{$i}} Month</option>
                                                @endif
                                            @endfor
                                        </select>
                                        @if ($errors->has('duration'))
                                            <span class="text-danger">{{ $errors->first('duration') }}</span>
                                        @endif
                                        <script>document.getElementById('duration').value="{{ old('duration') }}";</script>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label">Weekly Days <span class="text-danger">*</span> </label>
                                    <div class="col-md-9">
                                        <input type="number" name="weekly_days" value="{{ old('weekly_days') }}" step="any" class="form-control form-control-success">
                                        @if ($errors->has('weekly_days'))
                                            <span class="text-danger">{{ $errors->first('weekly_days') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label">Total Class <span class="text-danger">*</span> </label>
                                    <div class="col-md-9">
                                        <input type="number" name="total_class" value="{{ old('total_class') }}" class="form-control form-control-success">
                                        @if ($errors->has('total_class'))
                                            <span class="text-danger">{{ $errors->first('total_class') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label">Class Time <span class="text-danger">*</span> </label>
                                    <div class="col-md-9">
                                        <select name="class_time" id="class_time" class="form-control form-control-success">
                                            <option selected disabled value="">Choose</option>
                                            <option value="1.00">1 Hour</option>
                                            <option value="1.30">1 Hour 30 Minutes</option>
                                            <option value="2.00">2 Hour</option>
                                            <option value="2.30">2 Hour 30 Minutes</option>
                                            <option value="3.00">3 Hour</option>
                                            <option value="3.30">3 Hour 30 Minutes</option>
                                            <option value="4.00">4 Hour</option>
                                        </select>
                                        <script>document.getElementById('class_time').value = "{{ old('class_time') }}"</script>
                                        @if ($errors->has('class_time'))
                                            <span class="text-danger">{{ $errors->first('class_time') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label">Type <span class="text-danger">*</span> </label>
                                    <div class="col-md-9">
                                        <select name="type" id="type" class="form-control form-control-success">
                                            <option selected disabled value="">Choose...</option>
                                            <option value="Professional">Professional</option>
                                            <option value="Industrial">Industrial</option>
                                        </select>
                                        @if ($errors->has('type'))
                                            <span class="text-danger">{{ $errors->first('type') }}</span>
                                        @endif
                                        <script>document.getElementById('type').value="{{ old('type') }}";</script>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label">Fee <span class="text-danger">*</span> </label>
                                    <div class="col-md-9">
                                        <input type="number" name="fee" value="{{ old('fee') }}" step="any" class="form-control form-control-success">
                                        @if ($errors->has('fee'))
                                            <span class="text-danger">{{ $errors->first('fee') }}</span>
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
@endpush