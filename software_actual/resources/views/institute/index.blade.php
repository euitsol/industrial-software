@extends('layouts.master')

@section('title', 'Institutes - European IT Solutions Institute')

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
                        <h4>Institutes</h4>
                    </span>
                    <span class="float-right">
                        <a href="{{ route('institute.create') }}" class="btn btn-primary btn-sm">Add Institute</a>
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
                                    <th>SL</th>
                                    <th>Name</th>
                                    <th>District</th>
                                    <th>Added By</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($institutes as $key => $institute)
                                    <tr>
                                        <td> {{ $key + 1 }} </td>
                                        <td> {{ $institute->name }} </td>
                                        <td> {{ $institute->district }} </td>
                                        <td> {{ optional($institute->user)->name }} </td>
                                        <td>
                                            <div class="btn-group">
                                                <a href="{{ route('institute.show', $institute->id) }}"
                                                   class="btn btn-sm btn-dark">
                                                    <i class="fa fa-eye"></i>
                                                </a>
                                                <a href="{{ route('institute.edit', $institute->id) }}" class="btn btn-sm btn-info">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                                <a href="{{ route('institute.delete', $institute->id) }}" onclick="return confirm('Are you sure?')" class="btn btn-sm btn-danger">
                                                    <i class="fa fa-trash"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>SL</th>
                                    <th>Name</th>
                                    <th>District</th>
                                    <th>Added By</th>
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
                    title: 'Institutes'
                },
                {
                    extend: 'print',
                    exportOptions: {
                        columns: [0,1,2,3]
                    }
                }, 'pageLength'
            ]
        } );
    } );
</script>
@endpush
