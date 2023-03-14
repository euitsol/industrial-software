@extends('layouts.master')

@section('title', 'Teacher Payment Setup - European IT Solutions Institute')

@push('css')

@endpush

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10 col-lg-12">
                <div class="card">
                    <div class="card-header">
                    <span class="float-left">
                        <h4>Teacher Payment Setup</h4>
                    </span>
                        <span class="float-right">
                        <a href="{{ route('teacher.payment.setup') }}" class="btn btn-primary btn-sm">Add New</a>
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

                        @if ($tpi_years->count() > 0)
                            <div class="row my-3">
                                <div class="col-md-6 offset-md-3">
                                    <div class="form-group row">
                                        <label for="tpi_year" class="col-md-2 form-control-label">Year</label>
                                        <div class="col-md-10">
                                            <select id="tpi_year" class="form-control">
                                                @foreach ($tpi_years as $tpi_year)
                                                    <option value="{{ $tpi_year->year }}" {{ $year == $tpi_year->year ? 'selected' : '' }}>{{ $tpi_year->year }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        @if ($tpis->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <tr>
                                        <th>SL</th>
                                        <th>Institute</th>
                                        <th>Responsible Teacher</th>
                                        <th>Designation</th>
                                        <th>Phone</th>
                                        <th>Per Student Payment</th>
                                        <th>Action</th>
                                    </tr>
                                    @foreach ($tpis as $tpi_k => $tpi)
                                        <tr>
                                            <td>{{ ++$tpi_k }}</td>
                                            <td>{{ $tpi->institute->name ?? '' }}</td>
                                            <td>{{ $tpi->teacher->name ?? ''}}</td>
                                            <td>{{$tpi->teacher->designation ?? ''}}</td>
                                            <td>{{ $tpi->teacher->phones[0]->phone ?? '' }}</td>
                                            <td>{{ number_format($tpi->per_student_payment, 2) }}</td>
                                            <td>
                                                <div class="btn-group">
                                                    <a href="{{ route('teacher.payment.setup.edit', $tpi->id) }}"
                                                       class="btn btn-sm btn-info">
                                                        <i class="fa fa-edit"></i>
                                                    </a>
                                                    <a href="javascript:void(0)" class="btn btn-sm btn-danger"
                                                       id="delete_button">
                                                        <i class="fa fa-trash"></i>
                                                    </a>

                                                    <form action="{{ route('teacher.payment.setup.delete') }}" method="post"
                                                          id="delete_form">
                                                        @csrf
                                                        <input type="hidden" name="id" value="{{ $tpi->id }}">
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </table>
                            </div>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script type="text/javascript">
        $(document).on('change', '#tpi_year', function () {
            let tpi_year = $(this);
            if ('' !== tpi_year.val()) {
                let url = '{{ route('teacher.payment.setup.index', 'year') }}';
                window.location.href = url.replace('year', tpi_year.val());
            }
        });
        $(document).on('click', '#delete_button', function () {
            if (confirm('Are you sure?')) {
                $('#delete_form').submit();
            }
        });
    </script>
@endpush