@extends('layouts.master')

@section('title', 'Students - European IT Solutions Institute')

@push('css')
    <link rel="stylesheet" href="{{ asset('assets/vendor/jquery-ui/jquery-ui.css') }}">
@endpush

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4> Transaction Report </h4>
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

                                <form action="{{ route('transaction.find') }}" method="post">
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
                                        <label for="from_date">From Date <span class="text-danger">*</span> </label>
                                        <input type="text" name="from_date" id="from_date" autocomplete="off" readonly="readonly" class="form-control">
                                        @if ($errors->has('from_date'))
                                            <span class="text-danger">{{ $errors->first('from_date') }}</span>
                                        @endif
                                    </div>

                                    <div class="form-group">
                                        <label for="to_date">To Date <span class="text-danger">*</span> </label>
                                        <input type="text" name="to_date" id="to_date" autocomplete="off" readonly="readonly" class="form-control">
                                        @if ($errors->has('to_date'))
                                            <span class="text-danger">{{ $errors->first('to_date') }}</span>
                                        @endif
                                    </div>

                                    <div class="form-group">
                                        <label for="type">Type <span class="text-danger">*</span> </label>
                                        <select name="type" class="form-control" required>
                                            <option selected hidden value="all">All</option>
                                            <option value="all">All</option>
                                            <option value="Industrial">Industrial</option>
                                            <option value="Professional">Professional</option>
                                        </select>
                                        @if ($errors->has('type'))
                                            <span class="text-danger">{{ $errors->first('type') }}</span>
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
        let dateToday = new Date();
        $('#from_date, #to_date').datepicker({
            dateFormat: 'dd-mm-yy',
            maxDate: dateToday
        }).datepicker('setDate', new Date());

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
