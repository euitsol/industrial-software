<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BatchAttendance;
use App\Models\StudentAttendance;
use App\Models\Session;
use App\Models\Student;
use App\Models\Course;
use App\Models\BatchStudent;
use App\Models\Institute;
use Carbon\Carbon;

class AttendanceReportController extends Controller
{
    public function batchWise(){
        return view('attendance_report.batch_wise_search');
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

            $check = BatchAttendance::where('course_type', $course_type)
            ->where('course_id', $course_id)
            ->where('batch_id', $batch_id)->first();

            
            
            if ($check == null) {
                $insert = new BatchAttendance();
                $insert->course_type = $course_type;
                $insert->course_id = $course_id;
                $insert->batch_id = $batch_id;
                $insert->created_at = Carbon::now();
                $insert->created_by = auth()->user()->id;
                $insert->save();
                $id = $insert->id;
            }else{
                $id = $check->id;
            }
            return redirect()->route('attendance_report.batch', compact('id'));
        }
    }
    public function batchAttendanceReport($id){
        $n['minfo'] = BatchAttendance::with(['created_user', 'course', 'batch'])->findOrFail($id);
        $n['students'] = BatchStudent::with('student')
                        ->where('batch_id', $n['minfo']->batch_id)
                        ->get();
        return view('attendance.attendance_report', $n);
    }


    // Attendance Report Session and Institute wise
    public function institute_index()
    {
        $institutes = Institute::all();
        $sessions = Session::all();
        return view('attendance_report.attendance_reportBy_institute', compact('institutes', 'sessions'));
    }
    public function sessionInstituteStudents(Request $request)
    {
        $session_id = $request->session;
        $institute_id = $request->institute;
        $shift = $request->shift;
        return redirect()->route('attendance_report.institute', compact('session_id','institute_id','shift'));
    }
    public function instituteAttendanceReport($session_id,$institute_id,$shift){

        $ids = array();
        $student = '';
        if($session_id == 'all' && $shift == 'all'){
            $students = Student::with(['batches'])
                    ->where('institute_id', $institute_id)
                    ->get();
        }elseif($session_id == 'all' ){
            $students = Student::with(['batches'])
                    ->where('institute_id', $institute_id)
                    ->where('shift',$shift)
                    ->get();
        }elseif($shift == 'all'){
            $students = Student::with(['batches'])->where('session_id',$session_id)
                    ->where('institute_id', $institute_id)
                    ->get();
        }else{
        $students = Student::with(['batches'])->where('session_id',$session_id)
                    ->where('institute_id', $institute_id)
                    ->where('shift',$shift)
                    ->get();
        }
        foreach($students as $student){
            foreach($student->batches as $batch){
                $check = BatchAttendance::where('course_id',$batch->course->id)->where('batch_id',$batch->id)->first();
                if($check ==null) {
                    $insert = new BatchAttendance();
                    $insert->course_type = 'Industrial';
                    $insert->course_id = $batch->course->id;
                    $insert->batch_id = $batch->id;
                    $insert->created_at = Carbon::now();
                    $insert->created_by = auth()->user()->id;
                    $insert->save();
                    $ids[] = $insert->id;
                        
                }else{
                    $ids[] = $check->id;
                }
            }
        }
        $minfo = array();
        $ids = array_unique($ids);
        foreach($ids as $id){
            $minfo[]= BatchAttendance::with(['created_user', 'course', 'batch'])->findOrFail($id);
        }
        $institute = Institute::find($institute_id);
        $session = Session::find($session_id);
        return view('attendance_report.students_by_institute', compact('students','institute','shift','session','minfo'));
    }
    public function StudentSingleAttendanceView($stid, $baid){
        
        $n['student'] = Student::findOrFail($stid);
        $n['minfo'] = array();
        foreach($n['student']->courses as $ck => $course){
            foreach($n['student']->batches as $bk => $batch){
                $n['minfo'][] = BatchAttendance::where('course_id',$course->id)->where('batch_id',$batch->id)->get();
            }
        }
        return view('attendance_report.single_attendance_report',$n);

    }
}
