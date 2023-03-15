<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Marketing;
use App\Models\Marketingcomment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class MarketingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index()
    {
        $datalist['converse_with'] = DB::select(DB::raw('SELECT converse_with FROM marketingcomments GROUP BY converse_with'));
        $marketings = Marketing::where('status', null)->orderBy('created_at', 'desc')->get();
        foreach ($marketings as $m) {
            $m['course'] = Course::find($m->course_id)->title;
            $m['comments'] = Marketingcomment::where('marketing_id', $m->id)->get();
        }
        $courses = Course::where('type', 'Professional')->get();
        return view('marketing.list', compact('marketings', 'datalist', 'courses'));
    }


    public function admittedList()
    {
        $marketings = Marketing::where('status', 'admitted')->orderBy('created_at', 'desc')->get();
        foreach ($marketings as $m) {
            $m['course'] = Course::find($m->course_id)->title;
            $m['comments'] = Marketingcomment::where('marketing_id', $m->id)->get();
        }
        $courses = Course::where('type', 'Professional')->get();
        return view('marketing.admittedList', compact('marketings', 'courses'));
    }


    public function notInterestedList()
    {
        $marketings = Marketing::where('status', 'not-interested')->orderBy('created_at', 'desc')->get();
        foreach ($marketings as $m) {
            $m['course'] = Course::find($m->course_id)->title;
            $m['comments'] = Marketingcomment::where('marketing_id', $m->id)->get();
        }
        $courses = Course::where('type', 'Professional')->get();
        return view('marketing.notInterestedList', compact('marketings', 'courses'));
    }


    public function create()
    {
        $courses = Course::where('type', 'Professional')->get();
        $datalist['converse_with'] = DB::select(DB::raw('SELECT converse_with FROM marketingcomments GROUP BY converse_with'));
        return view('marketing.add', compact('courses', 'datalist'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'course' => 'required',
            'mobile' => 'required',
            'address' => 'required',
            'date' => 'required|date',
            'nextDate' => 'required|date',
            'converseWith' => 'required',
            'comment' => 'required',
        ]);
        DB::beginTransaction();
        try {
            $m = new Marketing;
            $m->name = $request->name;
            $m->course_id = $request->course;
            $m->mobile = $request->mobile;
            if (isset($request->email))
            {
                $m->email = $request->email;
            }
            
            $m->address = $request->address;
            $m->next_date = $request->nextDate;
            $m->save();
            $mc = new Marketingcomment;
            $mc->marketing_id = $m->id;
            $mc->date = $request->date;
            $mc->converse_with = $request->converseWith;
            $mc->comment = $request->comment;
            $mc->save();
            DB::commit();
            $success = true;
        } catch (\Exception $e) {
            $success = false;
            DB::rollback();
        }
        if ($success) {
            Session::flash('success', "The marketing info has been added successfully.");
            return redirect()->route('marketing.list');
        } else {
            Session::flash('error', "Something went wrong :(");
            return redirect()->back();
        }
    }


    public function storeComment(Request $request, $mid)
    {
        $request->validate([
            'date' => 'required|date',
            'converseWith' => 'required',
            'nextDate' => 'required|date',
            'comment' => 'required',
        ]);
        DB::beginTransaction();
        try {
            $m = Marketing::find($mid);
            $m->next_date = $request->nextDate;
            $m->update();
            $mc = new Marketingcomment;
            $mc->marketing_id = $mid;
            $mc->date = $request->date;
            $mc->converse_with = $request->converseWith;
            $mc->comment = $request->comment;
            $mc->save();
            DB::commit();
            $success = true;
        } catch (\Exception $e) {
            $success = false;
            DB::rollback();
        }
        if ($success) {
            Session::flash('success', "The marketing comment has been added successfully.");
            // return redirect()->route('marketing.list');
            return redirect()->back();
        } else {
            Session::flash('error', "Something went wrong :(");
            return redirect()->back();
        }
    }


    public function destroy($mid)
    {
        DB::beginTransaction();
        try {
            Marketing::find($mid)->delete();
            Marketingcomment::where('marketing_id', $mid)->delete();
            DB::commit();
            $success = true;
        } catch (\Exception $e) {
            $success = false;
            DB::rollback();
        }
        if ($success) {
            Session::flash('success', "The marketing info has been deleted successfully.");
            return redirect()->route('marketing.list');
        } else {
            Session::flash('error', "Something went wrong :(");
            return redirect()->back();
        }
    }


    public function admitted($mid)
    {
        $m = Marketing::find($mid);
        $m->status = 'admitted';
        $m->update();
        Session::flash('success', "The marketing info has been moved to admitted list successfully.");
        return redirect()->back();
    }


    public function notInterested($mid)
    {
        $m = Marketing::find($mid);
        $m->status = 'not-interested';
        $m->update();
        Session::flash('success', "The marketing info has been moved to not-interested list successfully.");
        return redirect()->back();
    }


    public function interested($mid)
    {
        $m = Marketing::find($mid);
        $m->status = null;
        $m->update();
        Session::flash('success', "The marketing info has been moved to default list successfully.");
        return redirect()->back();
    }


    public function defaultSearch(Request $request)
    {
        $request->validate([
            'fromDate' => 'required|date',
            'toDate' => 'required|date|after_or_equal:fromDate',
            'course' => 'required',
        ]);
        $mcs = Marketingcomment::whereBetween('date', [$request->fromDate, $request->toDate])->groupBy('marketing_id')->get();
        $marketings = [];
        if ($request->course == 'all') {
            foreach ($mcs as $mc) {
                $a = Marketing::where('id', $mc->marketing_id)->where('status', null)->first();
                if ($a != null) {
                    $marketings[] = $a;
                }
            }
        } else {
            foreach ($mcs as $mc) {
                $a = Marketing::where('id', $mc->marketing_id)->where('course_id', $request->course)->where('status', null)->first();
                if ($a != null){
                    $marketings[] = $a;
                }
            }
        }
        if (!empty($marketings)) {
            foreach ($marketings as $m) {
                $m['course'] = Course::find($m->course_id)->title;
            }
        }
        return view('marketing.listSearch', compact('marketings'));
    }


    public function notInterestedSearch(Request $request)
    {
        $request->validate([
            'fromDate' => 'required|date',
            'toDate' => 'required|date|after_or_equal:fromDate',
            'course' => 'required',
        ]);
        $mcs = Marketingcomment::whereBetween('date', [$request->fromDate, $request->toDate])->groupBy('marketing_id')->get();
        $marketings = [];
        if ($request->course == 'all') {
            foreach ($mcs as $mc) {
                $a = Marketing::where('id', $mc->marketing_id)->where('status', 'not-interested')->first();
                if ($a != null) {
                    $marketings[] = $a;
                }
            }
        } else {
            foreach ($mcs as $mc) {
                $a = Marketing::where('id', $mc->marketing_id)->where('course_id', $request->course)->where('status', 'not-interested')->first();
                if ($a != null) {
                    $marketings[] = $a;
                }
            }
        }
        if (!empty($marketings)) {
            foreach ($marketings as $m) {
                $m['course'] = Course::find($m->course_id)->title;
            }
        }
        return view('marketing.notInterestedListSearch', compact('marketings'));
    }


    public function admittedSearch(Request $request)
    {
        $request->validate([
            'fromDate' => 'required|date',
            'toDate' => 'required|date|after_or_equal:fromDate',
            'course' => 'required',
        ]);
        $mcs = Marketingcomment::whereBetween('date', [$request->fromDate, $request->toDate])->groupBy('marketing_id')->get();
        $marketings = [];
        if ($request->course == 'all') {
            foreach ($mcs as $mc) {
                $a = Marketing::where('id', $mc->marketing_id)->where('status', 'admitted')->first();
                if ($a != null) {
                    $marketings[] = $a;
                }
            }
        } else {
            foreach ($mcs as $mc) {
                $a = Marketing::where('id', $mc->marketing_id)->where('course_id', $request->course)->where('status', 'admitted')->first();
                if ($a != null) {
                    $marketings[] = $a;
                }
            }
        }
        if (!empty($marketings)) {
            foreach ($marketings as $m) {
                $m['course'] = Course::find($m->course_id)->title;
            }
        }
        return view('marketing.admittedListSearch', compact('marketings'));
    }

 public function today()
    {
        $datalist['converse_with'] = DB::select(DB::raw('SELECT converse_with FROM marketingcomments GROUP BY converse_with'));
        $marketings = Marketing::whereRaw('DAYOFYEAR(curdate()) =  dayofyear(next_date)')->get();
        if (count($marketings) > 0){
            foreach ($marketings as $m) {
                $m['course'] = Course::find($m->course_id)->title;
                $m['comments'] = Marketingcomment::where('marketing_id', $m->id)->get();
            }
        }
        return view('marketing.today', compact('marketings', 'datalist'));
    }


}
