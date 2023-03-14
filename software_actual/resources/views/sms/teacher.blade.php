@extends('layouts.master')

@section('title', 'SMS- European IT Solutions Institute')

@push('css')

@endpush

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10 col-lg-12">
                <div class="card">
                    <div class="card-header">
                    <span class="float-left">
                        <h4>Teacher Message</hh4>
                    </span>
                        
                    </div>

                    <div class="card-body">
                        <form action="{{ route('sms.teacher.send')}}" method="post">
                        @csrf

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
                                <table class="table table-bordered text-center">
                                    <tr>
                                        <th class="align-middle">SL</th>
                                        <th class="align-middle">Institute</th>
                                        <th class="align-middle">Responsible Teacher</th>
                                        <th class="align-middle">Designation</th>
                                        <th class="align-middle">Phone</th>
                                        <th class="align-middle">Per Student Payment</th>
                                        <th class="align-middle">SMS</th>
                                    </tr>
                                    @foreach ($tpis as $tpi_k => $tpi)
                                        <tr>
                                            <td class="align-middle">{{ ++$tpi_k }}</td>
                                            <td class="align-middle">{{ $tpi->institute->name ?? '' }}</td>
                                            <td class="align-middle">{{ $tpi->teacher->name ?? ''}}</td>
                                            <td class="align-middle">{{$tpi->teacher->designation ?? ''}}</td>
                                            <td class="align-middle">{{ $tpi->teacher->phones[0]->phone ?? '' }}</td>
                                            <td class="align-middle">{{ number_format($tpi->per_student_payment, 2) }}</td>
                                            <td class="align-middle">
                                                <div class="btn-group">
                                                    
                                                        
                                                        <input type="checkbox" name="teacher_phone[]" value="{{ $tpi->teacher->phones[0]->phone ?? '' }}">
                                                    
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </table>
                            </div>
                        @endif                                                        
                                <div class="row mt-3">
                                    <div class="col-md-8 offset-md-2">
                                        <div class="form-group">
                                            <label for="message">Message <span class="text-danger">*</span></label>
                                            <div class="mb-2 ">Dear Sir,</div>
                                            <textarea name="message" id="message"
                                                      class="form-control mb-2" required></textarea>
                                            <div>
                                                Sincerely, <br>
                                                European IT Institute <br>
                                                Contact Us: 01889977951
                                            </div>
                                            @if ($errors->has('message'))
                                                <span class="text-danger">{{ $errors->first('message') }}</span>
                                            @endif
                                        </div>
                                        
                                        <div class="form-group">
                                            <input type="submit" value="Send" class="btn btn-primary">
                                        </div>
                                    </div>
                                </div>
                        </form>

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
                let url = '{{ route('sms.teacher', 'year') }}';
                window.location.href = url.replace('year', tpi_year.val());
            }
        });

    </script>
@endpush