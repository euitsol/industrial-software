@extends('layouts.master')

@section('title', 'Course Status - European IT Solutions Institute')

@push('css')

<style>
.switch {
  position: relative;
  display: inline-block;
  width: 60px;
  height: 34px;
}

.switch input { 
  opacity: 0;
  width: 0;
  height: 0;
}

.slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #C82333;
  -webkit-transition: .4s;
  transition: .4s;
}

.slider:before {
  position: absolute;
  content: "";
  height: 26px;
  width: 26px;
  left: 4px;
  bottom: 4px;
  background-color: white;
  -webkit-transition: .4s;
  transition: .4s;
}

input:checked + .slider {
  background-color: #2196F3;
}

input:focus + .slider {
  box-shadow: 0 0 1px #2196F3;
}

input:checked + .slider:before {
  -webkit-transform: translateX(26px);
  -ms-transform: translateX(26px);
  transform: translateX(26px);
}

/* Rounded sliders */
.slider.round {
  border-radius: 34px;
}

.slider.round:before {
  border-radius: 50%;
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
                        <h4>Course Status</h4>
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
                        <form method="post" action="{{ route('course_status.store')}}">
                        @csrf
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Course Name</th>
                                    <th>Course Type</th>   
                                    <th>Course Status</th> 
                                                                
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($course as $cs )
                                <tr>
                                
                                    <td class = "align-middle">{{$cs->title}}</td>
                                    <td class = "align-middle">{{$cs->type}}</td>
                                    <td class = "align-middle ">
                                    @php
                                        if($cs->status == "Running"){
                                            $check = "checked";
                                        }
                                        else{
                                            $check = "";
                                        }
                                    @endphp


                                    <label class="switch mb-0">
                                        <input type="checkbox" name = "{{$cs->id}}" {{$check}}>
                                        <span class="slider round"></span>
                                    </label>
                                    </td>

                                </tr> 
                            @endforeach
                                                             
                            </tbody>
                            <tfoot>
                                <th  colspan = "3">
                                    <input type = "submit" class = "btn btn-primary" value="Submit" style = "width:100%">
                                </th> 
                            </tfoot>
                        </table>
                        </form>    

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
<script src="{{asset('assets/vendor/jquery-ui/jquery-ui.js')}}"></script>
    <script>
    </script>
@endpush