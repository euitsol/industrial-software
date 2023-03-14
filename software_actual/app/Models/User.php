<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'username', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function course_types()
    {
        return $this->hasMany(CourseType::class);
    }

    public function courses()
    {
        return $this->hasMany(Course::class);
    }

    public function mentors()
    {
        return $this->hasMany(Mentor::class);
    }

    public function institutes()
    {
        return $this->hasMany(Institute::class);
    }

    public function students()
    {
        return $this->hasMany(Student::class);
    }

    public function accounts()
    {
        return $this->hasMany(Account::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function batches()
    {
        return $this->hasMany(Batch::class);
    }

    public function teachers()
    {
        return $this->hasMany(Teacher::class);
    }
}
