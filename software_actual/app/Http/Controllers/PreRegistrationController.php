<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\PreRegistration;
use App\Models\Institute;
use App\Models\CourseType;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

use Carbon\Carbon;

class PreRegistrationController extends Controller
{

    public function registration()
    {
        $institutes = Institute::latest()->get();
        $courseTypes = CourseType::all();


        return view('pre_registration.index', compact('institutes', 'courseTypes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'fathers_name' => 'required|string|max:255',
            'mothers_name' => 'required|string|max:255',

            'present_address' => 'required|string|max:255',
            'permanent_address' => 'required|string|max:255',

            'dob' => 'required|date',
            'gender' => 'required|in:male,female',

            'phone' => 'required|numeric|digits:11|unique:pre_registrations,phone',
            'parents_phone' => 'nullable|numeric|digits:11',
            'email' => 'nullable|email|unique:pre_registrations,email',

            'nationality' => 'nullable|string|max:255',
            'nid' => 'nullable|string|max:255',

            'blood_group' => 'nullable|in:A+,A-,B+,B-,AB+,AB-,O+,O-',

            'student_as' => 'nullable|string|max:255',
            'institute' => 'required|exists:institutes,id',

            'shift' => 'nullable|string|max:255',
            'board_roll' => 'required|string|max:255',
            'board_reg' => 'required|string|max:255',

            'emergency_contact_name' => 'required|string|max:255',
            'emergency_contact_address' => 'required|string|max:255',
            'emergency_contact_relation' => 'required|string|max:255',
            'emergency_contact_phone' => 'required|numeric|digits:11',
        ]);


        $date = Carbon::now();
        $regNo = '0000';

        $s = new PreRegistration;
        $s->reg_no = $regNo;
        $s->name = $request->name;
        $s->fathers_name = $request->fathers_name;
        $s->mothers_name = $request->mothers_name;

        if ($request->hasFile('photo')) {
            $photo = $request->photo;
            $img_name = time() . '_' . $photo->getClientOriginalName();
            $photo->move('uploads/images/pre-admission/', $img_name);
            $s->photo = 'uploads/images/pre-admission/' . $img_name;
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

        $s->student_as = 'Industrial';
        $s->year = $date->year;
        $s->institute_id = $request->institute;

        $s->emergency_contact_name = $request->emergency_contact_name;
        $s->emergency_contact_address = $request->emergency_contact_address;
        $s->emergency_contact_relation = $request->emergency_contact_relation;
        $s->emergency_contact_phone = $request->emergency_contact_phone;

        $s->save();


        $this->message('success', "Your registration is successful");
        return redirect()->route('pre.reg.success');
    }

    public function success()
    {
        return view('pre_registration.success');
    }

    public function list($year = '')
    {
        $years = PreRegistration::select('year')->where('student_as', 'Industrial')->distinct()->get();
        $year = $year ? $year : ($years->max()->year ?? date('Y'));

        $students = PreRegistration::with('institute')->with('user')
            ->where('student_as', 'Industrial')
            ->where('year', $year)->latest()->get();

        $student_as = 'Industrial';
        $totalStudents = PreRegistration::where('student_as', 'Industrial')->get();
        return view('pre_registration.list', compact('students', 'student_as', 'years', 'year', 'totalStudents'));
    }
    public function show($sid)
    {
        $student = PreRegistration::with('institute')->findOrFail($sid);
        return view('pre_registration.show', compact('student'));
    }

    public function edit($sid)
    {
        $student = PreRegistration::findOrFail($sid);
        $institutes = Institute::latest()->get();
        return view('pre_registration.edit', compact('student', 'institutes'));
    }


    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'fathers_name' => 'required|string|max:255',
            'mothers_name' => 'required|string|max:255',

            'present_address' => 'required|string|max:255',
            'permanent_address' => 'required|string|max:255',

            'dob' => 'required|date',
            'gender' => 'required|in:male,female',

            'phone' => 'required|numeric|digits:11|unique:pre_registrations,phone,' . $request->id,
            'parents_phone' => 'nullable|numeric|digits:11',
            'email' => 'nullable|email|unique:pre_registrations,email,' . $request->id,

            'nationality' => 'nullable|string|max:255',
            'nid' => 'nullable|string|max:255',

            'blood_group' => 'nullable|in:A+,A-,B+,B-,AB+,AB-,O+,O-',

            'student_as' => 'nullable|string|max:255',
            'institute' => 'required|exists:institutes,id',

            'shift' => 'nullable|string|max:255',
            'board_roll' => 'required|string|max:255',
            'board_reg' => 'required|string|max:255',

            'emergency_contact_name' => 'required|string|max:255',
            'emergency_contact_address' => 'required|string|max:255',
            'emergency_contact_relation' => 'required|string|max:255',
            'emergency_contact_phone' => 'required|numeric|digits:11',
        ]);
        $date = Carbon::now();
        $regNo = '0000';
        $s = PreRegistration::findOrFail($request->id);
        $s->reg_no = $regNo;
        $s->name = $request->name;
        $s->fathers_name = $request->fathers_name;
        $s->mothers_name = $request->mothers_name;

        if ($request->hasFile('photo')) {
            if (!empty($s->photo) && file_exists($s->photo)) {
                unlink($s->photo);
            }
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

        $s->student_as = 'Industrial';
        $s->year = $date->year;
        $s->institute_id = $request->institute;

        $s->emergency_contact_name = $request->emergency_contact_name;
        $s->emergency_contact_address = $request->emergency_contact_address;
        $s->emergency_contact_relation = $request->emergency_contact_relation;
        $s->emergency_contact_phone = $request->emergency_contact_phone;

        $s->update();

        $this->message('success', 'Student info update successfully');

        return redirect()->route('pr.list');
    }


    public function destroy($sid)
    {
        $s = PreRegistration::findOrFail($sid);
        if ($s->status == 1) {
            $this->message('success', 'The student has already been admitted, so you cannot delete it.');
        } else {
            $s->delete();
            $this->message('success', 'Student info delete successfully');
        }
        return redirect()->back();
    }

    public function admit($sid)
    {
        $student = PreRegistration::findOrFail($sid);
        return view('pre_registration.admit', compact('student'));
    }
}
