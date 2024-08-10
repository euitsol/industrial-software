<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Course;
use App\Models\Batch;
use App\Models\StudentAttendance;
use App\Models\User;
use App\Models\BatchStudent;
use App\Models\Mentor;
use DB;

class BatchAttendance extends Model
{
    protected $table = 'batch_attendances';

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id','id');
    }
    public function batch()
    {
        return $this->belongsTO(Batch::class, 'batch_id', 'id');
    }
    public function created_user(){
        return $this->belongsTo(User::class,'created_by','id');
    }
    public function updated_user(){
        return $this->belongsTo(User::class,'updated_by','id');
    }

    public function student_attendances()
    {
        return $this->hasMany(StudentAttendance::class);
    }
    public function getDate($class){
        $id = $this->id;

        $get_data = StudentAttendance::where('batch_attendance_id',$id)
                ->where('class',$class)
                ->first();
        return $get_data;
    }
    public function getAttend($class, $stdid){
        $id = $this->id;
        $getAttend = StudentAttendance::where('batch_attendance_id',$id)
                ->where('class',$class)->where('student_id', $stdid)
                ->first();
        return $getAttend;
        
    }
    public function countStd($batch_id){
        $students = BatchStudent::where('batch_id',$batch_id)
                ->get();
        $student_count = count($students);
        return $student_count;
    }
    public function countPresentStd($class){
        $id = $this->id;
        $present_students = StudentAttendance::where('batch_attendance_id',$id)
                    ->where('class',$class)
                    ->where('attendance_status',1)
                    ->get();
        $present_students = count($present_students);
        return $present_students;
    }
    public function attendanceCheck($class){
        $check = StudentAttendance::where('batch_attendance_id',$this->id)->where('class',$class)->first();
        if($check){
            return true;
        }else{
            return false;
        }
    }
    public function completeClassCount(){
        $id = $this->id;
        $completeClassCount = StudentAttendance::where('batch_attendance_id',$id)
        ->whereNotNull('date')
        ->distinct()
        ->count('class');
        return $completeClassCount;
    }
    public function studentTotalPresentCount($std_id){
        $id = $this->id;
        $studentTotalPresentCount = StudentAttendance::where('batch_attendance_id',$id)
        ->where('student_id', $std_id)
        ->where('attendance_status',1)
        ->get()
        ->count();
        return $studentTotalPresentCount;
    }
    public function studentTotalAbsentCount($std_id){
        $id = $this->id;
        $studentTotalPresentCount = StudentAttendance::where('batch_attendance_id',$id)
        ->where('student_id', $std_id)
        ->where('attendance_status',-1)
        ->get()
        ->count();
        return $studentTotalPresentCount;
    }

    public function mentorName($batch_id){
        $batch_mentors = DB::table('batch_mentor')->where('batch_id', $batch_id)->first();
        if($batch_mentors == null){
            return "N/A";
        }
        $mentor = Mentor::where('id',$batch_mentors->mentor_id)->first()->name;
        return $mentor;
    }
    public function comment($sid,$class){
        $attendance = StudentAttendance::where('student_id',$sid)->where('class',$class)->first();
        if($attendance){
            return $attendance->comment;
        }
    }

}
