<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\BatchAttendance;
use App\Models\Student;

class StudentAttendance extends Model
{
    protected $table = 'student_attendances';

    public function created_user(){
        return $this->belongsTo(User::class,'created_by','id');
    }
    public function updated_user(){
        return $this->belongsTo(User::class,'updated_by','id');
    }
    public function student(){
        return $this->belongsTo(Student::class, 'student_id', 'id');
    }
    public function batch_attendance(){
        return $this->belongsTo(BatchAttendance::class. 'batch_attendance_id', 'id');
    }
    public function attedanceStatus(){
        switch($this->attendance_status) {
            case(1):
                return 'fa fa-check text-success';
            case(-1):
                return 'fa fa-times text-danger';
            default:
                return '';
                
        }
    }
    public function attendance($batch_attendance_id,$std_id){

        $class = $this->class;

        $check_attendance = StudentAttendance::where('batch_attendance_id',$batch_attendance_id)
                            ->where('student_id',$std_id)
                            ->where('class',$class)
                            ->where('attendance_status',1)
                            ->first();
        if($check_attendance==null){
            return true;
        }
        else{
            return false;
        }
    }
}
