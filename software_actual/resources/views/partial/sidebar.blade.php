<div class="d-flex align-items-stretch main-sidebar">
    <div id="sidebar" class="sidebar ">
        <div class=" text-uppercase   py-3 font-weight-bold small headings-font-family text-center align-middle bg-info text-white" > MENU </div>

@php 

$microtime1 = microtime(true);
$a=0;
$b=0;
$output_1 = '';
        $output_2 ='';
        $output_3 = '';
        $output = '';

        echo'<ul class="sidebar-menu list-unstyled">';
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
                        @endphp
                         <li class="sidebar-list-item">
                                        <a href="javascript:void(0)" data-toggle="collapse"data-target="#{{str_replace(' ', '_', $mn_2->mN_name)}}"
                                        aria-expanded="false"aria-controls="{{str_replace(' ', '_', $mn_2->mN_name)}}"class="sidebar-link text-muted">
                                        <i class="{{$mn_2->mN_icon}}"></i>
                                        <span>{{$mn_2->mN_name}}</span>
                                        </a>
                                        <div id="{{str_replace(' ', '_', $mn_2->mN_name)}}" class="collapse">
                                            <ul class="sidebar-menu list-unstyled border-left border-primary border-thick">
                        @php 

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
                            { @endphp 
                                 
                            
                                <li class="sidebar-list-item">
                                            <a href="{{ route ($sn->sN_route) }}" class="sidebar-link text-muted">
                                                <i class= "{{$sn->sN_icon}}"></i><span>{{$sn->sN_name}}</span>
                                            </a>
                                        </li>
                                               
                            @php                      
                            }

                        }

                        echo'</ul></div></li>';
                        
                    }
                }
                else
                {
                    $mn_id = $nb->mN_id;
                    $main_nav = App\Models\Main_nav::where('mN_id',$mn_id)->get();
                    foreach($main_nav as $mn)
                    {
                    @endphp 
                        <li class="sidebar-list-item">
                                        <a href="{{ route ($mn->mN_route) }}" class="sidebar-link text-muted">
                                            <i class="{{$mn->mN_icon}}"></i><span>{{$mn->mN_name}}</span>
                                        </a>
                                    </li>
                    @php      
                    }    
                }
                  
                
                
                                                                   
                
                                                             
                            
            }
        }





$microtime2 = microtime(true);

echo $microtime2 - $microtime1 ;




@endphp 






@if (Auth::user()->id == 7 || 
     Auth::user()->name == 'superadmin' || 
     Auth::user()->name == 'Superadmin' || 
     Auth::user()->name == "Super admin" || 
     Auth::user()->name == "Super Admin" || 
     Auth::user()->name == "super_admin" || 
     Auth::user()->name == "Super_admin" || 
     Auth::user()->name == "Super_Admin" ||
     Auth::user()->name == "super-admin" || 
     Auth::user()->name == "Super-admin" || 
     Auth::user()->name == "Super-Admin" ||
     Auth::user()->name == "SuperAdmin")




<li class="sidebar-list-item">
    <a href="{{ route ('nav_assign') }}" class="sidebar-link text-muted">
    <i class="fas fa-street-view"></i><span>Navigattion</span>
    </a>
</li>





@endif



        </ul>




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
                            Copyright © European IT Solutions |
                            2009-
                            2009-{{ date('Y') }} 
                        </a>
                    </p>
                </div>
            </div>
        </footer>
    </div>
</div>
