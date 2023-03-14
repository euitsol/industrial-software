<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    protected $table = 'discount';

    public function discount()
    {
        return $this->belongsTo(Course::class,'course_id','id');
    }
    public function user()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }
    public function course_type()
    {
        return $this->belongsTo(CourseType::class);
    }
    
}
