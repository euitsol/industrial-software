<?php

namespace App\Http\Controllers;
use App\Models\Nav;
use App\Models\Main_nav;
use App\Models\Nav_assign_bkdn;
use App\Models\Nav_assign;
use App\Models\Sub_nav;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class Dynamic_sidebar_controller extends Controller
{
    
    public function sideber()
    {
        $output_1 = '';
        $output_2 ='<div id="" class="collapse">
                                <ul class="sidebar-menu list-unstyled border-left border-primary border-thick">';
        $output_3 = '';
        $output = '';

        $output_1 .= '<ul class="sidebar-menu list-unstyled">';
        $nav_assign = Nav_assign::select('nA_id')->where('user_id',Auth::id())->get();
        foreach($nav_assign as $na)
        {
            $na_id = $na->nA_id;
            $nav_assign_bkdn = Nav_assign_bkdn::select('mN_id')->groupBy('mN_id')->where('nA_id',$na_id)->get();
            
            foreach($nav_assign_bkdn as $nb)
            {   
                $mn_id = $nb->mN_id;
                
                $main_nav = Main_nav::where('mN_id',$mn_id)->get();
                foreach($main_nav as $mn)
                {
                    $output_1 .='<li class="sidebar-list-item">
                                        <a href="'.$mn->mN_route.'" class="sidebar-link text-muted">
                                            <i class="'.$mn->mN_icon.'"></i><span>'.$mn->mN_name.'</span>
                                        </a>
                                    ';                                                        
                
                $nav_assign_bkdn_2 = Nav_assign_bkdn::select('sN_id')->groupBy('sN_id')->where('mN_id',$nb->mN_id )->get();
                foreach($nav_assign_bkdn_2 as $nb_2)
                {
                    $sn_id = $nb_2->sN_id;
                    $sub_nav = Sub_nav::where('sN_id',$sn_id)->get();
                    foreach($sub_nav as $sn)
                    {                    
                        $output_1 .='<li class="sidebar-list-item">
                                        <a href="'.$sn->sN_route.'" class="sidebar-link text-muted">
                                            <i class="'.$sn->sN_icon.'"></i><span>'.$sn->sN_name.'</span>
                                        </a>
                                    </li>';
                        
                    }
                }                             
             
            }
            
                  }
    } 

            

            $output .= "".$output_1."</ul></div></li></ul>";
            

            return view('partial.dynamic_sidebar',compact('output'));
    }
}
