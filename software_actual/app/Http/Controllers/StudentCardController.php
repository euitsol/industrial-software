<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Institute;
use App\Models\BatchStudent;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use function GuzzleHttp\Psr7\str;

class StudentCardController extends Controller
{
    public function index()
    {
        $data['institutes'] = Institute::all();
        $data['divisions'] = Institute::select('division')->groupBy('division')->get();
        
        $data['result'] = Student::select(DB::raw('YEAR(created_at) as year'))->distinct()->orderBy('created_at')->get();
        $data['years'] = $data['result']->pluck('year');
        
        return view('student_card.student_card_institute', $data);
    }
    public function studentCardFind(Request $request)
    {
        if (isset($request->institute)) {
            return redirect()->route('student_card.institute.cards', [$request->institute, $request->year]);
        }
        return redirect()->back();
    }
    public function studentsCardInstitute($iid, $year)
    {
        $data['students'] = Student::where('institute_id', $iid)->where('year', '=', $year)->latest()->get();
        return view('student_card.student_cards', $data);
    }
    public function batchWiseCard(){
        return view('student_card.student_card_batch');
    }
    public function batchWiseSearch(Request $request)
    {
        if (empty($request->course_type)) {
            session()->flash('error', 'Please select course type first.');
            return redirect()->back();
        }
        else{
            $course_type = $request->course_type;
            $course_id = $request->course;
            $batch_id = $request->batch;
            return redirect()->route('student_card.batch.view', compact('course_type','course_id','batch_id'));
        }
    }
    public function batchStudentCard($ctid, $cid, $bid){
        $s['students'] = BatchStudent::with('student')
                        ->where('batch_id', $bid)
                        ->get();
        return view('student_card.batch_student_cards', $s);
    }

    public function selectedCards()
    {
        $s['students'] = Student::where('card_print_status', 0)->latest()->get();
        return view('student_card.selected_cards', $s);
    }
    public function selectedCardsClear()
    {
        $students = Student::where('card_print_status', 0)->latest()->get();
        foreach($students as $student){
            $student->card_print_status = 1;
            $student->save();
        }
        $this->message('success', 'Selected card cleared successfully');
        return redirect()->back();
    }
}
