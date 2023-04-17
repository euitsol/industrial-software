@extends('layouts.master')

@section('title', 'Cash To Bank Report - European IT Solutions Institute')

@push('css')
    <link rel="stylesheet" href="{{ asset('assets/vendor/jquery-ui/jquery-ui.css') }}">
@endpush

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4> Cash To Bank Report - Search </h4>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 offset-md-3">

                                <form action="{{ route('ctb.report.find') }}" method="post">
                                    @csrf

                                    <div class="form-group">
                                        <label for="from_date">From Date <span class="text-danger">*</span> </label>
                                        <input type="text" name="from_date" id="from_date" autocomplete="off" readonly="readonly" class="form-control" required>
                                        @if ($errors->has('from_date'))
                                            <span class="text-danger">{{ $errors->first('from_date') }}</span>
                                        @endif
                                    </div>

                                    <div class="form-group">
                                        <label for="to_date">To Date <span class="text-danger">*</span> </label>
                                        <input type="text" name="to_date" id="to_date" autocomplete="off" readonly="readonly" class="form-control" required>
                                        @if ($errors->has('to_date'))
                                            <span class="text-danger">{{ $errors->first('to_date') }}</span>
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
    </script>

@endpush

