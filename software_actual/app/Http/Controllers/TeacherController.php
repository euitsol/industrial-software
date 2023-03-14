<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use App\Models\Institute;
use App\Models\TeacherEmail;
use App\Models\TeacherPaymentInfo;
use App\Models\TeacherPhone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TeacherController extends Controller
{

    public function index()
    {
        $institutes = Institute::latest()->get();
        return view('teacher.index', compact('institutes'));
    }

    public function findTeachers(Request $request)
    {
        $request->validate([
            'institute' => 'required'
        ]);

        return redirect()->route('teachers.found', $request->institute);
    }

    public function get_teachers($iid)
    {
        if (request()->ajax()) {
            $teachers = Teacher::where('institute_id', $iid)->latest()->get();
            return response()->json($teachers);
        }
        $teachers = Teacher::where('institute_id', $iid)->latest()->get();
        $institute = Institute::findOrFail($iid);
        return view('teacher.teachers', compact('teachers', 'institute'));
    }


    public function create()
    {
        $institutes = Institute::latest()->get();
        return view('teacher.create', compact('institutes'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:170',
            'photo' => 'image|mimes:jpg,jpeg,png,JPG,JPEG,PNG',
            'designation' => 'required|max:170',
            'institute' => 'required',
            'phone.*' => 'required',
            'short_bio' => 'max:170',
            'comments' => 'max:170'
        ]);

        $t = new Teacher;
        $t->name = $request->name;

        if ($request->hasFile('photo')) {
            $photo = $request->photo;
            $img_name = time() . '_' . $photo->getClientOriginalName();
            $photo->move('uploads/images/', $img_name);
            $t->photo = 'uploads/images/' . $img_name;
        }

        $t->designation = $request->designation;
        $t->present_address = $request->present_address;
        $t->permanent_address = $request->permanent_address;
        $t->biography = $request->short_bio;
        $t->comments = $request->comments;
        $t->institute_id = $request->institute;
        $t->user_id = Auth::id();
        $t->save();

        if (is_array($request->phone) && count($request->phone) > 0) {
            foreach ($request->phone as $phone) {
                if (!empty($phone)) {
                    $tp = new TeacherPhone;
                    $tp->phone = $phone;
                    $tp->teacher_id = $t->id;
                    $tp->save();
                }
            }
        }

        if (is_array($request->email) && count($request->email) > 0) {
            foreach ($request->email as $email) {
                if (!empty($email)) {
                    $te = new TeacherEmail;
                    $te->email = $email;
                    $te->teacher_id = $t->id;
                    $te->save();
                }
            }
        }

        $this->message('success', 'Teacher info save successfully');
        return redirect()->route('teachers.found', $t->institute_id);
    }


    public function show($tid)
    {
        $teacher = Teacher::findOrFail($tid);
        return view('teacher.show', compact('teacher'));
    }


    public function edit($tid)
    {
        $teacher = Teacher::findOrFail($tid);
        $institutes = Institute::latest()->get();
        return view('teacher.edit', compact('teacher', 'institutes'));
    }


    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|max:170',
            'photo' => 'image|mimes:jpg,jpeg,png,JPG,JPEG,PNG',
            'designation' => 'required|max:170',
            'institute' => 'required',
            'phone.*' => 'required',
            'short_bio' => 'max:170',
            'comments' => 'max:170'
        ]);

        $t = Teacher::findOrFail($request->id);
        $t->name = $request->name;

        if ($request->hasFile('photo')) {
            if (!empty($t->photo) && file_exists($t->photo)) {
                unlink($t->photo);
            }
            $photo = $request->photo;
            $img_name = time() . '_' . $photo->getClientOriginalName();
            /*ini_set('memory_limit', '256M');
            Image::make($photo)->resize(70, 70)->save('uploads/images/' . $img_name);*/
            $photo->move('uploads/images/', $img_name);
            $t->photo = 'uploads/images/' . $img_name;
        }

        $t->designation = $request->designation;
        $t->biography = $request->short_bio;
        $t->present_address = $request->present_address;
        $t->permanent_address = $request->permanent_address;
        $t->comments = $request->comments;
        $t->institute_id = $request->institute;
        $t->save();

        if (is_array($request->phone) && count($request->phone) > 0) {

            $tp = TeacherPhone::where('teacher_id', $t->id)->get();

            if ($tp->count() > 0) {
                foreach ($tp as $key => $value) {
                    $value->delete();
                }
            }

            foreach ($request->phone as $p) {
                if (!empty($p)) {
                    $n_tp = new TeacherPhone;
                    $n_tp->phone = $p;
                    $n_tp->teacher_id = $t->id;
                    $n_tp->save();
                }
            }
        }

        if (is_array($request->email) && count($request->email) > 0) {

            $te = TeacherEmail::where('teacher_id', $t->id)->get();

            if ($te->count() > 0) {
                foreach ($te as $key_ => $value_) {
                    $value_->delete();
                }
            }

            foreach ($request->email as $e) {
                if (!empty($e)) {
                    $n_te = new TeacherEmail;
                    $n_te->email = $e;
                    $n_te->teacher_id = $t->id;
                    $n_te->save();
                }
            }
        }

        $this->message('success', 'Teacher info update successfully');
        return redirect()->route('teacher.show', $t->id);
    }


    public function destroy($tid)
    {
        $t = Teacher::findOrFail($tid);
        if (!empty($t->photo) && file_exists($t->photo)) {
            unlink($t->photo);
        }
        $t->delete();
        $this->message('success', 'Teacher info delete successfully');
        return redirect()->back();
    }


    public function teacher_payment_setup_index($year = '')
    {
        $tpi_years = TeacherPaymentInfo::select('year')->distinct()->orderBy('year', 'desc')->get();
        $year = $year ? $year : optional($tpi_years->max())->year;
        $tpis = TeacherPaymentInfo::where('year', $year)->get();
        return view('teacher.payment_setup.index', compact('tpi_years','tpis', 'year'));

    }


    public function teacher_payment_setup()
    {
        $institutes = Institute::all();
        if ($institutes->count() > 0) {
            foreach ($institutes as $ik => $institute) {
                $tpi = TeacherPaymentInfo::where('institute_id', $institute->id)
                    ->where('year', date('Y'))->first();
                if ($tpi) {
                    unset($institutes[$ik]);
                }
            }
        }
        return view('teacher.payment_setup.create', compact('institutes'));
    }


    public function teacher_payment_setup_process(Request $request)
    {
        $request->validate([
            '_institute' => 'required',
            'teacher' => 'required',
            '_session' => 'required',
            'per_student_payment' => 'required'
        ]);

        $teacher = Teacher::find($request->teacher);

        $tpi = new TeacherPaymentInfo();
        $tpi->institute_id = $request->_institute;
        $tpi->teacher_id = $teacher->id;
        $tpi->responsible_teacher_name = $teacher->name;
        $tpi->designation = $teacher->designation;
        $tpi->phone = $teacher->phones[0]->phone ?? '';
        $tpi->year = $request->_session;
        $tpi->per_student_payment = $request->per_student_payment;
        $tpi->save();

        $this->message('success', 'Teacher payment setup created successfully.');
        return redirect()->route('teacher.payment.setup.index');
    }

    public function teacher_payment_setup_edit($tpiid)
    {
        $institutes = Institute::all();
        $tpi = TeacherPaymentInfo::find($tpiid);
        return view('teacher.payment_setup.edit', compact('tpi', 'institutes'));
    }

    public function teacher_payment_setup_update(Request $request)
    {
        $request->validate([
            '_institute' => 'required',
            'teacher' => 'required',
            '_session' => 'required',
            'per_student_payment' => 'required'
        ]);

        $teacher = Teacher::find($request->teacher);

        $tpi = TeacherPaymentInfo::find($request->id);
        $tpi->institute_id = $request->_institute;
        $tpi->teacher_id = $teacher->id;
        $tpi->responsible_teacher_name = $teacher->name;
        $tpi->designation = $teacher->designation;
        $tpi->phone = $teacher->phones[0]->phone ?? '';
        $tpi->year = $request->_session;
        $tpi->per_student_payment = $request->per_student_payment;
        $tpi->save();

        $this->message('success', 'Teacher payment setup update successfully.');
        return redirect()->route('teacher.payment.setup.index');
    }

    public function teacher_payment_setup_destroy(Request $request)
    {
        TeacherPaymentInfo::find($request->id)->delete();

        $this->message('success', 'Teacher payment setup delete successfully.');
        return redirect()->route('teacher.payment.setup.index');
    }

}
