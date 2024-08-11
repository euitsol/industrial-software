<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Fees;
use App\Models\Session as SessionModel;
use App\Models\Sms_history;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class FeesController extends Controller
{


    public function index()
    {
        $fees = Fees::with(['session', 'created_user'])->latest()->get()
            ->each(function ($fee) {
                $fee->total_student = Account::with('student')
                    ->whereHas('student', function ($query) use ($fee) {
                        $query->where('session_id', $fee->session_id);
                    })->withDuePayments()->count();
                return $fee;
            });

        return view('fees.index', compact('fees'));
    }

    public function create()
    {
        $sessions = SessionModel::latest()->get();
        return view('fees.create', compact('sessions'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'session' => 'required|exists:sessions,id',
            'amount' => 'required|numeric|min:1'
        ]);
        $session_id = $request->session;

        $fee = new Fees();
        $fee->session_id = $session_id;
        $fee->amount = $request->amount;
        $fee->created_by = auth()->user()->id;
        $fee->save();
        $query = Account::with(['course', 'payments', 'student'])
            ->whereHas('student', function ($query) use ($session_id) {
                $query->where('session_id', $session_id);
            })->withDuePayments();

        $query->update(['additional_fee' => $request->amount, 'user_id' => auth()->user()->id, 'updated_at' => Carbon::now()]);
        $accounts = $query->get();

        ini_set('max_execution_time', 3000);
        $success = 0;
        $fail = 0;
        $total = 0;

        foreach ($accounts as $account) {
            $previous_due = $account->get_due();
            $total_due = $previous_due + $account->additional_fee;
            $previous_due = number_format($account->get_due(), 2);
            $total_due = number_format($total_due, 2);
            $additional_fee = number_format($account->additional_fee, 2);
            $total++;
            $message = "";
            $message .= "প্রিয় " . $account->student->name . ",\n\n";
            $message .= "নির্ধারিত সময়ে কোর্স ফি পরিশোধ না করায় $additional_fee টাকা বিলম্ব ফি যুক্ত হয়েছে । পূর্বে আপনার বকেয়া ছিলো " . $previous_due . " টাকা । এখন আপনাকে  বিলম্ব ফি সহ মোট " . $total_due . " টাকা আগামী ৫ দিনের মধ্যে পরিশোধ করতে হবে । ";

            $message .= "\n\nযোগাযোগ,\n";
            $message .= "ইউরোপিয়ান আইটি \n";
            $message .= "০১৮৮৯৯৭৭৯৫০\n";
            $receiver_number = $account->student->phone;


            $result = $this->sendMaskingSms($receiver_number, $message);
            // sms history
            $type = "Additional Fee";
            $save = new Sms_history();
            $save->user_id = Auth::id();
            $save->message = $message;
            $save->type = $type;
            $save->status = $result;
            $save->receiver_no = $receiver_number;
            $save->save();
            //COUNT     
            if ($result != "1") {
                $fail++;
            } else {
                $success++;
            }
        }
        if ($fail != "0") {
            $this->message('error', " $fail message sent unseccessful out of $total .");
        }
        $this->message('success', 'Additional fee added successfully');
        return redirect()->route('fee.index');
    }
}
