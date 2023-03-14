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
                    <span class="float-left">
                        <h4> Report </h4>
                    </span>
                        <span class="float-right">
                        <h4> Students by Division </h4>
                    </span>
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

                        <h4 class="font-weight-light text-center border-bottom pb-3 mb-3">
                            Division : {{ucfirst($division)}} - {{ $year }}
                            <span class="badge badge-success">{{$total_students}}</span>
                        </h4>

                        @if ($institutes->count() > 0)
                            @foreach ($institutes as $institute)
                                @if ($institute->students->where('year', '=', $year)->count() > 0)
                                    <p class="font-weight-bold">
                                        <i class="fa fa-school"></i> {{$institute->name}}
                                        <span class="badge badge-primary">{{$institute->students->where('year', '=', $year)->count()}}</span>
                                    </p>
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <tr>
                                                <th>SL</th>
                                                <th>Name</th>
                                                <th>Phone</th>
                                                <th>Courses</th>
                                            </tr>
                                            @foreach ($institute->students->where('year', '=', $year) as $sk => $student)
                                                <tr>
                                                    <td>{{ ++$sk }}</td>
                                                    <td>{{ $student->name }}</td>
                                                    <td>{{ $student->phone }}</td>
                                                    <td>
                                                        @foreach ($student->courses as $ck => $course)
                                                            <span class="">({{++$ck}})</span>
                                                            <span class="mr-2">{{$course->title}}</span>
                                                        @endforeach
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </table>
                                    </div>
                                @endif
                            @endforeach
                        @endif

                    </div>
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
    </script>
@endpush