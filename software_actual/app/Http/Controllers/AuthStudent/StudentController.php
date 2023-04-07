<?php

namespace App\Http\Controllers\AuthStudent;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class StudentController extends Controller
{
    public function studentProfile(){
        return view('student_panel.student.profile');
    }
}
