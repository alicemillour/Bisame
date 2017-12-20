<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml"
      xmlns:fb="http://ogp.me/ns/fb#">
    <head>
        <meta charset="utf-8">  
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta property="og:image" content="{{ asset('images/ppic.jpg') }}" />
        <meta property="og:description" content="Bisame est un projet de recherche collaboratif visant à favoriser la diffusion de l'alsacien. Venez participer !" />
        <!-- TODO DIFF <title>Krik !</title> -->
        <title> {{ trans('home.app-name') }} </title>   
        {{-- <link href="{{ elixir('css/app.css') }}" rel="stylesheet"> --}}
        <link rel="shortcut icon" href="{{ asset('images/favicon-'.App::getLocale().'.png') }}" >
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <style>
            @font-face {font-family: "Ostrich-Rounded"; src: url({{asset('/images/ostrich-rounded.ttf')}}) ;}
            @font-face {font-family: "Cicle-Fina"; src: url({{asset('/images/cicle/Cicle_Semi.ttf')}}) ;}
            .custom-fonts {font-family: "Cicle-Fina" }
            body {
                font-size:14px;
            }
            .fill {
                margin:0;
                padding:0;
                background: url({{ asset('/images/back-'.App::getLocale().'.jpg') }}) no-repeat center fixed;
                -webkit-background-size: cover;  /* pour anciens Chrome et Safari  */
                background-size: cover;  /* version standardisée */
                background-position: left top;  
                position: relative;
            }            
/*            .card-header {
                color: #333;
                background-color: #f5f5f5;
                border-color: #ddd;
            }*/
            .background-colored{
/*                background-color: #86b8b9;*/
                background-color: white;
                opacity: 0.9;   

            }

            .info-message-trans {
                padding: 1.25rem;
                /* background-color:rgba(249, 242, 236, 0.9); */
            }
                

            .bg-dark {
                color:white;
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
                font: 400 1.25rem 'Raleway';
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
                font-size: 125%;
            }

            .navbar-default .navbar-nav > .open > a, .navbar-default .navbar-nav > .open > a:focus, .navbar-default .navbar-nav > .open > a:hover {
                background-color: #CECECE !important;
                color: black !important;
            }

            li.nav-item > a.no-hover:focus, li.nav-item > a.no-hover:hover{
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
            .dropdown-menu > li > a {
                background-color:#545454 !important;
                color: #FCF8E3 !important;
            } 
            .navbar-button-text {
                font-size: 120%;
            }

            .white{
                color: white;
            }

            .navbar-dark .navbar-nav .nav-link {
                color: #CECECE;
            }
            .navbar-dark .navbar-nav .nav-link:hover {
                color: #f69a47;
            }
            .navbar-dark {
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
            .container-fluid {
                z-index:10;
            }
            .fixed-bottom {
                z-index: 5;
            }
            /*            @media screen and (max-width: 1280px) {
                        .footer-container {
                            max-width: 40%;
                        }
                        }*/
            alert {
                color : red;
            }

            a.btn-default {
                color: black;
            }
        </style>
        <link href="{{ asset('css/'.App::getLocale().'.css') }}" rel="stylesheet">

        @yield('style')

        @section('page-header')

        @stop
    </head>
    
    <body class="fill" id="app">

        @include('partials.nav')

        {{-- @include('shared/alerts') --}}
        
        @include('shared/badges')

        <div class="container-fluid">
            @yield('content')
        </div>

        @include('partials.footer-'.App::getLocale())
        <!-- JavaScripts -->
        <script>
            var base_url = '{{ asset('') }}';
        </script>    
        <script src="{{ asset('/js/all.js') }}"></script>

        <script type="text/javascript" src="{{ asset('js/navbar.js') }}"></script>
        <script type="text/javascript" src="{{ asset('js/master.js') }}"></script>


        @yield('scripts')

    </body>

</html>