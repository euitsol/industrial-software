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
                        <h4> Today Installment Dates </h4>
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

                        @if(session('_errors'))
                            <p class="alert alert-danger text-center">
                                @foreach(session('_errors') as $error)
                                    {{ $error }} <br>
                                @endforeach
                            </p>
                        @endif

                        <p class="text-center">
                            <b>Date :</b> {{ date('D d F, Y') }}
                        </p>

                        @if ($dates->count() > 0)

                            <form action="{{ route('student.installment.message') }}" method="post">
                                @csrf

                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <tr>
                                            <th>SL</th>
                                            <th>Batch</th>
                                            <th>Name</th>
                                            <th>Phone</th>
                                            <th>Student As</th>
                                            <th>Due</th>
                                            <th class="text-center">SMS</th>
                                        </tr>
                                        @foreach ($dates as $dk => $date)
                                            <tr>
                                                <td>{{ ++$dk }}</td>
                                                <td>{{ $date->batch }}</td>
                                                <td>{{ $date->student_name }}</td>
                                                <td>{{ $date->student_phone }}</td>
                                                <td>{{ $date->student_as }}</td>
                                                <td>{{ $date->due }}</td>
                                                <td class="text-center">
                                                    <input type="checkbox" name="student_id[]"
                                                           value="{{ $date->student_id }}" checked>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </table>
                                </div>

                                <div class="row mt-3">
                                    <div class="col-md-8 offset-md-2">
                                        <div class="form-group">
                                            <label for="message">Message <span class="text-danger">*</span></label>
                                            <div class="mb-2">Dear ____________________,</div>
                                            <textarea name="message" id="message"
                                                      class="form-control mb-2">{{ installment_message() }}</textarea>
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