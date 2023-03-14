<?php

namespace App\Http\Controllers;

use App\Models\CourseType;
use App\Models\Mentor;
use App\Models\MentorEducation;
use App\Models\MentorEmploymentHistory;
use App\Models\MentorPaymentInfo;
use App\Models\MentorSpecialization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;

class MentorController extends Controller
{

    public function index()
    {
        $mentors = Mentor::with('user')->latest()->get();
        return view('mentor.index', compact('mentors'));
    }


    public function create()
    {
        $courseTypes = CourseType::with('courses')->get();
        return view('mentor.add_new.personal_info', compact('courseTypes'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:170',
            'fathers_name' => 'required|max:170',
            'mothers_name' => 'required|max:170',
            'phone' => 'required|min:11|max:14',
            'email' => 'required|max:170',
            'present_address' => 'required|max:170',
            'photo' => 'image|mimes:jpg,jpeg,png,JPG,JPEG,PNG|max:5000'
        ]);

        if (!isset($request->course) || count(array_filter($request->course)) <= 0) {
            $this->message('error', 'The course field is required');
            return redirect()->back()->withInput();
        }

        $m = new Mentor;
        $m->name = $request->name;
        $m->fathers_name = $request->fathers_name;
        $m->mothers_name = $request->mothers_name;
        $m->phone = $request->phone;
        $m->email = $request->email;
        $m->parents_phone = $request->parents_phone;
        $m->nid = $request->nid;
        $m->present_address = $request->present_address;
        $m->permanent_address = $request->permanent_address;
        if ($request->hasFile('photo')) {
            $photo = $request->photo;
            $img_name = time() . '_' . $photo->getClientOriginalName();
            ini_set('memory_limit', '256M');
            Image::make($photo)->resize(70, 70)->save('uploads/images/' . $img_name);
            $m->photo = 'uploads/images/' . $img_name;
        }
        $m->user_id = Auth::id();
        $m->save();

        $m->courses()->attach(array_filter($request->course));

        return redirect()->route('mentor.career-objective', $m->id);
    }

    public function career_objective($mid)
    {
        $mentor = Mentor::find($mid);
        return view('mentor.add_new.career_objective', compact('mentor'));
    }

    public function career_objective_store(Request $request)
    {
        $request->validate([
            'career_objective' => 'required'
        ]);

        $m = Mentor::find($request->mid);
        $m->career_objective = $request->career_objective;
        $m->save();

        return redirect()->route('mentor.academic-qualification', $request->mid);
    }

    public function academic_qualification($mid)
    {
        $mentor = Mentor::find($mid);
        return view('mentor.add_new.academic_qualification', compact('mentor'));
    }

    public function academic_q_store(Request $request)
    {
        $request->validate([
            'exam_title.*' => 'required|max:170',
            'major.*' => 'required|max:170',
            'passing_year.*' => 'required|max:8',
            'duration.*' => 'required|max:8'
        ]);

        for ($i = 0; $i < count($request->exam_title); $i++) {
            $me = new MentorEducation();
            $me->exam_title = $request->exam_title[$i];
            $me->major = $request->major[$i];
            $me->institute = $request->institute[$i];
            $me->result = $request->result[$i];
            $me->passing_year = $request->passing_year[$i];
            $me->duration = $request->duration[$i];
            $me->mentor_id = $request->mid;
            $me->save();
        }

        if (isset($request->_mode) && $request->_mode == 'edit') {
            $this->message('success', 'Academic qualification saved successfully');
            return redirect()->back();
        }
        return redirect()->route('mentor.specialization.create', $request->mid);
    }

    public function create_specialization($mid)
    {
        $mentor = Mentor::find($mid);
        return view('mentor.add_new.specialization', compact('mentor'));
    }

    public function specialization_store(Request $request)
    {
        $request->validate([
            'field_title.*' => 'required|max:170',
            'description' => 'max:170'
        ]);

        for ($i = 0; $i < count($request->field_title); $i++) {
            $ms = new MentorSpecialization();
            $ms->field_title = $request->field_title[$i];
            $ms->description = $request->description[$i];
            $ms->mentor_id = $request->mid;
            $ms->save();
        }

        if (isset($request->_mode) && $request->_mode == 'edit') {
            $this->message('success', 'Specialization saved successfully');
            return redirect()->back();
        }
        return redirect()->route('mentor.employment-history.create', $request->mid);
    }

    public function create_employment_h($mid)
    {
        $mentor = Mentor::find($mid);
        return view('mentor.add_new.employment_history', compact('mentor'));
    }

    public function employment_history_store(Request $request)
    {
        $request->validate([
            'office_name.*' => 'required|max:170',
            'address.*' => 'required|max:170',
            'designation.*' => 'required|max:170',
            'responsibility.*' => 'required|max:170'
        ]);

        for ($i = 0; $i < count($request->office_name); $i++) {
            $meh = new MentorEmploymentHistory();
            $meh->office_name = $request->office_name[$i];
            $meh->address = $request->address[$i];
            $meh->designation = $request->designation[$i];
            $meh->responsibility = $request->responsibility[$i];
            $meh->from = $request->from[$i];
            $meh->to = $request->to[$i];
            $meh->mentor_id = $request->mid;
            $meh->save();
        }

        if (isset($request->_mode) && $request->_mode == 'edit') {
            $this->message('success', 'Employment history saved successfully');
            return redirect()->back();
        }
        return redirect()->route('mentor.show', $request->mid);
    }

    public function show($mid)
    {
        $mentor = Mentor::with('educations')->with('employmentHistories')
            ->with('specializations')->findOrFail($mid);
        return view('mentor.show', compact('mentor'));
    }

    public function edit($mid)
    {
        $mentor = Mentor::findOrFail($mid);
        $courseTypes = CourseType::with('courses')->get();
        return view('mentor.edit', compact('mentor', 'courseTypes'));
    }

    public function edit_personal_info($mid)
    {
        $mentor = Mentor::findOrFail($mid);
        $courseTypes = CourseType::with('courses')->get();
        $course_ids = [];
        foreach ($mentor->courses as $course) {
            $course_ids[] = $course->id;
        }
        return view('mentor.edit.personal_info', compact('mentor', 'courseTypes', 'course_ids'));
    }

    public function update_personal_info(Request $request)
    {
        $request->validate([
            'name' => 'required|max:170',
            'fathers_name' => 'required|max:170',
            'mothers_name' => 'required|max:170',
            'phone' => 'required|numeric',
            'email' => 'required|max:170',
            'present_address' => 'required|max:170'
        ]);

        if (!isset($request->course) || count(array_filter($request->course)) <= 0) {
            $this->message('error', 'The course field is required');
            return redirect()->back()->withInput();
        }

        $m = Mentor::findOrFail($request->id);
        $m->name = $request->name;
        $m->fathers_name = $request->fathers_name;
        $m->mothers_name = $request->mothers_name;
        $m->phone = $request->phone;
        $m->email = $request->email;
        $m->parents_phone = $request->parents_phone;
        $m->nid = $request->nid;
        $m->present_address = $request->present_address;
        $m->permanent_address = $request->permanent_address;
        if ($request->hasFile('photo')) {
            if (!empty($m->photo) && file_exists($m->photo)) {
                unlink($m->photo);
            }
            $photo = $request->photo;
            $img_name = time() . '_' . $photo->getClientOriginalName();
            ini_set('memory_limit', '256M');
            Image::make($photo)->resize(70, 70)->save('uploads/images/' . $img_name);
            $m->photo = 'uploads/images/' . $img_name;
        }
        $m->save();

        $m->courses()->sync(array_filter($request->course));

        return redirect()->back();
    }

    public function edit_career_objective($mid)
    {
        $mentor = Mentor::findOrFail($mid);
        return view('mentor.edit.career_objective', compact('mentor'));
    }

    public function update_career_objective(Request $request)
    {
        $request->validate([
            'career_objective' => 'required'
        ]);
        $m = Mentor::find($request->mid);
        $m->career_objective = $request->career_objective;
        $m->save();

        return redirect()->back();
    }

    public function edit_employment_history($mid)
    {
        $mentor = Mentor::find($mid);
        return view('mentor.edit.employment_history', compact('mentor'));
    }

    public function update_employment_history(Request $request)
    {
        $request->validate([
            'e_h_id' => 'required',
            'office_name' => 'required|max:170',
            'address' => 'required|max:170',
            'designation' => 'required|max:170',
            'responsibility' => 'required|max:170'
        ]);

        $me = MentorEmploymentHistory::find($request->e_h_id);
        $me->office_name = $request->office_name;
        $me->address = $request->address;
        $me->designation = $request->designation;
        $me->responsibility = $request->responsibility;
        $me->from = $request->from;
        $me->to = $request->to;
        $me->save();

        $this->message('success', 'Employment history updated successfully');
        return redirect()->back();
    }

    public function delete_employment_history($eid)
    {
        MentorEmploymentHistory::find($eid)->delete();

        $this->message('success', 'Employment history deleted successfully');
        return redirect()->back();
    }

    public function edit_academic_qualification($mid)
    {
        $mentor = Mentor::find($mid);
        return view('mentor.edit.academic_qualification', compact('mentor'));
    }

    public function update_academic_qualification(Request $request)
    {
        $request->validate([
            'a_q_id' => 'required',
            'exam_title' => 'required|max:170',
            'major' => 'required|max:170',
            'passing_year' => 'required|max:8',
            'duration' => 'required|max:8'
        ]);

        $maq = MentorEducation::find($request->a_q_id);
        $maq->exam_title = $request->exam_title;
        $maq->major = $request->major;
        $maq->major = $request->major;
        $maq->institute = $request->institute;
        $maq->result = $request->result;
        $maq->passing_year = $request->passing_year;
        $maq->duration = $request->duration;
        $maq->save();

        $this->message('success', 'Academic qualification updated successfully');
        return redirect()->back();
    }

    public function delete_academic_qualification($aid)
    {
        MentorEducation::find($aid)->delete();

        $this->message('success', 'Academic qualification deleted successfully');
        return redirect()->back();
    }

    public function edit_specialization($mid)
    {
        $mentor = Mentor::find($mid);
        return view('mentor.edit.specialization', compact('mentor'));
    }

    public function update_specialization(Request $request)
    {
        $request->validate([
            's_id' => 'required',
            'field_title' => 'required|max:170'
        ]);

        $ms = MentorSpecialization::find($request->s_id);
        $ms->field_title = $request->field_title;
        $ms->description = $request->description;
        $ms->save();

        $this->message('success', 'Specialization updated successfully');
        return redirect()->back();
    }

    public function delete_specialization($sid)
    {
        MentorSpecialization::find($sid)->delete();

        $this->message('success', 'Specialization deleted successfully');
        return redirect()->back();
    }

    public function destroy($mid)
    {
        $m = Mentor::findOrFail($mid);
        if (!empty($m->photo) && file_exists($m->photo)) {
            unlink($m->photo);
        }
        $m->courses()->detach();
        $m->delete();

        $this->message('success', 'Mentor delete successfully');
        return redirect()->route('mentors');
    }

    public function mentor_payment_setup_index($mid)
    {
        $mentor = Mentor::find($mid);
        $mpis = MentorPaymentInfo::where('mentor_id', $mid)->orderBy('year', 'desc')->get();
        return view('mentor.payment_setup.index', compact('mentor', 'mpis'));
    }

    public function mentor_payment_setup($mid)
    {
        $mentor = Mentor::find($mid);
        return view('mentor.payment_setup.create', compact('mentor'));
    }

    public function mentor_payment_setup_process(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'course' => 'required',
            'batch' => 'required',
            'year' => 'required',
            'total_class' => 'required',
            'payment' => 'required'
        ]);

        if (isset($request->payment) && 'per_class' == $request->payment) {
            $request->validate([
                'per_class_amount' => 'required'
            ]);
        }

        if (isset($request->payment) && 'batch_wise' == $request->payment) {
            $request->validate([
                'batch_wise_amount' => 'required'
            ]);
        }

        if (!empty($request->per_class_amount) && !empty($request->batch_wise_amount)) {
            $this->message('error', 'Sorry! Any one of the payment field is required.');
            return redirect()->back()->withInput();
        }

        $m = Mentor::find($request->id);
        if (isset($m)) {
            $mpi = new MentorPaymentInfo();
            $mpi->mentor_id = $m->id;
            $mpi->mentor_name = $m->name;
            $mpi->mentor_phone = $m->phone;
            $mpi->email = $m->email;
            $mpi->course_id = $request->course;
            $mpi->batch_id = $request->batch;
            $mpi->year = $request->year;
            $mpi->total_class = $request->total_class;
            $mpi->per_class_payment = $request->per_class_amount;
            $mpi->batch_wise_payment = $request->batch_wise_amount;
            $mpi->save();

            $this->message('success', 'Mentor payment setup successfully');
            return redirect()->route('mentor.setup-payments', $mpi->mentor_id);
        }

        $this->message('error', "Something went wrong :(");
        return redirect()->back();
    }

    public function mentor_payment_setup_edit($mpiid)
    {
        $mpi = MentorPaymentInfo::find($mpiid);
        return view('mentor.payment_setup.edit', compact('mpi'));
    }

    public function mentor_payment_setup_update(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'course' => 'required',
            'batch' => 'required',
            'year' => 'required',
            'total_class' => 'required',
            'payment' => 'required'
        ]);

        if (isset($request->payment) && 'per_class' == $request->payment) {
            $request->validate([
                'per_class_amount' => 'required'
            ]);
        }

        if (isset($request->payment) && 'batch_wise' == $request->payment) {
            $request->validate([
                'batch_wise_amount' => 'required'
            ]);
        }

        if (!empty($request->per_class_amount) && !empty($request->batch_wise_amount)) {
            $this->message('error', 'Sorry! Any one of the payment field is required.');
            return redirect()->back()->withInput();
        }

        $mpi = MentorPaymentInfo::find($request->id);
        $mpi->course_id = $request->course;
        $mpi->batch_id = $request->batch;
        $mpi->year = $request->year;
        $mpi->total_class = $request->total_class;
        $mpi->per_class_payment = $request->per_class_amount;
        $mpi->batch_wise_payment = $request->batch_wise_amount;
        $mpi->save();

        $this->message('success', 'Mentor payment info update successfully');
        return redirect()->route('mentor.setup-payments', $mpi->mentor_id);
    }


    public function mentor_payment_setup_delete(Request $request)
    {
        $mpi = MentorPaymentInfo::find($request->id);
        $mentor_id = $mpi->mentor_id;
        $mpi->delete();

        $this->message('success', 'Mentor payment info delete successfully.');
        return redirect()->route('mentor.setup-payments', $mentor_id);
    }


    public function batch_setup_index()
    {
        $mentors = Mentor::all();
        return view('mentor.mentor_batch.index', compact('mentors'));
    }

    public function batch_setup($mid)
    {
        $mentor = Mentor::find($mid);
        $batch_ids = [];
        if ($mentor->batches->count()) {
            foreach ($mentor->batches as $batch) {
                $batch_ids[] = $batch->id;
            }
        }
        return view('mentor.mentor_batch.batch_setup', compact('mentor', 'batch_ids'));
    }

    public function batch_setup_process(Request $request)
    {
        $request->validate([
            'mentor_id' => 'required',
            'batch' => 'required'
        ]);

        $m = Mentor::find($request->mentor_id);
        $m->batches()->sync($request->batch);

        $this->message('success', 'Mentor batch info save successfully.');
        return redirect()->back();
    }


    public function mentor_batches_by_course($mid, $cid)
    {
        if (request()->ajax() && !empty($cid) && !empty($mid)) {
            $mentor = Mentor::find($mid);
            $mentor_batches = $mentor->batches()->where('course_id', $cid)->get();
            $exist_count = 0;
            if (isset($mentor_batches)) {
                foreach ($mentor_batches as $bk => $batch) {
                    $mpi = MentorPaymentInfo::where('course_id', $batch->course_id)
                        ->where('batch_id', $batch->id)
                        ->where('year', date('Y'))->first();
                    if ($mpi !== null) {
                        $exist_count++;
                        unset($mentor_batches[$bk]);
                    }
                }
            }
            $batches = '';
            if ($mentor_batches->count()) {
                foreach ($mentor_batches as $b) {
                    $batch_name = batch_name($b->course->title_short_form, $b->year, $b->month, $b->batch_number);
                    $batches .= '<option value="' . $b->id . '">' . $batch_name . '</option>';
                }
            }
            return response()->json([
                'batches' => $batches,
                'exist_count' => $exist_count
            ]);
        }
        return redirect()->back();
    }

}
