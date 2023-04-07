<div class="d-flex align-items-stretch main-sidebar">
    <div id="sidebar" class="sidebar ">
        <div class=" text-uppercase   py-3 font-weight-bold small headings-font-family text-center align-middle bg-info text-white" >
             MENU 
        </div>


        <ul class="sidebar-menu list-unstyled">
            <li class="sidebar-list-item">
                <a href="javascript:void(0)" class="sidebar-link text-muted">
                <i class="fas fa-church"></i>
                <span>Static Test Menu</span>
                </a>
                <div class="collapse">
                    <ul class="sidebar-menu list-unstyled border-left border-primary border-thick">
                        <li class="sidebar-list-item">
                            <a href="#" class="sidebar-link text-muted">
                                <i class= "fas fa-minus text-gray"></i><span>Static Sub Nav</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>        
            <li class="sidebar-list-item">
                <a href="#" class="sidebar-link text-muted">
                    <i class="fas fa-church"></i><span>Static Test Menu-2</span>
                </a>
            </li>
            <li class="sidebar-list-item">
                <a href="#" class="sidebar-link text-muted">
                <i class="fas fa-street-view"></i><span>Navigattion</span>
                </a>
            </li>
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
