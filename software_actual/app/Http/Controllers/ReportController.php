<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Batch;
use App\Models\Course;
use App\Models\CourseMigration;
use App\Models\CourseType;
use App\Models\InstallmentDate;
use App\Models\Institute;
use App\Models\Payment;
use App\Models\Referral;
use App\Models\Session as Sessions;
use App\Models\Source;
use App\Models\Student;
use App\Models\Sms_history;
use App\Models\User;
use Carbon\Carbon;
use function GuzzleHttp\Psr7\str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index()
    {
        $institutes = Institute::all();
        $divisions = Institute::select('division')->groupBy('division')->get();

        $result = Student::select(DB::raw('YEAR(created_at) as year'))->distinct()->orderBy('created_at')->get();
        $years = $result->pluck('year');
        
        return view('report.transaction_report_course_type', compact('years'));
        
        // return view('report.index', compact('institutes', 'divisions'));
    }
    
    public function institute_index()
    {
        $institutes = Institute::all();
        $divisions = Institute::select('division')->groupBy('division')->get();
        
        $result = Student::select(DB::raw('YEAR(created_at) as year'))->distinct()->orderBy('created_at')->get();
        $years = $result->pluck('year');
        
        return view('report.transaction_report_institute', compact('institutes', 'divisions', 'years'));
    }
    
    public function division_index()
    {
        $divisions = Institute::select('division')->groupBy('division')->get();
                
        $result = Student::select(DB::raw('YEAR(created_at) as year'))->distinct()->orderBy('created_at')->get();
        $years = $result->pluck('year');
        
        return view('report.student_report_division', compact('divisions', 'years'));
    }

    public function studentsReport(Request $request)
    {
        if (!empty($request->course_type) && 'all' == $request->course_type) {
            return redirect()->route('report.students.all');
        } elseif (!empty($request->course_type) && !empty($request->course) && !empty($request->batch)) {
            return redirect()->route('report.students.batch', $request->batch);
        } elseif (!empty($request->course_type) && !empty($request->course)) {
            return redirect()->route('report.students.course', $request->course);
        } elseif (!empty($request->course_type)) {
            return redirect()->route('report.students.course-type', $request->course_type);
        }
        return redirect()->back();
    }

    public function studentsByBatch($bid)
    {
        $batch = Batch::find($bid);
        $course = $batch->course;
        $students = $batch->students;
        $batch_name = batch_name($course->title_short_form, $batch->year, $batch->month, $batch->batch_number);
        return view('report.students_by_batch', compact('students', 'course', 'batch_name', 'bid'));
    }

    public function studentsByCourse($cid)
    {
        $course = Course::find($cid);
        $batches = $course->batches;
        return view('report.students_by_course', compact('course', 'batches'));
    }

    public function studentByCourseType($ct)
    {
        $courses = Course::where('type', $ct)->get();
        $courseType = $ct;
        return view('report.students_by_course_type', compact('courses', 'courseType'));
    }

    public function allStudents()
    {
        $course_types = CourseType::with('courses.batches')->with('courses.students')->get();
        return view('report.all_students', compact('course_types'));
    }

    public function paymentStatusSearch(Request $request)
    {
        $request->validate([
            'course_type' => 'required',
            'year' => 'required'
        ]);
        if (isset($request->course_type) && isset($request->year) ) {
            // if ('Paid' == $request->btn) {
            //     return redirect()->route('report.paid.students', $request->course_type);
            // }
            // if ('Due' == $request->btn) {
                return redirect()->route('report.due.students', [$request->course_type, $request->year]);
            // }
        }
        return redirect()->back();
    }

    public function paidPaymentStudents($course_type)
    {
        $students = Student::where('student_as', $course_type)->get();
        $paidPaymentStudents = [];
        if (isset($students)) {
            foreach ($students as $student) {
                $courses = $student->courses;
                $accounts = $student->accounts;
                if (isset($courses)) {
                    foreach ($courses as $key => $course) {
                        if (isset($accounts)) {
                            $_account = $accounts->where('student_id', $student->id)->where('course_id', $course->id)->first();
                            $_payments = isset($_account->payments) ? $_account->payments->sum('amount') : 0;
                            $total_fee = $this->courseFeeCalculate($_account, $course->fee);
                            $course['total_fee'] = $total_fee;
                            $course['payments'] = $_payments;
                        }
                    }
                }

                $student['paid_count'] = 0;

                if (isset($courses)) {
                    foreach ($courses as $_k1 => $course) {
                        if ($course->payments > 0 && $course->total_fee <= $course->payments) {
                            $b = $student->batches()->where('course_id', $course->id)->first();
                            $batch_name = batch_name($course->title_short_form, $b->year, $b->month, $b->batch_number);
                            $student['courses'][$_k1]['batch'] = $batch_name;
                            $student['courses'][$_k1]['paid_status'] = true;
                            $student['courses'][$_k1]['paid_amount'] = $course->payments;
                            $student['paid_count'] += 1;
                        } else {
                            unset($courses[$_k1]);
                        }
                    }
                }

                if (isset($student->paid_count) && $student->paid_count > 0) {
                    $paidPaymentStudents[] = $student;
                }
            }
        }

        return view('report.paid_payment_students', [
            'course_type' => $course_type,
            'students' => $paidPaymentStudents
        ]);
    }

    public function duePaymentStudents($course_type, $year)
    {
        $students = Student::where('student_as', $course_type)->where('year', '=', $year)->get();
        $duePaymentStudents = [];
        if (isset($students)) {
            foreach ($students as $student) {
                $courses = $student->courses;
                $accounts = $student->accounts;
                if (isset($courses)) {
                    foreach ($courses as $key => $course) {
                        if (isset($accounts)) {
                            $_account = $accounts->where('student_id', $student->id)->where('course_id', $course->id)->first();
                            $_payments = isset($_account->payments) ? $_account->payments->sum('amount') : 0;
                            $total_fee = $this->courseFeeCalculate($_account, $course->fee);
                            $course['total_fee'] = $total_fee;
                            $course['payments'] = $_payments;
                        }
                    }
                }

                $student['due_count'] = 0;

                if (isset($courses)) {
                    foreach ($courses as $_k => $course) {
                        if ($course->total_fee > $course->payments) {
                            $b = $student->batches()->where('course_id', $course->id)->first();
                            $batch_name = batch_name($course->title_short_form, $b->year, $b->month, $b->batch_number);
                            $student['courses'][$_k]['batch'] = $batch_name;
                            $student['courses'][$_k]['due_status'] = true;
                            $student['courses'][$_k]['due_amount'] = $course->total_fee - $course->payments;
                            $student['courses'][$_k]['paid_amount'] = $course->payments;
                            $student['due_count'] += 1;
                        }
                    }
                }

                if (isset($student->due_count) && $student->due_count > 0) {
                    $duePaymentStudents[] = $student;
                }
            }
        }
        return view('report.due_payment_students', [
            'students' => $duePaymentStudents,
            'course_type' => $course_type,
            'year' => $year
        ]);
    }

    public function divisionInstituteStudents(Request $request)
    {
        if (isset($request->institute)) {
            return redirect()->route('report.institute.students', [$request->institute, $request->year, $request->shift]);
        } elseif (isset($request->division)) {
            $division = strtolower($request->division);
            return redirect()->route('report.division.students', [$division, $request->year]);
        }
        return redirect()->back();
    }

    public function studentsByInstitute($iid, $year, $shift = null)
    {
        $institute = Institute::find($iid);
        if($shift == 'all')
            $students = Student::where('institute_id', $iid)->where('year', '=', $year)->latest()->get();
        else{
            $students = Student::where('institute_id', $iid)->where('year', '=', $year)->where('shift', '=', $shift)->latest()->get();
        }
        if (isset($students)) {
            foreach ($students as $student) {
                $courses = $student->courses;
                $accounts = $student->accounts;
                if (isset($courses)) {
                    foreach ($courses as $key => $course) {
                        if (isset($accounts)) {
                            $_account = $accounts->where('student_id', $student->id)->where('course_id', $course->id)->first();
                            $_payments = isset($_account->payments) ? $_account->payments->sum('amount') : 0;
                            $total_fee = $this->courseFeeCalculate($_account, $course->fee);
                            $course['total_fee'] = $total_fee;
                            $course['payments'] = $_payments;
                        }
                    }
                }
                if (isset($courses)) {
                    foreach ($courses as $_k => $course) {
                        $student['total_amount'] = $course->fee;
                        // $student['total_amount'] = $course->total_fee;
                        $student['paid_amount'] = $course->payments;
                        $student['due_amount'] = $course->total_fee - $course->payments;
                    }
                }
            }
        }
        // dd($students);
        return view('report.students_by_institute', compact('institute', 'students', 'iid', 'year', 'shift'));
    }



    public function studentsByInstituteDue($iid, $year, $shift = '')
    {
        $institute = Institute::find($iid);
        $students = [];
        if($shift == 'all')
            $ss = Student::where('institute_id', $iid)->where('year', '=', $year)->latest()->get();
        else{
            $ss = Student::where('institute_id', $iid)->where('year', '=', $year)->where('shift', '=', $shift)->latest()->get();
        }
        
        if (isset($ss)) {
            foreach ($ss as $student) {
                $courses = $student->courses;
                $accounts = $student->accounts;
                if (isset($courses)) {
                    foreach ($courses as $key => $course) {
                        if (isset($accounts)) {
                            $_account = $accounts->where('student_id', $student->id)->where('course_id', $course->id)->first();
                            $_payments = isset($_account->payments) ? $_account->payments->sum('amount') : 0;
                            $total_fee = $this->courseFeeCalculate($_account, $course->fee);
                            $course['total_fee'] = $total_fee;
                            $course['payments'] = $_payments;
                        }
                    }
                }
                if (isset($courses)) {
                    foreach ($courses as $_k => $course) {
                        $student['total_amount'] = $course->total_fee;
                        $student['paid_amount'] = $course->payments;
                        $student['due_amount'] = $course->total_fee - $course->payments;
                    }
                }
                if ($student->due_amount > 0){
                    $students[] = $student;
                }
            }
        }
        return view('report.students_by_institute_due', compact('institute', 'students', 'iid', 'year', 'shift'));
    }


    public function studentsByDivision($division, $year)
    {
        if (empty($division)) {
            abort(403);
        }
        $institutes = Institute::where('division', ucfirst($division))->get();
        $total_students = 0;
        if ($institutes->count() > 0) {
            foreach ($institutes as $institute) {
                $total_students += $institute->students->where('year', '=', $year)->count() ?? 0;
            }
        }
        return view('report.students_by_division', compact('division', 'institutes', 'total_students', 'year'));
    }


    public function transaction()
    {
        $users = User::all();
        $accounts = [];
        return view('transaction.index', compact('users', 'accounts'));
    }

    public function transaction_find(Request $request)
    {
        $request->validate([
            'from_date' => 'required|date',
            'to_date' => 'required|date',
            'type' => 'required',
        ]);
        return redirect()->route('transaction.user.show', [
            'uid' => $request->user,
            'from_date' => $request->from_date,
            'to_date' => $request->to_date,
            'type' => $request->type,
        ]);
//        if (isset($request->user) && $request->user != 'all') {
//            return redirect()->route('transaction.user.show', [
//                'uid' => $request->user,
//                'from_date' => $request->from_date,
//                'to_date' => $request->to_date
//            ]);
//        }
//
//        return redirect()->route('transaction.show', [
//            $request->from_date,
//            $request->to_date
//        ]);
    }

    // This Function is useless now
//    public function transaction_show($from_date, $to_date)
//    {
//        if (empty($from_date) || empty($to_date)) {
//            $this->message('error', 'The from date and to date field is required.');
//            return redirect()->back()->withInput();
//        }
//
//        $accounts = Account::whereDate('created_at', '>=', date('Y-m-d', strtotime($from_date)))
//            ->whereDate('created_at', '<=', date('Y-m-d', strtotime($to_date)))->get();
//
//        if ($accounts->count() > 0) {
//            foreach ($accounts as $account) {
//                $batch = Student::find($account->student_id)->batches->where('course_id', $account->course_id)->first();
//                if (isset($batch)) {
//                    $account['batch'] = batch_name($account->course->title_short_form, $batch->year, $batch->month, $batch->batch_number);
//                } else {
//                    $cm = CourseMigration::where('old_course_id', $account->course_id)
//                        ->where('student_id', $account->student_id)->first();
//                    $_batch = Batch::find($cm->old_batch_id);
//                    $account['batch'] = batch_name($_batch->course->title_short_form, $_batch->year, $_batch->month, $_batch->batch_number);
//                }
//            }
//        }
//
//        return view('transaction.transactions', compact('accounts', 'from_date', 'to_date'));
//    }


    public function user_transaction_show($uid, $from_date, $to_date, $type)
    {
        if (empty($uid) || empty($from_date) || empty($to_date)) {
            return redirect()->route('transaction');
        }
        if ($uid == 'all') {
            $user = 'all';
            $ps = Payment::whereDate('created_at', '>=', date('Y-m-d', strtotime($from_date)))
                ->whereDate('created_at', '<=', date('Y-m-d', strtotime($to_date)))->get();
            $payments = [];
            if ($type != 'all') {
                foreach ($ps as $p) {
                    if (Student::find(Account::find($p->account_id)->student_id)->student_as == $type) {
                        $payments[] = $p;
                    }
                }
            } else {
                $payments = $ps;
            }
        } else {
            $user = User::find($uid);
            $ps = Payment::where('user_id', $uid)->whereDate('created_at', '>=', date('Y-m-d', strtotime($from_date)))
                ->whereDate('created_at', '<=', date('Y-m-d', strtotime($to_date)))->get();
            $payments = [];
            if ($type != 'all') {
                foreach ($ps as $p) {
                    if (Student::find(Account::find($p->account_id)->student_id)->student_as == $type) {
                        $payments[] = $p;
                    }
                }
            } else {
                $payments = $ps;
            }
        }
        if (!empty($payments)) {
            foreach ($payments as $payment) {
                $account = Account::find($payment->account_id);
                $batch = $account->student->batches->where('course_id', $account->course_id)->first();
                if (isset($batch)) {
                    $payment['batch'] = batch_name($account->course->title_short_form, $batch->year, $batch->month, $batch->batch_number);
                } else {
                    $cm = CourseMigration::where('old_course_id', $account->course_id)
                        ->where('student_id', $account->student_id)->first();
                    $_batch = Batch::find($cm->old_batch_id);
                    $payment['batch'] = batch_name($_batch->course->title_short_form, $_batch->year, $_batch->month, $_batch->batch_number);
                }
                $payment['student_name'] = $account->student->name;
                $payment['student_phone'] = $account->student->phone;
                $payment['institute'] = $account->student->institute->name;
                $payment['student_as'] = $account->student->student_as;
            }
        }
        return view('transaction.transaction_user', compact('user', 'payments' ,'from_date', 'to_date'));
    }
    
    // Transaction Report Session Wise
    public function transaction_session_wise(){
        $users = User::all();
        $sessions = Sessions::all();
        $accounts = [];
        return view('transaction_session_wise.index', compact('users', 'sessions', 'accounts'));
    }
    public function transaction_session_wise_find(Request $request)
    {
        $request->validate([
            'session' => 'required|exists:sessions,id',
        ]);
        return redirect()->route('transaction_session_wise.user.show', [
            'uid' => $request->user,
            'session_id' => $request->session,
        ]);
    }
    public function session_wise_user_transaction_show($uid, $session_id)
    {
        $session = Sessions::findOrFail($session_id);
        if (empty($uid) || empty($session_id)) {
            return redirect()->route('transaction_session_user');
        }
        if ($uid == 'all') {
            $user = 'all';
            $results = Payment::whereHas('account.student')->get();
        }
        else {
            $user = User::findOrFail($uid);
            $results = Payment::whereHas('account.student', function($query) use ($uid, $session_id) {
                $query->where('payments.user_id', $uid);
                $query->where('students.session_id', $session_id);
            })->get();
            
        }
        return view('transaction_session_wise.transaction_session_wise_user', compact('user', 'session', 'results'));
    }

    //Admission Report -Reference Wise
    public function reference_wise_report()
    {
        $referrals = Referral::all();
        $sources = Source::all();
        $accounts = [];
        return view('reference_wise_report.index', compact('referrals','sources', 'accounts'));
    }
    public function reference_wise_report_find(Request $request)
    {
        if(!empty($request->source) && empty($request->referral)){
            $request->validate([
                'referral' => 'nullable',
            ]);
        }
        elseif(empty($request->source) && !empty($request->referral)){
            $request->validate([
                'source' => 'nullable',
            ]);
        }
        else{
            $request->validate([
                'referral' => 'required',
                'source' => 'required',
            ]);
        }
        $request->validate([
            'from_date' => 'required|date',
            'to_date' => 'required|date',
        ]);
        return redirect()->route('reference_wise_report.show', [
            'source_id' => $request->source ?? 'null',
            'referral_id' => $request->referral ?? 'null',
            'from_date' => $request->from_date,
            'to_date' => $request->to_date
        ]);
    }
    function reference_wise_report_show($source_id = false, $referral_id = false, $from_date, $to_date){
        if($source_id != 'null'){
            $source = Source::findOrFail($source_id);
            $results = Payment::whereHas('account.student', function($query) use ($source_id, $from_date, $to_date) {
                $query->whereDate('created_at', '>=', date('Y-m-d', strtotime($from_date)))
                ->whereDate('created_at', '<=', date('Y-m-d', strtotime($to_date)))->where('students.source_id', $source_id);
            })->get();
            return view('reference_wise_report.reference_report', compact('source','source_id','results','from_date', 'to_date'));

        }
        elseif($referral_id != 'null'){
            $referral = Referral::findOrFail($referral_id);
            $results = Payment::whereHas('account.student', function($query) use ($referral_id, $from_date, $to_date) {
                $query->whereDate('created_at', '>=', date('Y-m-d', strtotime($from_date)))
                ->whereDate('created_at', '<=', date('Y-m-d', strtotime($to_date)))->where('students.referral_id', $referral_id);
            })->get();
            return view('reference_wise_report.reference_report', compact('referral','referral_id', 'results','from_date', 'to_date'));
        }
    }





    public function today_installment_dates()
    {
        $dates = InstallmentDate::where('installment_date', date('Y-m-d'))->get();
        if ($dates->count() > 0) {
            foreach ($dates as $dk => $date) {
                $account = $date->account;
                $total_fee = $this->courseFeeCalculate($account, $account->course->fee);
                $due = $total_fee - $account->payments->sum('amount');
                $date['due'] = $due;

                $batch = $account->student->batches->where('course_id', $account->course_id)->first();
                if (isset($batch)) {
                    $date['batch'] = batch_name($account->course->title_short_form, $batch->year, $batch->month, $batch->batch_number);
                } else {
                    $cm = CourseMigration::where('old_course_id', $account->course_id)
                        ->where('student_id', $account->student_id)->first();
                    $_batch = Batch::find($cm->old_batch_id);
                    $date['batch'] = batch_name($_batch->course->title_short_form, $_batch->year, $_batch->month, $_batch->batch_number);
                }

                $date['student_id'] = $account->student->id;
                $date['student_name'] = $account->student->name;
                $date['student_phone'] = $account->student->phone;
                $date['student_as'] = $account->student->student_as;

                if ($due <= 0) {
                    unset($dates[$dk]);
                }
            }
        }
        return view('report.today_installment_dates', compact('dates'));
    }

    public function smsStudentBatch(Request $request, $bid)
    {
        $request->validate([
            'sms' => 'required',
        ]);
        $b = Batch::find($bid);
        $ss = $b->students;
        
        $success = 0;
        $fail = 0;
        $total = 0;
        
        foreach ($ss as $s) {
            $total++;
            
            // $a = "Dear $s->name,"."\n";
            $a = "প্রিয় শিক্ষার্থী,\n" ; 
            $a .= "$request->sms\n";
            
            // $a .= "Sincerely,\n";
            // $a .= "European IT Institute\n";
            // $a .= "Contact Us: 01889977951\n";
            
            
            $a .= "ইউরোপিয়ান আইটি ইনস্টিটিউট \n"; 
//sms          
            $result = $this->sendSms($s->phone, $a);

//sms history
            $type = "Payment Notice";
            $save = new Sms_history;
            $save->user_id = Auth::id();
            $save->message = $a;
            $save->type = $type;         
            $save->status = $result;
            $save->receiver_no = $s->phone;
            $save->save(); 
            
            //COUNT     
            if ($result != "1")
            {
                $fail ++;
            }
            else
            {
                $success ++;
            }
        }
        
                 
        if ($fail != "0")
        {
            Session::flash('error', " $fail message sent unseccessful out of $total ." );
            return redirect()->back();
        }
        else
        {
            Session::flash('success', " $success message sent successful out of $total .");
            return redirect()->back();
         }
    }


    public function instituteSms(Request $request, $iid, $year)
    {
        $request->validate([
            'sms' => 'required',
        ]);
//        $institute = Institute::find($iid);
        $ss = Student::where('institute_id', $iid)->where('year', '=', $year)->get();
        
                
        $success = 0;
        $fail = 0;
        $total = 0;
        
        
        foreach ($ss as $s) {
            $total++;
            
            // $a = "Dear $s->name,"."\n";
            $a = "প্রিয় শিক্ষার্থী,\n" ; 
            $a .= "$request->sms\n";
            
            // $a .= "Sincerely,\n";
            // $a .= "European IT Institute\n";
            // $a .= "Contact Us: 01889977951\n";
            
            $a .= "ইউরোপিয়ান আইটি ইনস্টিটিউট \n"; 

//sms
            $result = $this->sendSms($s->phone, $a);
//sms history
            $type = "Payment Notice";
            $save = new Sms_history;
            $save->user_id = Auth::id();
            $save->message = $a;
            $save->type = $type;         
            $save->status = $result;
            $save->receiver_no = $s->phone;
            $save->save(); 
            
                        
            //COUNT     
            if ($result != "1")
            {
                $fail ++;
            }
            else
            {
                $success ++;
            }
        
        }
        
                 
        if ($fail != "0")
        {
            Session::flash('error', " $fail message sent unseccessful out of $total ." );
            return redirect()->back();
        }
        else
        {
            Session::flash('success', " $success message sent successful out of $total .");
            return redirect()->back();
         }
    }


    public function instituteSmsDue(Request $request, $iid, $year)
    {
        $request->validate([
            'sms' => 'required',
        ]);
        $students = [];
        $ss = Student::where('institute_id', $iid)->where('year', '=', $year)->get();
        if (isset($ss)) {
            foreach ($ss as $student) {
                $courses = $student->courses;
                $accounts = $student->accounts;
                if (isset($courses)) {
                    foreach ($courses as $key => $course) {
                        if (isset($accounts)) {
                            $_account = $accounts->where('student_id', $student->id)->where('course_id', $course->id)->first();
                            $_payments = isset($_account->payments) ? $_account->payments->sum('amount') : 0;
                            $total_fee = $this->courseFeeCalculate($_account, $course->fee);
                            $course['total_fee'] = $total_fee;
                            $course['payments'] = $_payments;
                        }
                    }
                }
                if (isset($courses)) {
                    foreach ($courses as $_k => $course) {
                        $student['total_amount'] = $course->total_fee;
                        $student['paid_amount'] = $course->payments;
                        $student['due_amount'] = $course->total_fee - $course->payments;
                    }
                }
                if ($student->due_amount > 0){
                    $students[] = $student;
                }
            }
        }
        
                
                
        $success = 0;
        $fail = 0;
        $total = 0;
        
        
        foreach ($students as $s) {
            $total++;
            
            // $a = "Dear $s->name,"."\n";
            $a = "প্রিয় শিক্ষার্থী,\n" ; 
            $a .= "$request->sms\n";
            
            // $a .= "Sincerely,\n";
            // $a .= "European IT Institute\n";
            // $a .= "Contact Us: 01889977951\n";
            
            $a .= "ইউরোপিয়ান আইটি ইনস্টিটিউট \n"; 
//sms
            $result = $this->sendSms($s->phone, $a);
//sms history
            $type = "Payment Notice";
            $save = new Sms_history;
            $save->user_id = Auth::id();
            $save->message = $a;
            $save->type = $type;         
            $save->status = $result;
            $save->receiver_no = $s->phone;
            $save->save(); 
            
                        
                        
            //COUNT     
            if ($result != "1")
            {
                $fail ++;
            }
            else
            {
                $success ++;
            }
        }   
        
        if ($fail != "0")
        {
            Session::flash('error', " $fail message sent unseccessful out of $total ." );
            return redirect()->back();
        }
        else
        {
            Session::flash('success', " $success message sent successful out of $total .");
            return redirect()->back();
         }
    }

    public function discount_report(){
        $data = Account::where('discount_percent', '>', 0)->orWhere('discount_amount', '>', 0)->latest()->get();
        $courses = Course::where('type', 'industrial')->get();
        $result = Student::select(DB::raw('YEAR(created_at) as year'))->distinct()->orderBy('created_at')->get();
        $years = $result->pluck('year');
        $users = User::all();
        return view('report.discount_report', compact('data', 'courses', 'years', 'users'));
    }
    


}
