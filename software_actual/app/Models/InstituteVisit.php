<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class InstituteVisit extends Model
{
    
    public function getType() {
        switch ($this->type) {
            case 1:
                return 'Private';
            case 2:
                return 'public';
        }
    }
    
    public function user(){
        $user = User::findOrFail($this->created_by);
        return $user->name;
    }
    
    public function user2(){
        if($this->updated_by){
            $user = User::findOrFail($this->updated_by);
            return $user->name;
        }else{
            return 'No User Found';
        }

    }
    
}