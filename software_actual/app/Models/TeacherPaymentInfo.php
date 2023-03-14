<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TeacherPaymentInfo extends Model
{
    public function institute()
    {
        return $this->belongsTo(Institute::class);
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    public function teacher_payments()
    {
        return $this->hasMany(TeacherPayment::class);
    }
}
