@extends('layouts.master')

@push('css')
    <style>
        .dashboard-block {
            border: 1px solid darkgray;
            padding: 20px;
            text-align: center;
            font-size: 20px;
        }
    </style>
@endpush

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10 col-lg-12">
                <div class="card">
                    <div class="card-header">Dashboard</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <div class="row">
                            <div class="col-md-4">
                                <div class="dashboard-block shadow-sm">
                                    {{$sectors_count}} Sectors
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="dashboard-block shadow-sm">
                                    {{$courses->count()}} Courses
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="dashboard-block shadow-sm">
                                    {{$mentors_count}} Mentors
                                </div>
                            </div>
                        </div>

                        <div class="chart-holder mt-5 mb-5">
                            <canvas id="barChart1"></canvas>
                        </div>
                        
                        <div class="row">
                            
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="{{ asset('assets/vendor/chart.js/Chart.min.js') }}"></script>
    <script>
        // Charts Gradients
        let ctx1 = $("canvas").get(0).getContext("2d");
        let gradient1 = ctx1.createLinearGradient(150, 0, 150, 300);
        gradient1.addColorStop(0, 'rgba(210, 114, 181, 0.91)');
        gradient1.addColorStop(1, 'rgba(177, 62, 162, 0)');

        let gradient2 = ctx1.createLinearGradient(10, 0, 150, 300);
        gradient2.addColorStop(0, 'rgba(252, 117, 176, 0.84)');
        gradient2.addColorStop(1, 'rgba(250, 199, 106, 0.92)');


        let barChart1 = $('#barChart1');
        let barChartExample = new Chart(barChart1, {
            type: 'bar',
            options: {
                scales: {
                    xAxes: [{
                        display: true,
                        gridLines: {
                            color: '#fff'
                        },
                        ticks: {
                            autoSkip: false
                        }
                    }],
                    yAxes: [{
                        display: true,
                        ticks: {
                            max: parseInt({{$student_count_max}}),
                            min: parseInt({{$student_count_min}}),
                            fixedStepSize: 25
                        },
                        gridLines: {
                            color: '#fff'
                        }
                    }]
                },
                legend: false
            },
            data: {
                labels: [{!! rtrim($courses_title, ',') !!}],
                datasets: [
                    {
                        label: "Total Students",
                        backgroundColor: [
                            gradient2,
                            gradient2,
                            gradient2,
                            gradient2,
                            gradient2,
                            gradient2,
                            gradient2,
                            gradient2,
                            gradient2,
                            gradient2,
                            gradient2,
                            gradient2,
                            gradient2,
                            gradient2
                        ],
                        hoverBackgroundColor: [
                            gradient2,
                            gradient2,
                            gradient2,
                            gradient2,
                            gradient2,
                            gradient2,
                            gradient2,
                            gradient2,
                            gradient2,
                            gradient2,
                            gradient2,
                            gradient2,
                            gradient2,
                            gradient2
                        ],
                        borderColor: [
                            gradient2,
                            gradient2,
                            gradient2,
                            gradient2,
                            gradient2,
                            gradient2,
                            gradient2,
                            gradient2,
                            gradient2,
                            gradient2,
                            gradient2,
                            gradient2,
                            gradient2,
                            gradient2
                        ],
                        borderWidth: 1,
                        data: [{!! rtrim($courses_student, ',') !!}],
                    }
                ]
            }
        });
    </script>
@endpush
