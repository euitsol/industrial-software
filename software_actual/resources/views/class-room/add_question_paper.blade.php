@extends('layouts.master')

@section('title', 'Add Question - European IT Solutions Institute')

@push('css')
<style>


</style>
@endpush

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <span class = "float-left">
                            <h4>Add Question Paper</h4>
                        </span>
                        <span class = "float-right">
                            <h4></h4>
                        </span>
                    </div>

                    <div class="card-body">

                        @if (session('error'))
                            <p class="alert alert-danger text-center">
                                {{ session('error') }}
                            </p>
                        @endif
                        <div class="row">
                        <div class="col-md-8 offset-md-2">
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label">Set Question Paper<span
                                            class="text-danger">*</span> </label>
                                <div class="col-md-9">
                                    <select  id ="set_question_paper" value="{{ old('set_question_paper') }}"
                                            class="form-control form-control-success" required>
                                        <option value = "" hidden selected disabled>Choose.... </option>
                                        <option value = "1">Manually</option>
                                        <option value = "0">Upload Image </option>

                                    </select>
                                    
                                </div>
                            </div>
                        </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-8 offset-md-2">
                                <form action="" method="POST" class="form-horizontal" id = "form_1" style = "display : none;">
                                    @csrf

                                    
                                        <div class="form-group row">
                                            <label class="col-md-3 form-control-label">Image <span
                                                        class="text-danger">*</span> </label>
                                            <div class="col-md-9">
                                                
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" id="validatedCustomFile" required>
                                                <label class="custom-file-label" for="validatedCustomFile">Choose file...</label>
                                                <div class="invalid-feedback">Example invalid custom file feedback</div>
                                            </div>
                                            
                                                @if ($errors->has('exam_status'))
                                                    <span class="text-danger">{{ $errors->first('exam_status') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                                                       
                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label"> </label>
                                        <div class="col-md-9">
                                            <input type = "submit" value = "submit" class="btn btn-primary w-100">
                                        </div>
                                    </div>

                                    
                                
                                </form>
                            </div>
                        </div>

                        <div class = "card" id = "form_2" style = "">
                            
                            <div class = "card-body">
                                <div class="row">
                                    <div class="col-md-12 ">
                                        <form action="{{ route('classroom.question_paper.store') }}" method="POST" class="form-horizontal"  >
                                            @csrf
                                            <input type = "hidden" name = "total_questions" value = "1" id = "total_questions" >
                                            <input type = "hidden" name = "exam_id" value = "{{ $exam_id }}" id = "exam_id" >
                                            <div class = "" id = "questions">
                                                <div class="border p-2 mt-2">
                                                    <div class = "form-group row">
                                                        <label class="col-sm-2 col-form-label pr-0"><h6>Question No:</h6></label>
                                                        <div class = "col-sm-1 pl-0">
                                                            <input class="form-control-plaintext" type="number" name = "question_no_1" id = "question_no_1" value = "1" readonly>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">                                                   
                                                        <div class="col-md-8 ">
                                                            <input type="text" name="ques_tion_1" id = "question_1"  class = "form-control form-control-succes rounded-0" 
                                                            placeholder = "Question">                                                       
                                                        </div>
                                                        <div class="col-md-2 pl-0 ">
                                                            <input type="number" name="mar_k_1" id="mark_1" class = "form-control form-control-succes rounded-0" 
                                                            placeholder = "Mark">                                                      
                                                        </div>
                                                        <div class="col-md-2 pl-0 ">
                                                            <select  name="question_type_1" id="question_type_1" class = "form-control form-control-succes rounded-0">
                                                                <option value = "" hidden disabled selected>Type</option>
                                                                <option value = "1">Yes/No</option>
                                                                <option value = "2">True/False</option>
                                                                <option value = "3">Single Choice</option>
                                                                <option value = "4">Multiple Choice</option>
                                                                <option value = "5">Description</option>
                                                            </select>                                                       
                                                        </div>
                                                    </div>
                                                    <div class = "yes_no" id = yes_no_1 style = "display:none;">
                                                            <div class="form-group row">                                                   
                                                                <div class="col-md-1 align-middle ">
                                                                    <input type="radio" name="yes_no_1" class = "form-control form-control-sm" id = "yes" value = "1">                                                       
                                                                </div>
                                                                
                                                                <label class="col-md-5 col-form-label pr-0 align-middle" for = "yes">yes</label>                                                        
                                                                
                                                            
                                                            </div>
                                                            <div class="form-group row">                                                   
                                                                <div class="col-md-1 align-middle ">
                                                                    <input type="radio" name="yes_no_1"  class = "form-control form-control-sm" id = "no" value = "2">                                                       
                                                                </div>
                                                                
                                                                <label class="col-md-1 col-form-label pr-0 align-middle" for = "no">No</label>                                                        
                                                                
                                                            </div>
                                                        
                                                    </div>
                                                    <div class = "true_false_1" id = "true_false_1" style = "display:none;">
                                                            <div class="form-group row">                                                   
                                                                <div class="col-md-1 align-middle ">
                                                                    <input type="radio" class = "form-control form-control-sm" id = "true" name = "true_false_1" value = "1">                                                       
                                                                </div>
                                                                
                                                                <label  class="col-md-5 col-form-label pr-0 align-middle" for = "true">True</label>                                                        
                                                                
                                                            
                                                            </div>
                                                            <div class="form-group row">                                                   
                                                                <div class="col-md-1 align-middle ">
                                                                    <input type="radio" class = "form-control form-control-sm" id = "false" name = "true_false_1" value = "2">                                                       
                                                                </div>
                                                                
                                                                <label class="col-md-1 col-form-label pr-0 align-middle" for = "false">False</label>                                                        
                                                                
                                                            </div>
                                                        
                                                        
                                                    </div>
                                                    <div class = "single_choice_1" id = "single_choice_1" style = "display:none;">
                                                        <div class="form-group row">                                                   
                                                            <div class="col-md-1 align-middle ">
                                                                <input type="radio" class = "form-control form-control-sm" name = "single_choice_1" id = "one" value = "1">                                                       
                                                            </div>
                                                            
                                                            <label class="col-md-1 col-form-label pr-0 align-middle" for = "one">1.</label>                                                        
                                                            
                                                            <div class="col-md-2 pl-0 align-middle">
                                                                <input type = "text" class = "form-control form-control-sm rounded-0" name = "single_choice_1_1">                                                    
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">                                                   
                                                            <div class="col-md-1 align-middle ">
                                                                <input type="radio" class = "form-control form-control-sm" name = "single_choice_1" id = "two" value = "2" >                                                       
                                                            </div>
                                                            
                                                            <label class="col-md-1 col-form-label pr-0 align-middle" for = "two">2.</label>                                                        
                                                            
                                                            <div class="col-md-2 pl-0 align-middle">
                                                                <input type = "text" class = "form-control form-control-sm rounded-0" name = "single_choice_1_2" >                                               
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">                                                   
                                                            <div class="col-md-1 align-middle ">
                                                                <input type="radio" class = "form-control form-control-sm" name = "single_choice_1" id = "three" value = "3" >                                                       
                                                            </div>
                                                            
                                                            <label class="col-md-1 col-form-label pr-0 align-middle" for = "three">3.</label>                                                        
                                                            
                                                            <div class="col-md-2 pl-0 align-middle">
                                                                <input type = "text" class = "form-control form-control-sm rounded-0" name = "single_choice_1_3">                                                    
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">                                                   
                                                            <div class="col-md-1 align-middle ">
                                                                <input type="radio"  class = "form-control form-control-sm" name = "single_choice_1" id = "four" value = "4" >                                                       
                                                            </div>
                                                            
                                                            <label class="col-md-1 col-form-label pr-0 align-middle" for = "four">4.</label>                                                        
                                                            
                                                            <div class="col-md-2 pl-0 align-middle">
                                                                <input type = "text" class = "form-control form-control-sm rounded-0" name = "single_choice_1_4">                                                    
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class = "multiple_choice_1" id = "multiple_choice_1" style = "display:none;">
                                                        <div class="form-group row">                                                   
                                                            <div class="col-md-1 align-middle ">
                                                                <input type="checkbox" class = "form-control form-control-sm" name = "multiple_choice_1_1" value = "1" >                                                       
                                                            </div>
                                                            
                                                            <label class="col-md-1 col-form-label pr-0 align-middle">1.</label>                                                        
                                                            
                                                            <div class="col-md-2 pl-0 align-middle">
                                                                <input type = "text" class = "form-control form-control-sm rounded-0" name = "multiple_choice_1_1_1">                                                    
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">                                                   
                                                            <div class="col-md-1 align-middle ">
                                                                <input type="checkbox"  class = "form-control form-control-sm" name = "multiple_choice_1_2" value = "2" >                                                       
                                                            </div>
                                                            
                                                            <label class="col-md-1 col-form-label pr-0 align-middle">2.</label>                                                        
                                                            
                                                            <div class="col-md-2 pl-0 align-middle">
                                                                <input type = "text" class = "form-control form-control-sm rounded-0" name = "multiple_choice_1_2_2">                                                    
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">                                                   
                                                            <div class="col-md-1 align-middle ">
                                                                <input type="checkbox"   class = "form-control form-control-sm"  name = "multiple_choice_1_3" value = "3">                                                       
                                                            </div>
                                                            
                                                            <label class="col-md-1 col-form-label pr-0 align-middle">3.</label>                                                        
                                                            
                                                            <div class="col-md-2 pl-0 align-middle">
                                                                <input type = "text" class = "form-control form-control-sm rounded-0"  name = "multiple_choice_1_3_3">                                                    
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">                                                   
                                                            <div class="col-md-1 align-middle ">
                                                                <input type="checkbox"   class = "form-control form-control-sm"  name = "multiple_choice_1_4" value = "4">                                                       
                                                            </div>
                                                            
                                                            <label class="col-md-1 col-form-label pr-0 align-middle">4.</label>                                                        
                                                            
                                                            <div class="col-md-2 pl-0 align-middle">
                                                                <input type = "text" class = "form-control form-control-sm rounded-0" name = "multiple_choice_1_4_4">                                                    
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>                                         
                                            <div class="clearfix">
                                                    
                                                    <a href="javascript:void(0)" id="new_question" class="float-right">
                                                        + New Question
                                                    </a>
                                                    
                                                    
                                            </div>
                                            <div class="form-group row mt-5">
                                                
                                                <div class="col-md-12">
                                                    <input type = "submit" value = "submit" class="btn btn-primary w-100">
                                                </div>
                                            </div>                                                                                                                                                                
                                        </form>
                                    </div>
                                </div>
                            </div>
                        <div>                   
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
<script src="{{asset('assets/vendor/jquery-ui/jquery-ui.js')}}"></script>

<script>
    $(document).ready(function(){
        
    
        $(document).on('change', '#set_question_paper,#question_type_1', function () {

            let set_value = $('#set_question_paper').val();

            if (set_value == 0){
                $('#form_1').show(1000);
                $('#form_2').hide(1000);
            }
            else{
                $('#form_2').show(1000);
                $('#form_1').hide(1000);
            }
        
            let question_type = $('#question_type_1').val();

            if(question_type == 1){
                $('#yes_no_1').show(1000);
                $('#true_false_1').hide(1000);
                $('#single_choice_1').hide(1000);
                $('#multiple_choice_1').hide(1000);
            }
            if(question_type == 2){
                $('#yes_no_1').hide(1000);
                $('#true_false_1').show(1000);
                $('#single_choice_1').hide(1000);
                $('#multiple_choice_1').hide(1000);               
            }
            if(question_type == 3){
                $('#yes_no_1').hide(1000);
                $('#true_false_1').hide(1000);
                $('#single_choice_1').show(1000);
                $('#multiple_choice_1').hide(1000);               
            }
            if(question_type == 4){
                $('#yes_no_1').hide(1000);
                $('#true_false_1').hide(1000);
                $('#single_choice_1').hide(1000);
                $('#multiple_choice_1').show(1000);               
            }
            if(question_type == 5){
                $('#yes_no_1').hide(1000);
                $('#true_false_1').hide(1000);
                $('#single_choice_1').hide(1000);
                $('#multiple_choice_1').hide(1000);               
            }                                                          
});    

        $(document).on('click','#new_question'  , function() {
            
            let total_questions = $("#total_questions");
            let total_questions_val = parseInt( $("#total_questions").val());

            let question_no           = $("#question_no_1").attr("name");
            let question_name         = $("#question_1").attr("name");            
            let mark                  = $("#mark_1").attr("name");
            let question_type         = $("#question_type_1").attr("name");
            let yes_no                = $(".yes_no").attr("id");
            let true_false            = $(".true_false_1").attr("id");
            let single_choice         = $(".single_choice_1").attr("id");
            let multiple_choice       = $(".multiple_choice_1").attr("id");
          
            let id = total_questions_val + 1 ;
        
            var res_1 = question_no.split("_");
            var res_2 = question_name.split("_");
            var res_3 = mark.split("_");
            var res_4 = question_type.split("_");
            var res_5 = yes_no.split("_");
            var res_6 = true_false.split("_");
            var res_7 = single_choice.split("_");
            var res_8 = multiple_choice.split("_");

            
            var new_question_no       = res_1[0] + "_" + res_1[1] + "_" + id;
            var new_question_name     = res_2[0] + "_" + res_2[1] + "_" + id;
            var new_mark              = res_3[0] + "_" + res_3[1] + "_" + id;
            var new_question_type     = res_4[0] + "_" + res_4[1] + "_" + id;
            var new_yes_no            = res_5[0] + "_" + res_5[1] + "_" + id;
            var new_true_false        = res_6[0] + "_" + res_6[1] + "_" + id;
            var new_single_choice     = res_7[0] + "_" + res_7[1] + "_" + id;
            var new_multiple_choice   = res_8[0] + "_" + res_8[1] + "_" + id;

            total_questions.val(id);
           
                        let output = '';
                            output +=   '<div class="border p-2 mt-2">';
                            output +=   '<div class="form-group row">';
                            output +=   '<label class="col-sm-2 col-form-label pr-0">';
                            output +=   '<h6>Question No:</h6>';
                            output +=   '</label>';
                            output +=   '<div class="col-sm-1 pl-0">';
                            output +=   '<input class="form-control-plaintext" type="number" name="' + new_question_no + '" id="question_no_1" value="' + id + '" readonly>';
                            output +=   '</div>';
                            output +=   '</div>';
                            output +=   '<div class="form-group row">';
                            output +=   '<div class="col-md-8 ">';
                            output +=   '<input type="text" name="' + new_question_name + '" id="question_1" class="form-control form-control-succes rounded-0" placeholder="Question">';
                            output +=   '</div>';
                            output +=   '<div class="col-md-2 pl-0 ">';
                            output +=   '<input type="number" name="' + new_mark +'" id="mark" class="form-control form-control-succes rounded-0" placeholder="Mark">';
                            output +=   '</div>';
                            output +=   '<div class="col-md-2 pl-0 ">';
                            output +=   '<select name="' + new_question_type + '" id="' + new_question_type + '" class="form-control form-control-succes rounded-0" onchange ="reply_click(this.id)">';
                            output +=   '<option value="" hidden disabled selected>Type</option>';
                            output +=   '<option value="1">Yes/No</option>';
                            output +=   '<option value="2">True/False</option>';
                            output +=   '<option value="3">Single Choice</option>';
                            output +=   '<option value="4">Multiple Choice</option>';
                            output +=   '<option value="5">Description</option>';
                            output +=   '</select>';
                            output +=   '</div>';
                            output +=   '</div>';
                            output +=   '<div class="yes_no" id = "' + new_yes_no +'" style="display:none;">';
                            output +=   '<div class="form-group row">';
                            output +=   '<div class="col-md-1 align-middle ">';
                            output +=   '<input type="radio" name = "' + new_yes_no +'" class="form-control form-control-sm" value = "1">';
                            output +=   '</div>';
                            output +=   '<label class="col-md-5 col-form-label pr-0 align-middle">yes</label>';
                            output +=   '</div>';
                            output +=   '<div class="form-group row">';
                            output +=   '<div class="col-md-1 align-middle ">';
                            output +=   '<input type="radio" name = "' + new_yes_no +'" class="form-control form-control-sm" value = "2">';
                            output +=   '</div>';
                            output +=   '<label class="col-md-1 col-form-label pr-0 align-middle">No</label>';
                            output +=   '</div>';
                            output +=   '</div>';
                            output +=   '<div class="true_false" id = "' + new_true_false + '"  style="display:none;">';
                            output +=   '<div class="form-group row">';
                            output +=   '<div class="col-md-1 align-middle ">';
                            output +=   '<input type="radio" class="form-control form-control-sm" name = "' + new_true_false + '" value = "1">';
                            output +=   '</div>';
                            output +=   '<label class="col-md-5 col-form-label pr-0 align-middle">True</label>';
                            output +=   '</div>';
                            output +=   '<div class="form-group row">';
                            output +=   '<div class="col-md-1 align-middle ">';
                            output +=   '<input type="radio" class="form-control form-control-sm" name = "' + new_true_false + '" value = "2">';
                            output +=   '</div>';
                            output +=   '<label class="col-md-1 col-form-label pr-0 align-middle">False</label>';
                            output +=   '</div>';
                            output +=   '</div>';
                            output +=   '<div class = "single_choice" id="' + new_single_choice + '"  style="display:none;">';
                            output +=   '<div class="form-group row">';
                            output +=   '<div class="col-md-1 align-middle ">';
                            output +=   '<input type="radio" class="form-control form-control-sm" name = "' + new_single_choice + '" value = "1">';
                            output +=   '</div>';
                            output +=   '<label class="col-md-1 col-form-label pr-0 align-middle">1.</label>';
                            output +=   '<div class="col-md-2 pl-0 align-middle">';
                            output +=   '<input type="text" class="form-control form-control-sm rounded-0  " name = "' + new_single_choice + '_1">';
                            output +=   '</div>';
                            output +=   '</div>';
                            output +=   '<div class="form-group row">';
                            output +=   '<div class="col-md-1 align-middle ">';
                            output +=   '<input type="radio" class="form-control form-control-sm" name = "' + new_single_choice + '" value = "2">';
                            output +=   '</div>';
                            output +=   '<label class="col-md-1 col-form-label pr-0 align-middle">2.</label>';
                            output +=   '<div class="col-md-2 pl-0 align-middle">';
                            output +=   '<input type="text" class="form-control form-control-sm rounded-0  " name = "' + new_single_choice + '_2">';
                            output +=   '</div>';
                            output +=   '</div>';
                            output +=   '<div class="form-group row">';
                            output +=   '<div class="col-md-1 align-middle ">';
                            output +=   '<input type="radio" class="form-control form-control-sm" name = "' + new_single_choice + '" value = "3">';
                            output +=   '</div>';
                            output +=   '<label class="col-md-1 col-form-label pr-0 align-middle">3.</label>';
                            output +=   '<div class="col-md-2 pl-0 align-middle">';
                            output +=   '<input type="text" class="form-control form-control-sm rounded-0  " name = "' + new_single_choice + '_3">';
                            output +=   '</div>';
                            output +=   '</div>';
                            output +=   '<div class="form-group row">';
                            output +=   '<div class="col-md-1 align-middle ">';
                            output +=   '<input type="radio" class="form-control form-control-sm" name = "' + new_single_choice + '" value = "4">';
                            output +=   '</div>';
                            output +=   '<label class="col-md-1 col-form-label pr-0 align-middle">4.</label>';
                            output +=   '<div class="col-md-2 pl-0 align-middle">';
                            output +=   '<input type="text" class="form-control form-control-sm rounded-0  " name = "' + new_single_choice + '_4">';
                            output +=   '</div>';
                            output +=   '</div>';
                            output +=   '</div>';
                            output +=   '<div class = "multiple_choice" id="' + new_multiple_choice + '" style="display:none;">';
                            output +=   '<div class="form-group row">';
                            output +=   '<div class="col-md-1 align-middle ">';
                            output +=   '<input type="checkbox" class="form-control form-control-sm"  name = "' + new_multiple_choice + '_1" value = "1">';
                            output +=   '</div>';
                            output +=   '<label class="col-md-1 col-form-label pr-0 align-middle">1.</label>';
                            output +=   '<div class="col-md-2 pl-0 align-middle">';
                            output +=   '<input type="text" class="form-control form-control-sm rounded-0  "name = "' + new_multiple_choice + '_1_1">';
                            output +=   '</div>';
                            output +=   '</div>';
                            output +=   '<div class="form-group row">';
                            output +=   '<div class="col-md-1 align-middle ">';
                            output +=   '<input type="checkbox" class="form-control form-control-sm" name = "' + new_multiple_choice + '_2" value = "2">';
                            output +=   '</div>';
                            output +=   '<label class="col-md-1 col-form-label pr-0 align-middle">2.</label>';
                            output +=   '<div class="col-md-2 pl-0 align-middle">';
                            output +=   '<input type="text" class="form-control form-control-sm rounded-0  " name = "' + new_multiple_choice + '_2_2">';
                            output +=   '</div>';
                            output +=   '</div>';
                            output +=   '<div class="form-group row">';
                            output +=   '<div class="col-md-1 align-middle ">';
                            output +=   '<input type="checkbox" class="form-control form-control-sm" name = "' + new_multiple_choice + '_3" value = "3">';
                            output +=   '</div>';
                            output +=   '<label class="col-md-1 col-form-label pr-0 align-middle">3.</label>';
                            output +=   '<div class="col-md-2 pl-0 align-middle">';
                            output +=   '<input type="text" class="form-control form-control-sm rounded-0  " name = "' + new_multiple_choice + '_3_3">';
                            output +=   '</div>';
                            output +=   '</div>';
                            output +=   '<div class="form-group row">';
                            output +=   '<div class="col-md-1 align-middle ">';
                            output +=   '<input type="checkbox" class="form-control form-control-sm" name = "' + new_multiple_choice + '_4"  value = "4">';
                            output +=   '</div>';
                            output +=   '<label class="col-md-1 col-form-label pr-0 align-middle">4.</label>';
                            output +=   '<div class="col-md-2 pl-0 align-middle">';
                            output +=   '<input type="text" class="form-control form-control-sm rounded-0  " name = "' + new_multiple_choice + '_4_4">';
                            output +=   '</div>';
                            output +=   '</div>';
                            output +=   '</div>';
                            output +=   '</div>';
                            output +=   '</div>';
                $('#questions').append(output);                  
        });                   
        
    });
</script>
<script>
    function reply_click(clicked_id){
    

        let question_val = document.getElementById(clicked_id).value;

        let res_1 = clicked_id.split("_");

        var yes_no            = "yes_no" + "_" + res_1[2];
        var true_false        = "true_false" + "_" + res_1[2];
        var single_choice     = "single_choice" + "_" + res_1[2];
        var multiple_choice   = "multiple_choice" + "_" + res_1[2];

        var a   =  document.getElementById(yes_no);
        var b   =  document.getElementById(true_false);
        var c   =  document.getElementById(single_choice);
        var d   =  document.getElementById(multiple_choice);

        console.log(a);
        console.log(b);
        console.log(c);
        console.log(d);

        if(question_val == 1){
            a.style.display = "block";
            b.style.display = "none";
            c.style.display = "none";
            d.style.display = "none";
        }
        if(question_val == 2){
            a.style.display = "none";
            b.style.display = "block";
            c.style.display = "none";
            d.style.display = "none";
        }
        if(question_val == 3){
            a.style.display = "none";
            b.style.display = "none";
            c.style.display = "block";
            d.style.display = "none";
        }
        if(question_val == 4){
            a.style.display = "none";
            b.style.display = "none";
            c.style.display = "none";
            d.style.display = "block";
        }
        if(question_val == 5){
            a.style.display = "none";
            b.style.display = "none";
            c.style.display = "none";
            d.style.display = "none";
        }           
}
</script>
@endpush
