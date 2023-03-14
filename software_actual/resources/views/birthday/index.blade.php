@extends('layouts.master')

@section('title', 'Students - European IT Solutions Institute')

@push('css')
    <link rel="stylesheet" href="{{ asset('assets/vendor/data-table/css/jquery.dataTables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/data-table/css/buttons.dataTables.min.css') }}">
@endpush

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10 col-lg-12">
                <div class="card">
                    @if($errors->has('today') || $errors->has('date'))
                        <!-- <span class="help-block text-danger">Please Do Not Mess With The Original Code !!!</span> -->
                        {{$errors}}
                    @endif
                    <div class="card-header">
                        <span class="float-left">
                        <h4>Birthdays</h4>
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
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Phone</th>
                                    <th>Institute</th>
                                    <th>Batches</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($students as $i => $student)
                                    <tr>
                                        <td> {{ $i + 1 }} </td>
                                        <td> {{ $student->name }} </td>
                                        <td> {{ $student->phone }} </td>
                                        <td> {{ $student->institute }} </td>
                                        <td>
                                            @forelse($student->batches as $b)
                                                {{$b }}
                                            @empty
                                                No batch to show
                                            @endforelse
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            @if(count($students) > 0)
                                <form action="{{route('sms.student.birthday')}}" method="POST">
                                    @csrf
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="sms" required
                                               value="European IT is wishing you the happiest of birthdays.">
                                        @if($errors->has('sms'))
                                            <span class="help-block text-danger">{{$errors->first('sms')}}</span>
                                        @endif
                                    </div>
                                    <button type="submit" class="btn btn-sm btn-primary">Send SMS</button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
