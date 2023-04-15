<?php

namespace App\Http\Controllers\AuthStudent;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\BatchAttendance;
use App\Models\JobPlacement;
use App\Models\LinkageIndustryInfo;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
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
            'designation' => 'required|max:255',
            'joining_date' => 'required|date',
        ]);
        if (!isset($request->company_name)){
            $request->validate([
                'linkage_industry_info_id' => 'required',
            ]);
        }
        if (empty($request->linkage_industry_info_id) && empty($request->company_name)) {
            $this->message('error', 'Please select or add new company info.');
            return redirect()->back()->withInput();
        }
        if (!empty($request->linkage_industry_info_id) && !empty($request->company_name)) {
            $this->message('error', 'Company has both items data not applicable.');
            return redirect()->back()->withInput();
        }

        if (isset($request->company_name)) {
            if (empty($request->company_name) || empty($request->company_logo) || empty($request->company_website) || empty($request->company_address) || empty($request->contact_person_name) || empty($request->contact_number) || empty($request->contact_email) || empty($request->description)) {
                // $this->message('error', 'All field required!.');
                $request->validate([
                    'company_name' => 'required|max:255',
                    'company_logo' => 'image|mimes:jpg,jpeg,png,JPG,JPEG,PNG|max:5120',
                    'company_website' => 'required|max:255',
                    'company_address' => 'required|max:255',
                    'contact_person_name' => 'required|max:255',
                    'contact_number' => 'required',
                    'contact_email' => 'required',
                    'description' => 'required|max:10000',
                ]);
                return redirect()->back()->withInput();
            }
        }

            $m = new JobPlacement;
            $m->student_id = $request->student_id;

            if (empty($request->linkage_industry_info_id) && !empty($request->company_name)) {
                $data = new LinkageIndustryInfo;
                $data->company_name = $request->company_name;

                if ($request->hasFile('company_logo')) {
                    $logo = $request->company_logo;
                    $img_name = time() . '_' . $logo->getClientOriginalName();
                    $logo->move('uploads/images/', $img_name);
                    $data->company_logo = 'uploads/images/' . $img_name;
                    
                }

                $data->company_website = $request->company_website;
                $data->company_address = $request->company_address;
                $data->contact_person_name = $request->contact_person_name;
                $data->contact_number = $request->contact_number;
                $data->contact_email = $request->contact_email;
                $data->description = $request->description;
                $data->created_by = 35;
                $data->created_at = Carbon::now();
                $data->save();
                
                $id = LinkageIndustryInfo::latest()->first();
                $m->linkage_industry_info_id = $id->id;
            } else {
                $m->linkage_industry_info_id = $request->linkage_industry_info_id;
            }
            $m->designation = $request->designation;
            if (isset($request->department))
            {
                $m->department = $request->department;
            }
            $m->joining_date = $request->joining_date;
            $m->created_by = 35;
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
            $m->updated_by = 35;
            $m->updated_at = Carbon::now();
            $m->update();

            $this->message('success', 'Job placement update successfully');
            return redirect()->route('student.job_placement.info',$m->student_id);

    }

    public function studentCourse(){
        $data['student'] = Student::with(['courses','batches'])->where('id',Auth::guard('student')->user()->id)->first();
        return view('student_panel.payment.index',$data);
    }
}
