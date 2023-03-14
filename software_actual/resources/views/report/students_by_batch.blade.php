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
                        <h4> Students by Batch </h4>
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

                        <div class="row">
                            <div class="col-md-6">
                                <h5>Course : <span class="font-weight-normal">{{$course->title}}</span></h5>
                            </div>
                            <div class="col-md-6">
                                <h5>Batch : <span class="font-weight-normal">{{$batch_name}}</span></h5>
                            </div>
                        </div>

                        @if ($students->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                    <tr>
                                        <th>SL</th>
                                        <th>Name</th>
                                        <th>Phone</th>
                                        <th>Institute</th>
                                    </tr>
                                    @forelse($students as $key => $student)
                                        <tr>
                                            <td>{{++$key}}</td>
                                            <td>{{$student->name}}</td>
                                            <td>{{$student->phone}}</td>
                                            <td>{{optional($student->institute)->name}}</td>
                                        </tr>
                                    @empty

                                    @endforelse
                                </table>
                                <form action="{{route('sms.student.batch', ['bid' => $bid])}}" method="POST">
                                    @csrf
                                    <div class="form-group">
                                        <input type="text" class="form-control" placeholder="SMS body" name="sms"
                                               required>
                                        @if($errors->has('sms'))
                                            <span class="help-block text-danger">{{$errors->first('sms')}}</span>
                                        @endif
                                    </div>
                                    <button type="submit" class="btn btn-sm btn-primary">Send SMS</button>
                                </form>
                            </div>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')

@endpush
