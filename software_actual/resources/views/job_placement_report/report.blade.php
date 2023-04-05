@extends('layouts.master')

@section('title', 'Job Placement Report - European IT Solutions Institute')

@push('css')

@endpush

@section('content')
    <div class="container" id="print">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Job Placement Report</h4>
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
                            <div class="mb-4 text-center">
                                <button type="button" onclick="printT('print')"
                                        class="btn btn-dark btn-sm text-center hide"><i class="fa fa-print"></i>
                                </button>
                            </div>

                        <div class="clearfix">
                            <p class="float-left">
                                <i class="fa fa-money-bill"></i>
                                <b>Job Placement Report:</b>  {{date('jS, F, Y', strtotime($from_date))}} - {{date('jS, F, Y', strtotime($to_date))}}
                                <br>
                                <span><b>Industrial Students</b></span>
                            </p>
                            <p class="float-right">
                                <b>Print Date : </b> {{ date('D d F, Y') }}
                            </p>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                @if(count($job_placements))
                                <tr>
                                    <th>SL</th>
                                    <th>Name</th>
                                    <th>Phone</th>
                                    <th>Course Batch</th>
                                    <th>Company Name</th>
                                    <th>Designation</th>
                                    <th>Joining Date</th>
                                    <th>Company Phone</th>
                                    <th>Company Website</th>
                                    <th class="hide">Action</th>
                                </tr>
                                @endif
                                </thead>
                                <tbody>
                                @forelse ($job_placements as $key => $jp)
                                    <tr>
                                        <td>{{ ++$key }}</td>
                                        <td>{{ $jp->student->name }}</td>
                                        <td>{{ $jp->student->phone }}</td>
                                        <td>
                                            @foreach($jp->student->courses as $key => $course)
                                                    {{$course->title}}
                                                @if(isset($jp->student->batches))
                                                    @foreach($jp->student->batches as $_batch)
                                                        @if($_batch->course_id == $course->id)
                                                            ({{batch_name($course->title_short_form, $_batch->year, $_batch->month, $_batch->batch_number)}})
                                                            @break
                                                        @endif
                                                    @endforeach
                                                @endif
                                            @endforeach
                                        </td>
                                        <td>{{ $jp->linkageIndustry->company_name }}</td>
                                        <td>{{ $jp->designation }}</td>
                                        <td>{{ date('jS, F, Y', strtotime($jp->joining_date)) }}</td>
                                        <td>{{ $jp->linkageIndustry->contact_number ?? "N/A" }}</td>
                                        <td>{{ $jp->linkageIndustry->company_website ?? "N/A" }}</td>
                                        <td class="hide">
                                            <a href="
                                            {{ route('student.job_placement.report.view', $jp->id) }}
                                            "
                                                class="btn btn-sm btn-dark">
                                                 <i class="fa fa-eye"></i>
                                             </a>
                                        </td>

                                    </tr>
                                @empty
                                <h4 class="text-center">Empty</h4>
                                @endforelse
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
    <script>
        function printT(el, title = '') {
            console.log(el);
            var rp = document.body.innerHTML;
            $('.hide').addClass('d-none');
            var pc = document.getElementById(el).innerHTML;
            document.body.innerHTML = pc;
            document.title = 'Job Placement Report';
            window.print();
            document.body.innerHTML = rp;
        }
    </script>
@endpush
