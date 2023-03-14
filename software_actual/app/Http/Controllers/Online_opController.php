<?php

namespace App\Http\Controllers;


use App\Models\Account;
use App\Models\Batch;
use App\Models\Course;
use App\Models\CourseMigration;
use App\Models\Student;
use App\Models\Online_reg;
use App\Models\Discount;
use App\Models\CourseType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;

class Online_opController extends Controller
{

    public function index(){

    }

    public function course_dis(){
        $course = Discount::with('discount')->with('user')->orderBy('created_at', 'ASC')->get();       
        return view('online_operation.course_discount', compact('course'));
        //return $course;
        
    }
    public function course_dis_history(){
        $course = Discount::with('discount')->with('user')->latest( )->get();       
        return view('online_operation.course_discount_history', compact('course'));
        //return $course;
        
    }
    public function course_dis_create(){
               
        return view('online_operation.course_discount_create');
        //return $course;
        
    }
    public function course_dis_store(Request $request){
        $request->validate([
            'course' => 'unique:discount,course_id|required'
            

        ]);
        if ( 0 > $request->discount_fee) {
            
            return redirect()->back();
        }     
        
        $discount = new Discount;
        $discount->course_id = $request->course;
        if( isset($request->discount_percent))
        {
            $discount->discount_percent = $request->discount_percent;
        }
        else if ( isset($request->discount_amount))
        {
            $discount->discount_amount = $request->discount_amount;
        }
        else
        {
            return redirect()->back();
        }
        $date = Carbon::now();
        $discount->start = $date;
        $discount->user_id = Auth::id();
        $discount->save();

        Session::flash('success', "Discount added successfully" );
        return redirect()->route('online_op.course_dis');


        
        
    }
    public function course_dis_update($cid){
        $courses = Discount::with('discount')->where('id', $cid)->get(); 
        
        
        return view('online_operation.course_discount_update',compact('courses'));
        //return $courses;
    }
    public function course_dis_update_store(Request $request){
        $request->validate([
            'course' => 'required'
            

        ]);
        $date = Carbon::now();
        if ( 0 > $request->discount_fee) {
            
            return redirect()->back();
        }
        $end_process = Discount::where('id', $request->discount_id)
                            ->update(['end' => $date]);     
        
        $discount = new Discount;
        
        $discount->course_id = $request->course;
        if( isset($request->discount_percent))
        {
            $discount->discount_percent = $request->discount_percent;
        }
        else if ( isset($request->discount_amount))
        {
            $discount->discount_amount = $request->discount_amount;
        }
        else
        {
            return redirect()->back();
        }
        
        $discount->start = $date;
        
        $discount->user_id = Auth::id();
        $discount->save();

        Session::flash('success', "Discount updated successfully" );
        return redirect()->route('online_op.course_dis');

        
    }
    public function course_status()
    {
        $course = Course::latest()
            ->where('running','1')->get();
        return view('online_operation.course_status',compact('course'));
    }
    public function course_status_store(Request $request)
    {
        $out = "";
        $course = Course::latest()->get();
        foreach($course as $cs)
        {
            $id = $cs->id;
            if (isset($request->$id)) 
            {
                $end_process = Course::where('id', $id)
                            ->update(['status' => 'Running']);
            }
            else 
            {
                $end_process = Course::where('id', $id)
                            ->update(['status' => 'End']);
            }
        }
        Session::flash('success', "Course Status Updated Successfully" );
        return redirect()->route('course_status');
        
    }

    public function online_reg()
    {
        $student = Online_reg::latest()->get();
        $total = Online_reg::get()->count();
        $this_month = Online_reg::select('*')->whereMonth('created_at', Carbon::now()->month)->get()->count();
        $this_week = Online_reg::whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->get()->count();

        return view('online_operation.online_reg-index',compact('total','this_month','this_week','student'));
        //return $this_week;
    }










}