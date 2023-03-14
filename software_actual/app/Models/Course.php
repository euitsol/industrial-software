<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function batches()
    {
        return $this->hasMany(Batch::class);
    }

    public function course_type()
    {
        return $this->belongsTo(CourseType::class);
    }

    public function students()
    {
        return $this->belongsToMany(Student::class)->withTimestamps();
    }

    public function account() {
        return $this->hasOne(Account::class);
    }

    public function mentors()
    {
        return $this->belongsToMany(Mentor::class)->withTimestamps();
    }
    
}
