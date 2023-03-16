<?php

namespace App\Http\Controllers;

use App\Models\Batch;
use App\Models\Course;
use App\Models\Lab;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BatchController extends Controller
{
    public function index()
    {
        $batches = Batch::with(['students','user','course','lab'])->get();
        $in_batches = [];
        $pro_batches = [];
        foreach ($batches as $key => $batch) {
            if ('Industrial' == $batch->course->type) {
                $in_batches[$batch->course->title][] = $batch;
            } elseif ('Professional' == $batch->course->type) {
                $pro_batches[$batch->course->title][] = $batch;
            }
        }
        $now = Carbon::now();
        $this->batch_end();

        return view('batch.index', compact('in_batches', 'pro_batches', 'now'));
    }


    public function create()
    {
        $labs = Lab::where('status', 1)->get();
        return view('batch.create', compact('labs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'course' => 'required',
            'course_short_form' => 'required',
            'year' => 'required',
            'batch_number' => 'required',
            'month' => 'required',
            'lab'=> 'required'
        ]);

        $course = Course::findOrFail($request->course);
        $course->title_short_form = $request->course_short_form;
        $course->save();

        $b = new Batch;
        $b->course_id = $course->id;
        $b->year = $request->year;
        $b->batch_number = $request->batch_number;
        $b->month = $request->month;
        $b->start_date = $request->start_date;
        $b->end_date = $request->end_date;
        $b->lab_id = $request->lab;
        $b->user_id = Auth::id();
        $b->save();

        $this->message('success', 'Batch info save successfully');
        return redirect()->route('batches');
    }

    public function edit($bid)
    {
        $batch = Batch::with('lab')->findOrFail($bid);
        $labs = Lab::where('status', 1)->get();
        return view('batch.edit', compact('batch','labs'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
        ]);

        $b = Batch::findOrFail($request->id);
        $b->start_date = $request->start_date;
        if($b->previous_end_date == null){
            $b->previous_end_date = $b->end_date;
        }
        $b->end_date = $request->end_date;
        if($request->lab != 'null'){
            $b->lab_id = $request->lab;
        }
        $b->save();

        $this->message('success', 'Batch info update successfully');
        return redirect()->route('batches');
    }

    public function destroy($bid)
    {
        $batch = Batch::findOrFail($bid);

        if ($batch->students->count() > 0) {
            $this->message('error', 'Batch info can not deleted');
            return redirect()->route('batches');
        } else {
            $batch->delete();
            $this->message('success', 'Batch info delete successfully');
            return redirect()->route('batches');
        }
    }
    
    public function status($bid){
        $batch = Batch::findOrFail($bid);
        
        if($batch->status == 1){
            $batch->status = 0;  
        }else{
            $batch->status = 1;
        }
        
        $batch->save();            
        
        $this->message('success', 'Batch status changed successfully');
        return redirect()->route('batches');
    }
    
    public function details($id){
        $batch = Batch::where('id',$id)->first();
        $students = $batch->students;

        if (isset($students)) {
            foreach ($students as $student) {
                $course = $batch->course;
                $accounts = $student->accounts;
                if (isset($course)) {
                        if (isset($accounts)) {
                            $_account = $accounts->where('student_id', $student->id)->where('course_id', $course->id)->first();
                            $_payments = isset($_account->payments) ? $_account->payments->sum('amount') : 0;
                            $total_fee = $this->courseFeeCalculate($_account, $course->fee);
                            $course['total_fee'] = $total_fee;
                            $course['payments'] = $_payments;
                        }
                }
                if (isset($course)) {
                        $student['total_amount'] = $course->fee;
                        // $student['total_amount'] = $course->total_fee;
                        $student['paid_amount'] = $course->payments;
                        $student['due_amount'] = $course->total_fee - $course->payments;

                }
            }
        }
        return view('batch.details', compact('students', 'batch'));
    }
    protected function batch_end(){
        $batches = Batch::where('status',1)->get();
        foreach($batches as $batch){
            $now = Carbon::now();
            $end_date = Carbon::parse($batch->end_date);
            if($now > $end_date){
                $batch->status = 0;
                $batch->save();
            }
            
        }
    }
}
