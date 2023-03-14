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
                    <div class="card-header">
                    <span class="float-left">
                        <h4> Students </h4>
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
                            <table id="table" class="display nowrap">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Phone</th>
                                    <th>Student As</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($students as $key => $student)
                                    <tr>
                                        <td> {{ $key + 1 }} </td>
                                        <td> {{ $student->name }} </td>
                                        <td> {{ $student->phone }} </td>
                                        <td> {{ $student->student_as }} </td>
                                        <td>
                                            <div class="btn-group">
                                                <a href="{{ route('student.payment.history', $student->id) }}"
                                                   class="btn btn-sm btn-outline-primary">Payment Report</a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                                <tfoot>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Phone</th>
                                    <th>Student As</th>
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
@endsection

@push('js')
    <script src="{{ asset('assets/vendor/data-table/js/jquery-3.3.1.js') }}"></script>
    <script src="{{ asset('assets/vendor/data-table/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/data-table/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/data-table/js/buttons.flash.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/data-table/js/jszip.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/data-table/js/pdfmake.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/data-table/js/vfs_fonts.js') }}"></script>
    <script src="{{ asset('assets/vendor/data-table/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/data-table/js/buttons.print.min.js') }}"></script>

    <script>
        $(document).ready(function () {
            $('#table').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'copyHtml5',
                        title: 'Students'
                    },
                    {
                        extend: 'excelHtml5',
                        title: 'Students'
                    },
                    {
                        extend: 'pdfHtml5',
                        title: 'Students'
                    },
                    'print', 'pageLength'
                ]
            });
        });
    </script>

@endpush
