<?php

namespace App\Http\Controllers;

use App\Models\Institute;
use App\Models\Student;
use App\Models\TeacherPayment;
use App\Models\TeacherPaymentInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TeacherPaymentController extends Controller
{
    public function index()
    {
        $institutes = Institute::all();
        return view('teacher_payment.index', compact('institutes'));
    }

    public function institute_find(Request $request)
    {
        $request->validate([
            'institute' => 'required',
            'year' => 'required'
        ]);
        return redirect()->route('teacher.payment', [$request->institute, $request->year]);
    }

    public function institute_payment($iid, $year)
    {
        if (empty($iid) || empty($year)) {
            return redirect()->route('teacher.payment.institute');
        }
        $tpi = TeacherPaymentInfo::where('institute_id', $iid)->where('year', $year)->first();
        if (!$tpi) {
            $this->message('error', 'Please setup teacher payment');
            return redirect()->route('teacher.payment.institute');
        }
        $total_students = $tpi->institute->students->where('year', $tpi->year)->count();
        return view('teacher_payment.payment', compact('tpi', 'total_students'));
    }

    public function teacher_payment(Request $request)
    {
        $request->validate([
            'tpiid' => 'required',
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

        $tp = new TeacherPayment();
        $tp->amount = $request->amount;
        $tp->teacher_payment_info_id = $request->tpiid;
        $tp->user_id = Auth::id();
        $tp->save();

        $this->message('success', 'Teacher payment info successfully saved');
        return redirect()->back();
    }

    /*Teacher payment exist years by institute id*/
    public function teacher_payment_years($iid)
    {
        if (request()->ajax() && !empty($iid)) {
            $years = TeacherPaymentInfo::select('year')->where('institute_id', $iid)->get();
            if ($years) {
                return response()->json($years);
            }
        }
        return response()->json(['error' => 403]);
    }

    public function teacher_payment_history()
    {
        $count = 0;
        $tpis = TeacherPaymentInfo::orderBy('year', 'desc')->get();
        if ($tpis->count()) {
            foreach ($tpis as $tpi) {
                $count++;
                if (isset($tpi->institute->students))
                {
                $tpi->total_student = $tpi->institute->students()->where('year', $tpi->year)->count();
                }
            }
        }
         return view('teacher_payment.payment_history', compact('tpis'));
        // return $tpi;
    }

}
