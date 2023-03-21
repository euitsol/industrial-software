<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Batch;
use App\Models\Student;

class BatchStudent extends Model
{
    protected $table = 'batch_student';

    public function batch(){
        return $this->belongsTo(Batch::class, 'batch_id','id');
    }
    public function student(){
        return $this->belongsTo(Student::class, 'student_id','id');
    }
}
