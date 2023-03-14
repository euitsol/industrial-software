@extends('layouts.master')

@section('title', 'Create Discount - European IT Solutions Institute')

@push('css')
    <link rel="stylesheet" href="{{asset('assets/vendor/jquery-ui/jquery-ui.css')}}">
@endpush

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10 col-lg-12">
                <div class="card">
                    <div class="card-header">
                    <span class="float-left">
                        <h4>Add Discount</h4>
                    </span>
                        <span class="float-right">
                        <a href="{{ route('online_op.course_dis') }}"
                           class="btn btn-info btn-sm">Back</a>
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
                            <div class="col-md-8 offset-md-2">
                                <form action="{{ route('online_op.course_dis_store')}}" method="POST" class="form-horizontal">
                                    @csrf

                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label">Discount For</label>
                                        <div class="col-md-9">
                                            <select id="batch_for" class="form-control form-control-success">
                                                <option selected disabled hidden value="">Choose...</option>
                                                <option value="Professional" >Professional</option>
                                                <option value="Industrial">Industrial</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label">Course Name</label>
                                        <div class="col-md-9">
                                            <select name="course" id="course" disabled
                                                    class="form-control form-control-success">
                                            </select>
                                            @if ($errors->has('course'))
                                                <span class="text-danger">{{ $errors->first('course') }}</span>
                                            @endif
                                            <script>document.getElementById('course').value = "{{ old('course') }}";</script>
                                            

                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label">Discount</label>
                                        <div class="col-md-9">

                                            

                                            <div class="input-group" id="discount" style="">

                                                <input type="number" name="discount_percent" id="discount_percent"
                                                        min="0"
                                                       placeholder="Percent"
                                                       class="form-control">

                                                <div class="input-group-append">
                                                    <span class="input-group-text"
                                                          style="width: 36px !important;">%</span>
                                                </div>

                                                <span class="ml-2 mr-2 mt-2">OR</span>

                                                <input type="number" name="discount_amount" id="discount_amount"
                                                        min="0" placeholder="Amount"
                                                       class="form-control">
                                            </div>

                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label">Course Fee</label>
                                        <div class="col-md-9">
                                            <span id="course_fee"></span> TK
                                            <input type = "hidden" id = "_course_fee" value ="" name = "course_fee">

                                           
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label">Discounted Fee</label>
                                        <div class="col-md-9">
                                            <span id="discount_fee"></span> TK
                                            <input type = "hidden" id = "_discount_fee" value ="" name = "discount_fee">
                                            
                                        </div>
                                    </div>
                                    
                                    
                                    <div class="form-group row">
                                        <div class="col-md-9 ml-auto">
                                            <input type="submit" value="Start Discount" style = "width:100%"
                                                   onclick="return confirm('Are you sure to add discount ?')"
                                                   class="btn btn-primary">
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
<script src="{{asset('assets/vendor/jquery-ui/jquery-ui.js')}}"></script>
    <script>


        $(document).on('change', '#batch_for', function () {
            let batch_for = $(this).val();
            if ('' != batch_for) {
                let url = "{{route('courses.type', ['type'])}}";
                let _url = url.replace('type', batch_for);
                $.ajax({
                    url: _url,
                    method: "GET",
                    success: function (response) {
                        if ('' != response) {
                            $('#course').removeAttr('disabled');
                            let output = '<option selected disabled hidden value="">Choose...</option>' + response;
                            $('#course').html(output);
                            
                        } else {
                            $('#course').prop('disabled', true);
                            $('#course').html('');
                            
                        }
                    }
                });
            }
        });
        
        $(document).on('change','#course',function(){
            course_data();
        });
        function course_data(){
            let id = $('#course').val();
            console.log(id);
            if('' != id){
                let url = "{{ route('courses.id',['id'])}}";
                let _url = url.replace('id' , id);
                $.ajax({
                    url: _url,
                    method: "GET",
                    success: function (response) {
                        if ('' != response) {
                             let value = 0;
                            $('#course_fee').html(response['fee']);
                            $('#_course_fee').val(response['fee']);
                            

                        }
                        else{
                            let value = 0;
                            $('#course_fee').html(value);
                            
                        }
                    }
                });

            }
        }

        $(document).on('keyup change focusout', "#discount_percent, #discount_amount", function () {
            discount_calculation();
        });
        function discount_calculation(){
            let discount_percent = $("#discount_percent");
            let discount_percent_val = $("#discount_percent").val();
            let discount_amount = $("#discount_amount");
            let discount_amount_val = $("#discount_amount").val();
            let course_fee = $("#_course_fee").val();
            
            if(discount_percent_val) {
                discount_amount.val('');
                discount_amount.attr('disabled', 'disabled');
            }
            else {
                discount_amount.removeAttr('disabled', 'disabled');
            }
            if(discount_amount_val) {
                discount_percent.val('');
                discount_percent.attr('disabled', 'disabled');
            }
            else {
                discount_percent.removeAttr('disabled', 'disabled');
            }
            if ((course_fee != '') && (discount_percent_val != '')) {
                
                discount_fee = course_fee - ((course_fee * discount_percent_val) / 100);
                
            }
            if ((course_fee != '') && (discount_amount_val != '')) {
                
                discount_fee = course_fee - discount_amount_val;

                
            }
            if( discount_fee < 0){
                
                alert("Discount can not be grater than course fee");
                $('#discount_amount').val(0);
                $('#discount_percent').val(0);
                $('#discount_fee').html(0);
                $('#_discount_fee').val(0);
                $('#discount_amount').removeAttr('disabled', 'disabled');
                $('#discount_percent').removeAttr('disabled', 'disabled');
            }
            $('#discount_fee').html(discount_fee);
            $('#_discount_fee').val(discount_fee);
            
            



        }
        



    </script>
@endpush

