@extends('layouts.master')

@section('title', 'Default Marketing List - European IT Solutions Institute')

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
                    <div class="card-body">
                        <form action="{{route('marketing.default.search')}}" class="form-inline" method="post">
                            @csrf
                            <div class="form-group mx-sm-3 mb-2">
                                <input type="date" class="form-control" name="fromDate" value="{{date('Y-m-01')}}" required>
                            </div>
                            <div class="form-group mx-sm-3 mb-2">
                                <input type="date" class="form-control" name="toDate" value="{{date('Y-m-d')}}" required>
                            </div>
                            <div class="form-group mx-sm-3 mb-2">
                                <select class="form-control" name="course" required>
                                    <option selected value="all">All</option>
                                    @foreach ($courses as $c)
                                        <option value="{{ $c->id }}">{{ $c->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <button type="submit" class="btn btn-outline-primary mb-2 ml-2">Search</button>
                        </form>
                    </div>
                </div>
                <br>
                <div class="card">
                    <div class="card-header">
                        <h4>Default Marketing List</h4>
                        {{--                        <input type="text" name="search">--}}
                        {{--                        <button id="search-submit">Search</button>--}}
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
                                    <th>Next Conversation Date</th>
                                    <th>Mobile</th>
                                    <th>Email</th>
                                    <th>Interested Course</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse ($marketings as $m)
                                    <tr class="tr" dataID="{{$m->id}}">
                                        <td>{{ $m->name }}</td>
                                        {{--                                        <td>{{ $m->next_date }}</td>--}}
                                        <td>{{ date('jS, F, Y', strtotime($m->next_date)) }}</td>
                                        <td>{{ $m->mobile }}</td>
                                        <td>{{ $m->email }}</td>
                                        <td>{{ $m->course }}</td>
                                        <td>
                                            <div class="btn-group">
                                                <a href="{{route('marketing.admitted', ['mid' => $m->id])}}"
                                                   onclick="return confirm('Are you sure, You want to admit this student ?')"
                                                   class="btn btn-sm btn-success m-1">
                                                    Admitted
                                                </a>
                                                <a href="{{route('marketing.notInterested', ['mid' => $m->id])}}"
                                                   onclick="return confirm('Are you sure, You want to move this person to not interested list ?')"
                                                   class="btn btn-sm btn-secondary m-1">
                                                    Not Interested
                                                </a>
                                                <a href="{{route('marketing.delete', ['mid' => $m->id])}}"
                                                   onclick="return confirm('Are you sure?')"
                                                   class="btn btn-sm btn-danger m-1">
                                                    <i class="fa fa-trash"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr class="child-row {{$m->id}}" style="background-color: #f5f0ed;">
                                        <th></th>
                                        <th>Conversation Date</th>
                                        <th>Converse With</th>
                                        <th colspan="4">Comment</th>
                                    </tr>
                                    @foreach($m->comments as $mc)
                                        <tr class="child-row {{$m->id}}" style="background-color: #f5f0ed;">
                                            <td></td>
                                            <td>{{date('jS, F, Y', strtotime($mc->date))}}</td>
                                            <td>{{$mc->converse_with}}</td>
                                            <td colspan="4">{{$mc->comment}}</td>
                                            {{--                                            <td></td>--}}
                                        </tr>
                                    @endforeach
                                    <tr class="child-row {{$m->id}}" style="background-color: #f5f0ed;">
                                        <th>Conversation Date</th>
                                        <th>Next Conversation Date</th>
                                        <th>Converse With</th>
                                        <th colspan="3">Comment</th>
                                        <th></th>
                                    </tr>
                                    <tr class="child-row {{$m->id}}" style="background-color: #f5f0ed;">
                                        <form action="{{route('marketing.comment.store', ['mid' => $m->id])}}"
                                              method="post">
                                            @csrf
                                            <td>
                                                <input type="date" class="form-control" name="date" required>
                                            </td>
                                            <td>
                                                <input type="date" class="form-control" name="nextDate" required>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control" name="converseWith" required
                                                       list="converseWith">
                                            </td>
                                            <td colspan="3">
                                                <textarea cols="30" rows="3" style="width: 100%;" class="form-control"
                                                          name="comment" required></textarea>
                                            </td>
                                            <td>
                                                <button class="btn btn-sm btn-outline-info" type="submit">Submit
                                                </button>
                                            </td>
                                        </form>
                                    </tr>
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
    <datalist id="converseWith">
        @forelse($datalist['converse_with'] as $cw)
            <option value="{{$cw->converse_with}}">
        @empty
        @endforelse
    </datalist>
@endsection
@push('js')
    {{--    <script src="{{ asset('assets/vendor/data-table/js/jquery-3.3.1.js') }}"></script>--}}
    {{--    <script src="{{ asset('assets/vendor/data-table/js/jquery.dataTables.min.js') }}"></script>--}}
    {{--    <script>--}}
    {{--        $('#table').DataTable();--}}
    {{--    </script>--}}
    <script>
        $(function () {
            $('.child-row').fadeOut(1);
            $('.tr').on('click', function () {
                var a = $(this).attr('dataID');
                $(".child-row").not('.' + a).fadeOut(1);
                $('.' + a).fadeToggle("slow");
            });
        });


        // $(document).on('click', '.tr', function () {
        //     var a = $(this).attr('dataID');
        //     if ($('.' + a).hasClass('d-none')) {
        //         $('.child-row').addClass('d-none');
        //         $('.' + a).removeClass('d-none');
        //     } else {
        //         $('.child-row').addClass('d-none');
        //     }
        // });
    </script>
@endpush
