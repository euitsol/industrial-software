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
use App\Models\User;
use Carbon\Carbon;
use function GuzzleHttp\Psr7\str;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Session;


class Indivisual_reportController extends Controller
{

        public function index()
    {

        return view('indivisual_report.index');
    }

        public function indivisual_report(Request $request)
    {
        if (!empty($request->course_type) && 'all' == $request->course_type) {
            session()->flash('error', 'Please enter course type first.');
            return redirect()->back();
        } elseif (!empty($request->course_type) && !empty($request->course) && !empty($request->batch)) {
            return redirect()->route('indivisual_report.report.batch', $request->batch);
        } elseif (!empty($request->course_type) && !empty($request->course)) {
            return redirect()->route('indivisual_report.report.course', $request->course);
        } elseif (!empty($request->course_type)) {
            return redirect()->route('indivisual_report.report.course_type', $request->course_type);
        }
        return redirect()->back();


    }

        public function reportsByBatch($bid)
    {
        $batch = Batch::find($bid);
        $course = $batch->course;
        $students = $batch->students;
        $batch_name = batch_name($course->title_short_form, $batch->year, $batch->month, $batch->batch_number);

        $batches = Batch::with('students')->with('user')->with('course')->with('course_type')->get();
        $all_batches = [];
        foreach ($batches as $key => $batch)
        {
            if ($batch->id == $bid)
            {
                $all_batches[$batch->course->title][] = $batch;
            }

        }

        return view('indivisual_report.indivisual_report_by_batch',compact('all_batches','batch_name', 'course'));
    }

    public function reportsByCourse($cid)
    {
        $course = Course::find($cid);
        $batches = $course->batches;
        $course_name = $course->title;

        $batches = Batch::with('students')->with('user')->with('course')->with('course_type')->get();
        $all_batches = [];

        foreach ($batches as $key => $batch)
        {
            if ($batch->course->id == $cid)
            {
                $all_batches[$batch->course->title][] = $batch;
            }

        }

        return view('indivisual_report.indivisual_report_by_course',compact('all_batches','cid','course_name'));
    }

    public function reportsByCourseType($ct)
    {
        $batches = Batch::with('students')->with('user')->with('course')->with('course_type')->get();
        $all_batches = [];
        foreach ($batches as $key => $batch)
        {
            if ($batch->course->type == $ct)
            {
                $all_batches[$batch->course->title][] = $batch;
                $col_1 = 0;

            }
        }

        return view('indivisual_report.indivisual_report_by_course_type', compact('ct','all_batches','col_1','batches'));
    }


}
