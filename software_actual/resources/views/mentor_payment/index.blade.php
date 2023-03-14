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
                        <h4>Search Mentor</h4>
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
                                <form action="{{ route('mentor.payment.mentor-search.process') }}" method="POST"
                                      class="form-horizontal">
                                    @csrf

                                    <div class="form-group">
                                        <label for="mentor" class="form-control-label">Mentor <span
                                                    class="text-danger">*</span> </label>
                                        <select name="mentor" id="mentor"
                                                class="form-control form-control-success">
                                            <option value="">Choose...</option>
                                            @foreach ($mentors as $mentor)
                                                <option value="{{ $mentor->id }}">{{ $mentor->name }}</option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('mentor'))
                                            <span class="text-danger">{{ $errors->first('mentor') }}</span>
                                        @endif
                                        <script>document.getElementById('mentor').value = "{{ old('mentor') }}";</script>
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
    <script>
        $('#mentor').select2();
    </script>
@endpush