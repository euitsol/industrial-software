<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Student;
use App\Models\JobPlacement;

class JobPlacementController extends Controller
{
    public function index()
    {
        $students = Student::latest()->get();
        return view('job_placement.index', compact('students'));
    }
    public function profileSearch(Request $request){
        $request->validate([
            'student' => 'required'
        ]);
        $student_id = $request->student;
        return redirect()->route('job_placement.profile.student.info', $student_id);
    }
    public function studentCourses($sid){
        $student = Student::with('courses')->with('batches')->findOrFail($sid);
        $job_placement = JobPlacement::where('student_id',$sid)->first();

        if (isset($student->courses)) {
            $courses = $student->courses;
        }
        return view('job_placement.student_info', compact('student', 'courses','job_placement'));
    }

    public function create($id)
    {
        $student_id = $id;
        return view('job_placement.create',compact('student_id'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'company_name' => 'required|max:255',
            'designation' => 'required|max:255',
            'joining_date' => 'required|date',
            'company_address' => 'required|max:255',
        ]);

            $m = new JobPlacement;
            $m->student_id = $request->student_id;
            $m->company_name = $request->company_name;
            $m->designation = $request->designation;
            if (isset($request->department))
            {
                $m->department = $request->department;
            }
            $m->joining_date = $request->joining_date;
            if (isset($request->company_web_url))
            {
                $m->company_web_url = $request->company_web_url;
            }
            $m->company_address = $request->company_address;
            if (isset($request->company_phone))
            {
                $m->company_phone = $request->company_phone;
            }
            if (isset($request->company_email))
            {
                $m->company_email = $request->company_email;
            }
            $m->created_by = auth()->user()->id;
            $m->created_at = Carbon::now();
            $m->save();

            $this->message('success', 'Job placement add successfully');
            return redirect()->route('job_placement.profile.student.info',$request->student_id);
    }
    public function show($jp_id)
    {
        $jp = JobPlacement::findOrFail($jp_id);
        return view('job_placement.show', compact('jp'));
    }
    public function edit($id){
        $jp = JobPlacement::findOrFail($id);
        return  view('job_placement.edit',compact('jp'));
    }
    public function update(Request $request){

        $request->validate([
            'company_name' => 'required|max:255',
            'designation' => 'required|max:255',
            'joining_date' => 'required|date',
            'company_address' => 'required|max:255',
        ]);

            $m = JobPlacement::find($request->id);
            $m->company_name = $request->company_name;
            $m->designation = $request->designation;
            if (isset($request->department))
            {
                $m->department = $request->department;
            }
            $m->joining_date = $request->joining_date;
            if (isset($request->company_web_url))
            {
                $m->company_web_url = $request->company_web_url;
            }
            $m->company_address = $request->company_address;
            if (isset($request->company_phone))
            {
                $m->company_phone = $request->company_phone;
            }
            if (isset($request->company_email))
            {
                $m->company_email = $request->company_email;
            }
            $m->updated_by = auth()->user()->id;
            $m->updated_at = Carbon::now();
            $m->update();

            $this->message('success', 'Job placement update successfully');
            return redirect()->route('job_placement.profile.student.info',$m->student_id);

    }
}
