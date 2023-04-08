<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title> @yield('title', 'European IT') </title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="all,follow">
    <!-- Bootstrap CSS-->
    <link rel="stylesheet" href="{{ asset('assets') }}/vendor/bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome CSS-->
    <link rel="stylesheet" href="{{asset('assets')}}/vendor/fontawesome/css/all.css">
    <link rel="stylesheet" href="{{ asset('assets') }}/css/orionicons.css">
    <!-- theme stylesheet-->
    <link rel="stylesheet" href="{{ asset('assets') }}/css/style.default.css" id="theme-stylesheet">
    <!-- Custom stylesheet - for your changes-->
    <link rel="stylesheet" href="{{ asset('assets') }}/css/custom.css">

    <!-- Favicon-->
    <link rel="icon" href="{{asset('/')}}images/icon.png" type="image/png">

    @stack('third_party_css')
    @stack('css')

</head>
<body>

<div id="loader"></div>

<!-- navbar-->
@include('student_panel.partial.header')
<!-- sidebar -->
@include('student_panel.partial.sidebar')

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

<script>
    $(function () {
        $('#sidebar li a').filter(function () {
            return this.href === location.href;
        }).addClass('active').closest("div").addClass('show');
    });

    /*function baseUrl() {
        let getUrl = window.location;
        return getUrl.protocol + "//" + getUrl.host + "/" + getUrl.pathname.split('/')[1];
    }*/
    /*$(function(){
        $("a").each(function (i, el){
            var href = $(this).attr("href");
            $(this).attr("action-url", href);
            $(this).removeAttr("href");
            $(".btn").css({color: '#fff'});
        });
        $("a").click(function(){
            url = $(this).attr("action-url");
            $(this).attr("href", url);
        })
    });*/
</script>

{{-- <style>
    a { text-decoration: none; }
    a:hover { cursor: pointer; }
    a:focus{ outline: 0; }
</style> --}}


<script>

    window.onload = function () {
        clock();

        function clock() {
            let now = new Date();
            let TwentyFourHour = now.getHours();
            let hour = now.getHours();
            let min = now.getMinutes();
            let sec = now.getSeconds();
            let mid = 'PM';
            if (min < 10) {
                min = "0" + min;
            }
            if (hour > 12) {
                hour = hour - 12;
            }
            if (0 === hour) {
                hour = 12;
            }
            if (TwentyFourHour < 12) {
                mid = 'AM';
            }
            document.getElementById('clock').innerHTML = hour + ' : ' + min + ' : ' + sec + ' ' + mid;
            setTimeout(clock, 1000);
        }
    }
</script>

</body>
</html>