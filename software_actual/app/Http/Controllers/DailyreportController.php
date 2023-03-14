<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Student;
use App\Models\Sms_history;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class DailyreportController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index()
    {
        $payments = Payment::where('user_id', Auth::id())->get();
        $ts = 0;
        $ta = 0;
        if (count($payments) > 0) {
            $ts = count($payments);
            foreach ($payments as $p) {
                $ta = $ta + $p->amount;
            }
        }
        $paymentsToday = Payment::where('user_id', Auth::id())->whereDate('created_at', Carbon::today())->get();
        $tst = 0;
        $tat = 0;
        if (count($paymentsToday) > 0) {
            $tst = count($paymentsToday);
            foreach ($paymentsToday as $pp) {
                $tat = $tat + $pp->amount;
            }
        }
        return view('dailyReport.index', compact('ts', 'ta', 'tst', 'tat'));
    }


    public function drajax()
    {
        if (request()->ajax()) {
            $date = $_GET['date'];
            $payments = Payment::where('user_id', Auth::id())->whereDate('created_at', $date)->get();
            $ts = 0;
            $ta = 0;
            if (count($payments) > 0) {
                $ts = count($payments);
                foreach ($payments as $p) {
                    $ta = $ta + $p->amount;
                }
            }
            $data = [$ts, $ta];
            return $data;
        } else {
            abort(403);
        }
    }


    public function birthday()
    {
            $students = Student::whereMonth('dob', '=', Carbon::now()->format('m'))->whereDay('dob', '=', Carbon::now()->format('d'))->get();
            // $students = Student::whereRaw('DAYOFYEAR(curdate()) =  dayofyear(dob)')->orderByRaw('DAYOFYEAR(dob)')->get();
            foreach ($students as $s) {
                if (isset($s->institute->name))
                {
                    $s['institute'] = $s->institute->name;
                }
                $bn = [];
                $bs = $s->batches;
                foreach ($bs as $batch) {
                    $bn[] = batch_name($batch->course->title_short_form, $batch->year, $batch->month, $batch->batch_number);
                }
                $s['batches'] = $bn;
            }
            return view('birthday.index', compact('students'));
        
    }


    public function birthdaySms(Request $request)
    {
        $request->validate([
            'sms' => 'required',
        ]);
        $ss = Student::whereRaw('DAYOFYEAR(curdate()) =  dayofyear(dob)')->orderByRaw('DAYOFYEAR(dob)')->get();
        foreach ($ss as $s) {
            $message = "Dear $s->name ,\n";
            $message .= "$request->sms\n";
            $message .= "Sincerely,\n";
            $message .= "European IT Institute\n";
            $message .= "Contact Us: 01889977951\n";
            

            $receiver_number = $s->phone;
            $result = $this->sendSms($receiver_number, $message);  
            
            if ($result != "1")
            {
                Session::flash('error', $result);
                return redirect()->back();
            }
            $type = "Birthday Sms";
            $save = new Sms_history;
            $save->user_id = Auth::id();
            $save->message = $message;
            $save->type = $type;         
            $save->status = $result;
            $save->receiver_no = $s->phone;
            $save->save(); 
            
        }
        Session::flash('success', "Sms sent successfully.");
        return redirect()->back();

        
    }

}
