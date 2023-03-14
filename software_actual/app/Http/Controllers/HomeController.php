<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\CourseType;
use App\Models\Mentor;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $sectors_count = CourseType::all()->count();
        $courses = Course::where('running', 1)->get();
        $mentors_count = Mentor::all()->count();

        $courses_title = '';
        $courses_student = '';
        $courses_student_count = [];

        foreach ($courses as $i => $course) {
            $courses_title .= '"' . $course->title . '",';
            $courses_student .= $course->students->count() . ',';
            $courses_student_count[] = $course->students->count();
        }

        if (is_array($courses_student_count) && count($courses_student_count) > 0) {
            $student_count_max = max($courses_student_count);
            $student_count_min = min($courses_student_count);
        } else {
            $student_count_max = 0;
            $student_count_min = 0;
        }

        return view('home', compact('courses', 'sectors_count', 'mentors_count', 'courses_title', 'courses_student', 'student_count_max', 'student_count_min'));
    }
}
