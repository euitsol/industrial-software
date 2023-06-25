@extends('layouts.master')

@section('title', 'Industrial Marketing Students - European IT Solutions Institute')

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
                        <h4>Industrial Marketing Students</h4>
                    </span>
                    <span class="float-right">
                        <a href="{{ route('marketing.industrial.student') }}" class="btn btn-primary btn-sm">Add New Student</a>
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
                                    <th class="align-middle">Name</th>
                                    <th class="align-middle">Phone</th>
                                    <th class="align-middle">Year</th>
                                    <th class="align-middle">Institute</th>
                                    <th class="align-middle">Shift</th>
                                    <th class="align-middle">Course</th>
                                    <th class="align-middle">Note</th>
                                    <th class="align-middle">Added By</th>
                                    <th class="align-middle">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($students as $key => $student)
                                    <tr>
                                        <td class="align-middle"> {{ $key + 1 }} </td>
                                        <td class="align-middle"> {{ $student->name }} </td>
                                        <td class="align-middle"> {{ $student->phone }} </td>
                                        <td class="align-middle"> {{ $student->year }} </td>
                                        <td class="align-middle">{{ optional($student->institute())->name }}</td>
                                        <td class="align-middle">
                                            @if($student->shift == 1)
                                                1st Shift
                                            @else
                                                2nd Shift
                                            @endif
                                        </td>
                                        <td class="align-middle">{{ optional($student->course())->title }}</td>
                                        <td class="align-middle">{!!  substr(strip_tags($student->note), 0, 40) !!}...</td>
                                        <td class="align-middle"> {{ optional($student->created_user)->name }} </td>

                                        <td class="align-middle">
                                            <div class="btn-group">
                                                <a href="{{route('industrial.marketing.student.view',$student->id)}}"class="btn btn-sm btn-dark"><i class="fa fa-eye"></i></a>
                                                <a href="{{route('industrial.marketing.student.edit',$student->id)}}" class="btn btn-sm btn-info"><i class="fa fa-edit"></i></a>
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
