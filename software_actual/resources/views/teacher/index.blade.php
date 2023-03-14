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
                    <span class="float-left">
                        <h4>Find Teachers</h4>
                    </span>
                        <span class="float-right">
                        <a href="{{ route('teacher.create') }}" class="btn btn-primary btn-sm">Add Teacher</a>
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
                                <form action="{{ route('teachers.find') }}" method="POST" class="form-horizontal">
                                    @csrf

                                    <div class="form-group">
                                        <label class="form-control-label">Institute</label>
                                        <select name="institute" id="institute"
                                                class="form-control form-control-success">
                                            <option value="">Choose...</option>
                                            @foreach ($institutes as $institute)
                                                <option value="{{ $institute->id }}">{{ $institute->name }}
                                                    ({{$institute->teachers->count()}})
                                                </option>
                                            @endforeach
                                        </select>
                                        <small>* Teachers find by Institute name</small>
                                        <br>
                                        @if ($errors->has('institute'))
                                            <span class="text-danger">{{ $errors->first('institute') }}</span>
                                        @endif
                                        <script>document.getElementById('institute').value = "{{ old('institute') }}";</script>
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
    </script>
@endpush