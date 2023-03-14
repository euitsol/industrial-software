<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Batch;
use App\Models\Course;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class ChangecoursebatchController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index($sid, $cid, $bid)
    {
        if (Auth::user()->role == 'admin'){
            $student = Student::find($sid);
            $course = Course::find($cid);
            $courses = Course::where('type', $course->type)->get();
            $batch = Batch::find($bid);
            $batches = Batch::where('course_id', $cid)->where('status', 1)->get();
            return view('change.index', compact('student', 'course', 'courses', 'batch', 'batches', 'cid', 'bid'));
        } else {
            abort(403);
        }
    }


    public function ajaxCall()
    {
        if (request()->ajax() && Auth::user()->role == 'admin') {
            $cid = $_GET['cid'];
            $batches = Batch::where('course_id', $cid)->where('status', 1)->get();
            $html = '<select name="batch" id="batch" class="form-control form-control-success"
                                                    required>';
            if (count($batches) > 0) {
                foreach ($batches as $b) {
                    $html .= '<option value="' . $b->id . '"> ' . batch_name($b->course->title_short_form, $b->year, $b->month, $b->batch_number) . ' </option> ';
                }
            } else {
                $html .= '<option selected disabled hidden>No Batch for this course</option>';
            }
            $html .= '</select>';
            return $html;
        } else {
            return json_encode(['success' => false]);
        }
    }


    public function change(Request $request, $sid, $cid, $bid)
    {
        if (Auth::user()->role == 'admin'){
            $request->validate([
                'course' => 'required',
                'batch' => 'required',
            ]);
            DB::beginTransaction();
            try {
                $student = Student::find($sid);
                $batches = $student->batches;
                $bs = [];
                foreach ($batches as $b){
                    if ($b->id != $bid){
                        $bs[] = $b->id;
                    }
                }
                $bs[] = $request->batch;
                $student->batches()->sync($bs);
                $cources = $student->courses;
                $cs = [];
                foreach ($cources as $c){
                    if ($c->id != $cid){
                        $cs[] = $c->id;
                    }
                }
                $cs[] = $request->course;
                $student->courses()->sync($cs);
                $a = Account::where('student_id', $sid)->where('course_id', $cid)->first();
                if ($a){
                    $a->course_id = $request->course;
                    $a->update();
                }
                DB::commit();
                $success = true;
            } catch (\Exception $e) {
                $success = false;
                DB::rollback();
            }
            if ($success) {
                Session::flash('success', "The course / batch has been updated successfully.");
                return redirect()->route('student.show', ['sid' => $sid]);
            } else {
                Session::flash('error', "Something went wrong :(");
                return redirect()->back();
            }
        } else {
            abort(403);
        }
    }


}
