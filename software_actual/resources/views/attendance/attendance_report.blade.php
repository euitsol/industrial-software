@extends('layouts.master')
@section('title', 'Attendance - European IT Solutions Institute')

@push('css')
    <style>
        .info p i {
            color: #fb00ff;
            font-size: 15px;
        }

        .info p span {
            font-weight: 800;
            font-size: 15px;
            color: blue;
        }

        .info {
            margin-bottom: 25px;
            font-size: 17px;
        }

        .info p {
            margin-bottom: 1px !important;
        }
        .card{
            overflow: auto;
        }
        /* #date_row_1, #date_row_2{
            border-bottom:2px solid #dee2e6;
        } */
        .table th, .table td{
            border:1px solid #dee2e6 !important;
            font-size: 9px;
            text-align: center;
            font-weight: normal;
            max-width: 50px;
            padding: 4px !important;
        }
        .table{
            margin:0; 
        }
        #table_1{
            max-width: 100%;
        }
    </style>
@endpush

@section('content')
    <div class="container" id="print">
        <div class="row justify-content-center">
            <div class="col-md-10 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <span class="float-left">
                            <h4>Classes for {{ $minfo->course->title }}</h4>
                        </span>
                        <span class="float-right">
                                <a href="{{ route('attendance.page',$minfo->id) }}" class="btn btn-info back_btn">Back</a>
                        </span>

                    </div>
                    
                    <div class="mt-4 text-center">
                        <button type="button" onclick="printT('print')"
                                class="btn btn-dark btn-sm text-center hide"><i class="fa fa-print"></i>
                        </button>
                    </div>
                    <div class="card-body p-4">
                        <div class="info row">
                            <div class="col-md-12 p-0 mx-auto d-flex justify-content-around">
                                <p><i class="fa fa-check-circle"></i><span> Course Type: </span>
                                    {{ $minfo->course_type }}
                                </p>
                                <p><i class="fa fa-check-circle"></i> <span> Course: </span>
                                    {{ $minfo->course->title }}
                                </p>
                                <p><i class="fa fa-check-circle"></i> <span> Batch: </span>
                                    {{batch_name($minfo->batch->course->title_short_form, $minfo->batch->year, $minfo->batch->month, $minfo->batch->batch_number)}}
                                </p>
                                <p><i class="fa fa-check-circle"></i> <span> Mentor: </span>
                                    {{$minfo->mentorName($minfo->batch->id)}}
                                </p>
                            </div>
                            {{-- Table --}}
                            @forelse($students->chunk(12) as $students)
                            <div class="table-responsive my-3">
                                <table id='table_1' class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th> Class </th>
                                            <th> Date </th>
                                            @foreach ($students as $key => $student)
                                                <th> {{ $student->student->name }}</th>
                                            @endforeach  
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @for ($i = 1; $i <= $minfo->course->total_class; $i++)
                                            <tr>
                                                <td> {{'Class-'.$i}}</td>
                                                <th>{{ $minfo->getDate($i)->date ?? 'Date' }}</th>
                                                @foreach ($students as $key => $student)
                                                    <td>
                                                        <i class="{{optional($minfo->getAttend($i, $student->student->id))->attedanceStatus()}}"></i> 
                                                    </td>
                                                @endforeach
                                            </tr>
                                        @endfor
                                        <tr>
                                            <th colspan="2">
                                                Total Class
                                                ({{$minfo->completeClassCount()}}) 
                                            </th>
                                            @foreach ($students as $key => $student)
                                                <th> 
                                                    Total Present 
                                                    ({{ $minfo->studentTotalPresentCount($student->student->id) }})
                                                </th>
                                            @endforeach  
                                        </tr>
                                    </tbody>
                                </table> 
                            </div>
                            @empty
                            <p class='mx-auto my-5 font-weight-bold'>This batch doesn't have any student</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
        <script>
        function printT(el, title = '') {
            console.log(el);
            var rp = document.body.innerHTML;
            $('.back_btn').hide();
            $('.hide').addClass('d-none');
            var pc = document.getElementById(el).innerHTML;
            document.body.innerHTML = pc;
            document.title = 'Attendance Report';
            window.print();
            document.body.innerHTML = rp;
        }
    </script>
@endpush
