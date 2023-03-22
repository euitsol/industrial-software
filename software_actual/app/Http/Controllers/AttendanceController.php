<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BatchAttendance;
use App\Models\StudentAttendance;
use App\Models\Course;
use App\Models\BatchStudent;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{

    public function index()
    {
        return view('attendance.index');
    }
    public function attendanceClass(Request $request)
    {
        if (empty($request->course_type)) {
            session()->flash('error', 'Please select course type first.');
            return redirect()->back();
        }
        else{
            $request->validate([

                'course_type' => 'required',
                'course' => 'required',
                'batch' => 'required',
    
            ]);

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
            return redirect()->route('attendance.page', compact('id'));
        }
    }

    public function attendancePage($id){
        $n['minfo'] = BatchAttendance::with(['created_user', 'course', 'batch'])->findOrFail($id);
        return view('attendance.attendance_page', $n);
    }
    
    public function create($id, $class)
    {
        $n['minfo'] = BatchAttendance::with(['created_user', 'course', 'batch'])->findOrFail($id);
        $n['students'] = BatchStudent::with('student')
                        ->where('batch_id', $n['minfo']->batch_id)
                        ->get();
        $n['class'] = $class;
        $n['attendance_taken'] = StudentAttendance::where('class', $class)
            ->where('batch_attendance_id', $id)
            ->first();
        if((Auth::user()->role == 'admin' || Auth::user()->role == 'admin')){
            return view('attendance.create', $n);
        }elseif((empty($n['minfo']->getDate($class)->date) || ($n['minfo']->getDate($class)->date) == date('Y-m-d')) && Auth::user()->mentor_id != null){
            return view('attendance.create', $n);
        }else{
            return abort(404);
        }
        
    }

    public function store(Request $req)
    {
        $this->validate($req, [
            'student.*.id' => 'required',
        ]);
        // $date_check = StudentAttendance::where('batch_attendance_id', $req->batch_attendance_id)
        //             ->where('date', $req->date)
        //             ->where('class', $req->class)
        //             ->first();

        // if ($date_check) {
            // $date = StudentAttendance::where('date',date('Y-m-d'))->first();
            // if(empty($date)){
                $present = 0;
                $absent = 0;
                foreach ($req->student as $student) {
                    if ($student['attendance_status'] == 1) {
                        $present++;
                    }
                    if ($student['attendance_status'] == -1) {
                        $absent++;
                    }
                    $check = StudentAttendance::where('student_id', $student['id'])
                        ->where('batch_attendance_id', $req->batch_attendance_id)
                        ->where('class', $req->class)
                        ->first();
                    if ($check === null) {
                        $insert = new StudentAttendance();
                        $insert->student_id = $student['id'];
                        $insert->batch_attendance_id = $req->batch_attendance_id;
                        $insert->class = $req->class;

                        $insert->date = date('Y-m-d');
                        $insert->attendance_status = $student['attendance_status'];
                        $insert->created_by = auth()->user()->id;
                        $insert->save();
                    } else {
                        $check->student_id = $student['id'];
                        $check->batch_attendance_id = $req->batch_attendance_id;
                        $check->class = $req->class;
                        $check->attendance_status = $student['attendance_status'];
                        $check->updated_at = Carbon::now()->toDateTimeString();
                        $check->updated_by = auth()->user()->id;
                        $check->update();
                    }
                }
            // }else{
            //     $present = 0;
            //     $absent = 0;
            //     foreach ($req->student as $student) {
            //         if ($student['attendance_status'] == 1) {
            //             $present++;
            //         }
            //         if ($student['attendance_status'] == -1) {
            //             $absent++;
            //         }
            //         $check = StudentAttendance::where('student_id', $student['id'])
            //             ->where('batch_attendance_id', $req->batch_attendance_id)
            //             ->where('class', $req->class)
            //             ->first();
            //         if ($check === null) {
            //             $this->message('error', 'Today attendance already taken!');
            //         } else {
            //             $check->student_id = $student['id'];
            //             $check->batch_attendance_id = $req->batch_attendance_id;
            //             $check->class = $req->class;
            //             $check->attendance_status = $student['attendance_status'];
            //             $check->updated_at = Carbon::now()->toDateTimeString();
            //             $check->updated_by = auth()->user()->id;
            //             $check->update();
            //         }
            //     }
            // } 
        $total_std = $present + $absent;
        return redirect()->route('attendance.page', [$req->batch_attendance_id]);
    }
    public function attendanceReport($id){
        $n['minfo'] = BatchAttendance::with(['created_user', 'course', 'batch'])->findOrFail($id);
        $n['students'] = BatchStudent::with('student')
                        ->where('batch_id', $n['minfo']->batch_id)
                        ->get();
        return view('attendance.attendance_report', $n);
    }
}
