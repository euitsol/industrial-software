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
                        <h4> Students <span class="badge badge-blue">{{$students->count()}}</span> -   <span class="text-danger">{{batch_name(optional($batch->course)->title_short_form, $batch->year, $batch->month, $batch->batch_number)}}</span></h4>
                    </span>
                    <span class="float-right">
                        <button type="button" class="mr-1 btn btn-success btn-sm" onclick="print('print_content','{{batch_name(optional($batch->course)->title_short_form, $batch->year, $batch->month, $batch->batch_number)}}')">
                            <i class="fa fa-print"></i>
                        </button>
                        <a href="{{ route('batches') }}" class="btn btn-info btn-sm"> Back </a>
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
                        <div id="print_content">
                        <span class="text-center print-show" style="display:none">
                            <h4> Students <span class="badge badge-blue">{{$students->count()}}</span> -   <span class="text-danger">{{batch_name(optional($batch->course)->title_short_form, $batch->year, $batch->month, $batch->batch_number)}}</span></h4>
                        </span>
                        <div class="table-responsive">
                            <table id="table" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Phone</th>
                                    <th>Institute</th>
                                    @if($batch->course->type != null && $batch->course->type == "Industrial")
                                    <th>Shift</th>
                                    @endif
                                    <th class="print-hide">Paid</th>
                                    <th>Due</th>
                                    <th class="print-hide">Added By</th>
                                    <th class="print-hide">Action</th>
                                    <th class="print-show" style="display: none">Certificate</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($students as $key => $student)
                                    <tr>
                                        <td> {{ $student->year.$student->reg_no }} </td>
                                        <td> {{ $student->name }} </td>
                                        <td> {{ $student->phone }} </td>
                                        <td> {{ optional($student->institute)->name }} </td>
                                        @if($student->student_as != null && $student->student_as == "Industrial")
                                        <td> {{ $student->shift() }} </td>
                                        @endif
                                        <td class="print-hide"> {{ $student->paid_amount }} </td>
                                        <td> {{ $student->due_amount }} </td>
                                        <td class="print-hide"> {{ optional($student->user)->name }} </td>
                                        <td class=" print-hide">
                                            <div class="btn-group">
                                                <a href="{{ route('student.show', $student->id) }}"
                                                   class="btn btn-sm btn-dark">
                                                    <i class="fa fa-eye"></i>
                                                </a>
                                                <a href="{{ route('student.edit', $student->id) }}"
                                                   class="btn btn-sm btn-info">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                                <a href="{{ route('student.delete', $student->id) }}"
                                                   onclick="return confirm('Are you sure?')"
                                                   class="btn btn-sm btn-danger">
                                                    <i class="fa fa-trash"></i>
                                                </a>
                                            </div>
                                        </td>
                                        <td class="print-show" style="display: none"></td>
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
@endsection

@push('js')
    <script>
        $(document).ready(function () {
            // $('#table').DataTable({
            //     dom: 'Bfrtip',
            //     buttons: [
            //         {
            //             extend: 'pdfHtml5',
            //             title: 'Batch: {{batch_name(optional($batch->course)->title_short_form, $batch->year, $batch->month, $batch->batch_number)}}',
            //         },
            //         {
            //             extend: 'print',
            //             title: 'Batch: {{batch_name(optional($batch->course)->title_short_form, $batch->year, $batch->month, $batch->batch_number)}}',
            //             exportOptions: {
            //                 columns: [0, 1, 2, 3, 4, 5]
            //             }
            //         }, 'pageLength'
            //     ]
            // });
        });

        function print(el, title = ''){
            var rp = document.body.innerHTML;
            $('.print-hide').hide();
            $('.print-show').show();
            var pc = document.getElementById('print_content').innerHTML;
            document.body.innerHTML = pc;
            document.title = title ? title : '';
            window.print();
            document.body.innerHTML = rp;
        }
    </script>

@endpush