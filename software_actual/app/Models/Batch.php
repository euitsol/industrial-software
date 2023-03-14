<?php

namespace App\Models;
use App\Models\Account;
use Illuminate\Database\Eloquent\Model;

class Batch extends Model
{
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function students()
    {
        return $this->belongsToMany(Student::class)->withTimestamps();
    }

    public function mentors()
    {
        return $this->belongsToMany(Mentor::class)->withTimestamps();
    }
        public function course_type()
    {
        return $this->belongsTo(CourseType::class);
    }
        public function accounts()
    {
        return $this->belongsToMany(Account::class);
    }
    public function lab()
    {
        return $this->belongsTo(Lab::class, 'lab_id');
    }


}
