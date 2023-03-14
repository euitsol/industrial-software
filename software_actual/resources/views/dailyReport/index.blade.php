@extends('layouts.master')

@section('title', 'Daily Report')

@push('css')

@endpush

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <span class="float-left">
                            <h4>Today</h4>
                        </span>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-8 offset-md-2">
                                <div class="table-responsive">
                                    <table class="table table-borderless table-striped">
                                        <tr>
                                            <th>Students</th>
                                            <th>Amounts</th>
                                        </tr>
                                        <tr>
                                            <td>{{$tst}}</td>
                                            <td>{{$tat}}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="col-md-10 col-lg-12 mt-3">
                <div class="card">
                    <div class="card-header">
                        <span class="float-left">
                            <h4>Total</h4>
                        </span>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-8 offset-md-2">
                                <div class="table-responsive">
                                    <table class="table table-borderless table-striped">
                                        <tr>
                                            <th>Students</th>
                                            <th>Amounts</th>
                                        </tr>
                                        <tr>
                                            <td>{{$ts}}</td>
                                            <td>{{$ta}}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <div class="col-md-10 col-lg-12 mt-3">
                <div class="card">
                    <div class="card-header">
                        <span class="float-left">
                            <input type="date" value="{{Carbon\Carbon::now()->format('Y-m-d')}}" id="dateInput">
                        </span>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-8 offset-md-2">
                                <div class="table-responsive">
                                    <table class="table table-borderless table-striped">
                                        <tr>
                                            <th>Students</th>
                                            <th>Amounts</th>
                                        </tr>
                                        <tr>
                                            <td id="totalS">{{$tst}}</td>
                                            <td id="totalA">{{$tat}}</td>
                                        </tr>
                                    </table>
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
    <script>
        $(function () {
            $("#dateInput").on('change', function () {
                var date = $("#dateInput").val();
                $.ajax({
                    url: '/daily-report/ajax',
                    method: "GET",
                    data: {date: date},
                    success: function (r) {
                        $("#totalS").html(r[0]);
                        $("#totalA").html(r[1]);
                    }
                });
            })
        })
    </script>
@endpush

