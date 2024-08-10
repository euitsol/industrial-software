<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CourseStudent extends Model
{
    protected $table = 'course_student';

    public function course(){
        return $this->belongsTo(Course::class, 'course_id','id');
    }
    public function student(){
        return $this->belongsTo(Student::class, 'student_id','id');
    }

}
