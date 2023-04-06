<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Institute;
use App\Models\Course;
use App\Models\User;

class IndustrialMarketing extends Model
{
    protected $fillable = [
        'name',
        'year',
        'phone',
        'institute',
        'course',
        'note',
        'created_at',
        'updated_at',
        'created_by',
        'updated_by',
        'status',
        'shift'
    ];
    public function institutes(){
        $this->belongsToMany(Institute::class);
    }
    public function courses(){
        $this->belongsToMany(Course::class);
    }

    public function institute()
    {
        $institute = Institute::find($this->institute);
        return $institute;
    }
    public function course()
    {
        $course = Course::find($this->course);
        return $course;
    }
    public function created_user(){
        return $this->belongsTo(User::class,'created_by','id');
    }
    public function updated_user(){
        return $this->belongsTo(User::class,'updated_by','id');
    }

}