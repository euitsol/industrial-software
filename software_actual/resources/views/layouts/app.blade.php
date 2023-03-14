<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>European IT Solutions Institute</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <style>
        .card {
            background: url({{asset('images/login-card-bg.jpg')}});
            background-size: cover !important;
            background-repeat: no-repeat !important;
            padding: 15px !important;
        }

        body {
            background-size: cover !important;
            background-repeat: no-repeat !important;
            height: 100vh;
            display: table;
            table-layout: fixed;
            margin: 0 auto;
        }

        label {
            color: white !important;
        }

        #app {
            display: table-cell;
            vertical-align: middle;
            width: 1140px;
        }

        body {
            background: url({{asset('images/login-background.jpg')}});
        }
    </style>
</head>
<body>
<div id="app">
    <main class="py-4">
        @yield('content')
    </main>
</div>
</body>
</html>
