<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Fees;
use App\Models\Session;
use Illuminate\Http\Request;
use Carbon\Carbon;

class FeesController extends Controller
{


    public function index()
    {
        $sessions = Session::latest()->get();
        return view('fees.index', compact('sessions'));
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

        $numbers = $query->get()->pluck('student.phone')->toArray();

        $mobileNumberString = implode('+', $numbers);

        $this->message('success', 'Additional fee added successfully');
        return redirect()->back();
    }
}
