<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class LinkageIndustryInfo extends Model
{
    protected $table = 'linkage_industry_infos';
    public function created_user()
    {
        return $this->belongsTo(User::class,'created_by','id');
    }

    public function updated_user()
    {
        return $this->belongsTo(User::class,'updated_by','id');
    }
}
