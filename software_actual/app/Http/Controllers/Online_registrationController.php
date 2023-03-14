<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Session;
use App\Models\Account;
use App\Models\Batch;
use App\Models\Course;
use App\Models\CourseMigration;
use App\Models\Student;
use App\Models\Online_reg;
use App\Models\Institute;
use App\Models\CourseType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class Online_registrationController extends Controller
{

public function new_reg_number($student_as, $year)
    {
        if (!empty($student_as) && !empty($year)) {
            $s = Online_reg::select('reg_no')->where('student_as', $student_as)->where('year', $year)->get()->max();
            if (isset($s->reg_no)) {
                if ($s->reg_no <= 8) {
                    return '0'.($s->reg_no + 1);
                }
                return ($s->reg_no + 1);
            }
            return '01';
        }

        /*if (request()->ajax() && !empty($student_as) && !empty($year)) {
            $s = Student::select('reg_no')->where('student_as', $student_as)->where('year', $year)->get()->max();
            if (isset($s->reg_no)) {
                if ($s->reg_no <= 8) {
                    return response()->json(['reg_no' => '0'.($s->reg_no + 1)]);
                }
                return response()->json(['reg_no' => ($s->reg_no + 1)]);
            }
            return response()->json(['reg_no' => '01']);
        }
        return response()->json([$student_as, $year]);*/
    }

    public function create()
    {
        $institutes = Institute::latest()->get();
        $courseTypes = CourseType::all();
        
            
        return view('online_admission.index', compact('institutes', 'courseTypes'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:170',
            'fathers_name' => 'required|max:170',
            'mothers_name' => 'required|max:170',
            'photo' => 'image|mimes:jpg,jpeg,png,JPG,JPEG,PNG|max:5000',
            'present_address' => 'required|max:170',
            'permanent_address' => 'required|max:170',
            'dob' => 'required',
            'gender' => 'required',
            'phone' => 'required|numeric|digits:11|unique:online_registration,phone',
            'nationality' => 'max:170',
            
            'emergency_contact_name' => 'max:170',
            'emergency_contact_relation' => 'max:170',
            'emergency_contact_address' => 'max:170',
            'district' => 'nullable|max:170'
        ]);

        $date = Carbon::now();
        $regNo = $this->new_reg_number('Industrial',$date->year);

        $s = new Online_reg;
        $s->reg_no = $regNo ?? '0';
        $s->name = $request->name;
        $s->fathers_name = $request->fathers_name;
        $s->mothers_name = $request->mothers_name;

        if ($request->hasFile('photo')) {
            $photo = $request->photo;
            $img_name = time() . '_' . $photo->getClientOriginalName();
            $photo->move('uploads/images/', $img_name);
            $s->photo = 'uploads/images/' . $img_name;
        }
        
        $s->board_roll = $request->board_roll;
        $s->shift = $request->shift;
        $s->board_reg = $request->board_reg;

        $s->present_address = $request->present_address;
        $s->permanent_address = $request->permanent_address;
        $s->dob = $request->dob;
        
        $s->gender = $request->gender;
        $s->phone = $request->phone;
        $s->parents_phone = $request->parents_phone;
        $s->email = $request->email;
        $s->nationality = $request->nationality;
        $s->nid = $request->nid;
        $s->birth = $request->birth;       
        $s->blood_group = $request->blood_group;  
        //     
        $s->student_as = 'Industrial';    
        $s->year = $date->year;

        $s->district = $request->district;
        $s->emergency_contact_name = $request->emergency_contact_name;
        $s->emergency_contact_address = $request->emergency_contact_address;
        $s->emergency_contact_relation = $request->emergency_contact_relation;
        $s->emergency_contact_phone = $request->emergency_contact_phone;
        
        $s->save();

        $student_id = $s->id;

        if($student_id != 0)
        {
            $this->message('success', "Your registration is successful" );
            return redirect()->route('web.cheackout', $student_id);
        }
        else
        {
            $this->message('error', "There is an error please try again" );
            return redirect()->back();
        }
        
        
    }
    public function cheackout($student_id)
    {
        $id = $student_id;
        $student = Online_reg::findorFail($student_id);
        $student_as = $student->student_as;
        
        $course_types = CourseType::with(['courses' => function ($query) use ($student_as) {
            $query->where('type', $student_as)
            ->where('status','Running')
            ->where('running', 1);
        }])->latest()->get();
        return view('online_admission.checkout', compact('student','course_types','id'));
    }

    public function course_update(Request $request)
    {
        $student_id = $request->student_id;
        $s = Online_reg::where('id', $request->student_id)
                            ->update(['course_id' => $request->course]);

        
        return redirect()->route('web.payment1', $student_id);
    }
    public function payment1($student_id)
    {
        $id = $student_id;
        $student = Online_reg::findorFail($student_id);
        $student_as = $student->student_as;
        $course_id = $student->course_id;
        $course = Course::findorFail($course_id);

        
        return view('online_admission.payment', compact('student','course','id'));
    }










}