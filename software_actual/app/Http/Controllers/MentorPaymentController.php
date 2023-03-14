<?php

namespace App\Http\Controllers;

use App\Models\Mentor;
use App\Models\MentorPayment;
use App\Models\MentorPaymentInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MentorPaymentController extends Controller
{
    public function index()
    {
        $mentors = Mentor::all();
        return view('mentor_payment.index', compact('mentors'));
    }

    public function mentor_search(Request $request)
    {
        $request->validate([
            'mentor' => 'required'
        ]);

        return redirect()->route('mentor.payment.info', $request->mentor);
    }

    public function mentor_payment_info($mid)
    {
        if (isset($mid)) {
            $mentor = Mentor::find($mid);
            $mpis = MentorPaymentInfo::where('mentor_id', $mid)->get();
            if ($mpis->count()) {
                return view('mentor_payment.payment_info', compact('mentor', 'mpis'));
            }
            $this->message('error', 'Mentor payment setup not found');
            return redirect()->route('mentor.payment.mentor-search');
        }
        return redirect()->route('mentor.payment.mentor-search');
    }

    public function mentor_payment($mpiid)
    {
        $mpi = MentorPaymentInfo::find($mpiid);
        return view('mentor_payment.payment', compact('mpi'));
    }

    public function mentor_payment_receive(Request $request)
    {
        $request->validate([
            'mpiid' => 'required',
            'amount' => 'required',
            '_total_due' => 'required'
        ]);

        if (isset($request->amount) && isset($request->_total_due)) {
            if ($request->amount > $request->_total_due) {
                $this->message('error', 'Amount can not be up to due amount.');
                return redirect()->back()->withInput();
            }
            if ($request->amount <= 0) {
                $this->message('error', 'Amount can not be minus or zero.');
                return redirect()->back()->withInput();
            }
        }

        $mp = new MentorPayment();
        $mp->amount = $request->amount;
        $mp->mentor_payment_info_id = $request->mpiid;
        $mp->user_id = Auth::id();
        $mp->save();

        $this->message('success', 'Mentor payment info successfully saved');
        return redirect()->back();
    }


    public function mentor_payment_history()
    {
        $mpis = MentorPaymentInfo::orderBy('year', 'desc')->get();
        return view('mentor_payment.payment_history', compact('mpis'));
    }

}
