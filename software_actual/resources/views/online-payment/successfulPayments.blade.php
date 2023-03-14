@extends('layouts.master')

@section('title', 'All transactions - European IT Solutions Institute')

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
                            <h4>All Transactions</h4>
                        </span>
                        <span class="float-right">
                            <a href="{{ route('op.index') }}" class="btn btn-info">Pay</a>
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
                        <div class="table-responsive">
                            <table id="table" class="display nowrap">
                                <thead>
                                    <tr>
                                        <th>transaction Id</th>
                                        <th>Name</th>
                                        <th>Phone Number</th>
                                        <th>Course</th>
                                        <th>Amount</th>
                                        <th>Created At</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($online_payments as $key => $online_payment)
                                        <tr>
                                            
                                            <td> {{ $online_payment->transaction_id }} </td>
                                            @if($online_payment->student_id !=null)
                                                <td> {{ $online_payment->student->name }} </td>
                                                <td> {{ $online_payment->student->phone }} </td>
                                            @elseif($online_payment->online_reg_id !=null)
                                                <td> {{ $online_payment->online_student->name }} </td>
                                                <td> {{ $online_payment->online_student->phone }} </td>
                                            @endif
                                            <td> {{ $online_payment->course->title }} </td>
                                            <td> {{ $online_payment->amount .' '. $online_payment->currency }} </td>
                                            <td> {{  date('d-m-Y h:m:s', strtotime($online_payment->created_at)) }} </td>
                                            <td> {{ $online_payment->status }} </td>
                                            
                                        </tr>
                                    @endforeach
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
    <script src="{{ asset('assets/vendor/data-table/js/jquery-3.3.1.js') }}"></script>
    <script src="{{ asset('assets/vendor/data-table/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/data-table/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/data-table/js/pdfmake.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/data-table/js/vfs_fonts.js') }}"></script>
    <script src="{{ asset('assets/vendor/data-table/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/data-table/js/buttons.print.min.js') }}"></script>
    <script>
        $(document).ready(function () {
            $('#table').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'pdfHtml5',
                    },
                    {
                        extend: 'print',
                        exportOptions: {
                            columns: [0,1,2,3,4,5]
                        }
                    }, 'pageLength'
                ]
            });

        });
    </script>
@endpush