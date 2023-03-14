@extends('layouts.master')

@section('title', 'Account - European IT Solutions Institute')

{{--@push('css')--}}
{{--    <link rel="stylesheet" href="{{ asset('assets/vendor/select2/select2.min.css') }}">--}}
{{--@endpush--}}

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10 col-lg-12">
                <div class="card">
                    <div class="card-header">
                    <span class="float-left">
                        <h4>Change Course / batch of {{$student->name}}</h4>
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
                                <form action="{{ route('change.course', ['sid' => $student->id, 'cid' => $cid, 'bid' => $bid]) }}" method="POST"
                                      class="form-horizontal">
                                    @csrf

                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label">Course</label>
                                        <div class="col-md-9">
                                            <select name="course" id="course" class="form-control form-control-success"
                                                    required>
                                                <option selected hidden value="{{$course->id}}">{{$course->title}}</option>
                                                @foreach ($courses as $c)
                                                    <option value="{{ $c->id }}">{{ $c->title }}</option>
                                                @endforeach
                                            </select>
                                            @if ($errors->has('course'))
                                                <span class="text-danger">{{ $errors->first('course') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label">Batch</label>
                                        <div class="col-md-9">
                                            <select name="batch" id="batch" class="form-control form-control-success"
                                                    required>
                                                <option selected hidden value="{{$batch->id}}">
                                                    {{batch_name($batch->course->title_short_form, $batch->year, $batch->month, $batch->batch_number)}}
                                                </option>
                                                @foreach ($batches as $b)
                                                    <option value="{{ $b->id }}">
                                                        {{batch_name($b->course->title_short_form, $b->year, $b->month, $b->batch_number)}}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @if ($errors->has('batch'))
                                                <span class="text-danger">{{ $errors->first('batch') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-9 ml-auto">
                                            <input type="submit" value="Change" class="btn btn-primary" onclick="return confirm('Are you sure ?')">
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
    <script type="text/javascript">
        $(document).on('change', '#course', function () {
            var cid = $('#course').val();
            $.ajax({
                url: '/ajax/change/course',
                method: "GET",
                data: {cid: cid},
                success: function (r) {
                    $("#batch").slideUp(1, e => {
                        $("#batch").html(r).slideDown('slow');
                    });
                }
            });
        })
    </script>
@endpush