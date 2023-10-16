<?php

namespace App\Http\Controllers;

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
}
