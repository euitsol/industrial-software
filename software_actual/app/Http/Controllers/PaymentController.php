<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Sms_history;
use App\Models\Course;
use App\Models\Payment;
use App\Models\Student;
use Illuminate\Http\Request;
use App\Models\InstallmentDate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;


class PaymentController extends Controller
{
    public function payment($sid, $cid)
    {
        $account = Account::where('student_id', $sid)->where('course_id', $cid)->count();
        if ($account > 0) {
            return redirect()->route('account.payment.exist', ['sid' => $sid, 'cid' => $cid]);
        } else {
            return redirect()->route('account.payment.new', ['sid' => $sid, 'cid' => $cid]);
        }
    }

    public function newPaymentForm($sid, $cid)
    {
        $student = Student::find($sid);
        $course = $student->courses->find($cid);
        $batch = $student->batches->where('course_id', $cid)->first();
        return view('account.new_payment', compact('student', 'course', 'batch'));
    }

    public function newPaymentReceive(Request $request)
    {
        $request->validate([
            'amount' => 'required',
            'total_fee' => 'required'
        ]);

        if (($request->amount > $request->total_fee)) {
            $this->message('error', 'Amount can not be greater than payable fee.');
            return redirect()->back()->withInput();
        }
        if (Auth::id() == 7){
            if ($request->amount < 0) {
                $this->message('error', 'Amount can not be minus.');
                return redirect()->back()->withInput();
            }
        } else {
            if ($request->amount <= 0) {
                $this->message('error', 'Amount can not be minus or zero.');
                return redirect()->back()->withInput();
            }
        }
        if ($this->containsDecimal($request->amount)) {
            $this->message('error', 'Amount cannot be fraction.');
            return redirect()->back()->withInput();
        }
        $discount_percent = 0;
        $discount_amount = 0;
        $installment_quantity = 0;
        if (isset($request->discount_radio) && $request->discount_radio == 'yes') {
            if (empty($request->discount_percent) && empty($request->discount_amount)) {
                $this->message('error', 'Please fill out discount required fields.');
                return redirect()->back()->withInput();
            }
            if (!empty($request->discount_percent) && !empty($request->discount_amount)) {
                $this->message('error', 'Please fill out only one discount field.');
                return redirect()->back()->withInput();
            }
            if (!empty($request->discount_percent)) {
                $discount_percent = $request->discount_percent;
            }
            if (!empty($request->discount_amount)) {
                $discount_amount = $request->discount_amount;
            }
        }
        if (isset($request->method_radio) && $request->method_radio == 'installment') {
            if (empty($request->installment_quantity)) {
                $this->message('error', 'The installment quantity field is required.');
                return redirect()->back()->withInput();
            } else {
                $installment_quantity = $request->installment_quantity;
            }
        }
        if ($installment_quantity > 0 && isset($request->installment_date)) {
            $request->validate([
                'installment_date.*' => 'required'
            ]);
        }
         $exist = Account::where('student_id', $request->student_id)
             ->where('course_id', $request->course_id)->first();

        if (!$exist) {
            $account = new Account;
            $account->student_id = $request->student_id;
            $account->course_id = $request->course_id;
            $account->discount_percent = $discount_percent;
            $account->discount_amount = $discount_amount;
            $account->installment_quantity = $installment_quantity;
            $account->user_id = Auth::id();
            $account->save();

            $payment = new Payment;
            $payment->account_id = $account->id;
            $payment->amount = $request->amount;
            $payment->user_id = Auth::id();
            $payment->save();

            if (is_array($request->installment_date) && count($request->installment_date) > 0) {
                foreach ($request->installment_date as $date_key => $date) {
                    $i_date = new InstallmentDate;
                    $i_date->installment_date = $date;
                    $i_date->account_id = $account->id;
                    $i_date->save();
                }
            }
// mesage for admin after student 1st payment
            $student = Student::findorFail($request->student_id);
            $admin = "01717221398";
            $message = "";            
            
                // $message .= $student->student_as."\n" ;
                // if($student->gender == "male")
                // {
                //     $message .= "Mr.";
                // }
                // else if($student->gender == "female")
                // {
                //     $message .= "Mrs.";
                // }
                // else 
                // {
                //     $message .= "";
                // }    
                
                $course_fee = $this->number_convert($this->courseFeeCalculate($account, $request->course_fee ));
                $total_payments = $this->number_convert($account->payments->sum('amount'));
                $due_amount = $this->number_convert($this->courseFeeCalculate($account, $request->course_fee ) - $account->payments->sum('amount'));
                
                    //admin
                    
                    if($student->student_as == "Industrial") $message .= "ইন্ডাস্ট্রিয়াল \n";
                    
                    $message .= "ফোন: ".$this->number_convert($student->phone)."\n"; 
                    $message .= "কোর্স ফী: ".$course_fee." \n";
                    $message .= "পেইড:  ".$total_payments."\n";
                    $message .= "ডিউ: ".$due_amount."\n";    
                    
                    $result_1 = $this->sendSms($admin, $message);
                    //sms history
                    $type = "Payment to Admin";
                    $save = new Sms_history;
                    $save->user_id = Auth::id();
                    $save->message = $message;
                    $save->type = $type;         
                    $save->status = $result_1;
                    $save->receiver_no = $admin;
                    $save->save(); 

                    //student
                    $message_2 = "প্রিয় শিক্ষার্থী, \n";
                    $message_2 .= "আপনার কোর্স ফী: ".$course_fee."টাকা, আজকে আপনি দিয়েছেন:".$total_payments." টাকা";
                    $message_2 .= "। মোট পরিশোধ করেছেন: ".$total_payments;
                    
                    $message_2 .= "\n \n ইউরোপিয়ান আইটি ইনস্টিটিউট। \n";
                    
                    // $message_2 .= " Thanks for your payment !\n";
                    // $message_2 .= "Sincerely,\n";
                    // $message_2 .= "European IT Institute\n";
                    // $message_2 .= "Contact Us: 01889977951\n";
                    $result_2 = $this->sendSms($student->phone, $message_2);
                    //sms history
                    $type = "Payment to Student";
                    $save = new Sms_history;
                    $save->user_id = Auth::id();
                    $save->message = $message_2;
                    $save->type = $type;         
                    $save->status = $result_2;
                    $save->receiver_no = $student->phone;
                    $save->save(); 
            
            $this->message('success', 'Payment info successfully saved.');
            return redirect()->route('payment.receipt', ['aid'=>$account->id, 'pid' => 'null' ]);
            
        }
        return abort('403', 'Something went wrong!');







    }

    public function existPaymentForm($sid, $cid)
    {
        $student = Student::find($sid);

        $installment_dates_arr = [];
        $account = $student->accounts->where('course_id', $cid)->first();
        $installment_dates = $account->installment_dates;

        foreach ($installment_dates as $key1 => $value1) {
            $installment_dates_arr[] = $value1->installment_date;
        }

        $course = Course::find($cid);
        $batch = $student->batches->where('course_id', $cid)->first();
        $course_fee = $course->fee;
        $payments = $account->payments;

        $total_fee = $this->courseFeeCalculate($account, $course_fee);

        $due = $total_fee - optional($payments)->sum('amount');

        if (count(array_slice($installment_dates_arr, ($payments->count() - 1))) > 0) {
            $installment_amount = $due / count(array_slice($installment_dates_arr, ($payments->count() - 1)));
        } else {
            $installment_amount = $due;
        }

        $installment_dates = array_slice($installment_dates_arr, ($payments->count() - 1));

        return view('account.exist_payment', [
            'student' => $student,
            'course' => $course,
            'batch' => $batch,
            'installment_amount' => $installment_amount,
            'installment_dates' => $installment_dates,
            'course_fee' => $course_fee,
            'total_fee' => $total_fee,
            'account' => $account,
            'payments' => $payments,
            'due' => $due
        ]);
    }

    public function installmentReceive(Request $request)
    {
        $request->validate([
            'account_id' => 'required',
            'amount' => 'required'
        ]);

        $account = Account::find($request->account_id);

        if ($this->containsDecimal($request->amount)) {
            $this->message('error', 'Amount cannot be fraction.');
            return redirect()->back()->withInput();
        }

        if ($request->amount > $request->_due) {
            $this->message('error', 'Installment payment can not be greater than due.');
            return redirect()->back()->withInput();
        }

        if ($request->amount <= 0) {
            $this->message('error', 'Amount can not be minus or zero.');
            return redirect()->back()->withInput();
        }

        if (isset($request->installment_quantity) && $request->installment_quantity > 0) {
            if ($request->installment_quantity != count(array_filter($request->installment_date))) {
                $this->message('error', 'Installment quantity and installment total date not matched.');
                return redirect()->back()->withInput();
            } else {
                $account->installment_quantity += $request->installment_quantity;
                $account->save();
                foreach ($request->installment_date as $date) {
                    $i_date = new InstallmentDate;
                    $i_date->installment_date = $date;
                    $i_date->account_id = $account->id;
                    $i_date->save();
                }
            }
        }

        $p = new Payment;
        $p->account_id = $account->id;
        $p->amount = $request->amount;
        $p->user_id = Auth::id();
        $p->save();

        /* ----------------- Money receipt mail send ------------- */
        $student = Student::find($account->student_id);
        $course = Course::find($account->course_id);

        $to_name = $student->name;
        $to_email = $student->email;

        $total_course_fee = $this->number_convert($this->courseFeeCalculate($account, $course->fee));
        $today_paid_amount = $this->number_convert($request->amount);

        $payments = $account->payments;
        $total_payments = $this->number_convert($payments->sum('amount'));
        $due_amount = $this->number_convert($this->courseFeeCalculate($account, $course->fee) - $payments->sum('amount'));

        if (isset($student->phone)) {

            // $message = "Dear ".$to_name.",\n";
            // $message .= "Your course fee is ".$total_course_fee." tk. Today you have paid ".$today_paid_amount;
            // $message .= "tk and total paid ".$total_payments." tk. Your due amount is ".$due_amount. " tk.";
            // $message .= " Thanks for your payment !\n";
            // $message .= "Sincerely,\n";
            // $message .= "European IT Institute\n";
            // $message .= "Contact Us: 01889977951\n";   
          
                $message_2 = "প্রিয় শিক্ষার্থী, \n";
                $message_2 .= "আপনার কোর্স ফী: ".$total_course_fee."টাকা, আজকে আপনি দিয়েছেন:".$today_paid_amount." টাকা";
                $message_2 .= "। মোট পরিশোধ করেছেন: ".$total_payments;
                    
                $message_2 .= "\n \n ইউরোপিয়ান আইটি ইনস্টিটিউট। \n";
            
            
            $result = $this->sendSms($student->phone, $message_2);
//sms history
            $type = "Payment to Student";
            $save = new Sms_history;
            $save->user_id = Auth::id();
            $save->message = $message_2;
            $save->type = $type;         
            $save->status = $result;
            $save->receiver_no = $student->phone;
            $save->save(); 
        }


 /* ----------------- Money receipt mail to admin ------------- */
    $admin = "01717221398";
    $message = "";
            
    
    // $message .= $student->student_as."\n" ;

    // if($student->gender == "male")
    // {
    //     $message .= "Mr.";
    // }
    // else if($student->gender == "female")
    // {
    //     $message .= "Mrs.";
    // }
    // else 
    // {
    //     $message .= "";
    // }

    // $message .= $to_name."(".$request->batch_name.")\n";
    // $message .="P: ".$student->phone.".\n";
    // $message .= "Course fee: ".$total_course_fee."tk.\nPaid: ".$today_paid_amount;
    // $message .= "tk.\nTotal paid: ".$total_payments."tk.\nDue: ".$due_amount. "tk.\n";
    // $message .= "By: ".Auth::user()->name;
    
    
                                    
            if($student->student_as == "Industrial") $message .= "ইন্ডাস্ট্রিয়াল \n";
                    
            $message .= "ফোন: ".$this->number_convert($student->phone)."\n"; 
            $message .= "কোর্স ফী: ".$total_course_fee." \n";
            $message .= "পেইড:  ".$today_paid_amount."\n";
            $message .= "ডিউ: ".$due_amount."\n";    
            
    $result = $this->sendSms($admin, $message);

//sms history
    $type = "Payment to Admin";
    $save = new Sms_history;
    $save->user_id = Auth::id();
    $save->message = $message;
    $save->type = $type;         
    $save->status = $result;
    $save->receiver_no = $admin;
    $save->save(); 



        

        //        no email
//        if (isset($student->email)) {
//
//            $data = [
//                'name' => $to_name,
//                'total_course_fee' => $total_course_fee,
//                'today_paid_amount' => $today_paid_amount,
//                'total_paid' => $total_payments,
//                'due_amount' => $due_amount
//            ];
//
//            Mail::send('account.money_receipt_mail', $data, function($message) use ($to_name, $to_email) {
//                $message->to($to_email, $to_name)->subject('Payment confirmation');
//                $message->from('europeanitinstitute@gmail.com','European IT Institute');
//            });
//        }


        $this->message('success', 'Installment payment successfully saved.');
        return redirect()->route('payment.receipt', ['aid'=>$p->account_id, 'pid' => 'null' ]);
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

            return view('account.money_receipt', [
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

            return view('account.money_receipt', [
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

    public function studentPaymentHistory($sid)
    {
        $student = Student::with('batches')->with('batches.course')->findOrFail($sid);
        if (isset($student->courses)) {
            foreach ($student->courses as $course) {
                $account = $student->accounts()->with('payments')
                    ->where('course_id', $course->id)->first();
                $course['_account'] = $account;
                $total_fee = $this->courseFeeCalculate($account, $course->fee);
                $course['_total_fee'] = $total_fee;
                $course['_batch'] = $student->batches()->where('course_id', $course->id)->first();
            }
        }
        return view('account.payment_history', compact('student'));
    }
    
    
       public function anytimeDiscount(Request $request, $aid)
    {
        $request->validate([
            '_due' => 'required',
            'discount' => 'required'
        ]);
        if ($request->discount <= $request->_due){
            $a = Account::find($aid);
            if (($a->discount_percent * 1) != 0){
                $a->discount_percent = 0;
            }
            $a->discount_amount = $request->discount;
            $a->save();
            Session::flash('success', "Discount added successfully.");
            return redirect()->back();
        } else {
            Session::flash('error', "Discount is grater than due amount.");
            return redirect()->back();
        }
    }

}
