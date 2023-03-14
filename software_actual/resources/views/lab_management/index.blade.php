@extends('layouts.master')

@section('title', 'Labs - European IT Solutions Institute')

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
                        <h4>Lab Management</h4>
                    </span>
                    <span class="float-right">
                        <a href="{{ route('lab-management.create') }}" class="btn btn-primary btn-sm">Add New Lab</a>
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
                                    <th class="align-middle">SL</th>
                                    <th class="align-middle">Lab Name</th>
                                    <th class="align-middle">Capacity</th>
                                    <th class="align-middle">Status</th>
                                    <th class="align-middle">Added By</th>
                                    <th class="align-middle">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($labs as $key => $lab)
                                    <tr>
                                        <td class="align-middle"> {{ $key + 1 }} </td>
                                        <td class="align-middle"> {{ $lab->lab_name }} </td>
                                        <td class="align-middle"> {{ $lab->capacity }} </td>
                                        <td class="align-middle"> {{ $lab->getStatus() }} </td>
                                        <td class="align-middle"> {{ $lab->created_user->name }} </td>
                                        <td class="align-middle">
                                            <div class="btn-group">
                                                <a href="{{ route('lab-management.show', $lab->id) }}"class="btn btn-sm btn-dark"><i class="fa fa-eye"></i></a>
                                                <a href="{{ route('lab-management.edit', $lab->id) }}" class="btn btn-sm btn-info"><i class="fa fa-edit"></i></a>
                                                <a href="{{ route('lab-management.delete', $lab->id) }}" onclick="return confirm('Are you sure?')" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></a>
                                                @if($lab->status == 1)
                                                    <a href="{{ route('lab.closed', $lab->id) }}" class="btn btn-sm btn-warning"><i class="fa fa-times" style="padding: 0 2px"></i></a>
                                                @else
                                                    <a href="{{ route('lab.running', $lab->id) }}" class="btn btn-sm btn-success"><i class="fa fa-check"></i></a>
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
                    title: 'Lab-info'
                },
                {
                    extend: 'print',
                    exportOptions: {
                        columns: [0,1,2,3,4]
                    }
                }, 'pageLength'
            ]
        } );
    } );
</script>
@endpush
