@extends('layouts.master')

@section('title', 'Not Interested Marketing List - European IT Solutions Institute')

{{--@push('css')--}}
{{--    <link rel="stylesheet" href="{{ asset('assets/vendor/data-table/css/jquery.dataTables.min.css') }}">--}}
{{--    <link rel="stylesheet" href="{{ asset('assets/vendor/data-table/css/buttons.dataTables.min.css') }}">--}}
{{--    <style>--}}
{{--        * {--}}
{{--            transition: all 3s !important;--}}
{{--        }--}}
{{--    </style>--}}
{{--@endpush--}}

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10 col-lg-12">
                <div class="card">
                    <div class="card-header text-center">
                        <span class="float-left"><h4>Not Interested Marketing Search List</h4></span>
                        <span>
                            <button type="button" onclick="printT('print-student')"
                                    class="btn btn-dark btn-sm text-center"><i class="fa fa-print"></i>
                            </button>
                        </span>
                        <span class="float-right">
                            <a href="{{route('marketing.not.interested.list')}}" class="btn btn-sm btn-info">Back</a>
                        </span>
                    </div>
                    <div class="card-body">
                        @if(session('success'))
                            <p class="alert alert-success text-center">
                                {{ session('success') }}
                            </p>
                        @elseif(session('unsuccess'))
                            <p class="alert alert-danger text-center">
                                {{ session('unsuccess') }}
                            </p>
                        @endif
                        <div class="table-responsive" id="print-student">
                            <table class="table" id="table">
                                <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Next Conversation Date</th>
                                    <th>Mobile</th>
                                    <th>Email</th>
                                    <th>Interested Course</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse ($marketings as $m)
                                    <tr>
                                        <td>{{ $m->name }}</td>
                                        <td>{{ date('jS, F, Y', strtotime($m->next_date)) }}</td>
                                        <td>{{ $m->mobile }}</td>
                                        <td>{{ $m->email }}</td>
                                        <td>{{ $m->course }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="text-danger">Nothing Found to be shown</td>
                                    </tr>
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
        function printT(el) {
            var rp = document.body.innerHTML;
            var pc = document.getElementById(el).innerHTML;
            document.body.innerHTML = pc;
            document.title = 'marketing-default-list';
            window.print();
            document.body.innerHTML = rp;
        }
    </script>
@endpush
