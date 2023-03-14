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
use App\Models\Student;
use App\Models\Sms_history;
use App\Models\User;
use App\Models\Promotion_type ;
use App\Models\Teacher;
use App\Models\CsvData;
use App\Models\Message;

use App\Models\TeacherEmail;
use App\Models\TeacherPaymentInfo;
use App\Models\TeacherPhone;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
class SmsController extends Controller
{
    //
    public function index()
    {

    }
    
    public function sms_send(Request $request)
    {
        ini_set('max_execution_time', 3000);
        $request->validate([
            'message' => 'required',
        ]);
        $id = $request->id;
        $success = 0;
        $fail = 0;
        $total = 0;
        
        foreach ($request->phone as $pn)
        {
            $total++;
            $message = "";
            
            // $message .= "Dear Students,\n" ; 
            
            $message .= "প্রিয় শিক্ষার্থী,\n" ; 
            
            $message .= $request->message;
            
            $message .= "\n";
            
            // $message .= "\nSincerely,\n";
            // $message .= "European IT \n"; 
            
            $message .= "ইউরোপিয়ান আইটি ইনস্টিটিউট \n"; 
            
            // $message .= "Contact Us: 01889977950 \n";
            
            $receiver_number = $pn;
            $result = $this->sendSms($receiver_number, $message);
//sms history
            $type = "Marketing";
            $save = new Sms_history;
            $save->user_id = Auth::id();
            $save->message = $message;
            $save->type = $type;         
            $save->status = $result;
            $save->receiver_no = $pn;
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
        $save_msg = new Message;
        $save_msg->promotion_type_id = $request->id;
        $save_msg->message = $message;
        $save_msg->user_id = Auth::id();
        $save_msg->save();

        $data = CsvData::where('promotion_type_id',$request->id)->get();       
        $product = new CsvData;
        $columns = $product->getTableColumns();
        $message_data = Message::where('promotion_type_id',$request->id)->get();
        $user_data = User::get();
         
        if ($fail != "0")
        {
            Session::flash('error', " $fail message sent unseccessful out of $total ." );
            return view('import.new', compact('data','columns','id','message_data','user_data'));
        }
        else
        {
            Session::flash('success', " $success message sent successful out of $total .");
            return view('import.new', compact('data','columns','id','message_data','user_data'));
         }
        
        // return $pn;
    }
    public function promotional_sms_index()
    {
        $data = Promotion_type::get();
        return view('sms.send_marketing_sms_index',compact('data'));
    }
    public function promotional_sms_search(Request $request)
    {
        
        return redirect()->route('promotion_type.sms', ['id' => $request->promotion_type]);
    }
    public function sms_students()
    {
        $students = Student::orderBy('phone', 'ASC')->latest()->get();
        
        return view ('sms.students', compact('students')) ;
    }

    public function sms_students_search(Request $request)
    {
        if(isset($request->student_id))
        {
            $students = Student::find($request->student_id);           
            return view('sms.send_student_one', compact('students'));           
        }
        if(isset($request->course_type) && isset($request->course) && isset($request->batch))
        {

            $batch = Batch::find($request->batch);
            $course = $batch->course;
            $students = $batch->students;
            $batch_name = batch_name($course->title_short_form, $batch->year, $batch->month, $batch->batch_number);
            return view('sms.send_student_by_batch', compact('students', 'course', 'batch_name'));
            // return $batch;

        }
        if(isset($request->course_type) && isset($request->course))
        {
        
            $course = Course::find($request->course);
            $batches = $course->batches;
            return view('sms.send_student_by_course', compact('course', 'batches'));

        }
        if(isset($request->course_type))
        {
        
            $students = Course::where('type', $request->course_type)->with(['students'])->get();
            return view('sms.send_student_by_file', compact('students'));

        }
        
    }

    public function sms_students_send(Request $request)
    {
        ini_set('max_execution_time', 30000);
        
        $success = 0;
        $fail = 0;
        $total = 0;
        foreach ($request->student_phone as $sp)
        {
            $total++;
            $message = "";
            // $message .= "Dear Student,\n";
            
            $message .= "প্রিয় শিক্ষার্থী,\n" ; 
            
            $message .= "$request->message\n";
            
            // $message .= "Sincerely,\n";
            // $message .= "European IT\n";
                        
            $message .= "ইউরোপিয়ান আইটি ইনস্টিটিউট \n"; 
            
            // $message .= "Contact Us: 01889977950\n";
            $receiver_number = $sp;
            
            $result = $this->sendSms($receiver_number, $message);
//sms history
            $type = "Genaral Notice";
            $save = new Sms_history;
            $save->user_id = Auth::id();
            $save->message = $message;
            $save->type = $type;         
            $save->status = $result;
            $save->receiver_no = $sp;
            $save->save(); 
            if ($result != "1")
            {
                $fail ++;
            }
            else
            {
                $success ++;
            }
            
        }

        if ($result != "1")
        {
            Session::flash('error', " $fail message sent unseccessful out of $total ." );
                
        }
        else
        {
            Session::flash('success', " $success message sent successful out of $total .");
                
        }
        return redirect()->route("sms.sms_students");
    }
    public function sms_history()
    {
        $user_data = User::get();
        $data = Sms_history::latest()->take(500)->get();
        return view('sms.history_index',compact('data','user_data'));
    }
    public function sms_history_show($id)
    {
    
        $data = Sms_history::findOrFail($id);
        $user_data = User::get();
        return view('sms.history_view',compact('data','user_data'));
        // return $data;
    }
    public function sms_indivisual()
    {
        return view('sms.indivisual');
    }
    public function sms_indivisual_send(Request $request)
    {
        ini_set('max_execution_time', 3000);

        $request->validate([
            
            'phone' => 'required|max:11|min:11',
            'message' => 'required'
        ]);

        $message = "";
        
        $message .= "$request->name,\n";
        
        
        $message .= "$request->message\n";
        
        $message .= "$request->company_name\n";
        
        $message .= "যোগাযোগ: $request->company_phn\n";

        $receiver_number = $request->phone;
        $result = $this->sendSms($receiver_number, $message);

//sms history
            $type = "Indivisual Message";
            $save = new Sms_history;
            $save->user_id = Auth::id();
            $save->message = $message;
            $save->type = $type;         
            $save->status = $result;
            $save->receiver_no = $receiver_number;
            $save->save(); 

            if ($result != "1")
            {
                Session::flash('error', $result);
                return redirect()->back();
            }
            else
            {
                Session::flash('success', "Sms sent successfully.");
                return redirect()->back();
            }
        
    }

    public function sms_teacher($year = '')
    {
        $tpi_years = TeacherPaymentInfo::select('year')->distinct()->orderBy('year', 'desc')->get();
        $year = $year ? $year : optional($tpi_years->max())->year;
        $tpis = TeacherPaymentInfo::where('year', $year)->get();
        return view('sms.teacher', compact('tpi_years','tpis', 'year'));
        // return view('sms.teacher');
    }

    public function sms_teacher_send(Request $request)
    {
        ini_set('max_execution_time', 3000);
        $success = 0;
        $fail = 0;
        $total = 0;
        
        // $message = "Dear Sir,\n";  
        
        $message = "প্রিয় শিক্ষক,\n";     
        
        $message .= "$request->message\n";
        // $message .= "Sincerely,\n";
        // $message .= "European IT Institute\n";
        // $message .= "Contact Us: 01889977950\n";
        
        $message .= "ইউরোপিয়ান আইটি ইনস্টিটিউট \n"; 
        
        
         foreach ($request->teacher_phone as $receiver_number)
        {
        $total++;
        $result = $this->sendSms($receiver_number, $message);
//sms history
        $type = "Teacher SMS";
        $save = new Sms_history;
        $save->user_id = Auth::id();
        $save->message = $message;
        $save->type = $type;         
        $save->status = $result;
        $save->receiver_no = $receiver_number;
        $save->save(); 
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


    
}
