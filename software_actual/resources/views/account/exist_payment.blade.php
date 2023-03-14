@extends('layouts.master')

@section('title', 'Exist Payment - European IT Solutions Institute')

@push('css')
    <style>
        #new_installment_button {
            text-decoration: none;
        }
    </style>
@endpush

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10 col-lg-12">
                <div class="card">
                    <div class="card-header">
                    <span class="float-left">
                        <h4>Payment</h4>
                    </span>
                        <span class="float-right">
                        <a href="{{ route('account.student.courses', $student->id) }}"
                           class="btn btn-info btn-sm">Back</a>
                    </span>
                    </div>

                    <div class="card-body">

                        <div class="row">
                            <div class="col-md-8">

                                @if(session('success'))
                                    <p class="alert alert-success text-center">
                                        {{ session('success') }}
                                    </p>
                                @elseif(session('error'))
                                    <p class="alert alert-danger text-center">
                                        {{ session('error') }}
                                    </p>
                                @endif

                                <table class="table table-borderless">
                                    <tr>
                                        <td>Course Fee</td>
                                        <td>:</td>
                                        <td>{{ number_format($course_fee, 2) }} Tk</td>
                                    </tr>
                                    <tr>
                                        <td>Discount</td>
                                        <td>:</td>
                                        <td>
                                            @if ($account->discount_percent > 0)
                                                {{$account->discount_percent}} %
                                            @elseif($account->discount_amount > 0)
                                                {{ number_format($account->discount_amount, 2) }} Tk
                                            @else 0 Tk @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Total Fee</td>
                                        <td>:</td>
                                        <td>{{ number_format($total_fee, 2) }} Tk</td>
                                    </tr>
                                    <tr>
                                        <td>Deposit</td>
                                        <td>:</td>
                                        <td>{{ number_format($payments->sum('amount'), 2) }} Tk</td>
                                    </tr>
                                    <tr>
                                        <td>Due</td>
                                        <td>:</td>
                                        <td>
                                            <span id="due">{{ number_format($due, 2) }}</span> Tk
                                        </td>
                                    </tr>

                                    @if (count($installment_dates) > 0 && $due > 0)
                                        <tr>
                                            <td>Installment Dates</td>
                                            <td>:</td>
                                            <td>
                                                <table>
                                                    @foreach($installment_dates as $key => $date)
                                                        <tr>
                                                            <td>{{ date('D d M, Y', strtotime($date)) }}</td>
                                                            <td>:</td>
                                                            <td>{{ number_format(ceil($installment_amount), 2) }} Tk</td>
                                                        </tr>
                                                    @endforeach
                                                </table>
                                            </td>
                                        </tr>
                                    @endif
                                </table>

                                @if (optional($payments)->sum('amount') < $total_fee)
                                    <form action="{{ route('payment.installment') }}" method="post" class="mt-4">
                                        @csrf

                                        <input type="hidden" name="account_id" value="{{ $account->id }}">
                                        <input type="hidden" name="_due" value="{{ $due }}">
                                        <input type="hidden" name="batch_name" value="{{batch_name($course->title_short_form, $batch->year, $batch->month, $batch->batch_number)}}">
                                        <div class="row">
                                            <div class="col-md-8 offset-md-2">

                                                <div class="form-group row">
                                                    <label for="" class="col-md-5">Installment Amount</label>
                                                    <div class="col-md-7">
                                                        <input type="number" name="amount" id="installment_amount" min="0"
                                                               class="form-control form-control-sm">
                                                        @if ($errors->has('amount'))
                                                            <span class="text-danger d-block">{{ $errors->first('amount') }}</span>
                                                        @endif
                                                        <div class="mt-2">
                                                            <a href="javascript:void(0)" id="new_installment_button">
                                                                <i class="fa fa-plus-circle"></i> New Installment
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group row" id="installment_quantity_wrapper" style="display: none;">
                                                    <label for="installment_quantity" class="col-md-5">Installment Quantity</label>
                                                    <div class="col-md-7">
                                                        <input type="number" name="installment_quantity" value="{{ old('installment_quantity') }}" id="installment_quantity" min="0" class="form-control form-control-sm">
                                                    </div>
                                                </div>

                                                {{--Installment new dates--}}
                                                <div id="installment_dates"></div>
                                                
                                                <div class="form-group row">
                                                    <div class="col-md-5"></div>
                                                    <div class="col-md-7">
                                                        <input type="submit" value="Submit" class="btn btn-primary">
                                                    </div>
                                                </div>

                                            </div>
                                        </div>

                                    </form>
                                @endif

                                @if (optional($payments)->sum('amount') >= $total_fee)
                                    <div class="text-center p-2 text-success">
                                        <p style="font-size: 50px"><i class="fas fa-check"></i></p>
                                        <p>Payment Status : Completed</p>
                                    </div>
                                @endif

                                @if ($payments->count() > 0)

                                    <p class="text-right">
                                        <a href="{{route('payment.receipt',['aid'=>$account->id, 'pid' => 'null' ])}}"
                                           class="btn btn-dark btn-sm">
                                            <i class="fa fa-file"></i> Money Receipt
                                        </a>
                                    </p>

                                    <table class="table table-bordered">
                                        <tr>
                                            <th># SL</th>
                                            <th>Date</th>
                                            <th>Amount</th>
                                            <th>Print</th>
                                        </tr>
                                        @foreach ($payments as $k => $item)
                                            <tr>
                                                <td>{{ $k + 1 }}</td>
                                                <td>{{ date('D d M, Y', strtotime($item->created_at)) }}</td>
                                                <td>{{ number_format($item->amount, 2) }}</td>
                                                <td><a href="{{route('payment.receipt',['aid'=>$account->id,'pid'=>$item->id])}}" class="btn btn-dark btn-sm">
                                                    <i class="fa fa-file"></i>  {{$item->id}}
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </table>
                                @endif

                            </div>
                            <div class="col-md-4">
                                <table class="table table-borderless border table-striped">
                                    <tr>
                                        <td>Student ID</td>
                                        <td>:</td>
                                        <td>{{ $student->year.$student->reg_no }}</td>
                                    </tr>
                                    <tr>
                                        <td>Name</td>
                                        <td>:</td>
                                        <td>{{ $student->name }}</td>
                                    </tr>
                                    <tr>
                                        <td>Father's Name</td>
                                        <td>:</td>
                                        <td>{{ $student->fathers_name }}</td>
                                    </tr>
                                    <tr>
                                        <td>Course</td>
                                        <td>:</td>
                                        <td>{{ $course->title }}</td>
                                    </tr>
                                    <tr>
                                        <td>Batch</td>
                                        <td>:</td>
                                        <td>{{batch_name($course->title_short_form, $batch->year, $batch->month, $batch->batch_number)}}</td>
                                    </tr>
                                    <tr>
                                        <td>Student As</td>
                                        <td>:</td>
                                        <td>{{ $student->student_as }}</td>
                                    </tr>
                                    <tr>
                                        <td>Phone</td>
                                        <td>:</td>
                                        <td>{{ $student->phone }}</td>
                                    </tr>
                                    <tr>
                                        <td>Present Address</td>
                                        <td>:</td>
                                        <td>{{ $student->present_address }}</td>
                                    </tr>
                                    @if (isset($student->photo))
                                        <tr>
                                            <td>Photo</td>
                                            <td>:</td>
                                            <td><img src="{{asset($student->photo)}}" style="height: 120px;" alt="">
                                            </td>
                                        </tr>
                                    @endif
                                </table>
                                @if(Auth::id() == 7)
                                    <hr>
                                    <form action="{{route('anytime.discount', ['aid' => $account->id])}}" method="post">
                                        @csrf
                                        <input type="hidden" name="_due" value="{{ $due }}" required>
                                        <div class="form-group row">
                                            <div class="col-md-6">
                                                <input type="number" placeholder="Discount Amount" min="0"
                                                       name="discount"
                                                       class="form-control form-control-sm" max="{{$due}}"
                                                       step="0.01" required>
                                            </div>
                                            <div class="col-md-6">
                                                <button type="submit" class="btn btn-sm btn-outline-dark mt-1">
                                                    Discount
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                @endif
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
        let due = $('#due');
        if (due.text() > 0 && '' !== due.text()) {
            $('#installment_amount').val(Math.ceil($('#due').text()));
        }

        $(document).on('click', '#new_installment_button', function () {
            $('#installment_quantity').val('');
            $('#installment_dates').html('');
            $('#installment_quantity_wrapper').slideToggle();
        });

        $(document).on('change keyup focusout', '#installment_quantity', function () {
            let this_val = $(this).val();
            if (this_val !== '' && this_val > 0) {
                let output = `
                    <div class="form-group row">
                        <label class="col-md-5">Installment Dates</label>
                        <div class="col-md-7">
                `;
                for (let i = 0; i < this_val; i++) {
                    output += '<input type="date" name="installment_date[]" class="form-control form-control-sm mb-1">';
                }
                output += '</div></div>';
                $('#installment_dates').html(output);
            } else {
                $('#installment_dates').html('');
            }
        });
    </script>
@endpush