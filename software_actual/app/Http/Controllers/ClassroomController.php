<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Add_exam;
use App\Models\Add_questions;
use App\Models\Add_questions_type;


use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;

class ClassroomController extends Controller
{
    

    public function index()
    {
        
        return view('class-room.index');
    }
    public function exam()
    {

        return view ('class-room.add_exam');
    }
    public function exam_store(Request $request)
    {
        $request->validate([
            'exam_title' => 'required',
            'exam_duration' => 'required',
            '_exam_duration' => 'required',
            'exam_status' => 'required'

        ]);

        $add_exam = new Add_exam;
        $add_exam->title     = $request->exam_title;
        if (isset($request->exam_sub_titl))
        {
            $add_exam->sub_title = $request->exam_sub_title;
        }
        
        $add_exam->duration  = $request->exam_duration;
        $add_exam->time      = $request->_exam_duration;
        $add_exam->status    = $request->exam_status;
        $add_exam->add_by    = Auth::id();
        $add_exam->save();
        $exam_id = $add_exam->id;
          
        return redirect()->route('classroom.question_paper',$exam_id);
        
    }
    public function exam_question_paper($exam_id)
    {
        $add_exam = Add_exam::findorFail($exam_id);
        // return $add_exam;
        return view ('class-room.add_question_paper',compact('add_exam','exam_id'));
    }
    public function exam_question_paper_store(Request $request)
    {
        $output = $request->total_questions;

        $loop = $request->total_questions;
        for ($i = 1; $i <= $loop; $i++ )
        {

            $question_no     = "question_no_".$i ;
            $question        = "ques_tion_".$i;
            $mark            = "mar_k_".$i;
            $question_type   = "question_type_".$i; 

            $yes_no            = "yes_no_".$i;
            $true_false        = "true_false_".$i;
            $single_choice     = "single_choice_".$i;
            $multiple_choice   = "multiple_choice_".$i;


            $exam_question = new Add_questions;

            $exam_question->exam_id       = $request->exam_id;
            $exam_question->question_no   = $request->$question_no;
            $exam_question->question      = $request->$question;
            $exam_question->question_type = $request->$question_type;
            $exam_question->mark          = $request->$mark;
            $exam_question->user_id       = Auth::id();
            $exam_question->save();

            $question_id = $exam_question->id;

            $data_question_type = new Add_questions_type;
            $data_question_type->question_id = $question_id;
            

            if ($request->$question_type == 1 )
            {               

                if (isset($request->$yes_no) && ($request->$yes_no == 1))
                {
                    //option && answer
                    
                    
                }
                if (isset($request->$yes_no) && ($request->$yes_no == 2))
                {
                    //option && answer
                    
                }
            }
            if ($request->$question_type == 2 )
            {
                if (isset($request->$true_false) && ($request->$true_false == 1))
                {
                    //option && answer
                    
                }
                if (isset($request->$true_false) && ($request->$true_false == 2))
                {
                    //option && answer 
                    
                }
                
            }
            if ($request->$question_type == 3 )
            {
                //answer
                

                for ( $j = 1; $j <= 4;$j++)
                {
                    $new_single_choice = $single_choice."_".$j;

                    if (isset($request->$new_single_choice))
                    {
                        $jj = "".$j;
                        $data_question_type->$j = $request->$new_single_choice;
                        
                    }
                }

            }
            if ($request->$question_type == 4 )
            {
                for ( $k = 1; $k <= 4;$k++)
                {
                    $new_multiple_choice = $multiple_choice."_".$k;

                    if (isset($request->$new_multiple_choice))
                    {
                        //answer
                        
                    }
                    for ( $l = 1; $l <= 4;$l++)
                    {
                        $_new_multiple_choice = $new_multiple_choice."_".$l;

                        if (isset($request->$_new_multiple_choice))
                        {
                            //option
                            $data_question_type->$l = $request->$_new_multiple_choice;
                        }
                    }
                }
                
            }
           
            $data_question_type->save();
            
        } return $request;
        
    }
}
