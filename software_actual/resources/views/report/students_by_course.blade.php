@extends('layouts.master')

@section('title', 'Students - European IT Solutions Institute')

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
                        <h4> Students by Course </h4>
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

                        <h5>Course : <span class="font-weight-normal">{{$course->title}}</span></h5>

                        @forelse($batches as $batch)
                            <p>
                                Batch
                                : {{batch_name($batch->course->title_short_form, $batch->year, $batch->month, $batch->batch_number)}}
                            </p>
                            @if ($batch->students->count() > 0)
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

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')

@endpush
