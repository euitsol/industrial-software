@extends('layouts.master')

@section('title', 'Cash To Bank - European IT Solutions Institute')

@push('css')
    <link rel="stylesheet" href="{{ asset('assets/vendor/data-table/css/jquery.dataTables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/data-table/css/buttons.dataTables.min.css') }}">
@endpush

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10 col-lg-12">
                <div class="card">
                    <div class="card-header">
                    <span class="float-left">
                        <h4> Detail Report 
                            <span class="text-danger">
                                
                            </span>
                        </h4>
                    </span>
                    <span class="float-right">
                        <a href="{{ route('ctb') }}" class="btn btn-success ml-1">Back</a>
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


                        @if ($payments->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-bordered display nowrap" id="table_one">
                                    <thead>
                                    <tr>
                                        <th class="text-center align-middle">SL</th>
                                        <th class="text-center align-middle">Student Name</th>
                                        <th class="text-center align-middle">Phone</th>
                                        <th class="text-center align-middle">Student as</th>
                                        <th class="text-center align-middle">Course</th>
                                        <th class="text-center align-middle">Batch</th>
                                        <th class="text-center align-middle">Amount</th>
                                        <th class="text-center align-middle">Payment Date</th>
                                        <th class="text-center align-middle">Done by</th>
                                        <th class="text-center align-middle">Transfer Note</th>
                                        <th class="text-center align-middle">Status</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @forelse($payments as $key => $payment)
                                        <tr>
                                            <td class="text-center align-middle">{{++$key}}</td>
                                            <td class="text-center align-middle">{{optional($payment->account)->student->name}}</td>
                                            <td class="text-center align-middle">{{optional($payment->account)->student->phone}}</td>
                                            <td class="text-center align-middle">{{optional($payment->account)->student->student_as}}</td>
                                            <td class="text-center align-middle">{{optional($payment->account)->course->title}}</td>
                                            <td class="text-center align-middle">
                                                {{
                                                    batch_name(optional($payment->account)->course->title_short_form, $payment->account->student->batches->where('course_id', optional($payment->account)->course->id)->first()->year, $payment->account->student->batches->where('course_id', optional($payment->account)->course->id)->first()->month, $payment->account->student->batches->where('course_id', optional($payment->account)->course->id)->first()->batch_number)

                                                }}
                                            </td>
                                            <td class="text-center align-middle">{{number_format($payment->amount,2)}}</td>
                                            <td class="text-center align-middle">{{ date('d-m-y h:m A', strtotime($payment->created_at)) }}</td>
                                            <td class="text-center align-middle">{{optional($payment->user)->name}}</td>
                                            <td class="text-center align-middle">
                                                @if($payment->cashtobank <= 0 )
                                                    Not Transferred Yet
                                                @else
                                                    @php
                                                        $note = App\Models\CashToBank::findOrFail($payment->cashtobank);
                                                    @endphp   
                                                    {{ $note->note }}
                                                @endif

                                                </td>
                                            <td class="text-center align-middle">
                                                @if($payment->cashtobank > 0)
                                                    <button class="btn btn-success">Transferred</button>
                                                @else
                                                    <button class="btn btn-danger">Cash</button>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty

                                    @endforelse
                                    </tbody>
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
    <script src="{{ asset('assets/vendor/data-table/js/jquery-3.3.1.js') }}"></script>
    <script src="{{ asset('assets/vendor/data-table/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/data-table/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/data-table/js/pdfmake.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/data-table/js/vfs_fonts.js') }}"></script>
    <script src="{{ asset('assets/vendor/data-table/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/data-table/js/buttons.print.min.js') }}"></script>
    <script>
        $(document).ready(function () {
            $('#table_one').DataTable({
                dom: 'Bfrtip',
                buttons: [ 'pageLength', 'pdf', 'print']
            });

        });
    </script>
@endpush