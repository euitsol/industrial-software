<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LinkageIndustryInfo;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class LinkageIndustryInfosController extends Controller
{
    public function index()
    {
        $linkage_industry_infos = LinkageIndustryInfo::with(['created_user'])->latest()->get();
        return view('linkage_industry_info.index', compact('linkage_industry_infos'));

    }
    public function create()
    {
        return view('linkage_industry_info.create');
    }
    public function show($id)
    {
        $data = LinkageIndustryInfo::with(['created_user','updated_user'])->latest()->findOrFail($id);
        return view('linkage_industry_info.show', compact('data'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'company_name' => 'required|max:255',
            'company_logo' => 'image|mimes:jpg,jpeg,png,JPG,JPEG,PNG|max:5120',
            'company_website' => 'required|max:255',
            'company_address' => 'required|max:255',
            'contact_person_name' => 'required|max:255',
            'contact_number' => 'required|max:11|min:11',
            'contact_email' => 'required',
            'description' => 'required|max:10000',
        ]);

        $data = new LinkageIndustryInfo;
        $data->company_name = $request->company_name;

        if ($request->hasFile('company_logo')) {
            $logo = $request->company_logo;
            $img_name = time() . '_' . $logo->getClientOriginalName();
            $logo->move('uploads/images/', $img_name);
            $data->company_logo = 'uploads/images/' . $img_name;
            
        }

        $data->company_website = $request->company_website;
        $data->company_address = $request->company_address;
        $data->contact_person_name = $request->contact_person_name;
        $data->contact_number = $request->contact_number;
        $data->contact_email = $request->contact_email;
        $data->description = $request->description;
        $data->created_by = auth()->user()->id;
        $data->created_at = Carbon::now();
        $data->save();

        $this->message('success', 'Linkage with industry info added successfully');
        return redirect()->route('linkage_industry.info');
    }
    public function edit($id)
    {
        $data = LinkageIndustryInfo::findOrFail($id);
        return view('linkage_industry_info.edit', compact('data'));
    }
    public function update(Request $request)
    {
        $request->validate([
            'company_name' => 'required|max:255',
            'company_logo' => 'image|mimes:jpg,jpeg,png,JPG,JPEG,PNG|max:5120',
            'company_website' => 'required|max:255',
            'company_address' => 'required|max:255',
            'contact_person_name' => 'required|max:255',
            'contact_number' => 'required|max:11|min:11',
            'contact_email' => 'required',
            'description' => 'required|max:10000',
        ]);

        $data = LinkageIndustryInfo::findOrFail($request->id);
        $data->company_name = $request->company_name;

        if ($request->hasFile('company_logo')) {
            if (!empty($data->company_logo) && file_exists($data->company_logo)) {
                unlink($data->company_logo);
            }
            $logo = $request->company_logo;
            $img_name = time() . '_' . $logo->getClientOriginalName();
            $logo->move('uploads/images/', $img_name);
            $data->company_logo = 'uploads/images/' . $img_name;
        }

        $data->company_website = $request->company_website;
        $data->company_address = $request->company_address;
        $data->contact_person_name = $request->contact_person_name;
        $data->contact_number = $request->contact_number;
        $data->contact_email = $request->contact_email;
        $data->description = $request->description;
        $data->updated_by = auth()->user()->id;
        $data->updated_at = Carbon::now();
        $data->update();

        $this->message('success', 'Linkage with industry info update successfully');
        return redirect()->route('linkage_industry.info');
    }
    public function destroy($id)
    {
        $data = LinkageIndustryInfo::findOrFail($id);
        $data->delete();
        $this->message('success', 'Linkage with industry info delete successfully');
        return redirect()->route('linkage_industry.info');

    }
}
