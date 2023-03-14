@extends('layouts.master')

@section('title', 'Create Mentor - European IT Solutions Institute')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10 col-lg-12">
                <div class="card">
                    <div class="card-header">
                    <span class="float-left">
                        <h4>Edit Mentor</h4>
                    </span>
                    <span class="float-right">
                        <a href="{{ route('mentor.show', $mentor->id) }}" class="btn btn-info btn-sm">Show</a>
                        <a href="{{ route('mentors') }}" class="btn btn-info btn-sm">Back</a>
                    </span>
                    </div>

                    <div class="card-body">

                        @include('partial.mentor_edit_nav')

                        <div class="row">
                            <div class="col-md-8 offset-md-2">

                                <p class="font-weight-bold">Career Objective</p>

                                @if(session('success'))
                                    <p class="alert alert-success text-center">
                                        {{ session('success') }}
                                    </p>
                                @elseif(session('error'))
                                    <p class="alert alert-danger text-center">
                                        {{ session('error') }}
                                    </p>
                                @endif

                                <form action="{{ route('mentor.career-objective.update') }}" method="POST"
                                      class="form-horizontal">
                                    @csrf

                                    <input type="hidden" name="mid" value="{{$mentor->id}}">

                                    <div class="form-group">
                                        <textarea name="career_objective" class="form-control">{{$mentor->career_objective}}</textarea>
                                        @if ($errors->has('career_objective'))
                                            <span class="text-danger">{{$errors->first('career_objective')}}</span>
                                        @endif
                                    </div>

                                    <div class="form-group">
                                        <input type="submit" value="Update" class="btn btn-info">
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
        CKEDITOR.replace('career_objective', {height: 200});

        $('#edit-mentor a').filter(function () {
            return this.href === location.href;
        }).addClass('text-light').closest("div").addClass('bg-primary');
    </script>
@endpush

