@extends('layouts.master')

@section('title', 'SMS - European IT Solutions Institute')

@push('css')

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
                        <h4> Send SMS to Students </h4>
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
                            <form action="{{ route('sms.sms_students.send')}}" method="post">
                            @csrf
                                <table class="table table-bordered ">
                                    <tr>
                                        <th>SL</th>
                                        <th>Batch</th>
                                        <th>Name</th>
                                        <th>Phone</th>
                                        <th>Student As</th>
                                        <th>SMS</th>
                                    </tr>
                                    
                                    
                                        @forelse($students as $key => $student)
                                            
                                            <tr>
                                                <td>{{$sl++}}</td>
                                                <td>{{$batch_name}}</td>
                                                <td>{{ $student->name }}</td>
                                                <td>{{ $student->phone }}</td>
                                                <td>{{ $student->student_as }}</td>
                                                
                                                <td class="text-center">
                                                    <input type="checkbox" name="student_phone[]"
                                                           value="{{ $student->phone }}" checked>
                                                </td>
                                            </tr>
                                            
                                        @empty

                                        @endforelse
   
                                </table>

                                
                                            <div class="col-md-8 pt-5 m-auto">
                                                <div class="form-group">
                                                    <label for="message">Message <span class="text-danger">*</span></label>
                                                    <div class="mb-2">Dear Student,</div>
                                                    <textarea name="message" id="message"
                                                            class="form-control mb-2" required></textarea>
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
