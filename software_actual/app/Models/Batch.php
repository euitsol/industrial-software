<?php

namespace App\Models;
use App\Models\Account;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Batch extends Model
{
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function students()
    {
        return $this->belongsToMany(Student::class)->withTimestamps();
    }

    public function mentors()
    {
        return $this->belongsToMany(Mentor::class)->withTimestamps();
    }
        public function course_type()
    {
        return $this->belongsTo(CourseType::class);
    }
        public function accounts()
    {
        return $this->belongsToMany(Account::class);
    }
    public function lab()
    {
        return $this->belongsTo(Lab::class, 'lab_id');
    }
    public function endChangeCalculate($previous_end_date, $endDate){
        $end_date = Carbon::parse($endDate);
        $pre_end_date = Carbon::parse($previous_end_date);
        if($pre_end_date < $end_date){
            $adding_day = 'Added '. $pre_end_date->diffInDays($end_date).' days';
            return $adding_day;
        }elseif($pre_end_date > $end_date){
            $remove_day = 'Remove '. $end_date->diffInDays($pre_end_date).' days';
            return $remove_day;
        }
    }


}
