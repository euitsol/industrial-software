<?php

namespace App\Http\Controllers\AuthStudent;

use Illuminate\Http\Request;
use App\Models\Student;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class StudentController extends Controller
{
    public function studentProfile(){
        // $data['account'] = Account::findOrFail(Auth::guard('student')->user()->id);
        // $data['payments'] = Payment::where('account_id',$account->id)->get();
        $data['student'] = Student::with(['courses', 'batches'])->find(Auth::guard('student')->user()->id);
        return view('student_panel.student.profile',$data);
    }
}
