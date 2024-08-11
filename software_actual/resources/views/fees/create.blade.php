@extends('layouts.master')

@section('title', 'Fees - European IT Solutions Institute')

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
                            <h4>Add Additional Fees</h4>
                        </span>
                    </div>

                    <div class="card-body">

                        @if (session('success'))
                            <p class="alert alert-success text-center">
                                {{ session('success') }}
                            </p>
                        @endif
                        @if (session('error'))
                            <p class="alert alert-danger text-center">
                                {{ session('error') }}
                            </p>
                        @endif

                        <div class="row">
                            <div class="col-md-8 offset-md-2">
                                <form action="{{ route('fee.update') }}" method="POST" class="form-horizontal"
                                    id="feeForm">
                                    @csrf

                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label">Session</label>
                                        <div class="col-md-9">
                                            <select name="session" id="session" class="form-control form-control-success"
                                                required>
                                                <option value="">Choose...</option>
                                                @foreach ($sessions as $session)
                                                    <option value="{{ $session->id }}">{{ $session->name }}</option>
                                                @endforeach
                                            </select>
                                            @if ($errors->has('session'))
                                                <span class="text-danger">{{ $errors->first('session') }}</span>
                                            @endif
                                            <script>
                                                document.getElementById('session').value = "{{ old('session') }}";
                                            </script>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label">Amount</label>
                                        <div class="col-md-9">
                                            <input type="text" value="{{ old('amount') }}"
                                                placeholder="Enter additional fee" name="amount"
                                                class="form-control form-control-success" required>
                                            <small>* This additional fee will be added to the students who have due.</small>
                                            <br>
                                            @if ($errors->has('amount'))
                                                <span class="text-danger">{{ $errors->first('amount') }}</span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <div class="col-md-9 ml-auto">
                                            <input type="submit" value="Add Additional Fee" class="btn btn-primary"
                                                id="submitFee">
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
    <script src="{{ asset('assets/vendor/select2/select2.min.js') }}"></script>
    <script type="text/javascript">
        $("#session").select2();
    </script>

    <script>
        $(document).ready(function() {
            $('#submitFee').click(function(e) {
                e.preventDefault(); // Prevent the default form submission
                // Show a confirmation dialog
                var confirmation = confirm(
                    "This additional fee will be added to the students who have due. Any additional fees added earlier will be deleted and these additional fees will be added for students who have dues for this session. Are you sure you want to add this additional fee?"
                );
                if (confirmation) {
                    // If the user clicks "Yes", submit the form
                    $('#feeForm').submit();
                } else {
                    // If the user clicks "No", do nothing
                    return false;
                }
            });
        });
    </script>
@endpush
