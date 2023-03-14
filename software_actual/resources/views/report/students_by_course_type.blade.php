@extends('layouts.master')

@section('title', '')

@push('css')

@endpush

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10 col-lg-12">
                <div class="card">
                    <div class="card-header">
                    <span class="float-left">
                        <h4> Report </h4>
                    </span>
                    <span class="float-right">
                        <h4> Students by Sector </h4>
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

                        <h5>Course Type : <span class="font-weight-normal">{{$courseType}}</span></h5>

                        @forelse($courses as $course)
                            @forelse($course->batches as $batch)
                                @if ($batch->students->count() > 0)
                                    <p>
                                        Batch
                                        : {{batch_name($batch->course->title_short_form, $batch->year, $batch->month, $batch->batch_number)}}
                                    </p>
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-striped">
                                            <tr>
                                                <th>SL</th>
                                                <th>Name</th>
                                                <th>Phone</th>
                                                <th>Institute</th>
                                            </tr>
                                            @forelse($batch->students as $key => $student)
                                                <tr>
                                                    <td>{{++$key}}</td>
                                                    <td>{{$student->name}}</td>
                                                    <td>{{$student->phone}}</td>
                                                    <td>{{optional($student->institute)->name}}</td>
                                                </tr>
                                            @empty

                                            @endforelse
                                        </table>
                                    </div>
                                @endif
                            @empty

                            @endforelse
                        @empty

                        @endforelse

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')

@endpush

