<?php

namespace App\Models;

use App\Models\User;

use App\Models\Sub_nav;
use Illuminate\Database\Eloquent\Model;

class Nav_assign_bkdn extends Model
{

    protected $table = 'eit_navassign_bkdn';

    public function main_menu()
    {
        return $this->hasOne(Main_nav::class,'mN_id','mN_id');
    }
    public function sub_menu()
    {
        return $this->belongsTo(Sub_nav::class,'sN_id','sN_id');
    }
    
    



}

