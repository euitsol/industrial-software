@extends('layouts.master')

@section('title', 'Session Wise Students - European IT Solutions Institute')

@push('css')
    <link rel="stylesheet" href="{{ asset('assets/vendor/jquery-ui/jquery-ui.css') }}">
@endpush

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4> Transaction Report - Session Wise </h4>
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

                                <form action="{{ route('transaction_session_wise.find') }}" method="post">
                                    @csrf

                                    <div class="form-group">
                                        <label for="user">User <span class="text-danger">*</span> </label>
                                        <select name="user" id="user" class="form-control" required>
                                            @if(auth()->user()->role == 'user')
                                                <option value="{{ auth()->user()->id }}">{{ auth()->user()->name }}</option>
                                            @else
                                                <option value="all">All</option>
                                                @if ($users->count() > 0)
                                                    @foreach ($users as $user)
                                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                                    @endforeach
                                                @endif
                                            @endif

                                        </select>
                                        @if ($errors->has('user'))
                                            <span class="text-danger">{{ $errors->first('user') }}</span>
                                        @endif
                                    </div>


                                    <div class="form-group">
                                        <label for="session">Session <span class="text-danger">*</span> </label>
                                        <select name="session" class="form-control" required>
                                            <option selected hidden value="">Select Session</option>
                                            @foreach ($sessions as $session)
                                                <option value="{{ $session->id }}">{{ $session->name }}</option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('session'))
                                            <span class="text-danger">{{ $errors->first('session') }}</span>
                                        @endif
                                    </div>

                                    <div class="form-group">
                                        <input type="submit" value="Search" class="btn btn-primary">
                                        <input type="reset" value="Reset" class="btn btn-dark">
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
    <script src="{{ asset('assets/vendor/jquery-ui/jquery-ui.js') }}"></script>
    <script>
        function printT(el, title = '') {
            let rp = document.body.innerHTML;
            let pc = document.getElementById(el).innerHTML;
            document.body.innerHTML = pc;
            document.title = title ? title : '';
            window.print();
            document.body.innerHTML = rp;
        }
    </script>
@endpush
