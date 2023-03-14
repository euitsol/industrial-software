@extends('layouts.master')

@section('title', 'Students - European IT Solutions Institute')

@push('css')

@endpush

@section('content')
    <div class="container" id="print">
        <div class="row justify-content-center">
            <div class="col-md-10 col-lg-12">
                <div class="card">
                    <div class="card-header text-center">
                        <h4>Transaction Report - <span class="text-danger">{{$course_type}} - {{$year}}</span></h4>
                    </div>
                    <div class="card-body">
                        @if(session('success'))
                            <p class="alert alert-success text-center hide">
                                {{ session('success') }}
                            </p>
                        @elseif(session('error'))
                            <p class="alert alert-danger text-center hide">
                                {{ session('error') }}
                            </p>
                        @endif
                        <div class="row">
                            <div class="col-md-5">
                                <h5 class="mb-4">Course Type : <span class="font-weight-normal">{{$course_type}}</span>
                                </h5>
                            </div>
                            <div class="col-md-2 text-center">
                                <button type="button" onclick="printT('print')"
                                        class="btn btn-dark btn-sm text-center hide"><i class="fa fa-print"></i>
                                </button>
                            </div>
                            <div class="col-md-5">
                                <p class="text-right">
                                    <b>Total Paid :</b> <span id="total_paid"></span> <br>
                                    <b>Total Due :</b> <span id="total_due"></span>
                                </p>
                            </div>
                        </div>
                        @if (count($students) > 0)
                            <table class="table table-bordered text-center">
                                <tr>
                                    <th rowspan="2" class="align-middle">SL</th>
                                    <th rowspan="2" class="align-middle">Name</th>
                                    <th rowspan="2" class="align-middle">Phone</th>
                                    <th colspan="4" class="align-middle">Details</th>
                                </tr>
                                <tr>
                                    <th>Course</th>
                                    <th>Batch</th>
                                    <th>Due</th>
                                    <th>Paid</th>
                                </tr>
                                @php($total_paid = 0)
                                @php($total_due = 0)
                                @foreach ($students as $sk => $student)
                                    <tr>
                                        <td rowspan="{{$student->courses->count()}}"
                                            class="align-middle">{{ ++$sk }}</td>
                                        <td rowspan="{{$student->courses->count()}}"
                                            class="align-middle">{{ $student->name ?? 'not set'}}</td>
                                        <td rowspan="{{$student->courses->count()}}"
                                            class="align-middle">{{$student->phone ?? 'not set'}}</td>
                                        @foreach($student->courses as $course)
                                                @if ($loop->first)

                                                    @php($total_paid += $course->paid_amount)
                                                    @php($total_due += $course->due_amount)

                                                    <td rowspan="1">{{$course->title ?? 'not set'}}</td>
                                                    <td rowspan="1">{{$course->batch ?? 'not set'}}</td>
                                                    <td rowspan="1">{{$course->due_amount ?? 'not set'}}</td>
                                                    <td rowspan="1">{{$course->paid_amount ?? 'not set'}}</td>
                                    </tr>
                                    @else

                                        @php($total_paid += $course->paid_amount)
                                        @php($total_due += $course->due_amount)

                                        <tr>
                                            <td rowspan="1">{{$course->title ?? 'not set'}}</td>
                                            <td rowspan="1">{{$course->batch ?? 'not set'}}</td>
                                            <td rowspan="1">{{$course->due_amount ?? 'not set'}}</td>
                                            <td rowspan="1">{{$course->paid_amount ?? 'not set'}}</td>
                                        </tr>
                                    @endif
                                @endforeach
                                @endforeach
                            </table>

                            <p class="text-right" style="display: none;">
                                <span id="total-paid">{{$total_paid}}</span>
                                <span id="total-due">{{$total_due}}</span>
                            </p>
                        @endif

                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        $(function () {
            $('#total_paid').html($('#total-paid').html());
            $('#total_due').html($('#total-due').html());
        });
        function printT(el) {
            console.log(el);
            var rp = document.body.innerHTML;
            $('.hide').addClass('d-none');
            var pc = document.getElementById(el).innerHTML;
            document.body.innerHTML = pc;
            document.title = 'Transaction-Report-Course-Type';
            window.print();
            document.body.innerHTML = rp;
        }
    </script>
@endpush
