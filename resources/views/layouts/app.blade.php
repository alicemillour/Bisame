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
        .fill {
                width:100%;
                height:100%;
                background-size: 100%;
                /*background-image: url("/images/back-fake.jpeg");*/   
                /*background-repeat:no-repeat;*/
                /*background-position: center top;*/
                /*margin-top: 60px;*/
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
            background-color: rgb(249, 242, 236);
        }
        .title-app-navbar {
           font-size: 150%;
        }
    </style>
    @yield('style')
</head>
<body id="app-layout">
    @include('partials.nav')
    <div class="fill">
    @yield('content')   
<!--    @include('partials.footer')-->
    <!-- JavaScripts -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    {{-- <script src="{{ elixir('js/app.js') }}"></script> --}}
    @yield('script')
    </div>
</body>
</html>
