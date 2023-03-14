@extends('layouts.master')

@section('title', 'SMS - European IT Solutions Institute')

@push('css')

@endpush

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4> Individual Message </h4>
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

                        @if(session('_errors'))
                            <p class="alert alert-danger text-center">
                                @foreach(session('_errors') as $error)
                                    {{ $error }} <br>
                                @endforeach
                            </p>
                        @endif
                            <form action="{{ route ('sms.indivisual.send')}}" method="post">
                                @csrf

                                

                                <div class="row mt-3">
                                    <div class="col-md-8 offset-md-2">
                                        <div class="form-group">
                                            <label for="message">Message <span class="text-danger">*</span></label>
                                            <div class="mb-2 "><input type="text" class="" name = "name"></div>
                                            <textarea name="message" id="message"
                                                      class="form-control mb-2" required></textarea>
                                            <div>
                                                <input type="text" class="mt-2 mb-2" style="width: 45%;" name="company_name" value="ইউরোপিয়ান আইটি সলিউশনস"> <br>
                                                যোগাযোগ: <input type="text" style="width: 35%;"  class="mt-2" name="company_phn" value="০১৮৮৯৯৭৭৯৫১"  ><br>
                                            </div>
                                            @if ($errors->has('message'))
                                                <span class="text-danger">{{ $errors->first('message') }}</span>
                                            @endif
                                        </div>
                                        <div class="form-group">
                                            <div class ='mb-2'>Receivers Number   <input type="text" class="" name = "phone" required></div>
                                        </div>
                                        <div class="form-group">
                                            <input type="submit" value="Send" class="btn btn-primary">
                                        </div>
                                    </div>
                                </div>

                            </form>
                        

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        function printT(el, title = '') {
            var rp = document.body.innerHTML;
            var pc = document.getElementById(el).innerHTML;
            document.body.innerHTML = pc;
            document.title = title ? title : '';
            window.print();
            document.body.innerHTML = rp;
        }
    </script>
@endpush