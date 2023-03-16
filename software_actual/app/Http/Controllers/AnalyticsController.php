<?php



namespace App\Http\Controllers;



use App\Models\Source;

use App\Models\Student;
use App\Models\Session as Sessions;

use App\Models\Referral;

use App\Models\InstallmentDate;



use Illuminate\Http\Request;

use Illuminate\Support\Facades\Session;

use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\DB;

use Carbon\Carbon;



class AnalyticsController extends Controller

{

    public function index($session_id = false){
        $check = false;
        $sources = Source::with(['created_user','students'])->latest()->get();
        $referrals = Referral::with(['created_user','students'])->latest()->get();
        $sessions = Sessions::all();
        if($session_id){
            $check = $session_id;
            $topSources = Student::with(['source'])->select('source_id', DB::raw('count(*) as count'))
            ->where('session_id', $session_id)
                                ->groupBy('source_id')
                                ->orderByDesc('count')
                                ->take(5)
                                ->get();
            $topReferrals = Student::with(['referral'])->select('referral_id', DB::raw('count(*) as count'))
            ->where('session_id', $session_id)

                                ->groupBy('referral_id')

                                ->orderByDesc('count')

                                ->take(5)

                                ->get();

            $students = DB::table('students')->where('year', '2023')
            ->where('session_id', $session_id)
            ->select(DB::raw('MONTH(created_at) as month'), DB::raw('COUNT(*) as total'))
            ->groupBy(DB::raw('MONTH(created_at)'))
            ->get();
        }else{
            $topSources = Student::with(['source'])->select('source_id', DB::raw('count(*) as count'))
                                    ->groupBy('source_id')
                                    ->orderByDesc('count')
                                    ->take(5)
                                    ->get();
            $topReferrals = Student::with(['referral'])->select('referral_id', DB::raw('count(*) as count'))
    
                                    ->groupBy('referral_id')
    
                                    ->orderByDesc('count')
    
                                    ->take(5)
    
                                    ->get();
    
    
            $students = DB::table('students')->where('year', '2023')
    
                        ->select(DB::raw('MONTH(created_at) as month'), DB::raw('COUNT(*) as total'))
    
                        ->groupBy(DB::raw('MONTH(created_at)'))
    
                        ->get();

        }


                            //    dd($students); 

        return view('analytics.index', compact('sources', 'referrals', 'topSources', 'topReferrals', 'students','sessions','check'));

    }



    public function addSource(){



        return view('analytics.add-source');

    }



    public function addSourceStore(Request $request){

        $request->validate([

            'name' => 'required|string|max:255'

        ]);



        $save = new Source();

        $save->name = $request->name;

        $save->created_at = Carbon::now();

        $save->created_by = Auth::User()->id;

        $save->save();



        $this->message('success', 'Source Added Successfully');

        return redirect()->route('analytics');

    }

    public function editSource($id){
        $source = Source::findOrFail($id);
        return view('analytics.edit-source', compact('source'));
    }

    public function updateSource(Request $request){
        $request->validate([
            'name' => 'required|max:255|string|unique:sources,name,'.$request->id,
        ]);

        $source = Source::findOrFail($request->id);
        $source->name = $request->name;
        $source->update();
        $this->message('success', 'Source Update Successfully');
        return redirect()->route('analytics');
    }
    
    public function deleteSource($id){
        $source = Source::findOrFail($id);
        $count = $this->source_delete($id);
        if($count>0){
            $this->message('error', "Can't delete this source because it has (" .$count. ") students");
        }
        else{
            $source->delete();
            $this->message('success', 'Source Delete Successfully');
        }
        return redirect()->back();

    }

    public function sourceStatus($id){
        $source = Source::findOrFail($id);
        // dd($session->status);+
        if($source->status == 1){
            $source->status = -1;
            $source->save();
            $this->message('success', 'Source closed successfully');
        }
        else{
            $source->status = 1;
            $source->save();
            $this->message('success', 'Source running successfully');
        }
        return redirect()->back();
    }


    public function addReferral(){
        return view('analytics.add-referral');
    }

    public function addReferralStore(Request $request){
        $request->validate([
            'name' => 'required|string|max:255'
        ]);

        $save = new Referral();
        $save->name = $request->name;
        $save->created_at = Carbon::now();
        $save->created_by = Auth::User()->id;
        $save->save();
        $this->message('success', 'Referral Added Successfully');
        return redirect()->route('analytics');

    }

    public function editReferral($id){
        $referral = Referral::findOrFail($id);
        return view('analytics.edit-referral', compact('referral'));
    }

    public function updateReferral(Request $request){
        $request->validate([
            'name' => 'required|max:255|string|unique:referrals,name,'.$request->id,
        ]);

        $referral = Referral::findOrFail($request->id);
        $referral->name = $request->name;
        $referral->update();
        $this->message('success', 'Referral Update Successfully');
        return redirect()->route('analytics');
    }

    public function deleteReferral($id){
        $referral = Referral::findOrFail($id);
        $count = $this->referral_delete($id);
        if($count>0){
            $this->message('error', "Can't delete this referral because it has (" .$count. ") students");
        }
        else{
            $referral->delete();
            $this->message('success', 'Referral Delete Successfully');
        }
        return redirect()->back();

    }
    public function referralStatus($id){
        $referral = Referral::findOrFail($id);
        // dd($session->status);+
        if($referral->status == 1){
            $referral->status = -1;
            $referral->save();
            $this->message('success', 'Referral closed successfully');
        }
        else{
            $referral->status = 1;
            $referral->save();
            $this->message('success', 'Referral running successfully');
        }
        return redirect()->back();
    }
    



    protected function source_delete($id){
        $student = Student::where('source_id', $id)->get()->count();
        return $student;
    }
    protected function referral_delete($id){
        $student = Student::where('referral_id', $id)->get()->count();
        return $student;
    }

}