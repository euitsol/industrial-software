<?php

namespace App\Http\Controllers;
use App\Models\IndustrialMarketing;
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

class IndustrialMarketingController extends Controller
{
    //
    public function index()
    {

    }
    
    public function student()
    {
        $institutes = Institute::latest()->get();
        $courses = Course::where('type','Industrial')->get();
        return view('industrial_marketing.add_student', compact('institutes', 'courses'));
    }

    public function add_student(Request $request)
    {
         $request->validate([
            'name' => 'required|max:170',
            'phone' => 'required|unique:industrial_marketings,phone|max:11|min:11',
            'course' => 'required',
            'shift' => 'required',
        ]);
        
        if (empty($request->institute) && empty($request->institute_name)) {
            $this->message('error', 'Please select or add new institute info.');
            return redirect()->back()->withInput();
        }

        if (isset($request->institute) && isset($request->institute_name)) {
            $this->message('error', 'Institute has both items data not applicable.');
            return redirect()->back()->withInput();
        }

        if (isset($request->institute_name)) {
            if (empty($request->institute_division) || empty($request->institute_district)) {
                $this->message('error', 'The institute address, division, and district field is required.');
                return redirect()->back()->withInput();
            }
        }
        
        $data = new IndustrialMarketing;
        $data->name = $request->name;
        $data->phone = $request->phone;
        $data->course = $request->course;
        $data->note = $request->note;
        $data->shift = $request->shift;
        $data->year = $date = Carbon::now()->format('Y');
        
        if (empty($request->institute) && !empty($request->institute_name)) {
            $i = new Institute;
            $i->name = $request->institute_name;
            $i->address = $request->institute_address;
            $i->division = $request->institute_division;
            $i->district = $request->institute_district;
            $i->website = $request->institute_website;
            $i->user_id = Auth::id();
            $i->save();

            $data->institute = $i->id;
        } else {
            $data->institute = $request->institute;
        }
        
        $data->created_by = Auth::id();
        $data->save();
        
        Session::flash('success', "New student $request->name added successfully");
        return redirect()->back();
        
        return $request;
    }
        
    public function message_index()
    {
        $courses = Course::where('type','Industrial')->get();
        $years = IndustrialMarketing::select('year')->distinct()->orderBy('year', 'desc')->get();
        $current_year = $date = Carbon::now()->format('Y');
        $institutes = IndustrialMarketing::select('institute')->distinct()->orderBy('institute', 'desc')->get();
        return view('industrial_marketing.message', compact('courses', 'years', 'current_year', 'institutes'));
    }
    
    public function message_search(Request $request)
    {
        $request->validate([
            'year' => 'required',
        ]);
        
        $year = $request->year;
        $course = '';
        $institute = '';
        
        if($request->institute == null && $request->course == !null )
        {
            $course = Course::findOrFail($request->course);
            $institute = $request->institute;
            $students = IndustrialMarketing::where('year', $request->year)->where('course', $request->course)->latest()->get();
        }
        elseif($request->institute == !null && $request->course == null )
        {
            $course = $request->course;
            $institute = Institute::findOrFail($request->institute);
            $students = IndustrialMarketing::where('year', $request->year)->where('institute', $request->institute)->latest()->get();
        }
        elseif($request->institute == !null && $request->course == !null )
        {
            $course = Course::findOrFail($request->course);
            $institute = Institute::findOrFail($request->institute);
            $students = IndustrialMarketing::where('year', $request->year)->where('institute', $request->institute)->where('course', $request->course)->latest()->get();
        }
        else
        {
            $course = $request->course;
            $institute = $request->institute;
            $students = IndustrialMarketing::where('year', $request->year)->latest()->get();
        }
        return view('industrial_marketing.message_view',compact('students', 'year', 'course', 'institute'));  
    }
    
    public function message_send(Request $request)
    {
        // dd($request);
        
        ini_set('max_execution_time', 3000);
        $request->validate([
            'message' => 'required',
        ]);
            
        $success = 0;
        $fail = 0;
        $total = 0;
        
        foreach ($request->student_id as $id)
        {

            $total++;
            $student = IndustrialMarketing::findOrFail($id);
            $message = "";
            if(!empty($request->heading))
            {
                $message .= "প্রিয় শিক্ষার্থী,\n" ; 
            }
            $message .= $request->message;
            if(!empty($request->heading))
            {
                $message .= "\n যোগাযোগ,\n";
                $message .= "ইউরোপিয়ান আইটি \n";
                $message .= "০১৮৮৯৯৭৭৯৫০\n";
            } 

            
            $receiver_number = $student->phone;
            
            if(!empty($request->masking))
            {
                $result = $this->sendMaskingSms($receiver_number, $message);
                //sms history
                $type = "Industrial Marketing-masking";
                $save = new Sms_history;
                $save->user_id = Auth::id();
                $save->message = $message;
                $save->type = $type;         
                $save->status = $result;
                $save->receiver_no = $receiver_number;
                $save->save();
            }
            else
            {
                $result = $this->sendNonMaskingSms($receiver_number, $message);
                //sms history
                $type = "Industrial Marketing-non_masking";
                $save = new Sms_history;
                $save->user_id = Auth::id();
                $save->message = $message;
                $save->type = $type;         
                $save->status = $result;
                $save->receiver_no = $receiver_number;
                $save->save();
            }
            
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
        
        // return $result;
        
        if ($fail != "0")
        {
            Session::flash('error', " $fail message sent unseccessful out of $total ." );
            return redirect()->route('marketing.industrial.message');
        }
        else
        {
            Session::flash('success', " $success message sent successful out of $total .");
            return redirect()->route('marketing.industrial.message');
        }

    }
   

    
}
