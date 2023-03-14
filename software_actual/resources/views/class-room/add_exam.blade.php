@extends('layouts.master')

@section('title', 'Create Exam - European IT Solutions Institute')

@push('css')

@endpush

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Add Exam</h4>
                    </div>

                    <div class="card-body">

                        @if (session('error'))
                            <p class="alert alert-danger text-center">
                                {{ session('error') }}
                            </p>
                        @endif

                        <div class="row">
                            <div class="col-md-8 offset-md-2">
                                <form action="" method="POST" class="form-horizontal">
                                    @csrf

                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label">Exam Title <span
                                                    class="text-danger">*</span> </label>
                                        <div class="col-md-9">
                                            <input type="text" name="exam_title" value="{{ old('exam_title') }}"
                                                   class="form-control form-control-success" >
                                            @if ($errors->has('exam_title'))
                                                <span class="text-danger">{{ $errors->first('exam_title') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label">Sub Title <span
                                                    class="">(if any)</span> </label>
                                        <div class="col-md-9">
                                            <input type="text" name="exam_sub_title" value="{{ old('exam_sub_title') }}"
                                                   class="form-control form-control-success" >
                                            @if ($errors->has('exam_sub_title'))
                                                <span class="text-danger">{{ $errors->first('exam_sub_title') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label">Exam Duration<span
                                                    class="text-danger">*</span> </label>
                                        <div class="col-md-6">
                                            <input type="number" name="exam_duration" value="{{ old('exam_duration') }}"
                                                   class="form-control form-control-success" >
                                                    
                                                        
                                                    
                                            @if ($errors->has('exam_duration'))
                                                <span class="text-danger">{{ $errors->first('exam_duration') }}</span>
                                            @endif
                                        </div>
                                        <div class="col-md-3">
                                            <select name = "_exam_duration"  class = "form-control form-control-success"  >
                                                <option value = "min">Minutes</option>
                                                <option value = "hrs">Hours</option>
                                                
                                                
                                            </select>                                                                                                                                                    
                                            @if ($errors->has('fathers_name'))
                                                <span class="text-danger">{{ $errors->first('fathers_name') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label">Exam Type <span
                                                    class="text-danger">*</span> </label>
                                        <div class="col-md-9">
                                            <select  name="exam_status" value="{{ old('exam_status') }}"
                                                   class="form-control form-control-success" >
                                                <option value = "" hidden selected disabled>Choose.... </option>
                                                <option value = "1">Online </option>
                                                <option value = "2">Ofline </option>
                                                <option value = "3">Viva </option>

                                            </select>
                                            @if ($errors->has('exam_status'))
                                                <span class="text-danger">{{ $errors->first('exam_status') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label"></label>
                                        <div class="col-md-9">
                                            <input type = "submit" value = "submit" id = "submit" class="btn btn-primary w-100">
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
