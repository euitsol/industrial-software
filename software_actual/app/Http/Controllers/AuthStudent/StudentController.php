<?php

namespace App\Http\Controllers\AuthStudent;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\BatchAttendance;
use App\Models\JobPlacement;
use App\Models\LinkageIndustryInfo;
use App\Models\Course;
use App\Models\Account;
use App\Models\Payment;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;

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
        if ($request->base64image || $request->base64image != '0') {
            $folderPath = 'uploads/images/';
            $image_parts = explode(";base64,", $request->base64image);
            $image_type_aux = explode("image/", $image_parts[0]);
            $image_type = $image_type_aux[1];
            $image_base64 = base64_decode($image_parts[1]);
            $filename = time() . '.'.$image_type;
            $file =$folderPath.$filename;
            file_put_contents($file, $image_base64);
            $s->photo = $file;
            $s->save();
        }
        $this->message('success', 'Profile photo update successfully');
        return redirect()->back();
    }

    public function registrationCard(){
        $data['student'] = Student::with(['courses', 'batches'])->find(Auth::guard('student')->user()->id);
        return view('student_panel.student.registration_card', $data);
    }
    public function idCard(){
        $data['student']= Student::findOrFail(Auth::guard('student')->user()->id);
        return view('student_panel.student.id_card',$data);
    }
    public function certificate(){
        $data['student']= Student::findOrFail(Auth::guard('student')->user()->id);
        return view('student_panel.student.certificate',$data);
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
    public function paymentCheckout($id){
            $id = Crypt::decrypt($id);
            $data['student'] = Student::findOrFail(Auth::guard('student')->user()->id);
            $data['course'] = Course::findOrFail($id);

            return view('student_panel.payment.checkout', $data);
    }
    public function paymentDetails($sid, $cid){
        $sid = Crypt::decrypt($sid);
        $cid = Crypt::decrypt($cid);
        $data['student'] = Student::findOrFail($sid);
        $data['course'] = Course::findOrFail($cid);
        $data['account'] = Account::where('student_id',$sid)->where('course_id',$cid)->first();
        $data['payments'] = Payment::where('account_id',$data['account']->id)->get();
        return view('student_panel.payment.details',$data);
    }

    public function paymentReceipt($aid ,$pid)
    {
        if ($pid == 'null')
        {
            $account = Account::with('student')->with('student.batches')->with('course')->find($aid);
            $student = $account->student;
            $course = $account->course;

            $batch_name = '';
            if (isset($student->batches)) {
                foreach ($student->batches as $b) {
                    if ($b->course_id == $account->course_id) {
                        $batch_name = batch_name($course->title_short_form, $b->year, $b->month, $b->batch_number, $b->batch_number);
                    }
                }
            }

            $total_fee = $this->courseFeeCalculate($account, $course->fee);

            $payments = $account->payments;
            $total_payments = $payments->sum('amount');

            $due = $total_fee - $total_payments;

            $installment_dates = $account->installment_dates;
            $installment_dates_arr = [];
            foreach ($installment_dates as $key1 => $value1) {
                $installment_dates_arr[] = $value1->installment_date;
            }

            if (count(array_slice($installment_dates_arr, ($payments->count() - 1))) > 0) {
                $installment_amount = $due / count(array_slice($installment_dates_arr, ($payments->count() - 1)));
            } else {
                $installment_amount = $due;
            }
            $_installment_dates = array_slice($installment_dates_arr, ($payments->count() - 1));

            return view('student_panel.payment.money_receipt', [
                'account' => $account,
                'student' => $student,
                'course' => $course,
                'batch_name' => $batch_name,
                'total_fee' => $total_fee,
                'due' => $due,
                'payments' => $payments,
                'total_payments' => $total_payments,
                'installment_amount' => $installment_amount,
                '_installment_dates' => $_installment_dates,
                'receipt_no' => $payments->max('id') ?? 1
            ]);

        }
        else
        {   $total_payments = 0;
            $account = Account::with('student')->with('student.batches')->with('course')->find($aid);
            $student = $account->student;
            $course = $account->course;

            $batch_name = '';
            if (isset($student->batches)) {
                foreach ($student->batches as $b) {
                    if ($b->course_id == $account->course_id) {
                        $batch_name = batch_name($course->title_short_form, $b->year, $b->month, $b->batch_number, $b->batch_number);
                    }
                }
            }

            $total_fee = $this->courseFeeCalculate($account, $course->fee);

            $payments_2 = $account->payments;


            foreach ($payments_2 as $p2)
            {
                if( $p2->id <= $pid )
                {
                    $total_payments += $p2->amount;
                }
            }


            $due = $total_fee - $total_payments;
            $payments = Payment::where('id', $pid)->get();
            $installment_dates = $account->installment_dates;
            $installment_dates_arr = [];
            foreach ($installment_dates as $key1 => $value1) {
                $installment_dates_arr[] = $value1->installment_date;
            }

            if (count(array_slice($installment_dates_arr, ($payments_2->count() - 1))) > 0) {
                $installment_amount = $due / count(array_slice($installment_dates_arr, ($payments_2->count() - 1)));
            } else {
                $installment_amount = $due;
            }
            $_installment_dates = array_slice($installment_dates_arr, ($payments_2->count() - 1));

            return view('student_panel.payment.money_receipt', [
                'account' => $account,
                'student' => $student,
                'course' => $course,
                'batch_name' => $batch_name,
                'total_fee' => $total_fee,
                'due' => $due,
                'payments' => $payments,
                'total_payments' => $total_payments,
                'installment_amount' => $installment_amount,
                '_installment_dates' => $_installment_dates,
                'receipt_no' => $payments->max('id') ?? 1
            ]);




        }

    }
}
