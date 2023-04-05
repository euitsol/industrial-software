<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Student;
use App\Models\LinkageIndustryInfo;

class JobPlacement extends Model
{
    protected $table = 'job_placements';

    public function created_user()
    {
        return $this->belongsTo(User::class,'created_by','id');
    }

    public function updated_user()
    {
        return $this->belongsTo(User::class,'updated_by','id');
    }
    public function student(){
        return $this->belongsTo(Student::class,'student_id','id');
    }
    public function linkageIndustry(){
        return $this->belongsTo(LinkageIndustryInfo::class,'linkage_industry_info_id','id');
    }
}
