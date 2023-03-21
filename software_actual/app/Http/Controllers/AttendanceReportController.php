<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BatchAttendance;
use App\Models\StudentAttendance;
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
}
