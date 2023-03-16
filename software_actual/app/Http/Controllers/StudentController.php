<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Batch;
use App\Models\Course;
use App\Models\CourseMigration;
use App\Models\Student;
use App\Models\Institute;
use App\Models\CourseType;
use App\Models\Payment;
use App\Models\Sms_history;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentController extends Controller
{
    public function index( $year = '')
    {
        $students_type = 'professional' ;
        $_students_type = ucfirst($students_type);

        if ($_students_type == 'Professional') {

            $years = Student::select('year')->where('student_as', 'Professional')->distinct()->get();
            $year = $year ? $year : ($years->max()->year ?? date('Y'));

            $students = Student::with('institute')->with('user')
                ->where('student_as', 'Professional')
                ->where('year', $year)->latest()->get();

            $student_as = 'Professional';
            $totalStudents = Student::where('student_as', 'Professional')->get();
            return view('student.index', compact('students', 'student_as', 'years', 'year', 'totalStudents'));

        } else {
            abort(403);
        }
    }

    









    public function index_2($year = '')
    {
        $students_type = 'industrial' ;
        $_students_type = ucfirst($students_type);

        if ($_students_type == 'Industrial') {

            $years = Student::select('year')->where('student_as', 'Industrial')->distinct()->get();
            $year = $year ? $year : ($years->max()->year ?? date('Y'));

            $students = Student::with('institute')->with('user')
                ->where('student_as', 'Industrial')
                ->where('year', $year)->latest()->get();

            $student_as = 'Industrial';
            $totalStudents = Student::where('student_as', 'Industrial')->get();
            return view('student.index', compact('students', 'student_as', 'years', 'year', 'totalStudents'));

        } else {
            abort(403);
        }
    }













    public function new_reg_number($student_as, $year)
    {
        if (!empty($student_as) && !empty($year)) {
            $s = Student::select('reg_no')->where('student_as', $student_as)->where('year', $year)->get()->max();
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
        $courses = Course::latest()->get();
        return view('student.create', compact('institutes', 'courses'));
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
            'phone' => 'required|unique:students,phone|max:11|min:11',
            'nationality' => 'max:170',
            'student_as' => 'required',
            'emergency_contact_name' => 'max:170',
            'emergency_contact_relation' => 'max:170',
            'emergency_contact_address' => 'max:170'
        ]);

        if ('Professional' == $request->student_as) {
            if (empty($request->district)) {
                $this->message('error', 'The district field is required');
                return redirect()->back()->withInput();
            }
        }

        if ('Industrial' == $request->student_as) {

            if (empty($request->institute) && empty($request->institute_name)) {
                $this->message('error', 'Please select or add new institute info.');
                return redirect()->back()->withInput();
            }

            if (isset($request->institute) && isset($request->institute_name)) {
                $this->message('error', 'Institute has both items data not applicable.');
                return redirect()->back()->withInput();
            }

            if (isset($request->institute_name)) {
                if (empty($request->institute_division) || empty($request->institute_district)) {
                    $this->message('error', 'The institute address, division, and district field is required.');
                    return redirect()->back()->withInput();
                }
            }

            if (empty($request->board_roll) || empty($request->board_reg)) {
                $this->message('error', 'The board roll and registration field is required.');
                return redirect()->back()->withInput();
            }

            if (!empty($request->board_roll) || !empty($request->board_reg)) {
                $request->validate([
                    'board_roll' => 'unique:students',
                    'board_reg' => 'unique:students'
                ]);
            }
        }

        $regNo = $this->new_reg_number($request->student_as, $request->year);

        $s = new Student;
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

        $s->present_address = $request->present_address;
        $s->permanent_address = $request->permanent_address;
        $s->dob = $request->dob;

        if (empty($request->institute) && !empty($request->institute_name)) {
            $i = new Institute;
            $i->name = $request->institute_name;
            $i->address = $request->institute_address;
            $i->division = $request->institute_division;
            $i->district = $request->institute_district;
            $i->website = $request->institute_website;
            $i->user_id = Auth::id();
            $i->save();

            $s->institute_id = $i->id;
        } else {
            $s->institute_id = $request->institute;
        }

        $s->board_roll = $request->board_roll;
        $s->shift = $request->shift;
        $s->board_reg = $request->board_reg;

        $s->phone = $request->phone;
        $s->parents_phone = $request->parents_phone;
        $s->email = $request->email;
        $s->nationality = $request->nationality;
        $s->nid = $request->nid;
        $s->birth = $request->birth;
        $s->gender = $request->gender;
        $s->blood_group = $request->blood_group;
        $s->note = $request->note;
        $s->student_as = $request->student_as;
        $s->year = $request->year;
        $s->district = $request->district;

        $s->emergency_contact_name = $request->emergency_contact_name;
        $s->emergency_contact_address = $request->emergency_contact_address;
        $s->emergency_contact_relation = $request->emergency_contact_relation;
        $s->emergency_contact_phone = $request->emergency_contact_phone;
        $s->session_id = $this->active_session()->id;
        $s->user_id = Auth::id();
        $s->save();
        
        if($s->id > 0){
            
            //reg successfull
            
                    $message = "প্রিয় শিক্ষার্থী, \n";
                    $message .= "আপনার নিবন্ধন সম্পন্ন হয়েছে। \n \n";
                    $message .= "ইউরোপিয়ান আইটি ইনস্টিটিউট। \n";
                    
                    // $message  = "Dear ".$s->name.",\n";
                    // $message .= "Your registration is completed.\n";
                    // $message .= "Please collect your gift from our institute. \n";
                    // $message .= "Sincerely,\n";
                    // $message .= "European IT Institute\n";
                    // $message .= "Contact Us: 01889977951\n";
                    
                    $result = $this->sendSms($s->phone, $message);
                    
            //sms history
                    $type = "Registration Successful";
                    $save = new Sms_history;
                    $save->user_id = Auth::id();
                    $save->message = $message;
                    $save->type = $type;         
                    $save->status = $result;
                    $save->receiver_no = $s->phone;
                    $save->save(); 
        }
        

        $this->message('success', 'Student info save successfully');
        return redirect()->route('student.course.assign', $s->id);
    }

    public function show($sid)
    {
        $student = Student::with('courses')->with('batches')->findOrFail($sid);
        return view('student.show', compact('student'));
    }


    public function edit($sid)
    {
        $student = Student::findOrFail($sid);
        $institutes = Institute::latest()->get();
        $courses = Course::latest()->get();
        return view('student.edit', compact('student', 'institutes', 'courses'));
    }


    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|max:170',
            'fathers_name' => 'required|max:170',
            'mothers_name' => 'required|max:170',
            'photo' => 'image|mimes:jpg,jpeg,png,JPG,JPEG,PNG|max:5120',
            'present_address' => 'required|max:170',
            'permanent_address' => 'required|max:170',
            'dob' => 'required',
            'gender' => 'required',
            'phone' => 'required|max:11|min:11',
            'student_as' => 'required'
        ]);

        $s = Student::findOrFail($request->id);
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

        $s->present_address = $request->present_address;
        $s->permanent_address = $request->permanent_address;
        $s->dob = $request->dob;

        $s->institute_id = $request->institute;
        $s->shift = $request->shift;
        $s->board_roll = $request->board_roll;
        $s->board_reg = $request->board_reg;

        $s->phone = $request->phone;
        $s->parents_phone = $request->parents_phone;
        $s->email = $request->email;
        $s->nationality = $request->nationality;
        $s->nid = $request->nid;
        $s->birth = $request->birth;
        $s->gender = $request->gender;
        $s->blood_group = $request->blood_group;
        $s->student_as = $request->student_as;
        $s->note = $request->note;

        $s->emergency_contact_name = $request->emergency_contact_name;
        $s->emergency_contact_address = $request->emergency_contact_address;
        $s->emergency_contact_relation = $request->emergency_contact_relation;
        $s->emergency_contact_phone = $request->emergency_contact_phone;
        $s->session_id = $this->active_session()->id;

        $s->user_id = Auth::id();
        $s->save();

        $this->message('success', 'Student info update successfully');

        $student = $s;
        return redirect()->route('student.show', compact('student'));
    }


    public function destroy($sid)
    {
        $s = Student::findOrFail($sid);

        if ($s->courses->count() > 0) {
            $this->message('error', "Student exist in courses. So you can't delete.");
            return redirect()->back();
        } elseif ($s->batches->count() > 0) {
            $this->message('error', "Student exist in batches. So you can't delete.");
            return redirect()->back();
        } elseif ($s->accounts->count() > 0) {
            $this->message('error', "Student have an account. So you can't delete.");
            return redirect()->back();
        } else {

            if (!empty($s->photo) && file_exists($s->photo)) {
                unlink($s->photo);
            }

            $student_as = $s->student_as;
            $s->courses()->detach();
            $s->batches()->detach();
            $s->delete();
            $this->message('success', 'Student info delete successfully');

            if ('Professional' == $student_as) {
                return redirect()->to('students/professional');
            } elseif ('Industrial' == $student_as) {
                return redirect()->to('students/industrial');
            }
            return redirect()->route('students');
        }
    }

    public function search_student()
    {
        $students = Student::latest()->get();
        return view('course_student.index', compact('students'));
    }

    public function student_search_process(Request $request)
    {
        $request->validate(['student' => 'required']);
        return redirect()->route('student.course.assign', $request->student);
    }

    public function new_course_assign($sid)
    {
        $student = Student::with('courses')->with('batches')->findOrFail($sid);

        $student_as = $student->student_as;
        $course_types = CourseType::with(['courses' => function ($query) use ($student_as) {
            $query->where('type', $student_as);
        }])->latest()->get();

        $student_course_exist = [];
        foreach ($student->courses as $_sc) {
            $student_course_exist[] = $_sc->id;
        }

        $student_batch_ids = [];
        foreach ($student->batches as $sb) {
            $student_batch_ids[] = $sb->id;
        }

        foreach ($student->batches as $batch) {
            $cm = CourseMigration::where('student_id', $student->id)->where('new_batch_id', $batch->id)->first();
            $batch['migrate'] = $cm;
        }

        return view('course_student.create', [
            'student' => $student,
            'course_types' => $course_types,
            'student_batch_ids' => $student_batch_ids,
            'student_course_exist' => $student_course_exist
        ]);
    }

    public function student_course_add(Request $request)
    {
        $request->validate(['course' => 'required', 'batch' => 'required']);

        if (count($request->course) != count($request->batch)) {
            $this->message('error', 'Please select proper course and batch.');
            return redirect()->back()->withInput();
        }

        $student = Student::findOrFail($request->student_id);
        $student->courses()->attach($request->course);
        $student->batches()->attach($request->batch);

//        $this->message('success', 'Student courses added successfully');
        return redirect()->route('student.registration-form', $request->student_id);
    }

    public function registration_form($sid)
    {
        $student = Student::with(['courses', 'batches'])->find($sid);
        return view('student.registration_form', compact('student'));
    }

    public function student_course_migration($sid, $bid)
    {
        $student = Student::with(['courses', 'batches'])->findOrFail($sid);
        $batch = Batch::with('course')->findOrFail($bid);

        if ($student->courses()->where('course_id', $batch->course->id)->count() == 0) {
            return redirect()->back();
        }

        $account = $student->accounts()->where('student_id', $sid)->where('course_id', $batch->course->id)->first();

        $payments = 0;
        if (isset($account) && $account->count() > 0) {
            if ($account->payments) {
                $payments = $account->payments->sum('amount');
            }
        }

        $total_fee = $this->courseFeeCalculate($account, $batch->course->fee);

        if ($payments > 0 && ($total_fee > $payments)) {
            $due = $total_fee - $payments;
        } else {
            $due = $total_fee;
        }

        

        $course_types = CourseType::with(['courses' => function ($query) use ($student) {
            $query->where('type', $student->student_as);
        }])->latest()->get();

        $student_course_exist = [];
        foreach ($student->courses as $_sc) {
            $student_course_exist[] = $_sc->id;
        }

        $student_batch_ids = [];
        foreach ($student->batches as $sb) {
            $student_batch_ids[] = $sb->id;
        }

        return view('course_migration.index',
            compact('student', 'batch', 'course_types', 'student_course_exist',
                'student_batch_ids', 'total_fee', 'payments', 'due'));
    }

    public function student_course_migrate(Request $request)
    {
        $request->validate([
            'student_id' => 'required',
            'old_batch_id' => 'required',
            'note' => 'max:170'
        ]);

        if (empty($request->course) || empty($request->batch)) {
            $this->message('error', 'Please select proper course and batch.');
            return redirect()->back();
        }
        
        $student = Student::findOrFail($request->student_id);
        $batch = Batch::findOrFail($request->old_batch_id);
        $old_course = $student->courses()->where('course_id', $batch->course->id)->first();
        $old_batch = $student->batches()->where('batch_id', $batch->id)->first();
        
        if ($old_course->count() > 0 && $old_batch->count() > 0) {

            $student->courses()->attach($request->course);
            $student->batches()->attach($request->batch);
            
            $account = $student->accounts()->where('student_id', $request->student_id)->where('course_id', $batch->course->id)->first();

            // if (isset($account) && $account->count() > 0) {
            //     $payments = 0;
            //     if (isset($account) && $account->count() > 0) {
            //         if ($account->payments) {
            //             $payments = $account->payments->sum('amount');
            //         }
            //     }
            //     $total_fee = $this->courseFeeCalculate($account, $batch->course->fee);
            //     if ($payments > 0 && ($total_fee > $payments)) {
            //         $due = $total_fee - $payments;
            //     } else {
            //         $due = $total_fee;
            //     }

            //     if (isset($account->discount_percent) && $account->discount_percent > 0) {
            //         $prev_discount = ($old_course->fee * $account->discount_percent) / 100;
            //         $total_discount = $prev_discount + $due;
            //         $current_discount = ($total_discount * 100) / $old_course->fee;
            //         $account->discount_percent = $current_discount;
            //         $account->save();
            //     } elseif (isset($account->discount_amount) && $account->discount_amount > 0) {
            //         $prev_discount = $course_fee - $account->discount_amount;
            //         $total_discount = $prev_discount + $due;
            //         $account->discount_percent = $total_discount;
            //         $account->save();
            //     } else {
            //         $prev_discount = 0;
            //         $total_discount = $prev_discount + $due;
            //         $account->discount_percent = $total_discount;
            //         $account->save();
            //     }

            // }
            
            $cm = new CourseMigration();
            $cm->student_id = $student->id;
            $cm->new_course_id = $request->course;
            $cm->new_batch_id = $request->batch;
            $cm->old_course_id = $batch->course->id;
            $cm->old_batch_id = $batch->id;
            $cm->note = $request->note;

            if (isset($account) && $account->count() > 0) {
                $cm->old_account_id = $account->id;
            }

            $cm->save();

            // $migration_assign = Course::where('course_id', $batch->course->id)->first();
            // $migration_assign->migration_id = $cm->id;
            // $migration_assign->save();

            // $student->courses()->detach($batch->course->id);
            // $student->batches()->detach($batch->id);
        }


        
        

        $this->message('success', 'Course successfully migrated.');
        return redirect()->route('student.registration-form', [$request->student_id, $cm->id]);
    }
    
    

    public function migrated_previous_course($sid, $cid)
    {
        $student = Student::findOrFail($sid);
        $migrate_course = CourseMigration::where('student_id', $student->id)->where('old_course_id', $cid)->first();
        $course = Course::find($migrate_course->old_course_id);
        $batch = Batch::find($migrate_course->old_batch_id);
        $account = Account::find($migrate_course->old_account_id);
        $total_fee = $this->courseFeeCalculate($account, $course->fee);
        return view('course_migration.previous_migrated', compact('student', 'course', 'batch', 'account', 'total_fee'));
    }

    // -------------------------------------------------existing student---------------------------------------------------------



    public function existing_create()
    {
        $students = Student::orderBy('phone', 'ASC')->latest()->get();
        return view('student.existing_create', compact('students'));
        // return $students;
        
    }
    public function existing_search(Request $request)
    {
        
        $student = Student::with('courses')->with('batches')->findOrFail($request->student_id);
        $check = Student::select('student_as')->where('phone',$student->phone)->get();
        if(count($check) > 1)
        {
            $check = "hidden";
        }
        else
        {
            $check = "visible";
        }
        return view('student.existing_show', compact('student','check'));
        // return $request;
    } 
    public function assign_new_type($phone)
    {
        
        $data = Student::where('phone',$phone)->get();
        foreach ($data as $id)
        {
            $s_id = $id->id;
        }
        $student = Student::findOrFail($s_id);
        $institutes = Institute::latest()->get();
        $courses = Course::latest()->get();       
        $student_2 = Student::with('courses')->with('batches')->findOrFail($s_id);
        return view('student.assign_edit',compact('student', 'institutes', 'courses'));
        
    }
    public function existing_save(Request $request)
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
            'phone' => 'required|max:11|min:11',
            'nationality' => 'max:170',
            'student_as' => 'required',
            'emergency_contact_name' => 'max:170',
            'emergency_contact_relation' => 'max:170',
            'emergency_contact_address' => 'max:170'
        ]);

        if ('Professional' == $request->student_as) {
            if (empty($request->district)) {
                $this->message('error', 'The district field is required');
                return redirect()->back()->withInput();
            }
        }
        if ('Industrial' == $request->student_as) {
            if (empty($request->institute) && empty($request->institute_name)) {
                $this->message('error', 'Please select or add new institute info.');
                return redirect()->back()->withInput();
            }
            if (isset($request->institute) && isset($request->institute_name)) {
                $this->message('error', 'Institute has both items data not applicable.');
                return redirect()->back()->withInput();
            }
            if (isset($request->institute_name)) {
                if (empty($request->institute_division) || empty($request->institute_district)) {
                    $this->message('error', 'The institute address, division, and district field is required.');
                    return redirect()->back()->withInput();
                }
            }
            if (empty($request->board_roll) || empty($request->board_reg)) {
                $this->message('error', 'The board roll and registration field is required.');
                return redirect()->back()->withInput();
            }
            if (!empty($request->board_roll) || !empty($request->board_reg)) {
                $request->validate([
                    'board_roll' => 'unique:students',
                    'board_reg' => 'unique:students'
                ]);
            }
        }
        $regNo = $this->new_reg_number($request->student_as, $request->year);
        $s = new Student;
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
        $s->present_address = $request->present_address;
        $s->permanent_address = $request->permanent_address;
        $s->dob = $request->dob;
        if (empty($request->institute) && !empty($request->institute_name)) {
            $i = new Institute;
            $i->name = $request->institute_name;
            $i->address = $request->institute_address;
            $i->division = $request->institute_division;
            $i->district = $request->institute_district;
            $i->website = $request->institute_website;
            $i->user_id = Auth::id();
            $i->save();
            $s->institute_id = $i->id;
        } else {
            $s->institute_id = $request->institute;
        }
        $s->board_roll = $request->board_roll;
        $s->board_reg = $request->board_reg;
        $s->phone = $request->phone;
        $s->parents_phone = $request->parents_phone;
        $s->email = $request->email;
        $s->nationality = $request->nationality;
        $s->nid = $request->nid;
        $s->birth = $request->birth;
        $s->gender = $request->gender;
        $s->blood_group = $request->blood_group;
        $s->note = $request->note;
        $s->student_as = $request->student_as;
        $s->year = $request->year;
        $s->district = $request->district;
        $s->emergency_contact_name = $request->emergency_contact_name;
        $s->emergency_contact_address = $request->emergency_contact_address;
        $s->emergency_contact_relation = $request->emergency_contact_relation;
        $s->emergency_contact_phone = $request->emergency_contact_phone;
        $s->session_id = $this->active_session()->id;
        $s->user_id = Auth::id();
        $s->save();

        $this->message('success', 'Student info save successfully');
        return redirect()->route('student.course.assign', $s->id);
    }
    public function existing_new_course($id)
    {
        return redirect()->route('student.course.assign', $id);
    }
}