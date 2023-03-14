<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MentorSpecialization extends Model
{
    public function mentor()
    {
        return $this->belongsTo(Mentor::class);
    }
}
