<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MentorPaymentInfo extends Model
{
    public function mentor()
    {
        return $this->belongsTo(Mentor::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function batch()
    {
        return $this->belongsTo(Batch::class);
    }

    public function mentor_payments()
    {
        return $this->hasMany(MentorPayment::class);
    }
}
