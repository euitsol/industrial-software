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
                        <h4> Admission Report - Reference Wise </h4>
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

                                <form action="{{ route('reference_wise_report.find') }}" method="post">
                                    @csrf

                                    <div class="form-group">
                                        <label for="source">Source <span class="text-danger" id="source_star">*</span> </label>
                                        <select name="source" id="source" class="form-control" onchange="selectSource()" required>
                                            <option value="" selected>Select source</option>
                                            @foreach ($sources as $source)
                                                <option value="{{ $source->id }}">{{ $source->name }}</option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('source'))
                                            <span class="text-danger">{{ $errors->first('source') }}</span>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label for="referral">Referral <span class="text-danger" id="referral_star">*</span> </label>
                                        <select name="referral" id="referral" class="form-control" onchange="selectReferral()" required>
                                            <option value="" selected>Select referral</option>
                                            @foreach ($referrals as $referral)
                                                <option value="{{ $referral->id }}">{{ $referral->name }}</option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('referral'))
                                            <span class="text-danger">{{ $errors->first('referral') }}</span>
                                        @endif
                                    </div>


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
                                        <input type="submit" onClick="checkVld()" value="Search" class="btn btn-primary">
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
    <script>
        function selectSource()
        {
            var sourceValue = document.getElementById('source').value;
            if(sourceValue != '')
            {
                document.getElementById("referral").value = '';
                document.getElementById("referral").disabled = true;
                document.getElementById("referral_star").innerHTML = '';
            }
            else
            {
                document.getElementById("referral").disabled = false;
                document.getElementById("referral_star").innerHTML = '*';
            }
        }
        function selectReferral()
        {
            var referralValue = document.getElementById('referral').value;
            if(referralValue != '')
            {
                document.getElementById("source").value = '';
                document.getElementById("source").disabled = true;
                document.getElementById("source_star").innerHTML = '';
            }
            else
            {
                document.getElementById("source").disabled = false;
                document.getElementById("source_star").innerHTML = '*';
            }
        }
        // Check Empty
        function checkVld(){
            var source = document.getElementById('source');
            var referral = document.getElementById('referral');
            var e = 0;
            if(source.value == '' && referral.value == '')
            {
                e++;
                source.reportValidity();
                referral.reportValidity();
            }
            else if(source.value != '' && referral.value == '')
            {
                e++;
                referral.required = false;
            }
            else if(source.value == '' && referral.value != '')
            {
                e++;
                source.required = false;
            }
            if(e == 0)
            {
                return true;
            }else{
                return false;
            }
        }
    </script>
@endpush

