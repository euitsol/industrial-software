<?php

namespace App\Http\Controllers;
use App\Models\Nav;
use App\Models\Main_nav;
use App\Models\Nav_assign_bkdn;
use App\Models\Nav_assign;
use App\Models\Sub_nav;
use App\Models\User;
use Carbon\Carbon;
use function GuzzleHttp\Psr7\str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class NavController extends Controller
{
    public function index(){
        $users = Nav::distinct()->get();

        return view('navigation.index', compact('users'));
    }
    public function index2(){
        $users = Nav::distinct()->get();
        return view('navigation.view', compact('users'));
    }
    public function userByType($type)
    {
        if (request()->ajax() && !empty($type)) {
            $output = '';
            $user_type = Nav::all();
            foreach ($user_type as $ut) {
                $users = $ut->where('role', $type)->distinct()->get();
                foreach ($users as $us) {
                    $output .= '<option value="' . $us->id . '">' . $us->name . '</option>';
                }
                return $output;
            }
        }
        else {
            abort(403, 'Unauthorized');
        }
        return false;
    }

    public function indivisual_menu(Request $request)
    {
        // return view('navigation.index', compact('request'));
        // return $request->all();
        return redirect()->route('nav_assign.menu', $request->user_name);
    }
    public function menus($user_name)
    {
        $output_2 = '<input type = "hidden" name = "user_id" value = "'.$user_name.'" >';
        $check = '';
        $check_2 = '';
        // $output_2 .= '<form><div class= "form-check form-control-lg" >';
        $main_nav = Main_nav::select('mN_name' ,'mN_id','mN_icon','user_id')->get();
        foreach($main_nav as $mn)
        {
            $check_2 = '';
            // $output_2 .= $mn->mN_name;
            $m_name = $mn->mN_name;
            $m_id = $mn->mN_id;
            $m_icon = $mn->mN_icon;
            $m_user_id = $mn->user_id;
            $added_by = User::findorFail($m_user_id)->name;
            
            $nav_assign = Nav_assign::select('nA_id')->where('user_id', $user_name)->get();
            foreach ($nav_assign as $na)
            {
                $na_id = $na->nA_id;
                $nav_assign_bkdn = Nav_assign_bkdn::select('mN_id')->where('nA_id', $na_id)->where('mN_id',$m_id)->get();
                foreach ($nav_assign_bkdn as $nb)
                {
                    if(count($nav_assign_bkdn) > 0)
                    {
                        $check = 'checked';
                    }
                    else
                    {
                        $check = '';
                    }
                }
            }
            $output_2 .= '<div class="alert alert-primary col-md-7 ">
                            <label class="form-check-label " for="'.$m_name.$m_id.'"> 
                            <i class= "'.$m_icon.'  mr-4"></i><input type="checkbox" name = "check_menu[]" 
                            class="form-check-input" id= "'.$m_name.$m_id.'" value = "'.$m_id.'"
                             '.$check.' >';
            $check = '';
            $output_2 .= ''.$m_name.'</label><label class="form-check-label float-right "><small>Added by - '.$added_by.'</small> </label></div>';
            $sub_nav = Sub_nav::select('sN_name','sN_id','sN_icon','user_id')->where('mN_id', $m_id)->get();
            foreach($sub_nav as $sn)
            {
                $s_name =$sn->sN_name;
                $s_id = $sn->sN_id;
                $s_icon = $sn->sN_icon;
                $s_user_id = $sn->user_id;
                $added_by_2 = User::findorFail($s_user_id)->name;
                $nav_assign_2 = Nav_assign::select('nA_id')->where('user_id', $user_name)->get();
                foreach ($nav_assign_2 as $na_2)
                {
                    $na_id_2 = $na_2->nA_id;
                    $nav_assign_bkdn_2 = Nav_assign_bkdn::select('sN_id')->where('nA_id', $na_id_2)->where('mN_id',$m_id)->get();
                    foreach($nav_assign_bkdn_2 as $nb_2 )
                    {

                        if ($nb_2->sN_id == $s_id)
                        {
                            $check_2 = "checked";
                        }

                    }
                }
                $output_2 .= '<div class="alert alert-info col-md-5  submenu" id = "submenu" >
                                <label class="form-check-label " for="'.$s_name.$s_id.'">
                                <i class= "'.$s_icon.' mr-4"></i><input type="checkbox" name = "check_sub_menu[] " class="form-check-input" id= "'.$s_name.$s_id.'" value = "'.$s_id.'"  '.$check_2.'>';
                $check_2 = '';
                $output_2 .= ''.$s_name.'</label><label class="form-check-label float-right "><small>Added by - '.$added_by_2.'</small> </label>
                            </div>';
            }
        }

        return view ('navigation.view',compact('output_2'));
        // return $user_name;
    }
    public function save(Request $request)
    {

        $query_status = "";
        $user = User::find($request->user_id);
        $nav_assign = Nav_assign::select('nA_id')->where('user_id', $user->id)->get();
        if (count($nav_assign) > 0)
            {
                foreach ($nav_assign as $na )
                    {
                        $query_1 = Nav_assign::where('nA_id', $na->nA_id)->delete();
                        if ($query_1 > 0)
                        {
                            $nav_assign = new Nav_assign;
                            $nav_assign->user_id = $request->user_id;
                            $nav_assign->save();
                        }
                    }
                }
            else
            {
                $nav_assign = new Nav_assign;
                $nav_assign->user_id = $request->user_id;
                $nav_assign->save();
            }
           $nav_assign_2 = Nav_assign::select('nA_id')->where('user_id', $user->id)->get();
            foreach ($nav_assign_2 as $na_2)
            {
                $na_id =  $na_2->nA_id;
            }
            foreach ($request->check_menu as $selected_menu)
            {
                $sub_menu = Sub_nav::select('sN_id')->where('mN_id', $selected_menu)->get();
                if(count($sub_menu) > 0)
                {
                    foreach ($sub_menu as $sn_id)
                    {
                         foreach($request->check_sub_menu as $selected_sub_menu)
                        {
                             if($sn_id->sN_id == $selected_sub_menu)
                                {
                                    try{$nav_assign_bkdn = new Nav_assign_bkdn;
                                    $nav_assign_bkdn->nA_id = $na_id;
                                    $nav_assign_bkdn->mN_id = $selected_menu;
                                    $nav_assign_bkdn->sN_id = $selected_sub_menu;
                                    $nav_assign_bkdn->user_id = Auth::id();
                                    $nav_assign_bkdn->save();}
                                    catch(\Exception $e)
                                    {
                                        $query_status .= "there is a error in between line 218 to 224 in NavController";
                                    }
                                }
                        }
                    }
                }
                else
                {
                    try
                    {
                        $nav_assign_bkdn = new Nav_assign_bkdn;
                        $nav_assign_bkdn->nA_id = $na_id;
                        $nav_assign_bkdn->mN_id = $selected_menu;
                        $nav_assign_bkdn->user_id = Auth::id();
                        $nav_assign_bkdn->save();
                    }
                    catch(\Exception $e)
                    {
                        $query_status .= "there is a error saving main menu";
                    }
                }
            }

             return redirect()->route('nav_assign')->with('success', 'Menu assigned was successful');
    }
}

