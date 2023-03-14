@extends('layouts.master')

@section('title', 'Find Teachers - European IT Solutions Institute')

@push('css')
    <link rel="stylesheet" href="{{ asset('assets/vendor/select2/select2.min.css') }}">
    <style>
        .nav-tabs .nav-link {
            border: 1px solid transparent;
            border-top-left-radius: unset;
            border-top-right-radius: unset;
        }

        .nav-tabs .nav-link.active, .nav-tabs .nav-item.show .nav-link {
            font-weight: unset;
        }

        .select2 {
            display: block !important;
        }
    </style>
@endpush

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Find Institute</h4>
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
                                <form action="{{ route('teacher.payment.institute.find') }}" method="POST"
                                      class="form-horizontal">
                                    @csrf

                                    <div class="form-group">
                                        <label for="institute" class="form-control-label">Institute <span
                                                    class="text-danger">*</span> </label>
                                        <select name="institute" id="institute"
                                                class="form-control form-control-success">
                                            <option value="">Choose...</option>
                                            @foreach ($institutes as $institute)
                                                <option value="{{ $institute->id }}">{{ $institute->name }}
                                                    ({{$institute->teachers->count()}})
                                                </option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('institute'))
                                            <span class="text-danger">{{ $errors->first('institute') }}</span>
                                        @endif
                                        <script>document.getElementById('institute').value = "{{ old('institute') }}";</script>
                                    </div>
                                    <div class="form-group">
                                        <label for="year">Year <span class="text-danger">*</span></label>
                                        <select name="year" id="year" class="form-control" disabled="disabled"></select>
                                        @if ($errors->has('year'))
                                            <span class="text-danger">{{ $errors->first('year') }}</span>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <input type="submit" value="Search" class="btn btn-primary">
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
    <script type="text/javascript">
        let institute = $("#institute");
        institute.select2();

        $(document).on('change', '#institute', function () {
            if ('' !== institute.val()) {
                $.ajax({
                    url: ("{{ route('teacher.payment.years', 'iid') }}").replace('iid', institute.val()),
                    method: "GET",
                    success: function (response) {
                        let year = $('#year');
                        year.html('');
                        if (response.length) {
                            console.log(response);
                            let output = '';
                            for (let i = 0; i < response.length; i++) {
                                let el = response[i];
                                output += '<option value="' + el.year + '">' + el.year + '</option>';
                            }
                            year.html(output).prop('disabled', false);
                        } else {
                            year.prop('disabled', true);
                        }
                    }
                });
            }
        });
    </script>
@endpush