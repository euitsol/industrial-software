<?php

namespace App\Models;

use App\Models\User;
use App\Models\Session;
use Illuminate\Database\Eloquent\Model;

class Fees extends Model
{
    protected $table = 'fees';
    public function session()
    {
        return $this->belongsTo(Session::class, 'session_id');
    }
    public function created_user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    public function updated_user()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
