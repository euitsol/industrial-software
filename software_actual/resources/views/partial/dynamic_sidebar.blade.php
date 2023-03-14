@extends('layouts.master')


<div class="d-flex align-items-stretch main-sidebar">
    <div id="sidebar" class="sidebar py-3">


            <div class="text-gray-400 text-uppercase px-3 px-lg-4 py-2 font-weight-bold small headings-font-family">
                SETUP
            </div>



@php 

$microtime1 = microtime(true);
$a=0;
$b=0;
$output_1 = '';
        $output_2 ='';
        $output_3 = '';
        $output = '';

        $output_1 .= '<ul class="sidebar-menu list-unstyled">';
        $nav_assign = App\Models\Nav_assign::select('nA_id')->where('user_id',Auth::id())->get();
        foreach($nav_assign as $na)
        {
            $na_id = $na->nA_id;
            $nav_assign_bkdn = App\Models\Nav_assign_bkdn::select('mN_id','sN_id')->groupBy('mN_id')->where('nA_id',$na_id)->distinct()->get();
            
            foreach($nav_assign_bkdn as $nb)
            {
                if(isset($nb->sN_id))
                {
                    $mn_id = $nb->mN_id;
                    $main_nav_2 = App\Models\Main_nav::where('mN_id',$mn_id)->get();
                    foreach($main_nav_2 as $mn_2)
                    {
                        $output_1 .= '<li class="sidebar-list-item">
                                        <a href="javascript:void(0)" data-toggle="collapse"data-target="#'.$mn_2->mN_name.'"aria-expanded="false"aria-controls="'.$mn_2->mN_name.'"class="sidebar-link text-muted">
                                        <i class="fa fa-user-plus text-gray"></i>
                                        <span>'.$mn_2->mN_name.'</span>
                                        </a>
                                        <div id="'.$mn_2->mN_name.'" class="collapse">
                                            <ul class="sidebar-menu list-unstyled border-left border-primary border-thick">';

                        $nav_assign_bkdn_2 = App\Models\Nav_assign_bkdn::select('sN_id')
                                                                            ->where('nA_id',$na_id)
                                                                            ->where('mN_id',$mn_2->mN_id)
                                                                            ->distinct()
                                                                            ->get();
                        foreach($nav_assign_bkdn_2 as $nb_2)
                        {
                            
                            $sn_id = $nb_2->sN_id;
                            $sub_nav = App\Models\Sub_nav::where('sN_id',$sn_id)->get();
                            foreach($sub_nav as $sn)
                            { 
                            
                                $output_1 .='<li class="sidebar-list-item">
                                            <a href="'.$sn->sN_route.'" class="sidebar-link text-muted">
                                                <i class="'.$sn->sN_icon.'"></i><span>'.$sn->sN_name.'</span>
                                            </a>
                                        </li>'; 
                                               
                                                      
                            }

                        }

                        $output_1 .= '</ul></div></li>';
                        
                    }
                }
                else
                {
                    $mn_id = $nb->mN_id;
                    $main_nav = App\Models\Main_nav::where('mN_id',$mn_id)->get();
                    foreach($main_nav as $mn)
                    {
                        $output_1 .='<li class="sidebar-list-item">
                                        <a href="'.$mn->mN_route.'" class="sidebar-link text-muted">
                                            <i class="'.$mn->mN_icon.'"></i><span>'.$mn->mN_name.'</span>
                                        </a>
                                    </li>';     
                    }    
                }
                  
                
                
                                                                   
                
                                                             
                            
            }
        }

$output .= "".$output_1."</ul>";

echo $output;

$microtime2 = microtime(true);

echo $microtime2 - $microtime1 ;
@endphp 







</div>









    <div class="page-holder w-100 d-flex flex-wrap">
        <div class="container-fluid px-xl-5">
            <section class="py-5">

                @yield('content')

            </section>
        </div>
        <footer class="footer bg-white shadow align-self-end py-3 px-xl-5 w-100">
            <div class="container-fluid">
                <div class="text-center text-primary">
                    <p class="mb-2 mb-md-0 text-center">
                        <a href="https://euitsols.com" target="_blank">
                            Copyright &copy; European IT Solutions |
                            2009-{{ date('Y') }}
                        </a>
                    </p>
                </div>
            </div>
        </footer>
    </div>
</div>




























