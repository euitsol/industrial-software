<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Sms_history;
use App\Models\InstallmentDate;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

use Carbon\Carbon;

class AccountController extends Controller
{
    public function index()
    {
        $students = Student::latest()->get();
        return view('account.index', compact('students'));
    }

    public function accountSearch(Request $request)
    {
        $request->validate([
            'student' => 'required'
        ]);
        $student_id = $request->student;
        return redirect()->route('account.student.courses', $student_id);
    }

    public function studentCourses($sid)
    {
        $student = Student::with('courses')->with('batches')->findOrFail($sid);
        if (isset($student->courses)) {
            $courses = $student->courses;
        }
        if (isset($student->accounts)) {
            $accounts = $student->accounts;
        }
        if (isset($courses)) {
            foreach ($courses as $key => $course) {
                if (isset($accounts)) {
                    $_account = $accounts->where('student_id', $sid)->where('course_id', $course->id)->first();
                    $_payments = isset($_account->payments) ? $_account->payments->sum('amount') : 0;
                    $total_fee = $this->courseFeeCalculate($_account, $course->fee);
                    $course['total_fee'] = $total_fee;
                    $course['payments'] = $_payments;
                }
            }
        }
        return view('account.student_courses', compact('student', 'courses'));
    }

    public function installment_message_send(Request $request)
    {
        $request->validate([
            'message' => 'required'
        ]);

        if (is_array($request->student_id) && count($request->student_id) > 0) {
            $filtered_ids = array_unique($request->student_id);
            if (is_array($filtered_ids) && count($filtered_ids) > 0) {
                $count = 0;
                $error = [];
                foreach ($filtered_ids as $filtered_id) {
                    $student = Student::find($filtered_id);
                    if ($student) {
                        $_message = "প্রিয় শিক্ষার্থী, \n";
                        $_message .= "$request->message\n";

                        // $_message = "Dear ".$student->name.",\n";
                        // $_message .= "$request->message\n";
                        // $_message .= "Sincerely,\n";
                        // $_message .= "European IT Institute\n";
                        // $_message .= "Contact Us: 01889977951\n";
                        $result = $this->sendSms($student->phone, $_message);
                        if ($result === true) {
                            $count++;
                        } else {
                            $error[] = $student->phone.' - '.$result;
                        }
                        $type = "Installment";
                        $save = new Sms_history;
                        $save->user_id = Auth::id();
                        $save->message = $_message;
                        $save->type = $type;         
                        $save->status = $result;
                        $save->receiver_no = $student->phone;
                        $save->save(); 

                    }
                }
                if ($count) {
                    $this->message('success', $count.' message(s) sent successfully');
                } elseif (count($error) > 0) {
                    Session::flash('_errors', array_unique($error));
                } else {
                    $this->message('error', 'Message sending failed');
                }
            }
        }
        return redirect()->back();
    }
    
    public function additional_fee()
    {
        $data=[];
        $installments = InstallmentDate::select('account_id')->where('installment_date', '<', 'Carbon::now()')->with('account')->distinct()->get() ;
        
        foreach($installments as $k => $installment){
            $_installment = InstallmentDate::where('account_id', $installment->account_id)->first();
            $account = $installment->account;
            $course = $account->course;
            $student = $account->student;
            $b = $student->batches()->where('course_id', $course->id)->first();
            $batch_name = batch_name($course->title_short_form, $b->year, $b->month, $b->batch_number);
            
            $payments = isset($installment->account->payments) ? $installment->account->payments->sum('amount') : 0;
            $total_fee = $this->courseFeeCalculate($installment->account, $course->fee);
            
            if($payments < $total_fee){
                $data['student'][$k]['due'] = $total_fee - $payments;
                $data['student'][$k]['course_fee'] = $total_fee;
                $data['student'][$k]['installment_date'] = $_installment->installment_date;
                $data['student'][$k]['batch'] = $batch_name;
                $data['student'][$k]['student_name'] = $student->name;
                $data['student'][$k]['student_phone'] = $student->phone;
            }
        }
        
        // dd ($data);
        return view('account.additional_fee', compact('data'));
    }
}
