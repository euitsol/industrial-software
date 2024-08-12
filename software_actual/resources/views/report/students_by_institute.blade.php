@extends('layouts.master')

@section('title', 'Students - European IT Solutions Institute')

@push('css')

@endpush

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <span class="float-left"><h4> Institute Students Report </h4></span>
                        <span class="float-right"><a href="{{route('report.institute.students.due', ['iid' => $iid, 'yr' => $year, 'shift' => $shift])}}"
                                                     class="btn btn-sm btn-outline-danger">Due</a></span>
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
                            <div class="float-left" title="Without Payment Info">
                                <button type="button" onclick="print_content_without_money('print_content', '{{$institute->name}}')"
                                        class="btn btn-success">
                                    <i class="fa fa-print"></i>
                                </button>
                            </div>
                            <div class="float-left" title="With Payment Info">
                                <button type="button" onclick="printT('print_content', '{{$institute->name}}')"
                                        class="btn btn-info">
                                    <i class="fa fa-print"></i>
                                </button>
                            </div>
                            
                            <div class="float-right">
                                <h4 class="font-weight-normal">
                                    @if ($students->count() > 0)
                                        <span class="text-success">{{$students->count()}}</span> Students found
                                    @else
                                        <span class="text-danger">{{$students->count()}}</span> Student found
                                    @endif
                                </h4>
                            </div>
                        </div>
                        <div id="print_content">
                            @if ($students->count() > 0)
                                <div style="margin-top: 40px">

                                    <div class="row mb-5">
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
                                   <h4 class="mb-4 text-center">{{$institute->name}} ( @if($shift == 1) 1st shift @elseif($shift == 2) 2nd shift @elseif($shift == null) Other Shift @else All Shift @endif ) - {{ $year }}</h4>
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <tr>
                                                <th>SL</th>
                                                <th>Name</th>
                                                <th>Board Roll</th>
                                                <th>Board Reg</th>
                                                <th>Phone</th>
                                                <th>Courses</th>
                                                <th class="payment">Course Fee</th>
                                                <th class="payment">Discount</th>
                                                <th class="payment">Paid</th>
                                                <th class="payment">Additional Fee</th>
                                                <th class="payment">Due</th>
                                                <th class="payment certificate">Certificate</th>
                                            </tr>
                                            @foreach ($students as $sk => $student)
                                                <tr>
                                                    <td>{{++$sk}}</td>
                                                    <td>{{$student->name}}</td>
                                                    <td>{{$student->board_roll ?? '---'}}</td>
                                                    <td>{{$student->board_reg ?? '---'}}</td>
                                                    <td>{{$student->phone}}</td>
                                                    <td>
                                                        @if ($student->courses->count() > 0)
                                                            @foreach($student->courses as $ck => $course)
                                                                <span class="">({{++$ck}})</span>
                                                                <span class="mr-2">{{$course->title}}</span>
                                                            @endforeach
                                                        @endif
                                                    </td>
                                                    <td class="payment">{{$student->total_amount}}</td>
                                                    <td class="payment">
                                                        @if ($student->accounts->count() > 0)
                                                            @foreach($student->accounts as $sa => $accont)
                                                                <span class="">({{++$sa}})</span>
                                                                <span class="mr-2">{{$accont->discount_amount}}</span>
                                                            @endforeach
                                                        @endif
                                                    </td>
                                                    <td class="payment">{{$student->paid_amount}}</td>
                                                    <td class="payment">
                                                        @php
                                                           $additional_fee = 0;
                                                        @endphp
                                                        @if ($student->accounts->count() > 0)
                                                            @foreach($student->accounts as $sa => $accont)
                                                                <span class="">({{++$sa}})</span>
                                                                <span class="mr-2">{{$additional_fee += !empty($accont->additional_fee) ? $accont->additional_fee : 0}}</span>
                                                            @endforeach
                                                        @endif
                                                    </td>
                                                    <td class="payment">{{$student->due_amount+$additional_fee}}</td>
                                                    <td class="payment certificate"></td>
                                                </tr>
                                            @endforeach
                                        </table>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    @if(count($students) > 0)
                        <form action="{{route('sms.student.institute', ['iid' => $institute->id, 'yr' => $year ])}}" method="POST">
                            @csrf
                            <div class="form-group">
                                <input type="text" class="form-control" name="sms" required>
                                @if($errors->has('sms'))
                                    <span class="help-block text-danger">{{$errors->first('sms')}}</span>
                                @endif
                            </div>
                            <button type="submit" class="btn btn-sm btn-primary">Send SMS</button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        function printT(el, title = '') {
            var rp = document.body.innerHTML;
            var pc = document.getElementById(el).innerHTML;
            document.body.innerHTML = pc;
            document.title = title ? title : '';
            window.print();
            document.body.innerHTML = rp;
        }
        
        function print_content_without_money(el, title = ''){
            var rp = document.body.innerHTML;
            $('.payment').hide();
            var pc = document.getElementById(el).innerHTML;
            document.body.innerHTML = pc;
            document.title = title ? title : '';
            window.print();
            document.body.innerHTML = rp;
        }
    </script>
@endpush
