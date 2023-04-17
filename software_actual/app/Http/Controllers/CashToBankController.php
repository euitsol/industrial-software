<?php
namespace App\Http\Controllers;

use App\Models\CashToBank;
use App\Models\User;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CashToBankController extends Controller
{
    public function index()
    {
        $users = User::latest()->get();
        return view('cashtobank.index', compact('users'));
    }
    
    public function search(Request $request)
    {
        if(!empty($request->user) && !empty($request->date)){
             return redirect()->route('ctb.all', [$request->date, $request->user, $request->type]);
        }else{
            return redirect()->route('ctb.all', [$request->date, 0, $request->type]);
        }
    }
    
    public function ctb_all($date, $user = 0, $type = 0)
    {
        if($user>0){
            $payments = Payment::where('user_id', $user)->where('cashtobank', 0)->whereDate('created_at', '=', date('Y-m-d', strtotime($date)))->get();
            $user = User::findOrFail($user);
        }else{
            $payments = Payment::where('cashtobank', 0)->whereDate('created_at', '=', date('Y-m-d', strtotime($date)))->get();
        }

        return view('cashtobank.all', compact('payments', 'date', 'user', 'type'));
    }
    
    public function cash_add(Request $request)
    {
        $request->validate([
            'payment_id' => 'required',
            'note' => 'required'
        ]);
        
        $cashtobank = new CashToBank;
        $cashtobank->note = $request->note;
        $cashtobank->created_by = auth()->user()->id;
        $cashtobank->save();
        
        foreach($request->payment_id as $pi){
            $payment = Payment::findOrFail($pi);
            $payment->cashtobank = $cashtobank->id;
            $payment->save();
        }
        
        return redirect()->route('ctb');
    }
    
    public function ctb_detail()
    {
        $payments = Payment::latest()->get();

        return view('cashtobank.details', compact('payments'));
    }

    public function ctbr_index(){
        return view('cashtobank_report.index');
    }
    public function ctbr_find(Request $request)
    {
        $request->validate([
            'from_date' => 'required|date',
            'to_date' => 'required|date',
        ]);
        return redirect()->route('ctb.report.show', [
            'from_date' => $request->from_date,
            'to_date' => $request->to_date
        ]);
    }
    public function ctbr_show($from_date, $to_date){
        $payments = Payment::where('cashtobank','!=', 0)->whereDate('updated_at', '>=', date('Y-m-d', strtotime($from_date)))
        ->whereDate('updated_at', '<=', date('Y-m-d', strtotime($to_date)))->get();

        return view('cashtobank.details', compact('payments','from_date','to_date'));
    }
}