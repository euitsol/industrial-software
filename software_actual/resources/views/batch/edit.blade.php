@extends('layouts.master')

@section('title', 'Edit Batch - European IT Solutions Institute')

@push('js')
    <link rel="stylesheet" href="{{ asset('assets/vendor/jquery-ui/jquery-ui.css') }}">
@endpush

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <span class="float-left">
                            <h4>Edit Batch</h4>
                        </span>
                        <span class="float-right">
                            <a href="{{ route('batches') }}" class="btn btn-info btn-sm">Back</a>
                        </span>
                    </div>

                    <div class="card-body">

                        <div class="row" id="info">
                            <div class="col-md-8 offset-md-2">
                                <div class="table-responsive">

                                    <table class="table table-striped table-borderless mt-3">
                                        <tr>
                                            <td>Course Name</td>
                                            <td>:</td>
                                            <td>{{ $batch->course->title }}</td>
                                        </tr>
                                        <tr>
                                            <td>Batch Name</td>
                                            <td>:</td>
                                            <td>{{ batch_name($batch->course->title_short_form, $batch->year, $batch->month, $batch->batch_number) }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Lab Name</td>
                                            <td>:</td>
                                            <td>{{ $batch->lab->lab_name ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <td>Total Students</td>
                                            <td>:</td>
                                            <td>{{ $batch->students->count() }}</td>
                                        </tr>
                                        <tr>
                                            <td>Start Date</td>
                                            <td>:</td>
                                            <td>{{ $batch->start_date ?? 'Not set !' }}</td>
                                        </tr>
                                        <tr>
                                            <td>End Date</td>
                                            <td>:</td>
                                            <td>
                                                {{ $batch->end_date ?? 'Not set !' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Certificate Issue Date</td>
                                            <td>:</td>
                                            <td>
                                                {{ $batch->certificate_issue_date ?? 'Not set !' }}
                                            </td>
                                        </tr>
                                    </table>

                                    <div class="text-right">
                                        <button type="button" id="edit-btn" class="btn btn-sm btn-outline-dark">
                                            Edit <i class="fa fa-arrow-circle-right"></i>
                                        </button>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <div class="row" id="edit" style="display: none;">
                            <div class="col-md-8 offset-md-2">

                                <form action="{{ route('batch.update') }}" method="POST" class="form-horizontal mt-3">
                                    @csrf

                                    <input type="hidden" name="id" value="{{ $batch->id }}">

                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label">Course Name</label>
                                        <div class="col-md-9 font-weight-bold">
                                            {{ $batch->course->title }}
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label">Batch Name</label>
                                        <div class="col-md-9 font-weight-bold">
                                            {{ batch_name($batch->course->title_short_form, $batch->year, $batch->month, $batch->batch_number) }}
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label">Start Date</label>
                                        <div class="col-md-9">
                                            <input type="text" name="start_date" value="{{ $batch->start_date }}"
                                                id="start_date" placeholder="Start" autocomplete="off" class="form-control">
                                            @if ($errors->has('start_date'))
                                                <span class="text-danger">{{ $errors->first('start_date') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label">End Date</label>
                                        <div class="col-md-9">
                                            <input type="text" name="end_date" value="{{ $batch->end_date }}"
                                                id="end_date" placeholder="End" autocomplete="off" class="form-control">
                                            @if ($errors->has('end_date'))
                                                <span class="text-danger">{{ $errors->first('end_date') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label">Certificate Issue Date</label>
                                        <div class="col-md-9">
                                            <input type="text" name="certificate_issue_date" value="{{ $batch->certificate_issue_date }}" id="certificate_issue_date"
                                                placeholder="Certificate Issue Date" class="form-control"
                                                autocomplete="off">
                                            @if ($errors->has('certificate_issue_date'))
                                                <span
                                                    class="text-danger">{{ $errors->first('certificate_issue_date') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label">Select Lab</label>
                                        <div class="col-md-9">
                                            <select name="lab" id="lab" class="form-control form-control-success">
                                                @if (empty($batch->lab_id))
                                                    <option value='null' hidden selected>Select Lab</option>
                                                    @foreach ($labs as $lab)
                                                        <option value="{{ $lab->id }}">{{ $lab->lab_name }}</option>
                                                    @endforeach
                                                @else
                                                    @foreach ($labs as $lab)
                                                        <option
                                                            value="{{ $lab->id }}"@if ($batch->lab_id == $lab->id) selected @endif>
                                                            {{ $lab->lab_name }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                            @if ($errors->has('lab'))
                                                <span class="text-danger">{{ $errors->first('lab') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-9 ml-auto">
                                            <input type="submit" value="Update" class="btn btn-primary">
                                        </div>
                                    </div>
                                </form>

                                <button type="button" id="info-btn" class="btn btn-sm btn-outline-dark">
                                    <i class="fa fa-arrow-circle-left"></i> Show Info
                                </button>

                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="{{ asset('assets/vendor/jquery-ui/jquery-ui.js') }}"></script>
    <script>
        $("#start_date").datepicker({
            dateFormat: 'yy-mm-dd'
        });
        $("#end_date").datepicker({
            dateFormat: 'yy-mm-dd'
        });
        $("#certificate_issue_date").datepicker({
            dateFormat: 'yy-mm-dd'
        });
        let edit = "{{ $errors->first('start_date') }}";
        if (edit !== '') {
            $('#info').hide();
            $('#edit').show();
        }
        $(function() {
            $(document).on('click', '#edit-btn', function() {
                $('#info').hide();
                $('#edit').show();
            });
            $(document).on('click', '#info-btn', function() {
                $('#edit').hide();
                $('#info').show();
            });
        });
    </script>
@endpush
