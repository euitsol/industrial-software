<?php

namespace App\Http\Controllers;

use App\Models\Institute;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InstituteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $institutes = Institute::latest()->get();
        return view('institute.index', compact('institutes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('institute.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:170',
            'district' => 'required|max:170',
            'division' => 'required|max:170',
            'website' => 'max:170',
            'address' => 'max:170'
        ]);

        $i = new Institute;
        $i->name = $request->name;
        $i->website = $request->website;
        $i->district = $request->district;
        $i->division = $request->division;
        $i->address = $request->address;
        $i->user_id = Auth::id();
        $i->save();

        $this->message('success', 'Institute info added successfully');
        return redirect()->route('institutes');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Institute  $institute
     * @return \Illuminate\Http\Response
     */
    public function show($iid)
    {
        $institute = Institute::find($iid);
        return view('institute.show', compact('institute'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Institute  $institute
     * @return \Illuminate\Http\Response
     */
    public function edit($iid)
    {
        $institute = Institute::findOrFail($iid);
        return view('institute.edit', compact('institute'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Institute  $institute
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|max:170',
            'district' => 'required|max:170',
            'division' => 'required|max:170',
            'website' => 'max:170',
            'address' => 'max:170'
        ]);

        $i = Institute::findOrFail($request->id);
        $i->name = $request->name;
        $i->website = $request->website;
        $i->district = $request->district;
        $i->division = $request->division;
        $i->address = $request->address;
        $i->update();

        $this->message('success', 'Institute info update successfully');
        return redirect()->route('institutes');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Institute  $institute
     * @return \Illuminate\Http\Response
     */
    public function destroy($iid)
    {
        $institute = Institute::findOrFail($iid);
        if ($institute->teachers->count() > 0) {
            $this->message('error', 'Institute can not deleted');
            return redirect()->back();
        } elseif ($institute->students->count() > 0) {
            $this->message('error', 'Institute can not deleted');
            return redirect()->back();
        } else {
            $institute->delete();
            $this->message('success', 'Institute info delete successfully');
            return redirect()->back();
        }
    }
}
