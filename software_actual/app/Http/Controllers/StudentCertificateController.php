<?php

namespace App\Http\Controllers;

use App\Models\BatchStudent;
use App\Models\Institute;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StudentCertificateController extends Controller
{
    public function index()
    {
        $data['institutes'] = Institute::all();
        $data['divisions'] = Institute::select('division')->groupBy('division')->get();

        $data['result'] = Student::select(DB::raw('YEAR(created_at) as year'))->distinct()->orderBy('created_at')->get();
        $data['years'] = $data['result']->pluck('year');

        return view('student_certificate.student_certificate_institute', $data);
    }
    public function studentCertificateFind(Request $request)
    {
        if (isset($request->institute)) {
            return redirect()->route('student_certificate.institute.certificates', [$request->institute, $request->year]);
        }
        return redirect()->back();
    }
    public function studentsCertificateInstitute($iid, $year)
    {
        $data['students'] = Student::where('institute_id', $iid)->where('year', '=', $year)->latest()->get();
        return view('student_certificate.student_certificates', $data);
    }
    public function batchWiseCertificate(){
        return view('student_certificate.student_certificate_batch');
    }
    public function batchWiseSearch(Request $request)
    {
        if (empty($request->course_type)) {
            session()->flash('error', 'Please select course type first.');
            return redirect()->back();
        }
        else{
            $course_type = $request->course_type;
            $course_id = $request->course;
            $batch_id = $request->batch;
            return redirect()->route('student_certificate.batch.view', compact('course_type','course_id','batch_id'));
        }
    }
    public function batchStudentCertificate($ctid, $cid, $bid){
        $s['students'] = BatchStudent::with('student')
                        ->where('batch_id', $bid)
                        ->get();
        return view('student_certificate.batch_student_certificates', $s);
    }
}
