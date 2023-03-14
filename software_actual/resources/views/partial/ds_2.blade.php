
                        @forelse ($first as $fs)
                        @empty
                        @endforelse

                        @if(1 == 1) 
                        @endif


                        @forelse ($first as $fs)
                            @if($fs->user_id == Auth::user()->id)
                            
                                @forelse ($fs->na_bkdn as $nb)
                                
                                    @forelse ($second as $sd)
                                        
                                        @if($sd->nB_id == $nb->nB_id) 
                                        
                                        {{$sd->main_menu->mN_name}}
                                        {{$sd->main_menu->mN_route}}
                                        {{$sd->main_menu->mN_icon}},
                                        

                                            @if(isset($sd->sub_menu)) 
                            

                                                {{$sd->sub_menu->sN_name}}
                                                {{$sd->sub_menu->sN_route}}
                                                {{$sd->sub_menu->sN_icon}}<br>
                                            @else
                                            <br>
                                            @endif 
                                        @endif

                                    @empty
                                    @endforelse

                                @empty
                                @endforelse
                            @endif
                        @empty
                        @endforelse

                        
