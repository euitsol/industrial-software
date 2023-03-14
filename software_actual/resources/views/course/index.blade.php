@extends('layouts.master')

@section('title', 'Courses - European IT Solutions Institute')

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
                            <h4>Courses</h4>
                        </span>
                            <span class="float-right">
                            <a href="{{ route('course.create') }}" class="btn btn-primary btn-sm">Add Course</a>
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

                        <nav style="margin-bottom: 10px;">
                            <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
                                <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab"
                                   href="#industrial" role="tab" aria-controls="industrial" aria-selected="true">Industrial</a>
                                <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#professional"
                                   role="tab" aria-controls="professional" aria-selected="false">Professional</a>
                            </div>
                        </nav>

                        <div class="tab-content" id="nav-tabContent">
                            <div class="tab-pane fade show active" id="industrial" role="tabpanel"
                                 aria-labelledby="nav-home-tab">
                                <div class="table-responsive">
                                    <table id="table_one" class="display nowrap">
                                        <thead>
                                        <tr>
                                            <th>SL</th>
                                            <th>Title</th>
                                            <th>Course Sector</th>
                                            <th>Fee
                                                <small>(BDT)</small>
                                            </th>
                                            <th>Status</th>
                                            <th>Added By</th>
                                            <th>Added at</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach ($in_courses as $key => $course)
                                            <tr>
                                                <td> {{ $key + 1 }} </td>
                                                <td> {{ $course->title }} </td>
                                                <td> {{ optional($course->course_type)->type_name }} </td>
                                                <td> {{ $course->fee }} </td>
                                                <td> @if($course->running == 1) Running @else End @endif</td>
                                                <td> {{ optional($course->user)->name }} </td>
                                                <td> {{ date('d-m-Y', strtotime($course->created_at)) }} </td>
                                                <td>
                                                    <div class="btn-group">
                                                        <a href="{{ route('course.show', $course->id) }}"
                                                           class="btn btn-sm btn-dark">
                                                            <i class="fa fa-eye"></i>
                                                        </a>
                                                        <a href="{{ route('course.edit', $course->id) }}"
                                                           class="btn btn-sm btn-info">
                                                            <i class="fa fa-edit"></i>
                                                        </a>
                                                        <a href="{{ route('course.delete', $course->id) }}"
                                                           onclick="return confirm('Are you sure?')"
                                                           class="btn btn-sm btn-danger">
                                                            <i class="fa fa-trash"></i>
                                                        </a>
                                                        <a href="{{ route('course.running', $course->id) }}"
                                                           onclick="return confirm('Are you sure, you want to change status?')"
                                                           class="btn btn-sm @if($course->running == 1)btn-warning @else btn-primary @endif">
                                                            <i class="fa">@if($course->running == 1) &#xf00d; @else &#xf00c; @endif</i>
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                        <tfoot>
                                        <tr>
                                            <th>SL</th>
                                            <th>Title</th>
                                            <th>Course Sector</th>
                                            <th>Fee</th>
                                            <th>Status</th>
                                            <th>Added By</th>
                                            <th>Added at</th>
                                            <th>Action</th>
                                        </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="professional" role="tabpanel"
                                 aria-labelledby="nav-profile-tab">
                                <div class="table-responsive">
                                    <table id="table_two" class="display nowrap">
                                        <thead>
                                        <tr>
                                            <th>SL</th>
                                            <th>Title</th>
                                            <th>Course Sector</th>
                                            <th>Fee
                                                <small>(BDT)</small>
                                            </th>
                                            <th>Status</th>
                                            <th>Added By</th>
                                            <th>Added at</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach ($pro_courses as $key => $course)
                                            <tr>
                                                <td> {{ $key + 1 }} </td>
                                                <td> {{ $course->title }} </td>
                                                <td> {{ optional($course->course_type)->type_name }} </td>
                                                <td> {{ $course->fee }} </td>
                                                <td> @if($course->running == 1) Running @else End @endif</td>
                                                <td> {{ optional($course->user)->name }} </td>
                                                <td> {{ date('d-m-Y', strtotime($course->created_at)) }} </td>
                                                <td>
                                                    <div class="btn-group">
                                                        <a href="{{ route('course.show', $course->id) }}"
                                                           class="btn btn-sm btn-dark">
                                                            <i class="fa fa-eye"></i>
                                                        </a>
                                                        <a href="{{ route('course.edit', $course->id) }}"
                                                           class="btn btn-sm btn-info">
                                                            <i class="fa fa-edit"></i>
                                                        </a>
                                                        <a href="{{ route('course.delete', $course->id) }}"
                                                           onclick="return confirm('Are you sure?')"
                                                           class="btn btn-sm btn-danger">
                                                            <i class="fa fa-trash"></i>
                                                        </a>
                                                        <a href="{{ route('course.running', $course->id) }}"
                                                           onclick="return confirm('Are you sure, you want to change status?')"
                                                           class="btn btn-sm @if($course->running == 1)btn-warning @else btn-primary @endif">
                                                            <i class="fa">@if($course->running == 1) &#xf00d; @else &#xf00c; @endif</i>
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                        <tfoot>
                                        <tr>
                                            <th>SL</th>
                                            <th>Title</th>
                                            <th>Course Sector</th>
                                            <th>Fee</th>
                                            <th>Status</th>
                                            <th>Added By</th>
                                            <th>Added at</th>
                                            <th>Action</th>
                                        </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="{{ asset('assets/vendor/data-table/js/jquery-3.3.1.js') }}"></script>
    <script src="{{ asset('assets/vendor/data-table/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/data-table/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/data-table/js/pdfmake.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/data-table/js/vfs_fonts.js') }}"></script>
    <script src="{{ asset('assets/vendor/data-table/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/data-table/js/buttons.print.min.js') }}"></script>
    <script>
        $(document).ready(function () {
            $('#table_one').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'pdfHtml5',
                        title: 'Industrial Courses'
                    },
                    {
                        extend: 'print',
                        exportOptions: {
                            columns: [0,1,2,3,4]
                        }
                    }, 'pageLength'
                ]
            });

            $('#table_two').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'pdfHtml5',
                        title: 'Professional Courses'
                    },
                    {
                        extend: 'print',
                        exportOptions: {
                            columns: [0,1,2,3,4]
                        }
                    }, 'pageLength'
                ]
            });
        });
    </script>
@endpush
