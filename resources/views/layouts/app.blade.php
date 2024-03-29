<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml"
      xmlns:fb="http://ogp.me/ns/fb#">
    <head>
        <meta charset="utf-8">  
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta property="og:image" content="{{ asset('images/ppic_'.App::getLocale().'.jpg') }}" />
        <meta property="og:description" content="Bisame est un projet de recherche collaboratif visant à favoriser la diffusion de l'alsacien. Venez participer !" />
        <!-- TODO DIFF <title>Krik !</title> -->
        <title> {{ trans('home.app-name') }} </title>

        <!-- Fonts -->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css" rel='stylesheet' type='text/css'>
        <link href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700" rel='stylesheet' type='text/css'>
        <!-- Styles -->
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
        {{-- <link href="{{ elixir('css/app.css') }}" rel="stylesheet"> --}}
        <!-- TODO DIFF <link rel="shortcut icon" href="{{ asset('images/favicon-krik2.ico') }}" > -->
        <link rel="shortcut icon" href="{{ asset('images/favicon-'.App::getLocale().'.png') }}" >
        <style>
            @font-face {font-family: "Ostrich-Rounded"; src: url('/images/ostrich-rounded.ttf') ;}
            @font-face {font-family: "Cicle-Fina"; src: url('/images/cicle/Cicle_Semi.ttf') ;}
            .custom-fonts {font-family: "Cicle-Fina" }
            body {
                font-family: 'Cicle-Fina';
                background-color: #86b8b9;
            }

            .background-colored{
/*                background-color: #86b8b9;*/
                background-color: white;
                opacity: 0.9;   

            }
/*            .footer { 
                position: absolute; 
                bottom: 0; 
                margin-top: 15px;
                font-family: 'Ostrich-Rounded';
            }*/
            .fa-btn {
                margin-right: 6px;
            }
            .ostrich{
                font-family: 'Ostrich-Rounded';
            }
            .fina{
                font: 400 2rem/2.3rem 'Raleway';
            }
            .fina-old{
                font-family: 'Cicle-Fina';
            }

            .foreground {
                z-index:1 !important;
            }

            .light-background-colored{
                background-color: #545454;
                margin-bottom: 0;
                border-color: #545454;
                /*background-color: rgb(249, 242, 236);*/
            }
            .dark-background-colored{
                    background-color: black;
                    margin-bottom: 0;
                    border-color: black;
                    /*background-color: rgb(249, 242, 236);*/
            }
            .title-app-navbar {
                font-size: 180%;
            }

            .navbar-default .navbar-nav > .open > a, .navbar-default .navbar-nav > .open > a:focus, .navbar-default .navbar-nav > .open > a:hover {
                background-color: #CECECE !important;
                color: black !important;
            }

            .navbar-default .navbar-nav > li > a.no-hover:focus, .navbar-default .navbar-nav > li > a.no-hover:hover{
                color: #CECECE !important;
            }
            
            .dropdown-menu {
                background-color: #545454 !important;
                color: white !important;
            }
            .navbar-default .navbar-nav .open .dropdown-menu {
                background-color:#545454 !important;
                color: #FCF8E3 !important;
            } 
            .dropdown-menu>li>a{
                background-color:#545454 !important;
                color: #FCF8E3 !important;
            } 
            .navbar-button-text {
                font-size: 130%;
            }

            .white{
                color: white;
            }

            .navbar-default .navbar-nav > li > a {
                color: #CECECE;
            }
            .navbar-default .navbar-brand {
                color: #CECECE;
            }
            .fancy-border{
                border: 1px solid white;
                
            }
            .footer-container {
                vertical-align: middle;
                overflow-y : auto;
                position : relative;
                margin: 0 auto;
            }
            /*            @media screen and (max-width: 1280px) {
                        .footer-container {
                            max-width: 40%;
                        }
                        }*/

        </style>
        <link href="{{ asset('css/'.App::getLocale().'.css') }}" rel="stylesheet">
        @yield('style')
        @section('page-header')

        @stop
    </head>
    <!--<div class="fill">-->
    @yield('content')
    <body class="fill" id="app-layout"/> 
    @include('partials.footer-'.App::getLocale())
    <!-- JavaScripts -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    {{-- <script src="{{ elixir('js/app.js') }}"></script> --}}
<script type="text/javascript" src="{{ asset('js/navbar.js') }}"></script>

<script type="text/javascript" src="{{ asset('js/master.js') }}"></script>
<!--<script>-->
    <!--{!! Html::script(route('asset',['asset'=>'js/master.js'])) !!}-->
<!--</script>-->


@yield('script')

</body>
<!--</div>-->
</html>