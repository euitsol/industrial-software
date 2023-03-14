<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    public function account()
    {
        return $this->belongsTo(Account::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
        
    public function cashtobank()
    {
        return $this->belongsTo(CashToBank::class);
    }
}
