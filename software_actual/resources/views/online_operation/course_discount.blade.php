@extends('layouts.master')

@section('title', 'Course Discount - European IT Solutions Institute')

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
                                <span class="float-left">
                                    <h4>Course Discount </h4>
                                </span>
                                
                                <span class="float-right">
                                    <a href="{{ route('online_op.course_dis_create') }}" class="btn btn-primary btn-sm">Add New</a>
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
                                                <th class="text-left"> Course Name</th>
                                                <th class = "text-left" >Course Status </th>
                                                <th class = "text-left" >Discount Status </th>
                                                
                                                <th class = "text-left"> Discount </th>
                                                <th class = "text-left"> Course Fee </th>
                                                <th class="text-left"> Discounted Fee </th>
                                                <th class="text-left"> Action </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($course as $courses)
                                        @if(!isset($courses->end))
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
                                             <td class="align-middle">{{ optional($courses->discount)->title }}({{ optional($courses->discount)->type }})</td>                            <!-- **************Course Name -->

                                            <td  class = "align-middle">
                                                
                                                @if(optional($courses->discount)->status == "End")
                                                    <a class = "btn btn-danger" href="{{ route('course_status') }}">
                                                        End
                                                    </a>
                                                @else
                                                    <a class = "btn btn-primary" href="{{ route('course_status') }}">
                                                        Running
                                                    </a>
                                                @endif
                                            </td>
                                            <td  class = "align-middle">
                                                @if(isset($courses->end) || ($dis_2 == 0))
                                                    <abstract class = "btn btn-warning" href="{{ route('online_op.course_dis_update', $courses->id)}}">
                                                        Stop
                                                    </a>
                                                @else
                                                    <a class = "btn btn-primary" href="{{ route('online_op.course_dis_update', $courses->id)}}">
                                                        Running
                                                    </a>
                                                @endif
                                            </td>                                                
                                               
                                            <td class = "align-middle">                                                                       
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
                                            <td class = "align-middle">
                                                <a href="{{ route('online_op.course_dis_update', $courses->id)}}" class="btn btn-secondary btn-sm">Update Discount Status</a>
                                                <a href="{{ route('course_status') }}" class="btn btn-secondary btn-sm mt-1">Update Course Status</a>
                                            </td>
                                        </tr>
                                        @endif
                                        @endforeach
                                        </tbody>
                                        <tfoot class="text-primary">
                                            <tr>
                                                <th class="text-left"> Course Name</th>
                                                <th class = "text-left" >Course Status </th>
                                                <th class = "text-left" >Discount Status </th>
                                                
                                                <th class = "text-left"> Discount </th>
                                                <th class = "text-left"> Course Fee </th>
                                                <th class="text-left"> Discount Fee </th>
                                                <th class="text-left"> Done by </th>
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
                        title: 'Course Discount'
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
