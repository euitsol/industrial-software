<?php

namespace App\Models;

use App\Models\User;
use App\Models\Course;
use App\Models\Student;
use App\Models\InstallmentDate;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function installment_dates()
    {
        return $this->hasMany(InstallmentDate::class);
    }
}
