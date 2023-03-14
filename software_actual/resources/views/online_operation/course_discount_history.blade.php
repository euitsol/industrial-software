@extends('layouts.master')

@section('title', 'Course Discount History - European IT Solutions Institute')

@push('css')
<link rel="stylesheet" href="{{ asset('assets/vendor/data-table/css/jquery.dataTables.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/vendor/data-table/css/buttons.dataTables.min.css') }}">
<style>

.row a{
    text-decoration: none;
}
*{
    font-size: 16px;
}

</style>
@endpush

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10 col-lg-12">                                                       
                        <div class="card">
                            <div class="card-header">
                                <span class="text-center">
                                    <h5>Course Discount History </h5>
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
                                <div class="table-responsive ps">
                                    <table class="table table-striped" id="table_one">
                                        <thead class="text-primary">
                                            <tr>
                                                <th class="align-middle"> Course Name</th>
                                                <th class = "align-middle" >Discount Status </th>
                                                <th class = "align-middle" > Start Date </th>
                                                <th class = "align-middle" > End Date </th>
                                                <th class = "align-middle"> Discount </th>
                                                <th class = "align-middle"> Course Fee </th>
                                                <th class="align-middle"> Discount Fee </th>
                                                <th class="align-middle"> Done by </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($course as $courses)
                                        @php
                                                    $currency = "";
                                                    $dis_1 = 0;
                                                    $dis_2 = 0;
                                                    $fee = optional($courses->discount)->fee;
                                                   
                                                        
                                                            if (isset($courses->discount_percent) && $courses->discount_percent > 0) {
                                                                $dis_1 = $courses->discount_percent;
                                                                $currency = "Persent";
                                                                $dis_2 = ($courses->discount_percent * $fee) / 100  ;
                                                            } elseif (isset($courses->discount_amount) && $courses->discount_amount > 0) {
                                                                $dis_1 = $courses->discount_amount;
                                                                $currency = "Tk";
                                                                $dis_2 = $courses->discount_amount;
                                                            } else {
                                                                $dis_1 = 0;
                                                                $currency = "Tk";
                                                                $dis_2 = 0;
                                                            }
                                                        
                                                    
                                                                            
                                                    $total_fee =  $fee - $dis_2;  

                                            @endphp
                                        <tr>
                                            <td class="align-middle">{{ optional($courses->discount)->title }}({{ optional($courses->discount)->type }})---
                                            @if(isset($courses->discount_percent))
                                                {{ $courses->discount_percent }}%
                                            @endif
                                            @if(isset($courses->discount_amount))
                                                {{ $courses->discount_amount }} Tk
                                            @endif
                                            </td>                            <!-- **************Course Name -->

                                            <td  class = "align-middle">
                                                @if(isset($courses->end))
                                                        <div class = "btn btn-danger">
                                                            End
                                                        </div>
                                                    @elseif($dis_2 == 0)
                                                        <div class = "btn btn-warning">
                                                            Stop
                                                        </div>
                                                    @else
                                                        <div class = "btn btn-primary">
                                                            Running
                                                        </div>
                                                @endif
                                            </td>                                                <!-- **************Status -->
                                            <td  class = "align-middle">{{ $courses->start }}</td>
                                            <td  class = "align-middle">{{ $courses->end }}</td>   
                                            <td class = "align-middle">                                                                         <!-- **************Discount -->
                                            @if(isset($courses->discount_percent))
                                                {{ $courses->discount_percent }}%
                                            @endif
                                            @if(isset($courses->discount_amount))
                                                {{ $courses->discount_amount }} Tk
                                            @endif
                                            </td>
                                            
                                            <td class = "align-middle">{{ optional($courses->discount)->fee }}Tk</td>
                                            <td class = "align-middle">

                                                {{$total_fee}}
                                            </td>
                                            <td>{{ optional($courses->user)->name }}</td>
                                        </tr>
                                        @endforeach
                                        </tbody>
                                        <tfoot class="text-primary">
                                            <tr>
                                                <th class="align-middle"> Course Name</th>
                                                <th class = "align-middle" >Discount Status </th>
                                                <th class = "align-middle" > Start Date </th>
                                                <th class = "align-middle" > End Date </th>
                                                <th class = "align-middle"> Discount </th>
                                                <th class = "align-middle"> Course Fee </th>
                                                <th class="align-middle"> Discount Fee </th>
                                                <th class="align-middle"> Done by </th>
                                            </tr>
                                        </tfoot>
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
            $('#table_one').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'pdfHtml5',
                        title: 'Course Discount History'
                    },
                    {
                        extend: 'print',
                        exportOptions: {
                            columns: [0,1,2,3,4]
                        }
                    }, 'pageLength'
                ]
            });


        });
    </script>
@endpush
