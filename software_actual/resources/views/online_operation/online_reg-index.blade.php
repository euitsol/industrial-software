@extends('layouts.master')

@section('title', 'Online registration - European IT Solutions Institute')

@push('css')
<link rel="stylesheet" href="{{ asset('assets/vendor/data-table/css/jquery.dataTables.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/vendor/data-table/css/buttons.dataTables.min.css') }}">
<style type="text/css">
  
</style>
@endpush

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10 col-lg-12">
                <div class="card">
                    <div class="card-header">
                    <span class="float-left">
                        <h4>Online Registration Dashboard</h4>
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


                        <div class="row">
                            <div class="col bg-info m-1 rounded p-1">
                                <div class="card rounded m-auto p-3">
                                        
                                    <div class=" card-header">
                                                
                                        <h6 class="p-1 m-1 text-center">Total Registrated</h6>

                                    </div>
                                    <div class="card-body p-0">
                                                
                                        <div class="text-center text-primary total" style="font-size: 50px;">
                                            <p >{{$total}}</p>
                                        </div>
                                                
                                    </div>

                                </div>
                            </div>
                            <div class="col bg-info m-1 rounded p-1">
                                <div class="card rounded m-auto p-3">
                                        
                                    <div class=" card-header">
                                                
                                        <h6 class="p-1 m-1 text-center">This Month Registrated</h6>

                                    </div>
                                    <div class="card-body p-0">
                                                
                                        <div class="text-center text-primary this_month" style="font-size: 50px;">
                                            <p >{{$this_month}}</p>
                                        </div>
                                                
                                    </div>

                                </div>
                            </div>
                            <div class="col bg-info m-1 rounded p-1">
                                <div class="card rounded m-auto p-3">
                                        
                                    <div class=" card-header">
                                                
                                        <h6 class="p-1 m-1 text-center">This Week Registrated</h6>

                                    </div>
                                    <div class="card-body p-0">
                                                
                                        <div class="text-center text-primary this_week" style="font-size: 50px;">
                                            <p >{{$this_week }}</p>
                                        </div>
                                                
                                    </div>

                                </div>
                            </div>

                        </div>
                        <div class = "card mt-5">
                            <div class = "card-header">
                                <h6 class = "text-center"> Registrated Student Status <h6p>
                            </div>
                            <div class = "card-body">                                               
                                <table class="table table-bordered text-center display" id = "table_one">
                                    <thead>
                                        <tr>
                                            <th scope="col">Sl</th>
                                            <th scope="col">Name</th>
                                            <th scope="col">Online Reg No</th>
                                            <th scope="col">Phone</th>
                                            <th scope="col">Course</th>
                                            <th scope="col">Payent Status</th>
                                            <th scope="col">Passing Status</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($student as $key => $st)
                                        <tr>
                                        
                                            <td class=""><!-- Sl -->
                                                {{$key+1}}
                                            </td>
                                            <td class=""><!-- Name -->
                                                {{$st->name}}
                                            </td>
                                            <td class=""><!-- Online Reg No -->
                                                {{$st->reg_no}}
                                            </td>
                                            <td class=""><!-- Phone -->
                                                {{$st->phone}}
                                            </td>
                                            <td class=""><!-- Course -->
                                                {{$st->course->title}}
                                            </td>
                                            <td class=""><!-- Payent Status -->
                                                {{$st->payment_status}}
                                            </td>
                                            <td class=""><!-- Passing Status -->
                                                {{$st->getStatus()}}
                                            </td>
                                            <td class=""><!-- Action -->
                                                
                                            </td>


                                        </tr>
                                    @endforeach                                       
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <th scope="col">Sl</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Online Reg No</th>
                                        <th scope="col">Phone</th>
                                        <th scope="col">Course</th>
                                        <th scope="col">Payent Status</th>
                                        <th scope="col">Passing Status</th>
                                        <th scope="col">Action</th>

                                    </tr>
                                    </tfoot>
                                </table> 
                            </div>                                          
                        </div>
                        
                                

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
<script src="https://code.jquery.com/jquery-1.12.4.min.js" integrity="sha384-nvAa0+6Qg9clwYCGGPpDQLVpLNn0fRaROjHqs13t4Ggj3Ez50XnGQqc/r8MhnRDZ" crossorigin="anonymous"></script>
<script src="{{ asset('assets') }}/js/jquery.numscroll.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript">
	$(".total").numScroll({
      number:{{$total}},
      symbol: true
    });
    $(".this_month").numScroll({
      number:{{$this_month}},
      symbol: true
    });
    $(".this_week").numScroll({
      number:{{$this_week}},
      symbol: true
    });
</script>
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
                    
                     'pageLength'
                ]
            });


        });
    </script>

@endpush