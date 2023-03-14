@extends('layouts.master')

@section('title', 'Sessions - European IT Solutions Institute')

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
                        <h4>Session</h4>
                    </span>
                    <span class="float-right">
                        <a href="{{ route('session.create') }}" class="btn btn-primary btn-sm">Add New Session</a>
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
                        <table id="table" class="display nowrap text-center">
                            <thead>
                                <tr>
                                    <th class="align-middle">SL</th>
                                    <th class="align-middle">Session Name</th>
                                    <th class="align-middle">Session Start</th>
                                    <th class="align-middle">Session End</th>
                                    <th class="align-middle">Status</th>
                                    <th class="align-middle">Added By</th>
                                    <th class="align-middle">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($sessions as $key => $session)
                                    <tr>
                                        <td class="align-middle"> {{ $key + 1 }} </td>
                                        <td class="align-middle"> {{ $session->name }} </td>
                                        <td class="align-middle"> {{ $session->start_time }} </td>
                                        <td class="align-middle"> {{ $session->end_time }} </td>
                                        <td class="align-middle"> {{ $session->getStatus() }} </td>
                                        <td class="align-middle"> {{ $session->created_user->name }} </td>
                                        <td class="align-middle">
                                            <div class="btn-group">
                                                <a href="{{ route('session.show', $session->id) }}"class="btn btn-sm btn-dark"><i class="fa fa-eye"></i></a>
                                                <a href="{{ route('session.edit', $session->id) }}" class="btn btn-sm btn-info"><i class="fa fa-edit"></i></a>
                                                <a href="{{ route('session.delete', $session->id) }}" onclick="return confirm('Are you sure?')" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></a>
                                                @if($session->status == 1)
                                                    <a href="javascript:void(0)" class="btn btn-sm btn-secondary"><i class="fa fa-check"></i></a>
                                                @else
                                                    <a href="{{ route('session.status', $session->id) }}" class="btn btn-sm btn-success"><i class="fa fa-check"></i></a>
                                                @endif
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
        $('#table').DataTable( {
            dom: 'Bfrtip',
            buttons: [
                {
                    extend: 'pdfHtml5',
                    title: 'Session Info'
                },
                {
                    extend: 'print',
                    exportOptions: {
                        columns: [0,1,2,3,4,5]
                    }
                }, 'pageLength'
            ]
        } );
    } );
</script>
@endpush
