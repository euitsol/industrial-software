@extends('layouts.master')

@section('title', 'Additional Fee - European IT Solutions Institute')

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
                            <h4>Additional Fees</h4>
                        </span>
                        <span class="float-right">
                            <a href="{{ route('fee.create') }}" class="btn btn-primary btn-sm">Add Additional Fee</a>
                        </span>
                    </div>

                    <div class="card-body">

                        @if (session('success'))
                            <p class="alert alert-success text-center">
                                {{ session('success') }}
                            </p>
                        @elseif(session('error'))
                            <p class="alert alert-danger text-center">
                                {{ session('error') }}
                            </p>
                        @endif

                        <div class="table-responsive">
                            <table id="table" class="display nowrap text-center">
                                <thead>
                                    <tr>
                                        <th class="align-middle">SL</th>
                                        <th class="align-middle">Session Name</th>
                                        <th class="align-middle">Fee</th>
                                        <th class="align-middle">Added By</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($fees as $key => $fee)
                                        <tr>
                                            <td class="align-middle"> {{ $key + 1 }} </td>
                                            <td class="align-middle"> {{ $fee->session->name }} </td>
                                            <td class="align-middle"> {{ $fee->amount }} </td>
                                            <td class="align-middle"> {{ $fee->created_user->name }} </td>
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
        $(document).ready(function() {
            $('#table').DataTable({
                dom: 'Bfrtip',
                buttons: [{
                        extend: 'pdfHtml5',
                        title: 'Session Info'
                    },
                    {
                        extend: 'print',
                        exportOptions: {
                            columns: [0, 1, 2, 3]
                        }
                    }, 'pageLength'
                ]
            });
        });
    </script>
@endpush
