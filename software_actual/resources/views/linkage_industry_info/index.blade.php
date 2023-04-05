@extends('layouts.master')

@section('title', 'Linkage With Industry Information - European IT Solutions Institute')

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
                        <h4>Linkage With Industry Information </h4>
                    </span>
                    <span class="float-right">
                        <a href="{{ route('linkage_industry.info.create') }}" class="btn btn-primary btn-sm">Add Linkage Industry Info</a>
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
                        <table id="table" class="display">
                            <thead>
                                <tr>
                                    <th class="align-middle">SL</th>
                                    <th class="align-middle">Company Name</th>
                                    <th class="align-middle">Company Logo</th>
                                    <th class="align-middle">Company Website</th>
                                    <th class="align-middle">Company Address</th>
                                    <th class="align-middle">Added By</th>
                                    <th class="align-middle">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($linkage_industry_infos as $key => $info)
                                    <tr>
                                        <td class="align-middle"> {{ $key + 1 }} </td>
                                        <td class="align-middle"> {{ $info->company_name }} </td>
                                        <td class="align-middle text-center">
                                            @if (!empty($info->company_logo) && file_exists($info->company_logo))
                                                <img src="{{ asset($info->company_logo) }}" height="50" width="50" alt="Company Logo">
                                            @endif
                                        </td>
                                        <td class="align-middle"> {{ $info->company_website }} </td>
                                        <td class="align-middle"> {{ $info->company_address }} </td>
                                        <td class="align-middle"> {{ $info->created_user->name }} </td>
                                        <td class="align-middle">
                                            <div class="btn-group">
                                                <a href="{{ route('linkage_industry.info.show', $info->id) }}"class="btn btn-sm btn-dark"><i class="fa fa-eye"></i></a>
                                                <a href="{{ route('linkage_industry.info.edit', $info->id) }}" class="btn btn-sm btn-info"><i class="fa fa-edit"></i></a>
                                                <a href="
                                                {{ route('linkage_industry.info.delete', $info->id) }}
                                                " onclick="return confirm('Are you sure?')" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></a>
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
                    title: 'Linkage with industry info'
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
