<?php



namespace App\Models;



use Illuminate\Database\Eloquent\Model;



class Referral extends Model

{
    public function created_user()
    {
        return $this->belongsTo(User::class,'created_by','id');
    }

    public function updated_user()
    {
        return $this->belongsTo(User::class,'updated_by','id');
    }
    public function students(){
        return $this->hasMany(Student::class, 'referral_id');
    }
    public function getStatus(){
        switch($this->status){
            case(1):
                return 'Running';
            case(-1):
                return 'Closed';
            default:
                return '';
        }
    }

}

