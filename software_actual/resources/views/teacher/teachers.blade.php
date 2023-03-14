@extends('layouts.master')

@section('title', 'Courses - European IT Solutions Institute')

@push('css')

@endpush

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <span class="float-left">
                        <h4>Teachers</h4>
                    </span>
                    <span class="float-right">
                        <a href="{{ route('teachers.find') }}" class="btn btn-info btn-sm">Back</a>
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

                    <h3 class="text-center mb-3 p-2">{{ $institute->name }}</h3>
                    
                    <div class="row">
                        @foreach ($teachers as $teacher)
                            <div class="col-md-4 text-center mb-2">
                                <div class="border p-2">
                                    @if (isset($teacher->photo))
                                        <img src="{{ asset($teacher->photo) }}" height="100" alt="" class="mb-2">
                                    @else
                                        <img src="{{ asset('images/avatar.png') }}" height="100" alt="" class="mb-2">
                                    @endif
                                    <h5>{{ $teacher->name }}</h5>
                                    <p>
                                        {{ $teacher->designation }}
                                        <p>
                                            <a href="{{ route('teacher.show', $teacher->id) }}" class="btn btn-dark btn-sm">Show</a>
                                            <a href="{{ route('teacher.edit', $teacher->id) }}" class="btn btn-info btn-sm">Edit</a>
                                            <a href="{{ route('teacher.delete', $teacher->id) }}" onclick="return confirm('Are you sure?')" class="btn btn-danger btn-sm">Delete</a>
                                        </p>
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')

@endpush
