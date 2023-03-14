<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OnlinePayment extends Model
{
    public function student(){
        return $this->belongsTo(Student::class, 'student_id', 'id');
    }
    public function course(){
        return $this->belongsTo(Course::class, 'course_id', 'id');
    }
    public function online_student(){
        return $this->belongsTo(Online_reg ::class, 'online_reg_id', 'id');
    }
}