@extends('layouts.master')

@section('title', 'Students - European IT Solutions Institute')

@push('css')
    <link rel="stylesheet" href="{{ asset('assets/vendor/data-table/css/jquery.dataTables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/data-table/css/buttons.dataTables.min.css') }}">
@endpush

@section('content')
<input type="hidden" name="studentType" id="studentType" value="{{ $student_as }}">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10 col-lg-12">
                <div class="card">
                    <div class="card-header">
                    <span class="float-left">
                        <h4> {{$student_as}} Students <span class="badge badge-blue">{{$students->count()}}</span> </h4>
                    </span>
                    @if($totalStudents)
                        <h6 class="float-right"> Total Students {{count($totalStudents)}}</h6>
                    @endif
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

                        @if ($years->count() > 0)
                            <div class="row mb-3">
                                <div class="col-md-6 offset-md-3">
                                    <div class="row">
                                        <label for="year" class="col-md-3">Select Year</label>
                                        <div class="col-md-9">
                                            <select id="year" class="form-control form-control-sm">
                                                <option value="">Choose...</option>
                                                @foreach ($years as $_year)
                                                    <option value="{{ $_year->year }}" {{ $year == $_year->year ? 'selected' : '' }}>
                                                        {{ $_year->year }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <div class="table-responsive">
                            <table id="table" class="display nowrap">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Phone</th>
                                    <th>Institute</th>
                                    <th>Image</th>
                                    @if($student_as != null && $student_as == "Industrial")
                                    <th>Shift</th>
                                    @endif
                                    <th>Added By</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($students as $key => $student)
                                    <tr>
                                        <td> {{ $student->year.$student->reg_no }} </td>
                                        <td class="pl-4"> 
                                            <input type="checkbox" class="card-print-checkbox" data-student-id="{{ $student->id }}" data-card-print-status="{{ $student->card_print_status }}" title="Check it for print card from selected cards" {{ $student->card_print_status == 0 ? 'checked' : '' }}>
                                            {{ $student->name }} 
                                        </td>
                                        <td> {{ $student->phone }} </td>
                                        <td> {{ optional($student->institute)->name }} </td>
                                        <td><img style="width:50px" src="{{$student->photo ? (asset($student->photo)) : (asset('assets/img/no_img.jpg'))}}"></td>
                                        @if($student_as != null && $student_as == "Industrial")
                                        <td> {{ $student->shift() }} </td>
                                        @endif
                                        <td> {{ optional($student->user)->name }} </td>
                                        <td>
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
                                                <a href="{{ route('student.profile',$student->id) }}"
                                                   class="btn btn-sm btn-dark">
                                                    <i class="fa fa-user"></i>
                                                </a>
                                                
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
                                    <th>Institute</th>
                                    <th>Image</th>
                                    @if($student_as != null && $student_as == "Industrial")
                                    <th>Shift</th>
                                    @endif
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
        $(document).ready(function () {
            let type  = $('#studentType').val();
            if( type == 'Professional') 
            { 
                $(document).on('change', '#year', function () {
                    if ('' !== $(this).val()) {
                        let _url = '{{route('students.professional', ['_year'])}}';
                        window.location.href = _url.replace('_year', $(this).val());
                    }
                });
            }
            else
            {
                $(document).on('change', '#year', function () {
                    if ('' !== $(this).val()) {
                        let _url = '{{route('students.industrial', ['_year'])}}';
                        window.location.href = _url.replace('_year', $(this).val());
                    }
                });
            }
            

            $('#table').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'pdfHtml5',
                        title: 'Students'
                    },
                    {
                        extend: 'print',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4]
                        }
                    }, 'pageLength'
                ]
            });
        });
    </script>
    <script>
        $(document).ready(function() {
        $('.card-print-checkbox').change(function() {
            var studentId = $(this).data('student-id');
            var cardPrintStatus = $(this).data('card-print-status');
            
            // Toggle the card print status
            var newCardPrintStatus = cardPrintStatus === 0 ? 1 : 0;
            let _url = "{{route('updateCardPrintStatus')}}";
            let token = '{{ csrf_token() }}'
            console.log(cardPrintStatus);
            
            $.ajax({
                type: 'POST',
                url: _url,
                data: {
                    _token: token,
                    student_id: studentId,
                    card_print_status: newCardPrintStatus
                },
                success: function(response) {
                    // Update the data-card-print-status attribute
                    $('.card-print-checkbox[data-student-id="' + studentId + '"]').data('card-print-status', newCardPrintStatus);
                    
                    // Show the success message
                    $('#success-message').fadeIn().delay(2000).fadeOut();
                },
                error: function(xhr, status, error) {
                    console.error(error);
                    }
                });
            });
        });
    </script>

@endpush
