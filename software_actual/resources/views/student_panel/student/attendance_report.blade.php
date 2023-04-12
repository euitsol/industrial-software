@extends('student_panel.layouts.master')

@section('title', 'Student Attendance Report - European IT Solutions Institute')

@push('css')
<style>
    .info p i{
        color: #fb00ff;
        font-size: 15px;
    }
    .info p span {
        font-weight: 800;
        font-size: 15px;
        color: blue;
    }
</style>
@endpush

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <span class="float-left"><h4> Attendance Report</h4></span>
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
                        <div class="clearfix mb-3">
                            <div class="float-left" title="Print Report">
                                <button type="button" onclick="printT('print_content', '{{$student->institute->name}}')"
                                        class="btn btn-info">
                                    <i class="fa fa-print"></i>
                                </button>
                            </div>
                        </div>
                        <div id="print_content">
                            @if ($student->courses->count() > 0)
                                @foreach($student->courses as $ck => $course)
                                    <div style="margin-top: 40px">
                                        <div class="row">
                                            <div class="col-md-7">
                                                <img src="{{asset('images/EUITSols Institute New.png')}}" width="300"
                                                        alt="">
                                                <p class="mt-2">An EUITSols undertaking</p>
                                            </div>
                                            <div class="col-md-5">
                                                <h5>European IT Solutions Institute</h5>
                                                Noor Mansion (3rd Floor), Plot#04, Main Road#01, Mirpur-10, Dhaka-1216
                                            </div>
                                        </div>
                                    </div>
                                    <div class="p-0 mb-4 text-center">
                                        <h4>
                                            {{ $student->name }}
                                            
                                        </h4>
                                    </div>
                                    <div class="p-0 mx-auto d-flex justify-content-between info">
                                        <p ><i class="fa fa-check-circle"></i><span> Institute: </span>
                                            {{ $student->institute->name }}
                                        </p>
                                        <p ><i class="fa fa-check-circle"></i> <span> Board Roll: </span>
                                            {{ $student->board_roll ?? '---' }}
                                        </p>
                                        <p ><i class="fa fa-check-circle"></i> <span> Phone: </span>
                                            {{$student->phone}}
                                        </p>
                                        <p ><i class="fa fa-check-circle"></i> <span> Course: </span>
                                            {{$course->title}}
                                        </p>
                                    </div>
                                    <div class="p-0 mx-auto d-flex justify-content-between info">
                                        <p ><i class="fa fa-check-circle"></i><span> Batch: </span>
                                            @foreach($student->batches as $bk => $batch)
                                            {{-- {{dd($batch)}} --}}
                                            {{batch_name($batch->course->title_short_form, $batch->year, $batch->month, $batch->batch_number)}}
                                            @endforeach
                                        </p>
                                        <p ><i class="fa fa-check-circle"></i> <span> Mentor: </span>
                                            @foreach($minfo as $infos)
                                                @foreach($infos as $info)
                                                    {{$info->mentorName($info->batch->id)}}
                                                @endforeach
                                            @endforeach
                                        </p>
                                        
                                        <p ><i class="fa fa-check-circle"></i> <span> Complete Class: </span>
                                            @foreach($student->batches as $bk => $batch)
                                                @foreach($minfo as $infos)
                                                    @foreach($infos as $info)
                                                        @if($course->id == $info->course_id && $batch->id == $info->batch_id)
                                                            {{$info->completeClassCount()}}
                                                        @endif
                                                    @endforeach
                                                @endforeach
                                            @endforeach
                                        </p>
                                        <p ><i class="fa fa-check-circle"></i> <span> Total Present: </span>
                                            @foreach($student->batches as $bk => $batch)
                                                @foreach($minfo as $infos)
                                                    @foreach($infos as $info)
                                                        @if($course->id == $info->course_id && $batch->id == $info->batch_id)
                                                            {{$info->studentTotalPresentCount($student->id)}}
                                                        @endif
                                                    @endforeach
                                                @endforeach
                                            @endforeach
                                        </p>
                                        <p ><i class="fa fa-check-circle"></i> <span> Total Absent: </span>
                                            @foreach($student->batches as $bk => $batch)
                                                @foreach($minfo as $infos)
                                                    @foreach($infos as $info)
                                                        @if($course->id == $info->course_id && $batch->id == $info->batch_id)
                                                            {{$info->studentTotalAbsentCount($student->id)}}
                                                        @endif
                                                    @endforeach
                                                @endforeach
                                            @endforeach
                                        </p>
                                    </div>
                                    <div class="table-responsive my-3">
                                        <table id='table_1' class="table table-bordered">
                                            @if($course->total_class > 0)
                                                <thead>
                                                    <tr>
                                                        <th class="text-center"> Class </th>
                                                        <th class="text-center"> Date</th>
                                                        <th class="text-center"> Attendance</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @for ($i = 1; $i <= $course->total_class; $i++)
                                                        <tr>
                                                            <td class="text-center"> {{'Class-'.$i}}</td>
                                                            @foreach($student->batches as $bk => $batch)
                                                                @foreach($minfo as $infos)
                                                                    @foreach($infos as $info)
                                                                        @if($course->id == $info->course_id && $batch->id == $info->batch_id)
                                                                            <td class="text-center">{{ $info->getDate($i)->date ?? 'Date' }}</td>
                                                                            <td class="text-center">
                                                                                <i class="{{optional($info->getAttend($i, $student->id))->attedanceStatus()}}"></i> 
                                                                            </td class="text-center">
                                                                        @endif
                                                                    @endforeach
                                                                @endforeach
                                                            @endforeach
                                                        </tr>
                                                    @endfor
                                                </tbody>
                                            @else
                                                <p class="text-center">Your course total class not set yet!</p>
                                            @endif
                                        </table> 
                                    </div>
                                @endforeach
                            @endif
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
            var rp = document.body.innerHTML;
            $('.session').hide();
            $('.action').hide();
            var pc = document.getElementById(el).innerHTML;
            document.body.innerHTML = pc;
            document.title = title ? title : '';
            window.print();
            document.body.innerHTML = rp;
        }
    </script>
@endpush
