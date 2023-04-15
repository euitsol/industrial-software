<header class="header">
    <nav class="navbar navbar-expand-lg px-4 py-2 bg-white shadow">
        <a href="javascript:void(0)"
           class="sidebar-toggler text-gray-500 mr-4 mr-lg-5 lead"><i
                    class="fas fa-align-left"></i></a>
        <a href="https://www.euitsols-inst.com/" target="_blank"
           class="navbar-brand font-weight-bold text-uppercase text-base">
            <img src="{{asset('images/EUITSols Institute New.png')}}" style="height: 30px;" alt="">
        </a>
        <div id="clock"></div>
        <ul class="ml-auto d-flex align-items-center list-unstyled mb-0">
            <li class="nav-item dropdown ml-auto">
                <a id="userInfo" href="javascript:void(0)"
                   data-toggle="dropdown" aria-haspopup="true"
                   aria-expanded="false" class="nav-link dropdown-toggle">
                    {{-- <span class="text-success">Welcome!</span>{{ Auth::guard('student')->user()->name }} --}}
                    @if(isset(Auth::guard('student')->user()->photo))
                    <img style="height: 20px; width:20px;" class="mr-2 rounded-circle" src="{{ asset(Auth::guard('student')->user()->photo)}}" alt="Profile">
                    @else
                        @if( Auth::guard('student')->user()->gender == 'male')
                            <img style="height: 20px; width:20px;" class="mr-2 rounded-circle" src="{{asset('images/avatar-male.jpg')}}" alt="Profile">
                        @else
                            <img style="height: 20px; width:20px;" class="mr-2 rounded-circle" src="{{asset('images/avater-female.jpg')}}" alt="Profile">
                        @endif
                    @endif
                    {{ Auth::guard('student')->user()->name }}
                </a>
                <div aria-labelledby="userInfo" class="dropdown-menu px-3">
                    <div class="table-responsive">
                        <table class="table table-borderless text-secondary">
                            <tr>
                                <th style="padding: 2px 8px !important;">Name :</th>
                            </tr>
                            <tr>
                                <td style="padding: 2px 8px !important;">{{ Auth::guard('student')->user()->name }}</td>
                            </tr>
                            <tr>
                                <th style="padding: 2px 8px !important;">Email :</th>
                            </tr>
                            <tr>
                                <td style="padding: 2px 8px !important;">{{ Auth::guard('student')->user()->email }}</td>
                            </tr>
                            <tr>
                                <th style="padding: 2px 8px !important;">Phone :</th>
                            </tr>
                            <tr>
                                <td style="padding: 2px 8px !important;">{{ Auth::guard('student')->user()->phone }}</td>
                            </tr>
                            @forelse (Auth::guard('student')->user()->batches as $key=>$b)
                                <tr>
                                    <th style="padding: 2px 8px !important;">
                                        Course:
                                    </th>
                                </tr>
                                <tr>
                                    <td style="padding: 2px 8px !important;">{{$b->course->title}}</td>
                                </tr>
                                <tr>
                                    <th style="padding: 2px 8px !important;">Batch:</th>
                                </tr>
                                <tr>
                                    <td style="padding: 2px 8px !important;">{{batch_name($b->course->title_short_form, $b->year, $b->month, $b->batch_number)}}</td>
                                </tr>
                                <tr>
                                    <th style="padding: 2px 8px !important;">Course Fee :</th>
                                </tr>
                                <tr>
                                    <td style="padding: 2px 8px !important;">{{ $b->course->fee }}Tk</td>           
                                </tr>


                                @php
                                $accounts = App\Models\Account::where('student_id',Auth::guard('student')->user()->id)->where('course_id',$b->course->id)->get();
                                @endphp
                                @foreach ($accounts as $account)
                                @php
                                    $payments = App\Models\Payment::where('account_id',$account->id)->get();
                                    $pay = 0;
                                @endphp
                                @foreach ($payments as $payment)
                                    @php
                                        $pay += $payment->amount;
                                    @endphp
                                @endforeach
                                    <tr>
                                        <th style="padding: 2px 8px !important;">Paid :</th>
                                    </tr>
                                    <tr>
                                        <td style="padding: 2px 8px !important;">{{ $pay ?? '0' }}.00Tk</td>           
                                    </tr>
                                    {{-- @php
                                        $due = $b->course->fee - $pay;
                                    @endphp --}}
                                    <tr>
                                        <th style="padding: 2px 8px !important;">Due :</th>
                                    </tr>
                                    <tr>
                                        <td style="padding: 2px 8px !important;"> {{ $account->get_due($payment->id) }}.00Tk</td>
                                    </tr>
                                    
                                @endforeach
                            @empty
                            @endforelse
                        
                        </table>
                    </div>
                    <a class="dropdown-item btn btn-outline-secondary" href="javascript:void(0)"
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        {{ __('Logout') }}
                    </a>
                    <form id="logout-form" action="{{ route('student.logout') }}"
                          method="POST">
                        @csrf
                    </form>
                </div>
            </li>
        </ul>
    </nav>
</header>
