<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mentor extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function educations()
    {
        return $this->hasMany(MentorEducation::class);
    }

    public function employmentHistories()
    {
        return $this->hasMany(MentorEmploymentHistory::class);
    }

    public function specializations()
    {
        return $this->hasMany(MentorSpecialization::class);
    }

    public function courses()
    {
        return $this->belongsToMany(Course::class)->withTimestamps();
    }

    public function batches()
    {
        return $this->belongsToMany(Batch::class)->withTimestamps();
    }
}
