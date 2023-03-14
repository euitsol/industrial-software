<?php

namespace App\Models;

use App\Models\Main_nav;
use App\Models\Nav_assign_bkdn;
use Illuminate\Database\Eloquent\Model;

class Nav_assign extends Model
{

    protected $table = 'eit_nav_assign';


    public function user()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }
    public function na_bkdn()
    {
        return $this->hasMany(Nav_assign_bkdn::class,'nA_id','nA_id');
    }
    
    


}
