<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title> @yield('title', 'European IT') </title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="all,follow">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Bootstrap CSS-->
    <link rel="stylesheet" href="{{ asset('assets') }}/vendor/bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome CSS-->
    <link rel="stylesheet" href="{{asset('assets')}}/vendor/fontawesome/css/all.css">
    <link rel="stylesheet" href="{{ asset('assets') }}/css/orionicons.css">
    <!-- theme stylesheet-->
    <link rel="stylesheet" href="{{ asset('assets') }}/css/style.default.css" id="theme-stylesheet">
    <!-- Custom stylesheet - for your changes-->
    <link rel="stylesheet" href="{{ asset('assets') }}/css/custom.css">
    <!-- web header css -->
    <link rel="stylesheet" href="{{ asset('assets') }}/css/web_header.css">

    <!-- Favicon-->
    <link rel="icon" href="{{asset('/')}}images/icon.png" type="image/png">
        <!-- Fonts -->
    
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@800&family=Teko&display=swap" rel="stylesheet">

    @stack('css')

</head>
<body>

<div id="loader"></div>

<!-- navbar-->
<!--@include('student_panel.partial.web_header')-->
<!-- menubar -->  
<!--@include('student_panel.partial.web_menu')-->

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
    












<!-- JavaScript files-->
<script src="{{ asset('assets') }}/vendor/jquery/jquery.min.js"></script>
<script src="{{ asset('assets') }}/vendor/popper.js/umd/popper.min.js"></script>
<script src="{{ asset('assets') }}/vendor/bootstrap/js/bootstrap.min.js"></script>
<script src="{{ asset('assets') }}/vendor/jquery.cookie/jquery.cookie.js"></script>
<script src="{{ asset('assets') }}/js/front.js"></script>

@stack('js')

<script>
    $(window).on('load', function () {
        $("#loader").fadeOut("slow");
    });
</script>



</body>
</html>