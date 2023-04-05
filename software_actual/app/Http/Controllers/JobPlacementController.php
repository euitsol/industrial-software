<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Student;
use App\Models\JobPlacement;
use App\Models\LinkageIndustryInfo;

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
        $student = Student::with(['courses','batches'])->findOrFail($sid);
        $job_placement = JobPlacement::with('linkageIndustry')->where('student_id',$sid)->first();

        if (isset($student->courses)) {
            $courses = $student->courses;
        }
        return view('job_placement.student_info', compact('student', 'courses','job_placement'));
    }

    public function create($id)
    {
        $student_id = $id;
        $linkage_industries = LinkageIndustryInfo::latest()->get();
        return view('job_placement.create',compact('student_id','linkage_industries'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'linkage_industry_info_id' => 'required',
            'designation' => 'required|max:255',
            'joining_date' => 'required|date',
        ]);

            $m = new JobPlacement;
            $m->student_id = $request->student_id;
            $m->linkage_industry_info_id = $request->linkage_industry_info_id;
            $m->designation = $request->designation;
            if (isset($request->department))
            {
                $m->department = $request->department;
            }
            $m->joining_date = $request->joining_date;
            $m->created_by = auth()->user()->id;
            $m->created_at = Carbon::now();
            $m->save();

            $this->message('success', 'Job placement add successfully');
            return redirect()->route('job_placement.profile.student.info',$request->student_id);
    }
    public function show($jp_id)
    {
        $jp = JobPlacement::findOrFail($jp_id);
        $linkage_industry = LinkageIndustryInfo::where('id',$jp->linkage_industry_info_id)->first();
        return view('job_placement.show', compact('jp','linkage_industry'));
    }
    public function edit($id){
        $jp = JobPlacement::findOrFail($id);
        $linkage_industries = LinkageIndustryInfo::latest()->get();
        return  view('job_placement.edit',compact('jp','linkage_industries'));
    }
    public function update(Request $request){

        $request->validate([
            'linkage_industry_info_id' => 'required',
            'designation' => 'required|max:255',
            'joining_date' => 'required|date',
        ]);

            $m = JobPlacement::find($request->id);
            $m->linkage_industry_info_id = $request->linkage_industry_info_id;
            $m->designation = $request->designation;
            if (isset($request->department))
            {
                $m->department = $request->department;
            }
            $m->joining_date = $request->joining_date;
            $m->updated_by = auth()->user()->id;
            $m->updated_at = Carbon::now();
            $m->update();

            $this->message('success', 'Job placement update successfully');
            return redirect()->route('job_placement.profile.student.info',$m->student_id);

    }
}
