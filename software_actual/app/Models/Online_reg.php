<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Online_reg extends Model
{
    protected $table = 'online_registration';
    
    public function course(){
        return $this->belongsTo(Course::class, 'course_id', 'id');
    }
    public function getStatus(){
        switch($this->status) {
            case(1):
                return 'Registered';
            default:
                return 'Not Defined';
                
        }
    }
    
    
}
