<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lab;
use Carbon\Carbon;

class LabController extends Controller
{
    public function index()
    {
        $labs = Lab::with(['created_user'])->latest()->get();
        return view('lab_management.index', compact('labs'));

    }
    public function create()
    {
        return view('lab_management.create');
    }
    public function store(Request $request)
    {
        $request->validate([
            'lab_name' => 'required|max:255|string|unique:labs,lab_name',
            'capacity' => 'required|numeric',
            'note' => 'nullable|max:10000'
        ]);

        $lab = new Lab;
        $lab->lab_name = $request->lab_name;
        $lab->capacity = $request->capacity;
        $lab->note = $request->note;
        $lab->created_by = auth()->user()->id;
        $lab->created_at = Carbon::now();
        $lab->save();

        $this->message('success', 'Lab added successfully');
        return redirect()->route('lab-management');
    }
    public function show($labid)
    {
        $lab = Lab::with(['created_user'])->latest()->findOrFail($labid);
        return view('lab_management.show', compact('lab'));
    }
    public function edit($labid)
    {
        $lab = Lab::findOrFail($labid);
        return view('lab_management.edit', compact('lab'));
    }
    public function update(Request $request)
    {
        $request->validate([
            'lab_name' => 'required|max:255|string|unique:labs,lab_name,'.$request->id,
            'capacity' => 'required|numeric',
            'note' => 'nullable|max:10000'
        ]);

        $lab = Lab::findOrFail($request->id);
        $lab->lab_name = $request->lab_name;
        $lab->capacity = $request->capacity;
        $lab->note = $request->note;
        $lab->updated_by = auth()->user()->id;
        $lab->updated_at = Carbon::now();
        $lab->update();

        $this->message('success', 'Lab update successfully');
        return redirect()->route('lab-management');
    }
    public function destroy($labid)
    {
        $lab = Lab::findOrFail($labid);
        $lab->delete();
        $this->message('success', 'Lab info delete successfully');
        return redirect()->route('lab-management');

    }

    //Lab running close action logic
    public function lab_runnig($labid)
    {
        $lab = Lab::findOrFail($labid);
        $lab->status = 1;
        $lab->update();
        $this->message('success', 'Lab running successfully');
        return redirect()->back();

    }
    public function lab_closed($labid)
    {
        $lab = Lab::findOrFail($labid);
        $lab->status = -1;
        $lab->update();
        $this->message('success', 'Lab closed successfully');
        return redirect()->back();

    }
}
