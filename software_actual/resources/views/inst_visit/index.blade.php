@extends('layouts.master')

@section('title', 'Visited Institute - European IT Solutions Institute')

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
                            <h4>Visited institute</h4>
                        </span>
                        <span class="float-right">
                            <a href={{ route('iv.add') }} class="btn btn-primary">Add new</a>
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
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table id="table" class="display nowrap">
                                        <thead>
                                        <tr>
                                            <th>#SL</th>
                                            <th>Name</th>
                                            <th>Type</th>
                                            <th>District</th>
                                            <th>Divition</th>
                                            <th>Year</th>
                                            <th>Created at</th>
                                            <th>Created by</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach ( $institute_visits as $key => $iv)
                                            <tr>
                                                <td> {{ $key + 1 }} </td>
                                                <td> {{ $iv->name }} </td>
                                                <td> {{ $iv->getType() }} </td>
                                                <td> {{ $iv->district }} </td>
                                                <td> {{ $iv->division }} </td>
                                                <td> {{ $iv->year }} </td>
                                                <td> {{ date('d-M-Y, h:i A', strtotime($iv->created_at)) }} </td>
                                                <td> {{ $iv->user() }} </td>
                                                <td>
                                                    <div class="btn-group">
                                                        <a href="{{ route('iv.show', $iv->id) }}"
                                                           class="btn btn-sm btn-dark">
                                                            <i class="fa fa-eye"></i>
                                                        </a>
                                                        <a href="{{ route('iv.show', $iv->id) }}"
                                                           class="btn btn-sm btn-info">
                                                            <i class="fa fa-edit"></i>
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
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
            $('#table').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'pdfHtml5',
                        title: 'Visited Institutes',
                        exportOptions: {
                            columns: [1, 2, 3, 4, 5, 6, 7]
                        }
                    },
                    {
                        extend: 'print',
                        exportOptions: {
                            columns: [1, 2, 3, 4, 5, 6, 7]
                        }
                    }, 'pageLength'
                ]
            });
        });
    </script>
@endpush