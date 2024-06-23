<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PreRegistration extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function institute()
    {
        return $this->belongsTo(Institute::class);
    }
    public function shift()
    {
        if ($this->shift == null || $this->shift == "") {
            return "Others";
        } elseif ($this->shift == 2) {
            return "2nd shift";
        } else {
            return "1st shift";
        }
    }
    public function sessions()
    {
        return $this->belongsTo(Session::class, 'session_id', 'id');
    }
    public function statusBg()
    {
        switch ($this->status) {
            case 1:
                return 'badge badge-success';
            default:
                return 'badge badge-warning';
        }
    }
    public function statusTitle()
    {
        switch ($this->status) {
            case 1:
                return 'Admitted';
            default:
                return 'Not Admitted';
        }
    }
}