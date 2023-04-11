<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Institute;
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
        // $data['institute'] = Institute::find($iid);
        $data['students'] = Student::where('institute_id', $iid)->where('year', '=', $year)->latest()->get();
        // if (isset($students)) {
        //     foreach ($students as $student) {
        //         $courses = $student->courses;
        //         $accounts = $student->accounts;
        //         if (isset($courses)) {
        //             foreach ($courses as $key => $course) {
        //                 if (isset($accounts)) {
        //                     $_account = $accounts->where('student_id', $student->id)->where('course_id', $course->id)->first();
        //                     $_payments = isset($_account->payments) ? $_account->payments->sum('amount') : 0;
        //                     $total_fee = $this->courseFeeCalculate($_account, $course->fee);
        //                     $course['total_fee'] = $total_fee;
        //                     $course['payments'] = $_payments;
        //                 }
        //             }
        //         }
        //         if (isset($courses)) {
        //             foreach ($courses as $_k => $course) {
        //                 $student['total_amount'] = $course->fee;
        //                 // $student['total_amount'] = $course->total_fee;
        //                 $student['paid_amount'] = $course->payments;
        //                 $student['due_amount'] = $course->total_fee - $course->payments;
        //             }
        //         }
        //     }
        // }
        // dd($students);
        return view('student_card.student_cards', $data);
    }
}
