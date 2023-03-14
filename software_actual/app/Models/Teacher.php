<?php

namespace App\Models;

use App\Models\Institute;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    public function institute()
    {
        return $this->belongsTo(Institute::class);
    }

    public function phones()
    {
        return $this->hasMany(TeacherPhone::class);
    }

    public function emails()
    {
        return $this->hasMany(TeacherEmail::class);
    }
}
