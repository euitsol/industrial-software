<?php

namespace App\Models;

use App\Models\Teacher;
use Illuminate\Database\Eloquent\Model;

class Institute extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function teachers()
    {
        return $this->hasMany(Teacher::class);
    }

    public function students()
    {
        return $this->hasMany(Student::class);
    }
}
