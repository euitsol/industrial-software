<?php

namespace App\Http\Controllers\AuthStudent;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\BatchAttendance;
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
}
