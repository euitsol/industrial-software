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

    public function mb_type()
    {
        if($this->mb_payment_type == 1){
            return 'Bkash';
        }elseif($this->mb_payment_type == 2){
            return 'Rocket';
        }elseif($this->mb_payment_type == 3){
            return 'Nagad';
        }elseif($this->mb_payment_type == 4){
            return 'Nexus Pay';
        }else{
            return 'Not found';
        }
    }
}
