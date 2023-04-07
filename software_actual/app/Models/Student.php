<?php

namespace App\Models;

use App\Models\Account;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Student extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name','phone', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function institute()
    {
        return $this->belongsTo(Institute::class);
    }

    public function accounts()
    {
        return $this->hasMany(Account::class);
    }

    public function courses()
    {
        return $this->belongsToMany(Course::class)->withTimestamps();
    }

    public function batches()
    {
        return $this->belongsToMany(Batch::class)->withTimestamps();
    }
    
    public function shift()
    {
        if($this->shift == null || $this->shift == ""){
            return "Others";
        }elseif($this->shift == "2"){
            return "2nd shift";
        }else{
            return "1st shift";
        }
    }
    public function sessions(){
        return $this->belongsTo(Session::class,'session_id','id');
    }
    public function source(){

        return $this->belongsTo(Source::class,'source_id');

    }

    public function referral(){

        return $this->belongsTo(Referral::class,'referral_id');

    }

}
