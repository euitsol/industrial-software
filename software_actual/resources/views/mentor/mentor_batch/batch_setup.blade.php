@extends('layouts.master')

@section('title', 'Mentor Batch Setup - European IT Solutions Institute')

@push('css')
    <link rel="stylesheet" href="{{ asset('assets/vendor/data-table/css/jquery.dataTables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/data-table/css/buttons.dataTables.min.css') }}">
@endpush

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10 col-lg-12">
                <div class="card">
                    <div class="card-header">
                    <span class="float-left">
                        <h4>Mentor Batch Setup</h4>
                    </span>
                        <span class="float-right">
                        <a href="{{ route('mentor.batch-setup.index') }}" class="btn btn-info btn-sm">Back</a>
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
                            <div class="col-md-8 offset-md-2">

                                <table class="table table-borderless">
                                    <tr>
                                        <td>Name</td>
                                        <td>:</td>
                                        <td>{{ $mentor->name }}</td>
                                    </tr>
                                    <tr>
                                        <td>Phone</td>
                                        <td>:</td>
                                        <td>{{ $mentor->phone }}</td>
                                    </tr>
                                    <tr>
                                        <td>Email</td>
                                        <td>:</td>
                                        <td>{{ $mentor->email }}</td>
                                    </tr>
                                </table>

                                @if ($mentor->courses->count())

                                    @if ($errors->has('batch'))
                                        <p class="alert alert-danger">{{ $errors->first('batch') }}</p>
                                    @endif

                                    <form action="{{ route('mentor.batch-setup.process') }}" method="post">
                                        @csrf

                                        <input type="hidden" name="mentor_id" value="{{ $mentor->id }}">

                                        <div class="form-group row">
                                            @foreach ($mentor->courses as $ck => $course)
                                                <div class="col-6">
                                                    <p class="font-weight-bold">{{ ++$ck }}. {{ $course->title }} <span
                                                                class="font-weight-normal">({{ $course->type }})</span>
                                                    </p>
                                                    @if ($course->batches->count())
                                                        <ul class="list-group">
                                                            @foreach ($course->batches as $bk => $batch)
                                                                <li class="list-group-item">
                                                                    <div class="custom-control custom-checkbox mr-sm-2">
                                                                        <input type="checkbox" name="batch[]"
                                                                               value="{{ $batch->id }}"
                                                                               {{ in_array($batch->id, $batch_ids) ? 'checked' : '' }} class="custom-control-input"
                                                                               id="{{ $ck.'_'.$bk }}">
                                                                        <label class="custom-control-label" for="{{ $ck.'_'.$bk }}">
                                                                            {{ batch_name($course->title_short_form, $batch->year, $batch->month, $batch->batch_number) }}
                                                                        </label>
                                                                    </div>
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    @endif
                                                </div>
                                            @endforeach
                                        </div>

                                        <div class="form-group">
                                            <input type="submit" value="Submit" class="btn btn-primary btn-block">
                                        </div>

                                    </form>
                                @endif

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

