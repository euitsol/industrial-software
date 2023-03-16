@extends('layouts.master')



@section('title', 'Analytics - European IT Solutions Institute')



@push('css')
    <link rel="stylesheet" href="{{ asset('assets/vendor/data-table/css/jquery.dataTables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/data-table/css/buttons.dataTables.min.css') }}">
@endpush



@section('content')

    <div class="container">

        <div class="row justify-content-center">
            <div class="col-md-10 col-lg-12">
                <div class="card">

                    <div class="card-header d-flex justify-content-between align-middle">

                        <div class="">

                            <h4>Student Account</h4>

                        </div>
                        <div>
                            <select id="session" class="form-control form-control-sm" style="width:35rem;">
                                <option value=" ">Select Session</option>
                                @foreach ($sessions as $_session)
                                    <option value="{{ $_session->id }}" {{ $check == $_session->id ? 'selected' : ''}}>
                                        {{ $_session->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="">

                            <a class="btn btn-sm btn-info" href="{{ route('analytics.source.add') }}">Add Source</a>

                            <a class="btn btn-sm btn-success" href="{{ route('analytics.referral.add') }}">Add Referral</a>

                        </div>

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



                        <div class="row">
                            <div class="col-md-6">
                                @if($topSources->count() != 0)
                                <canvas id="sourceChart"></canvas>
                                <p class="text-center mt-2">Top 5 student sources</p>
                                @else
                                <p class="text-center mt-2">No student found</p>
                                @endif
                            </div>

                            <div class="col-md-6">
                                @if($topReferrals->count() != 0)
                                <canvas id="sourceChartRef"></canvas>
                                <p class="text-center mt-2">Top 5 referrals</p>
                                @else
                                <p class="text-center mt-2">No student found</p>
                                @endif

                            </div>

                        </div>

                        <div class="row">

                            <canvas id="studentChart"></canvas>

                        </div>



                        

                    



                    </div>

                </div>

                {{-- source and refferal view --}}

                <div class="card mt-4">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <span class="float-left">
                                        <h4>Source Details</h4>
                                    </span>
                                </div>
                
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table id="table_one" class=" table display nowrap">
                                            <thead>
                                                <tr>
                                                    <th class="align-middle">SL</th>
                                                    <th class="align-middle">Name</th>
                                                    <th class="align-middle">Total Student</th>
                                                    <th class="align-middle">Status</th>
                                                    <th class="align-middle">Added by</th>
                                                    <th class="align-middle">Created at</th>
                                                    <th class="align-middle">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($sources as $key => $source)
                                                    <tr>
                                                        <td class="align-middle"> {{ $key + 1 }} </td>
                                                        <td class="align-middle"> {{ $source->name }} </td>
                                                        <td class="align-middle"> {{ number_format($source->students->count()) }} </td>
                                                        <td class="align-middle"> {{ $source->getStatus() }} </td>
                                                        <td class="align-middle"> {{ $source->created_user->name }} </td>
                                                        <td class="align-middle"> {{ $source->created_at }} </td>
                                                        <td class="align-middle">
                                                            <div class="btn-group">
                                                                <a href="{{ route('analytics.source.edit', $source->id) }}" class="btn btn-sm btn-info"><i class="fa fa-edit"></i></a>
                                                                <a href="{{ route('analytics.source.delete', $source->id) }}" onclick="return confirm('Are you sure?')" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></a>
                                                                @if($source->status == 1)
                                                                    <a href="{{route('analytics.source.status', $source->id)}}" class="btn btn-sm btn-warning"><i class="fa fa-times" style="padding: 0 2px"></i></a>
                                                                @else
                                                                    <a href="{{ route('analytics.source.status', $source->id) }}" class="btn btn-sm btn-success"><i class="fa fa-check"></i></a>
                                                                @endif
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
                        <div class="col-12">
                            <div class="card mt-4">
                                <div class="card-header">
                                    <span class="float-left">
                                        <h4>Referral Details</h4>
                                    </span>
                                </div>
                
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table id="table_two" class=" table display nowrap">
                                            <thead>
                                                <tr>
                                                    <th class="align-middle">SL</th>
                                                    <th class="align-middle">Name</th>
                                                    <th class="align-middle">Total Student</th>
                                                    <th class="align-middle">Status</th>
                                                    <th class="align-middle">Added by</th>
                                                    <th class="align-middle">Created at</th>
                                                    <th class="align-middle">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($referrals as $key => $referral)
                                                    <tr>
                                                        <td class="align-middle"> {{ $key + 1 }} </td>
                                                        <td class="align-middle"> {{ $referral->name }} </td>
                                                        <td class="align-middle"> {{ number_format($referral->students->count()) }} </td>
                                                        <td class="align-middle"> {{ $referral->getStatus() }} </td>
                                                        <td class="align-middle"> {{ $referral->created_user->name }} </td>
                                                        <td class="align-middle"> {{ $referral->created_at }} </td>
                                                        <td class="align-middle">
                                                            <div class="btn-group">
                                                                <a href="{{ route('analytics.referral.edit', $referral->id) }}" class="btn btn-sm btn-info"><i class="fa fa-edit"></i></a>
                                                                <a href="{{ route('analytics.referral.delete', $referral->id) }}" onclick="return confirm('Are you sure?')" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></a>
                                                                @if($referral->status == 1)
                                                                    <a href="{{route('analytics.referral.status', $referral->id)}}" class="btn btn-sm btn-warning"><i class="fa fa-times" style="padding: 0 2px"></i></a>
                                                                @else
                                                                    <a href="{{ route('analytics.referral.status', $referral->id) }}" class="btn btn-sm btn-success"><i class="fa fa-check"></i></a>
                                                                @endif
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

            </div>

        </div>

    </div>

@endsection



@push('js')
<script src="{{ asset('assets/vendor/data-table/js/jquery-3.3.1.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="{{ asset('assets/vendor/data-table/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/vendor/data-table/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('assets/vendor/data-table/js/pdfmake.min.js') }}"></script>
<script src="{{ asset('assets/vendor/data-table/js/vfs_fonts.js') }}"></script>
<script src="{{ asset('assets/vendor/data-table/js/buttons.html5.min.js') }}"></script>
<script src="{{ asset('assets/vendor/data-table/js/buttons.print.min.js') }}"></script>



<script>

 const ctx = document.getElementById('sourceChart');

    var chartData = {!! $topSources !!};

    var chartLabels = chartData.map(item => item.source.name);

    var chartCounts = chartData.map(item => item.count);

    new Chart(ctx, {

        type: 'doughnut',

        data:  {

        labels: chartLabels,

        datasets: [{

            label: 'Total Students',

            data: chartCounts,

            backgroundColor: [

            '#0099FF',

            '#FFD700',

            '#099587',

            '#F85D31',

            '#2C7873'

            ],

            hoverOffset: 4

        }]

        },

        options: {

        title: {

            display: true,

            text: 'Top Five Student Sources',

        }

        }

    });

</script>

<script>

 const crf = document.getElementById('sourceChartRef');

    var chartData = {!! $topReferrals !!};

    var chartLabels = chartData.map(item => item.referral.name);

    var chartCounts = chartData.map(item => item.count);

    new Chart(crf, {

        type: 'doughnut',

        data:  {

        labels: chartLabels,

        datasets: [{

            label: 'Total Students',

            data: chartCounts,

            backgroundColor: [

            '#0099FF',

            '#FFD700',

            '#099587',

            '#F85D31',

            '#2C7873'

            ],

            hoverOffset: 4

        }]

        },

        options: {

        title: {

            display: true,

            text: 'Top Five Referral',

        }

        }

    });

</script>

 <script>

        var data = {

    labels: {!! json_encode($students->pluck('month')->map(function ($month) {

        return DateTime::createFromFormat('!m', $month)->format('F');

    })) !!},

            datasets: [

                {

                    label: "Student Admission Growth",

                    backgroundColor: "rgba(255,99,132,0.2)",

                    borderColor: "rgba(255,99,132,1)",

                    borderWidth: 1,

                    data: {!! json_encode($students->pluck('total')) !!}

                }

            ]

        };



        var options = {

            scales: {

                yAxes: [{

                    ticks: {

                        beginAtZero: true

                    }

                }]

            }

        };



        var stx = document.getElementById("studentChart").getContext("2d");

        var myLineChart = new Chart(stx, {

            type: 'line',

            data: data,

            options: options

        });

    </script>

    {{-- Select Change Event --}}
    <script>
        $(document).ready(function () {
            $(document).on('change', '#session', function () {
                if ('' !== $(this).val()) {
                    let _url = '{{route('analytics', ['_session'])}}';
                    window.location.href = _url.replace('_session', $(this).val());
                }
            });
        });
    </script>

    {{-- dataTable --}}
    <script>
        $(document).ready(function () {
            $('#table_one').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'pdfHtml5',
                        title: 'Source Info'
                    },
                    {
                        extend: 'print',
                        exportOptions: {
                            columns: [0,1,2,3,4,5]
                        }
                    }, 'pageLength'
                ]
            });

            $('#table_two').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'pdfHtml5',
                        title: 'Referral Info'
                    },
                    {
                        extend: 'print',
                        exportOptions: {
                            columns: [0,1,2,3,4,5]
                        }
                    }, 'pageLength'
                ]
            });
        });
    </script>

@endpush