@extends('layouts.web')

@section('title', 'Payment - European IT Solutions Institute')

@push('css')
<style>
.container .card h4{
    color: hsl(207deg 37% 37%);
    font-family: "Teko", Sans-serif;
    font-size: 35px;
    font-weight: 600;
}
.container .card .row label{
    color: hsl(207deg 37% 37%);
    font-family: "Teko", Sans-serif;
    font-size: 20px;
    font-weight: 400;
}


</style>
 
@endpush


@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Online Payment</h4>
                    </div>

                    <div class="card-body">

                        @if (session('error'))
                            <p class="alert alert-danger text-center">
                                {{ session('error') }}
                            </p>
                        @elseif (session('success'))
                            <p class="alert alert-success text-center">
                                {{ session('success') }}
                            </p>
                        @endif

                        <div class="row">
                            <div class="col-md-8 offset-md-2">
                                <form action="{{ route('op.student.search') }}" method="POST" enctype="multipart/form-data" class="form-horizontal">
                                @csrf
                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label"> Student Phone Number<span class="text-danger">*</span> </label>
                                        <div class="col-md-9">
                                            <input type="number" name="phone" value="{{ old('phone') }}"
                                                   class="form-control form-control-success" placeholder="01*********" required>
                                            <small>Please enter your 11 digit phone number for payment</small>
                                            @if ($errors->has('phone'))
                                                <span class="text-danger">{{ $errors->first('phone') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-9 ml-auto">
                                            <div class = "">
                                                <input type="submit" value="Next" class=" submit_btn btn btn-primary float-right" style="font-size: 20px;">
                                            </div>
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

@endpush