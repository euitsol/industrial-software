<?php

namespace App\Http\Controllers;

use App\Models\CourseType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CourseTypeController extends Controller
{
    public function index()
    {
        $course_types = CourseType::with('user')->latest()->get();
        return view('course_type.index', compact('course_types'));
    }

    public function create()
    {
        return view('course_type.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'type_name' => 'required|max:170|unique:course_types'
        ]);

        $ct = new CourseType;
        $ct->type_name = $request->type_name;
        $ct->user_id = Auth::id();
        $ct->save();

        $this->message('success', 'Course sector info added successfully');
        return redirect()->route('course_types');
    }

    public function edit($ctid)
    {
        $ct = CourseType::findOrFail($ctid);
        return view('course_type.edit', compact('ct'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'type_name' => 'required|max:170'
        ]);

        $ct = CourseType::findOrFail($request->id);
        $ct->type_name = $request->type_name;
        $ct->update();

        $this->message('success', 'Course sector info update successfully');
        return redirect()->route('course_types');
    }

    public function destroy($ctid)
    {
        $course_sector = CourseType::findOrFail($ctid);

        if ($course_sector->courses->count() > 0) {
            $this->message('error', 'Course sector can not deleted');
            return redirect()->route('course_types');
        } else {
            $course_sector->delete();
            $this->message('success', 'Course sector info delete successfully');
            return redirect()->route('course_types');
        }
    }
}
