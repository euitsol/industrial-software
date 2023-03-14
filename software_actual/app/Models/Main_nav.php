<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Main_nav extends Model
{

    protected $table = 'eit_mainnav';


    public function sub_menu()
    {
        return $this->hasOne(Main_nav::class,'sN_id','sN_id');
    }
    public function m_add()
    {
        return $this->hasOne(User::class,'id','user_id');
    }

}
