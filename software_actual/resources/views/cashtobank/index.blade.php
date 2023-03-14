@extends('layouts.master')

@section('title', 'Cash To bank - European IT Solutions Institute')

@push('css')
    <link rel="stylesheet" href="{{ asset('assets/vendor/jquery-ui/jquery-ui.css') }}">
@endpush

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <span class="float-left">
                        <h4>Cash To bank</h4>
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

                                <form action="{{ route('ctb.search') }}" method="post">
                                    @csrf

                                    <div class="form-group">
                                        <label for="type">Course type <span class="text-danger">*</span> </label>
                                        <select name="type" id="type" class="form-control">
                                            <option value="industrial">Industrial</option>
                                            <option value="professional">Professional</option>
                                        </select>
                                        @if ($errors->has('type'))
                                            <span class="text-danger">{{ $errors->first('type') }}</span>
                                        @endif
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="user">User <span class="text-danger">*</span> </label>
                                        <select name="user" id="user" class="form-control">
                                            @if(auth()->user()->role == 'user')
                                                <option value="{{ auth()->user()->id }}">{{ auth()->user()->name }}</option>
                                            @else
                                                <option value="">All</option>
                                                @if ($users->count() > 0)
                                                    @foreach ($users as $user)
                                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                                    @endforeach
                                                @endif
                                            @endif

                                        </select>
                                        <small>select if you want user filter</small><br>
                                        @if ($errors->has('user'))
                                            <span class="text-danger">{{ $errors->first('user') }}</span>
                                        @endif
                                    </div>

                                    <div class="form-group">
                                        <label for="date">Date <span class="text-danger">*</span> </label>
                                        <input type="text" name="date" id="date" autocomplete="off" readonly class="form-control" value="">
                                        @if ($errors->has('date'))
                                            <span class="text-danger">{{ $errors->first('date') }}</span>
                                        @endif
                                    </div>

                                    <div class="form-group">
                                        <input type="submit" value="Search" style="width: 49%;" class="btn btn-primary">
                                        <input type="reset" value="Reset" style="width: 49%;" class="btn btn-dark">
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
        $('#date').datepicker({
            dateFormat: 'dd-mm-yy',
            maxDate: dateToday
        }).datepicker('setDate', new Date());


    </script>
@endpush