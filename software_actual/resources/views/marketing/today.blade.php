@extends('layouts.master')

@section('title', 'Today Conversation List - European IT Solutions Institute')

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
                    <div class="card-header">
                        <h4>Today's Conversation List</h4>
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
                        <div class="table-responsive">
                            <table class="table" id="table">
                                <thead>
                                <tr>
                                    <th>Name</th>
{{--                                    <th>Next Conversation Date</th>--}}
                                    <th>Mobile</th>
                                    <th>Email</th>
                                    <th colspan="2">Interested Course</th>
{{--                                    <th>Action</th>--}}
                                </tr>
                                </thead>
                                <tbody>
                                @forelse ($marketings as $m)
                                    <tr class="tr" dataID="{{$m->id}}">
                                        <td>{{ $m->name }}</td>
{{--                                        <td>{{ date('jS, F, Y', strtotime($m->next_date)) }}</td>--}}
                                        <td>{{ $m->mobile }}</td>
                                        <td>{{ $m->email }}</td>
                                        <td colspan="2">{{ $m->course }}</td>
                                    </tr>
                                    <tr class="child-row {{$m->id}}" style="background-color: #f5f0ed;">
                                        <th></th>
                                        <th>Converse With</th>
                                        <th>Conversation Date</th>
                                        <th colspan="2">Comment</th>
                                    </tr>
                                    @foreach($m->comments as $mc)
                                        <tr class="child-row {{$m->id}}" style="background-color: #f5f0ed;">
                                            <td></td>
                                            <td>{{$mc->converse_with}}</td>
                                            <td>{{$mc->date}}</td>
                                            <td colspan="2">{{$mc->comment}}</td>
                                        </tr>
                                    @endforeach
                                @empty
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
        $(function () {
            $('.child-row').fadeOut(1);
            $('.tr').on('click', function(){
                var a = $(this).attr('dataID');
                $(".child-row").not('.' + a).fadeOut(1);
                $('.' + a).fadeToggle("slow");
            });
        });
    </script>
@endpush
