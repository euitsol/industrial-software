<div class="d-flex align-items-stretch main-sidebar">
    <div id="sidebar" class="sidebar">
        <div class=" text-uppercase   py-3 font-weight-bold small headings-font-family text-center align-middle bg-info text-white" >
             MENU
        </div>


        <ul class="sidebar-menu list-unstyled">
            <li class="sidebar-list-item">
                <a href="{{route('student.profile')}}" class="sidebar-link text-muted">
                <i class="o-home-1 text-gray"></i>
                <span>Home</span>
                </a>
            </li>
            <li class="sidebar-list-item">
                <a href="{{route('student.studentAttendance')}}" class="sidebar-link text-muted">
                <i class="fas fa-chalkboard-teacher text-gray"></i>
                <span>Attendance Report</span>
                </a>
            </li>
            <li class="sidebar-list-item">
                <a href="{{route('student.courses')}}" class="sidebar-link text-muted">
                <i class="fa fa-money-bill-alt text-gray"></i>
                <span>Payment</span>
                </a>
            </li>
            <li class="sidebar-list-item">
                <a href="{{route('student.job_placement.info')}}" class="sidebar-link text-muted">
                <i class="fas fa-bacon text-gray"></i>
                <span>Job Placement</span>
                </a>
            </li>
            <li class="sidebar-list-item">
                <a href="javascript:void(0)" data-toggle="collapse" data-target="#AttendanceReport" class="sidebar-link text-muted" aria-expanded="false" aria-controls="StaticSubNav2">
                    <i class="fa fa-list-alt text-gray"></i><span>Document</span>
                </a>
                <div class="collapse" id="AttendanceReport">
                    <ul class="sidebar-menu list-unstyled border-left border-primary border-thick">
                        <li class="sidebar-list-item">
                            <a href="{{route('student.registration_card')}}" class="sidebar-link text-muted">
                            <i class= "fas fa-minus text-gray"></i>
                            <span>Registration Card</span>
                            </a>
                        </li>
                        <li class="sidebar-list-item">
                            <a href="#" class="sidebar-link text-muted">
                            <i class= "fas fa-minus text-gray"></i>
                            <span>Certificate</span>
                            </a>
                        </li>
                        <li class="sidebar-list-item">
                            <a href="{{route('student.id_card')}}" class="sidebar-link text-muted">
                            <i class= "fas fa-minus text-gray"></i>
                            <span>ID Card</span>
                            </a>
                        </li>
                    </ul>
                </div>
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
