@extends('layouts.master')

@section('title', 'SMS - European IT Solutions Institute')

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

@php
$sl = 1;
@endphp

@section('content')
<div class="container">
   <div class="row justify-content-center">
      <div class="col-md-10 col-lg-12">
         <div class="card">
            <div class="card-header">
               <span class="float-left">
                  <h4>Send Marketing Message <small>( {{ $year }} @if($course != null) + {{ $course->title }} @endif @if($institute != null) + {{ $institute->name }} @endif  )</small> </h4>
               </span>
               <span class="float-right">
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
               @if ($students->count() > 0)
               <div class="table-responsive">
                  <form action="{{ route('marketing.industrial.message.send') }}" method="post">
                     @csrf
                     <table class="table table-bordered ">
                        <tr>
                           <th>SL</th>
                           <th>Name</th>
                           <th>Phone</th>
                           <th>Institute</th>
                           <th>Course</th>
                           <th>SMS</th>
                        </tr>
                        @forelse($students as $key => $student)
                        <tr>
                            <td>{{$sl++}}</td>
                            <td>{{ $student->name }}</td>
                            <td>{{ $student->phone }}</td>
                            <td>
                                @php $inst = App\Models\Institute::findOrFail($student->institute); @endphp
                               {{ $inst->name }}
                            </td>
                            <td>
                                @php $course = App\Models\Course::findOrFail($student->course); @endphp
                                {{ $course->title }}
                            </td>
                            <td class="text-center">
                              <input type="checkbox" name="student_id[]"
                                 value="{{ $student->id }}" checked>
                            </td>
                        </tr>
                        @empty
                        @endforelse
                        <tr>
                            <td>{{$sl++}}</td>
                            <td>Test</td>
                            <td> 01796173484 </td>
                            <td> Test </td>
                            <td> Test </td>
                            <td class="text-center">
                              <input type="checkbox" name="student_id[]"
                                 value="1681" checked>
                            </td>
                        </tr>
                     </table>
                     <div class="col-md-8 pt-5 m-auto border border-primary">
                        <div class="form-group">
                           <label for="message">Message <span class="text-danger">*</span></label>
                           <div class="mb-2">Dear {Student_name},</div>
                           <textarea name="message" id="message"
                              class="form-control mb-2" required></textarea>
                           <div>
                              Sincerely, <br>
                              European IT <br>
                              Contact Us: 01889977950
                           </div>
                           @if ($errors->has('message'))
                           <span class="text-danger">{{ $errors->first('message') }}</span>
                           @endif
                        </div>
                        
                        <div class="form-group w-50 m-auto d-flex justify-content-between align-items-center">
                            <label for="heading">Header and footer message</label>
                            <label class="switch mb-0">
                                <input type="checkbox" id="heading" name="heading" value="1" checked>
                                <span class="slider round"></span>
                            </label>
                         </div>
                         
                        <div class="form-group mt-2 w-50 m-auto d-flex justify-content-between align-items-center" style="margin-top: 10px !important;">
                            <label for="masking">Masking</label>
                            <label class="switch mb-0">
                                <input type="checkbox" id="masking" name="masking" value="1" checked>
                                <span class="slider round"></span>
                            </label>
                         </div>   
                            
                        <div class="form-group mt-4 mb-3">
                           <input type="submit" value="Send" class="btn btn-primary  w-50 m-auto d-flex justify-content-center align-items-center ">
                        </div>
                     </div>
                  </form>
               </div>
               @endif
            </div>
         </div>
      </div>
   </div>
</div>
@endsection
@push('js')
@endpush