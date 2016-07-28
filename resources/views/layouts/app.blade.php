<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Bisame</title>

    <!-- Fonts -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css" rel='stylesheet' type='text/css'>
    <link href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700" rel='stylesheet' type='text/css'>
    <!-- Styles -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
    {{-- <link href="{{ elixir('css/app.css') }}" rel="stylesheet"> --}}
    <link rel="shortcut icon" href="{{ asset('images/favicon.ico') }}" >
    <style>
        @font-face {font-family: "Ostrich-Rounded"; src: url('/images/ostrich-rounded.ttf') ;}
        @font-face {font-family: "Cicle-Fina"; src: url('/images/cicle/Cicle_Semi.ttf') ;}
        .custom-fonts {font-family: "Cicle-Fina" }
        body {
            font-family: 'Cicle-Fina';
            background-color: #6eaaaa;
        }
        .background-colored{
            background-color: #6eaaaa;
        }
        .footer { 
            position: absolute; 
            bottom: 0; 
            margin-top: 15px;
            font-family: 'Ostrich-Rounded';
        }
        .fa-btn {
            margin-right: 6px;
        }
        .ostrich{
            font-family: 'Ostrich-Rounded';
        }
        .fina{
            font-family: 'Cicle-Fina';
        }

        .light-background-colored{
            
            background-color: #545454;
            /*background-color: rgb(249, 242, 236);*/
        }
        .title-app-navbar {
           font-size: 180%;
        }
                
        .navbar-button-text {
           font-size: 130%;
        }
        .white{
            color: white;
        }
        .navbar.navbar-default.light-background-colored {
            margin-bottom: 0;
            border-color: #545454;
        }
        .navbar-default .navbar-nav > li > a {
            color: #CECECE;
        }
        .navbar-default .navbar-brand {
            color: #CECECE;
        }
        .fill { 
            background: url(images/background.png) no-repeat center center fixed; 
            -webkit-background-size: 100% auto;
            -moz-background-size: 100% auto;
            -o-background-size: 100% auto;
            background-size: 100% auto;
        }

    </style>
    @yield('style')
</head>
<!--<div class="fill">-->
<body id="app-layout">
    @include('partials.nav')
    @yield('content')   
<!--    @include('partials.footer')-->
    <!-- JavaScripts -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    {{-- <script src="{{ elixir('js/app.js') }}"></script> --}}
    @yield('script')
</body>
<!--</div>-->
</html>