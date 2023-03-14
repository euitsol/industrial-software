
@extends('layouts.master')

@section('title', 'SMS promotion type')

@push('css')
    <link rel="stylesheet" href="{{ asset('assets/vendor/data-table/css/jquery.dataTables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/data-table/css/buttons.dataTables.min.css') }}">
    <style>
        .input{
            border-top-style: hidden;
            border-right-style: hidden;
            border-left-style: hidden;
            border-bottom-style: none;
            background-color: #fff;
        }

        .no-outline:focus{

            outline: none;
        }
        .btn-custom {
            border: 1px solid #9e9b9b73;
            background: #d2cfcf5c !important;
            border-radius: 0 !important;
            padding: 4px 22px !important;
            color: #000;
            opacity: 1 !important;
            text-align: center;
            cursor: pointer;
            transition: .4s;
        }

        a {
            text-decoration: none !important;
        }

        .btn-custom:hover {
            background: #19A4D0 !important;
            color: #ffffff !important;
        }
</style>
@endpush
@section('content')
@php
$count_1 = 1;
$sl = 1;
@endphp
<div class="container">
<form action = "{{route('promotion_type.sms.send')}}" method="POST" >
        <div class="row justify-content-center">
            <div class="col-md-10 col-lg-12">
                <div class="card">
                    <div class="card-header justify-content-between">
                        <span class = "float-left">
                            <h4>Send SMS From CSV</h4>
                        </span>
                        <!-- <span class="float-right">
                            <a href=""
                            class="btn btn-primary btn-sm">Send Sms</a>
                        </span> -->
                    </div>
                    <div class="card-body">
                    @if (session('error'))
                            <p class="alert alert-danger text-center">
                                {{ session('error') }}
                            </p>
                    @elseif(session('success'))
                            <p class="alert alert-success text-center">
                                {{ session('success') }}
                            </p>
                    @endif
                    <div class="row">
                        <div class="col-md-12 ">
                        
                        @csrf
                            <input type="hidden" name="id" value="{{$id}}">
                                <div class="form-group row ">
                                            <label class="col-md-2 form-control-label">Message <span
                                                        class="text-danger">*</span> </label>
                                            <div class="col-md-7">
                                            <textarea  name="message" class="form-control" rows=4 cols=60 id=t1 required></textarea>                                              
                                            </div>

                                            <div class="col-md-1 d-flex">                                                                                                                          
                                                <div id=d1 >0</div>(
                                                <div id=d2></div>)                                             
                                            </div>
                                                                                                                                                                                            
                                            <div class="col-md-1">                                                                                                                          
                                                <input type="submit" value="Send Message" class="btn-custom">                                               
                                            </div>
                                </div>
                        
                        </div>
                    </div>
                    
                        <div class="row">
                            <div class="col-md-12 ">
                            <div class="mb-5">
                            <div class="table-responsive">
                                <table class="table table-bordered text-center dataTable">
                                    <tr>
                                        <th class="align-middle">Sl</th>
                                        <th class="align-middle">Message</th>
                                        <th class="align-middle">Send date & time</th>
                                        <th class="align-middle">Send by</th>
                                    </tr>
                                @foreach($message_data as $md)
                                    <tr>                                       
                                            <td class="align-middle">{{$count_1}}</td>  
                                            <td class="text-left align-middle">{{$md->message}}</td>
                                            <td class="align-middle">{{$md->created_at}}</td>
                                            @foreach($user_data as $ud)
                                                @if($ud->id == $md->user_id)
                                                <td class="align-middle">{{$ud->name}}</td>
                                                @endif
                                            @endforeach
                                        
                                    </tr>
                                    @php
                                        $count_1++;
                                    @endphp
                                @endforeach
                                </table>
                                </div>
                            </div>                                                   
                                <div class="table-responsive">
                                <table class="table table-bordered text-center dataTable">
                                    <tr>
                                    <td>SL</td>
                                        @foreach($columns as $column_name)
                                            @if(($column_name != "created_at")&&($column_name != "updated_at")&&($column_name != "id")&&($column_name != "promotion_type_id"))
                                            <th class="align-middle">{{$column_name}}</th>
                                            @endif
                                        @endforeach
                                    <td>SMS</td>   
                                    </tr>
                                    
                                
                                @foreach($data as $dt)
                                    <tr>
                                        <td>{{$sl++}}</td>
                                        @foreach($columns as $column_name)
                                        @if(($column_name != "created_at")&&($column_name != "updated_at")&&($column_name != "id")&&($column_name != "promotion_type_id"))
                                        <td class="align-middle">{{$dt->$column_name}}</td>
                                        @endif
                                        @endforeach
                                        <td><input type="checkbox" name="phone[]" value="{{$dt->phone}}" checked></td>                                                         
                                    </tr>
                                @endforeach
                                    <tr>
                                            
                                    </tr>
                                </table>
                                </div>                                                                                  
                            
                            </div>
                        </div>                   
                    </div>
                </div>
            </div>
        </div>
</form>
    </div>
@endsection

@push('js')

<script type="text/javascript">
      window.loading_screen = window.pleaseWait({
        
        backgroundColor: '#ffffff',
        loadingHtml: '<h1>jncjidsncdncjsdcjnj</h1>'
      });
      window.loading_screen.finish();
    </script>
<script>
$(document).ready(function() {
//////////////////////////

$('#t1').keyup(function(){
var str=$('#t1').val();
var msd = 1;
var limit_1 = 160;
var limit_2 = 320;
var limit_3 = 480;
var limit_4 = 640;
var limit_5 = 800;
var limit_6 = 960;


  

if (str.length > limit_1) {
  msd = 2;
  if(str.length > limit_2) {
  msd = 3;
  if(str.length > limit_3) {
  msd = 4;
  if(str.length > limit_4) {
  msd = 5;
  if(str.length > limit_5) {
  msd = 6;
  if(str.length > limit_6) {
  msd = 7;
  if(str.length > limit_6) {
  msd = "too large";
}
}
}
}
}
}  
}





$('#d1').html(str.length + 50);
$('#d2').html(msd);

console.log(msd);
})
////////////
})


</script>

@endpush





