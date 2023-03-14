@extends('layouts.master')

@section('title', 'Mentor New Payment Setup - European IT Solutions Institute')

@push('css')

@endpush

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10 col-lg-12">
                <div class="card">
                    <div class="card-header">
                    <span class="float-left">
                        <h4>Mentor New Payment Setup</h4>
                    </span>
                        <span class="float-right">
                        <a href="{{ url()->previous() }}" class="btn btn-info btn-sm">Back</a>
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

                                <form action="{{ route('mentor.payment-setup.process') }}" method="post">
                                    @csrf

                                    <input type="hidden" name="id" value="{{ $mentor->id }}">

                                    <div class="form-group row">
                                        <label for="" class="form-control-label col-md-3">Name</label>
                                        <div class="col-md-9">
                                            {{ $mentor->name }}
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="course" class="form-control-label col-md-3">
                                            Course <span class="text-danger">*</span>
                                        </label>
                                        <div class="col-md-9">
                                            <select name="course" id="course" class="form-control">
                                                <option value="" hidden>Choose...</option>
                                                @foreach ($mentor->courses as $course)
                                                    <option value="{{ $course->id }}" {{ old('course') == $course->id ? 'selected' : '' }}>
                                                        {{ $course->title }} ({{ $course->type }})
                                                    </option>
                                                @endforeach
                                            </select>
                                            @if ($errors->has('course'))
                                                <span class="text-danger">{{ $errors->first('course') }}</span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="batch" class="form-control-label col-md-3">
                                            Batch <span class="text-danger">*</span>
                                        </label>
                                        <div class="col-md-9">
                                            <select name="batch" id="batch" data-selected="{{ old('batch') }}" class="form-control"></select>
                                            @if ($errors->has('batch'))
                                                <span class="text-danger">{{ $errors->first('batch') }}</span>
                                            @endif
                                            <span id="exist" class="mt-1"></span>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="year" class="form-control-label col-md-3">
                                            Year <span class="text-danger">*</span>
                                        </label>
                                        <div class="col-md-9">
                                            <select name="year" id="year" class="form-control">
                                                @foreach (range((date('Y') + 1), 2017) as $date)
                                                    <option value="{{ $date }}" {{ $date == date('Y') ? 'selected' : '' }}>
                                                        {{ $date }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @if ($errors->has('year'))
                                                <span class="text-danger">{{ $errors->first('year') }}</span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="total_class" class="form-control-label col-md-3">
                                            Total Class <span class="text-danger">*</span>
                                        </label>
                                        <div class="col-md-9">
                                            <input type="number" name="total_class" id="total_class" class="form-control">
                                            @if ($errors->has('total_class'))
                                                <span class="text-danger">{{ $errors->first('total_class') }}</span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="row">
                                        <label for="" class="form-control-label col-md-3">
                                            Payment <span class="text-danger">*</span>
                                        </label>
                                        <div class="col-md-9">
                                            <div class="form-inline">
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" id="per_class" name="payment"
                                                           value="per_class" {{ 'per_class' == old('payment') ? 'checked' : '' }}
                                                           class="custom-control-input">
                                                    <label class="custom-control-label" for="per_class">Per
                                                        Class</label>
                                                </div>
                                                <div class="custom-control custom-radio ml-3">
                                                    <input type="radio" id="batch_wise" name="payment"
                                                           value="batch_wise" {{ 'batch_wise' == old('payment') ? 'checked' : '' }}
                                                           class="custom-control-input">
                                                    <label class="custom-control-label"
                                                           for="batch_wise">Batch</label>
                                                </div>
                                            </div>
                                            <div class="">
                                                <input type="number" name="per_class_amount" value="{{ old('per_class_amount') }}"
                                                       id="per_class_payment"
                                                       placeholder="Per class amount" style="display: none"
                                                       class="form-control mt-2">
                                                <input type="number" name="batch_wise_amount" value="{{ old('batch_wise_amount') }}"
                                                       id="batch_wise_payment" placeholder="Batch wise amount"
                                                       style="display: none" class="form-control mt-2">
                                            </div>
                                            @if ($errors->has('payment'))
                                                <span class="text-danger">{{ $errors->first('payment') }}</span>
                                            @elseif($errors->has('per_class_amount'))
                                                <span class="text-danger">{{ $errors->first('per_class_amount') }}</span>
                                            @elseif($errors->has('batch_wise_amount'))
                                                <span class="text-danger">{{ $errors->first('batch_wise_amount') }}</span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group row mt-3">
                                        <div class="col-md-3"></div>
                                        <div class="col-md-9">
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
    <script type="text/javascript">

        function batchesByCourse() {
            if ('' !== $(this).val()) {
                $.ajax({
                    url: ("{{ route('mentor.course.batches', [$mentor->id, 'cid']) }}").replace('cid', $(this).val()),
                    method: "GET",
                    success: function (response) {
                        if (response.batches.length > 0) {
                            let output = '<option value="" hidden>Choose...</option>';
                            let batch = $('#batch');
                            batch.html(output + response.batches);
                            if ('' !== batch.data('selected')) {
                                batch.val(batch.data('selected'));
                            }
                        }
                        if (response.exist_count) {
                            $('#exist').html('<b class="text-danger">' + response.exist_count + '</b>' + ' batch already set.');
                        }
                    }
                });
            }
        }

        batchesByCourse.call($('#course'));

        $(document).on('change', '#course', function () {
            batchesByCourse.call(this);
        });

        function per_class_payment() {
            $('#per_class_payment').show(300);
            $('#batch_wise_payment').val('').hide();
        }

        function batch_wise_payment() {
            $('#batch_wise_payment').show(300);
            $('#per_class_payment').val('').hide();
        }

        if ($('#per_class').is(':checked')) {
            per_class_payment();
        }

        if ($('#batch_wise').is(':checked')) {
            batch_wise_payment();
        }

        $(document).on("change", '#per_class', function () {
            per_class_payment();
        });

        $(document).on('change', '#batch_wise', function () {
            batch_wise_payment();
        });

        $(document).on('change', '#tpi_year', function () {
            let tpi_year = $(this);
            if ('' !== tpi_year.val()) {
                let url = '{{ route('teacher.payment.setup.index', 'year') }}';
                window.location.href = url.replace('year', tpi_year.val());
            }
        });

        $(document).on('click', '#delete_button', function () {
            if (confirm('Are you sure?')) {
                $('#delete_form').submit();
            }
        });
    </script>
@endpush
