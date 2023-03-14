@extends('layouts.master')

@section('title', 'Create Batch - European IT Solutions Institute')

@push('css')
    <link rel="stylesheet" href="{{asset('assets/vendor/jquery-ui/jquery-ui.css')}}">
@endpush

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10 col-lg-12">
                <div class="card">
                    <div class="card-header">
                    <span class="float-left">
                        <h4>Add Batch</h4>
                    </span>
                        <span class="float-right">
                        <a href="{{ route('batches') }}"
                           class="btn btn-info btn-sm">Back</a>
                    </span>
                    </div>

                    <div class="card-body">

                        <div class="row">
                            <div class="col-md-8 offset-md-2">
                                <form action="{{ route('batch.store') }}" method="POST" class="form-horizontal">
                                    @csrf

                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label">Batch For</label>
                                        <div class="col-md-9">
                                            <select id="batch_for" class="form-control form-control-success">
                                                <option selected disabled hidden value="">Choose...</option>
                                                <option value="Professional">Professional</option>
                                                <option value="Industrial">Industrial</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label">Course Name</label>
                                        <div class="col-md-9">
                                            <select name="course" id="course" disabled
                                                    class="form-control form-control-success">
                                            </select>
                                            @if ($errors->has('course'))
                                                <span class="text-danger">{{ $errors->first('course') }}</span>
                                            @endif
                                            <script>document.getElementById('course').value = "{{ old('course') }}";</script>

                                            {{-- show existing batches --}}
                                            <div id="batches"></div>

                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label">Batch Name</label>
                                        <div class="col-md-9">
                                            <div class="input-group" style="display: block;">
                                                <div class="input-group-prepend">

                                                    <span class="input-group-text" id="batch_prefix"></span>

                                                    <input type="text" name="course_short_form" id="course_short_form" class="input-group-text">

                                                    <select name="year" id="year" class="input-group-text">
                                                        @foreach (array_reverse(range(2017, (date('Y') + 1))) as $date)
                                                            <option {{$date == date('Y') ? 'selected' : ''}} value="{{ $date }}">{{ $date }}</option>
                                                        @endforeach
                                                    </select>

                                                    <select name="month" id="month" class="input-group-text">
                                                        @for($i=12; $i >= 1; $i--)
                                                            <option {{(date('m') == $i) ? 'selected' : ''}} value="{{$i}}">{{$i}}</option>
                                                        @endfor
                                                    </select>

                                                    <input type="number" name="batch_number" id="batch_number"
                                                           class="input-group-text" readonly>
                                                </div>
                                            </div>
                                            @if ($errors->has('name'))
                                                <span class="text-danger">{{ $errors->first('name') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label">Date</label>
                                        <div class="col-md-9">
                                            <div class="row">
                                                <div class="col">
                                                    <input type="text" name="start_date" id="start_date" placeholder="Start"
                                                           class="form-control" autocomplete="off">
                                                    @if ($errors->has('start_date'))
                                                        <span class="text-danger">{{ $errors->first('start_date') }}</span>
                                                    @endif
                                                </div>
                                                <div class="col">
                                                    <input type="text" name="end_date" id="end_date" placeholder="End"
                                                           class="form-control" autocomplete="off">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-9 ml-auto">
                                            <input type="submit" value="Submit"
                                                   onclick="return confirm('Are you sure to create new batch?')"
                                                   class="btn btn-primary">
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
    <script src="{{asset('assets/vendor/jquery-ui/jquery-ui.js')}}"></script>
    <script>
        $("#start_date").datepicker({dateFormat: 'yy-mm-dd'});
        $("#end_date").datepicker({dateFormat: 'yy-mm-dd'});

        $(document).on('change', '#batch_for', function () {
            let batch_for = $(this).val();
            if ('' != batch_for) {
                let url = "{{route('courses.type', ['type'])}}";
                let _url = url.replace('type', batch_for);
                $.ajax({
                    url: _url,
                    method: "GET",
                    success: function (response) {
                        if ('' != response) {
                            $('#course').removeAttr('disabled');
                            let output = '<option selected disabled hidden value="">Choose...</option>' + response;
                            $('#course').html(output);
                            batch();
                        } else {
                            $('#course').prop('disabled', true);
                            $('#course').html('');
                            batch();
                        }
                    }
                });
            }
        });

        $(document).on('change', '#course, #year', function () {
            batch();
        });

        function batch() {
            let course_id = $('#course').val();
            let year = $('#year').val();

            if (course_id == null) {
                $('#course_short_form').html('');
                $('#batch_number').val('');
                $('#batches').html('');
            }

            if (('' != course_id) && (null != course_id) && ('' != year)) {
                let _url = ("{{ route('course.batch.create', ['course_id', 'year']) }}");
                let __url = _url.replace('course_id', course_id);
                let ___url = __url.replace('year', year);
                $.ajax({
                    url: ___url,
                    method: "GET",
                    success: function (response) {
                        $('#batch_prefix').html(response['batch_prefix']);
                        $('#course_short_form').val(response['course_short_form']);
                        $('#batch_number').val(response['last_batch_number']);
                        $('#batches').html(response['batches']);
                    }
                });
            }
        }

        // if ('' != course && 'Choose...' != course) {
        //     var words = course.split(/[\s,_-]+/);
        //     var wordFirstCharStr = '';
        //     for (const i in words) {
        //         wordFirstCharStr += words[i][0];
        //     }
        //     console.log(wordFirstCharStr);
        // }

    </script>
@endpush

