<?php

namespace App\Http\Controllers;

use App\Models\Batch;
use App\Models\Course;
use App\Models\OnlinePayment;
use App\Models\Student;
use App\Models\Online_reg;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class OnlinePaymentController extends Controller
{
    public function index(){
        return view('online-payment.index');
    }
    
    public function search(Request $request){
        if(isset($request->phone)){
            $check = [];
            $check = Student::where('phone', $request->phone)->first();
            if (!empty($check)){
                return redirect()->route('op.student.checkout', Crypt::encrypt($check->id));
            }else{
                $this->message('error', 'This phone number is not registered');
                return redirect()->back();                
            }
        }else{
            $this->message('error', 'Phone number is required');
            return redirect()->back();
        }
    }
    
    public function checkout($id = null){
        if($id != null){
            $id = Crypt::decrypt($id);
            $student = Student::findorFail($id);
            $courses = $student->courses;
        
            return view('online-payment.checkout', compact('student', 'courses'));
        }
    }
    
    public function successfullPayments(Request $request){
        if($request->ajax()){
          
        }
        $online_payments = OnlinePayment::where('deleted_by', null)->latest()->get();
        
        return view('online-payment.successfulPayments',compact('online_payments'));
    }
}









