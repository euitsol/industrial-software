@extends('layouts.master')

@section('title', 'Students - European IT Solutions Institute')

@push('css')

@endpush

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4> Students Paid Report </h4>
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

                        <h5 class="mb-4">Course Type : <span class="font-weight-normal">{{$course_type}}</span></h5>


                        @if (count($students) > 0)
                            <div class="table-responsive">
                                <table class="table table-bordered text-center">
                                    <tbody>
                                    <tr>
                                        <th rowspan="2" class="align-middle">SL</th>
                                        <th rowspan="2" class="align-middle">Name</th>
                                        <th rowspan="2" class="align-middle">Phone</th>
                                        <th colspan="4">Details</th>
                                    </tr>
                                    <tr>
                                        <th>Course</th>
                                        <th>Batch</th>
                                        <th>Amount</th>
                                    </tr>
                                    @php($total_paid = 0)
                                    @foreach ($students as $sk => $student)
                                        <tr>
                                            <td rowspan="{{ $student->courses->count() }}"
                                                class="align-middle">{{ ++$sk }}</td>
                                            <td rowspan="{{ $student->courses->count() }}"
                                                class="align-middle">{{ $student->name }}</td>
                                            <td rowspan="{{ $student->courses->count() }}"
                                                class="align-middle">{{ $student->phone }}</td>
                                            @if ($student->courses->count() > 0)
                                                @foreach ($student->courses as $course)
                                                    @if ($course->paid_status)
                                                        @if ($loop->first)

                                                            @php($total_paid += $course->paid_amount)

                                                            <td>{{ $course->title }}</td>
                                                            <td>{{ $course->batch }}</td>
                                                            <td>{{ $course->paid_amount }}</td>
                                        </tr>
                                        @else

                                            @php($total_paid += $course->paid_amount)

                                            <tr>
                                                <td>{{ $course->title }}</td>
                                                <td>{{ $course->batch }}</td>
                                                <td>{{ $course->paid_amount }}</td>
                                            </tr>
                                        @endif
                                        @endif
                                    @endforeach
                                    @endif
                                    @endforeach
                                    </tbody>
                                </table>

                                <p class="text-right">
                                    <b>Total Paid :</b> {{$total_paid}}
                                </p>
                            </div>
                        @endif

                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')

@endpush
