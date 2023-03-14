@extends('layouts.master')

@section('title', 'Teacher Payment Setup - European IT Solutions Institute')

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
                        <h4>Teacher Payment Setup Edit</h4>
                    </span>
                        <span class="float-right">
                        <a href="{{ url()->previous() }}" class="btn btn-primary btn-sm">Back</a>
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
                            <div class="col-md-6 offset-md-3">

                                <div class="p-2">

                                    <form action="{{ route('teacher.payment.setup.update') }}" method="post">
                                        @csrf

                                        <input type="hidden" name="id" value="{{ $tpi->id }}">

                                        <div class="form-group">
                                            <label for="_institute">Institute <span class="text-danger">*</span></label>
                                            <select name="_institute" id="_institute" class="form-control">
                                                <option value="">Choose...</option>
                                                @foreach ($institutes as $institute)
                                                    <option value="{{ $institute->id }}" {{ $tpi->institute_id == $institute->id ? 'selected' : '' }}>
                                                        {{ $institute->name }} ({{$institute->teachers->count()}})
                                                    </option>
                                                @endforeach
                                            </select>
                                            @if ($errors->has('_institute'))
                                                <span class="text-danger">{{ $errors->first('_institute') }}</span>
                                            @endif
                                        </div>
                                        <div class="form-group">
                                            <label for="teacher">Responsible Teacher <span
                                                        class="text-danger">*</span></label>
                                            <select name="teacher" id="teacher" class="form-control"
                                                    disabled="disabled"></select>
                                            @if ($errors->has('teacher'))
                                                <span class="text-danger">{{ $errors->first('teacher') }}</span>
                                            @endif
                                        </div>
                                        <div class="form-group">
                                            <label for="session">Session <span
                                                        class="text-danger">*</span></label>
                                            <select name="_session" id="session" class="form-control">
                                                @foreach (range((date('Y') + 1), 2017) as $date)
                                                    <option value="{{ $date }}" {{ $date == $tpi->year ? 'selected' : '' }}>
                                                        {{ $date }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @if ($errors->has('_session'))
                                                <span class="text-danger">{{ $errors->first('_session') }}</span>
                                            @endif
                                        </div>
                                        <div class="form-group">
                                            <label for="per_student">Per Student Payment <span
                                                        class="text-danger">*</span></label>
                                            <input type="number" name="per_student_payment" value="{{ $tpi->per_student_payment }}" id="per_student"
                                                   class="form-control">
                                            @if ($errors->has('per_student_payment'))
                                                <span class="text-danger">{{ $errors->first('per_student_payment') }}</span>
                                            @endif
                                        </div>
                                        <div class="form-group">
                                            <input type="submit" value="Update" class="btn btn-info">
                                        </div>

                                    </form>

                                </div>

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
    <script type="text/javascript">
        let institute = $("#_institute");
        institute.select2();
        teachers_by_institute(institute);
        $(document).on('change', '#_institute', function () {
            teachers_by_institute($(this));
        });
        function teachers_by_institute(_institute) {
            let _this = _institute;
            if ('' !== _this.val()) {
                let _url = "{{ route('teachers.found', 'iid') }}";
                let __url = _url.replace('iid', _this.val());
                $.ajax({
                    url: __url,
                    method: "GET",
                    success: function (response) {
                        let _teacher = $('#teacher');
                        if (response.length > 0) {
                            console.log(response);
                            let output = '';
                            for (let i = 0; i < response.length; i++) {
                                output += '<option value="' + response[i].id + '">' + response[i].name + ' (' + response[i].designation + ')</option>';
                            }
                            _teacher.html(output);
                            _teacher.prop('disabled', false);
                        } else {
                            _teacher.html('');
                            _teacher.prop('disabled', true);
                        }
                    }
                });
            }
        }

    </script>
@endpush