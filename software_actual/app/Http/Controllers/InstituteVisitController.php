<?php

namespace App\Http\Controllers;

use App\Models\InstituteVisit;
use App\Models\VisitContact;


use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class InstituteVisitController extends Controller
{
    //
    public function index(){
        $institute_visits = InstituteVisit::latest()->get();
        return view('inst_visit.index', compact('institute_visits'));
    }
    
    public function add(){
        return view('inst_visit.add');
    }
    
    public function store(Request $request){
        $request->validate([
            'name' => 'required|max:170',
            'type' => 'required',
            'division' => 'required|max:170',
            'district' => 'required|max:170',
            'address' => 'nullable|max:500',
            'website' => 'nullable|max:200',
            'facebook' => 'nullable|max:170',
            
            'contact.*.name' => 'string|max:255|required',
            'contact.*.designation' => 'string|max:255|required',
            'contact.*.phone' => 'nullable|numeric',
            'contact.*.email' => 'nullable|email',
            'contact.*.comment' => 'nullable|string|max:250'
        ]);
        
        $data = new InstituteVisit;
        $data->name = $request->name;
        $data->type = $request->type;
        $data->division = $request->division;
        $data->district = $request->district;
        $data->address = $request->address;
        $data->website = $request->website;
        $data->facebook = $request->facebook;
        $data->created_by = Auth::id();
        $data->updated_by = Auth::id();
        $data->year = $date = Carbon::now()->format('Y');
        $data->save();
        
        foreach($request->contact as $ct){
            $new_data = new VisitContact;
            $new_data->inst_visit_id = $data->id;
            $new_data->name = $ct['name'];
            $new_data->designation = $ct['designation'];
            $new_data->phone = $ct['phone'];
            $new_data->email = $ct['email'];
            $new_data->comment = $ct['comment'];
            $new_data->created_by = Auth::id();
            $new_data->save();
        }
        
        Session::flash('success', "New institute $request->name added successfully");
        return redirect()->route('iv');
    }
    
    public function show($id){
        
        $institute_visit = InstituteVisit::findOrFail($id);
        $contacts = VisitContact::where('inst_visit_id', $institute_visit->id)->latest()->get();
        
        return view('inst_visit.show', compact('institute_visit','contacts')); 
    }
   

    
}
