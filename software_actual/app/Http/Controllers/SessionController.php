<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Session;
use App\Models\Student;
use Carbon\Carbon;

class SessionController extends Controller
{
    public function index()
    {
        $sessions = Session::with(['created_user'])->latest()->get();
        return view('session.index', compact('sessions'));

    }
    public function create()
    {
        return view('session.create');
    }

    public function store(Request $request)
    {
        $this->all_end();
        $request->validate([
            'name' => 'required|max:255|string|unique:sessions,name',
            'start_date' => 'required',
            'end_date' => 'required'
        ]);

        $session = new Session;
        $session->name = $request->name;
        $session->start_time = $request->start_date;
        $session->end_time = $request->end_date;
        $session->status = 1;
        $session->created_by = auth()->user()->id;
        $session->created_at = Carbon::now();
        $session->save();
        
        $this->message('success', 'Session added successfully');
        return redirect()->route('session');
    }
    public function show($id)
    {
        $session = Session::with(['created_user','updated_user'])->latest()->findOrFail($id);
        return view('session.show', compact('session'));
    }

    public function edit($id)
    {
        $session = Session::findOrFail($id);
        return view('session.edit', compact('session'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255|string|unique:sessions,name,'.$request->id,
            'start_date' => 'required',
            'end_date' => 'required'
        ]);

        $session = Session::findOrFail($request->id);
        $session->name = $request->name;
        $session->start_time = $request->start_date;
        $session->end_time = $request->end_date;
        $session->updated_by = auth()->user()->id;
        $session->updated_at = Carbon::now();
        $session->update();

        $this->message('success', 'Session update successfully');
        return redirect()->route('session');
    }
    public function destroy($id)
    {
        $session = Session::findOrFail($id);
        $count = $this->session_delete($id);
        if($count>0){
            $this->message('error', "Can't delete this session because it has (" .$count. ") students");
        }
        else{
            $session->delete();
            $this->message('success', 'Session Delete Successfully');
        }
        return redirect()->back();

    }
    public function statusChange($id){
        $session = Session::findOrFail($id);
        // dd($session->status);
        $this->all_end();
        $session->status = 1;
        $session->save();
        $this->message('success', 'Session running successfully');
        
        return redirect()->back();
    }

    protected function all_end(){
        $sessions = Session::all();
        foreach($sessions as $session){
            $session->status = -1;
            $session->save();
        }
        
    }

    protected function session_delete($id){
        $student = Student::where('session_id', $id)->get()->count();
        return $student;
    }
}
