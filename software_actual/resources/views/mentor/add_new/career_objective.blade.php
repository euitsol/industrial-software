@extends('layouts.master')

@section('title', 'Create Mentor - European IT Solutions Institute')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10 col-lg-12">
                <div class="card">
                    <div class="card-header">
                    <span class="float-left">
                        <h4>New Mentor</h4>
                    </span>
                        <span class="float-right">
                        <a href="{{ route('mentors') }}" class="btn btn-info btn-sm">Back</a>
                    </span>
                    </div>

                    <div class="card-body">

                        <div class="row">
                            <div class="col-md-8 offset-md-2">

                                <p class="font-weight-bold">Career Objective <span class="text-danger">*</span> </p>

                                <form action="{{ route('mentor.career-objective.store') }}" method="POST" class="form-horizontal">
                                    @csrf

                                    <input type="hidden" name="mid" value="{{$mentor->id}}">

                                    <div class="form-group">
                                        <textarea name="career_objective" class="form-control">{{ old('career_objective') }}</textarea>
                                        @if ($errors->has('career_objective'))
                                            <span class="text-danger">{{$errors->first('career_objective')}}</span>
                                        @endif
                                    </div>

                                    <div class="form-group">
                                        <input type="submit" value="Submit" class="btn btn-primary">
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
    <script src="https://cdn.ckeditor.com/4.13.0/standard/ckeditor.js"></script>
    <script>
        CKEDITOR.replace('career_objective', {height: 150});
    </script>
@endpush