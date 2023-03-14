<?php

namespace App\Http\Controllers;


use App\Models\Nav_assign_bkdn;
use App\Models\Nav_assign;
use App\Models\Sub_nav;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;


use Illuminate\Http\Request;

class SideberController extends Controller
{
    
    public function index()
    {
        $first = Nav_assign::with('user')->with('na_bkdn')->get();
        $second = Nav_assign_bkdn::with('sub_menu')->with('main_menu')->get();
        
        
        return view('layouts.master', compact('first','second'));
    }

    public function view()
    {
        $first = Nav_assign::with('user')->with('na_bkdn')->get();
        $second = Nav_assign_bkdn::with('sub_menu')->with('main_menu')->get();
        
        
        return $first;
    }
    public function view2()
    {
        $first = Nav_assign::with('user')->with('na_bkdn')->get();
        $second1 = Sub_nav::get();
        $second = Nav_assign_bkdn::with('sub_menu')->with('main_menu')->get();
        // $a=0;
        // $b= 0;
        // $c=0;
        // $d = 0;

        // for ($i=0; $i<=10; $i++)
        // {
        //     if( $a == 0 && $b!=1 )
        //     {
        //         $b = 1;
        //         $d++;
        //     }
        // }

        
        
        return $second;
    }
}
