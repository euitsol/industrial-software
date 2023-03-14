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
                    <span class="text-success">Welcome!</span> {{ Auth::user()->name }}
                </a>
                <div aria-labelledby="userInfo" class="dropdown-menu">
                    <a class="dropdown-item" href="javascript:void(0)"
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        {{ __('Logout') }}
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}"
                          method="POST">
                        @csrf
                    </form>
                </div>
            </li>
        </ul>
    </nav>
</header>
