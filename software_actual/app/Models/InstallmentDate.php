<?php

namespace App\Models;

use App\Models\Account;
use Illuminate\Database\Eloquent\Model;

class InstallmentDate extends Model
{
    public function account()
    {
        return $this->belongsTo(Account::class);
    }
}
