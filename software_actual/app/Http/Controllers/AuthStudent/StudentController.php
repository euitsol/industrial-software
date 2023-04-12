<?php

namespace App\Http\Controllers\AuthStudent;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\BatchAttendance;
use App\Models\JobPlacement;
use App\Models\LinkageIndustryInfo;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class StudentController extends Controller
{
    public function studentProfile(){
        $data['student'] = Student::with(['courses', 'batches'])->find(Auth::guard('student')->user()->id);
        $data['minfo'] = array();
        foreach($data['student']->courses as $ck => $course){
            foreach($data['student']->batches as $bk => $batch){
                $data['minfo'][] = BatchAttendance::where('course_id',$course->id)->where('batch_id',$batch->id)->get();
            }
        }
        
        return view('student_panel.student.profile',$data);
    }
    public function studentProfileImgUpdate(Request $request){
        $request->validate([
            'photo' => 'image|mimes:jpg,jpeg,png,JPG,JPEG,PNG|max:5120',
        ]);

        $s = Student::findOrFail($request->id);
        if ($request->hasFile('photo')) {
            if (!empty($s->photo) && file_exists($s->photo)) {
                unlink($s->photo);
            }
            $photo = $request->photo;
            $img_name = time() . '_' . $photo->getClientOriginalName();
            $photo->move('uploads/images/', $img_name);
            $s->photo = 'uploads/images/' . $img_name;
        }
        $s->save();

        $this->message('success', 'Profile photo update successfully');
        return redirect()->back();
    }

    public function registrationCard(){
        $data['student'] = Student::with(['courses', 'batches'])->find(Auth::guard('student')->user()->id);
        return view('student_panel.student.registration_card', $data);
    }
    public function studentAttendance(){
        $data['student'] = Student::findOrFail(Auth::guard('student')->user()->id);
        $data['minfo'] = array();
        foreach($data['student']->courses as $ck => $course){
            foreach($data['student']->batches as $bk => $batch){
                $data['minfo'][] = BatchAttendance::where('course_id',$course->id)->where('batch_id',$batch->id)->get();
            }
        }
        return view('student_panel.student.attendance_report', $data);
    }



    public function studentJobPlace(){
        $data['student'] = Student::with(['courses','batches'])->findOrFail(Auth::guard('student')->user()->id);
        $data['job_placement'] = JobPlacement::with('linkageIndustry')->where('student_id',Auth::guard('student')->user()->id)->first();

        if (isset($data['student']->courses)) {
            $data['courses'] = $data['student']->courses;
        }
        return view('student_panel.job_placement.student_info', $data);
    }

    public function JPcreate($id)
    {
        $data['student_id'] = $id;
        $data['linkage_industries'] = LinkageIndustryInfo::latest()->get();
        return view('student_panel.job_placement.create',$data);
    }
    public function JPstore(Request $request)
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
            return redirect()->route('student.job_placement.info',$request->student_id);
    }
    public function JPshow($jp_id)
    {
        $data['jp'] = JobPlacement::findOrFail($jp_id);
        $data['linkage_industry'] = LinkageIndustryInfo::where('id',$data['jp']->linkage_industry_info_id)->first();
        return view('student_panel.job_placement.show', $data);
    }
    public function JPedit($id){
        $data['jp'] = JobPlacement::findOrFail($id);
        $data['linkage_industries'] = LinkageIndustryInfo::latest()->get();
        return  view('student_panel.job_placement.edit',$data);
    }
    public function JPupdate(Request $request){

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
            return redirect()->route('student.job_placement.info',$m->student_id);

    }
}
