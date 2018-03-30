<!DOCTYPE html>
<html>
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
            @font-face {font-family: "Belle-Allure"; src: url({{asset('/fonts/belleAllure/BelleAllure-CMMoyenDemo.otf')}}) ;}
            .custom-fonts {font-family: "Cicle-Fina" }

            .fill {
                margin:0;
                padding:0;
                background: url({{ asset('/images/back-'.App::getLocale().'.jpg') }}) no-repeat center fixed;
                background: url({{ asset('/images/summer5.jpg') }}) no-repeat center fixed; 
                -webkit-background-size: cover;  /* pour anciens Chrome et Safari  */
                background-size: cover;  /* version standardisée */
                background-position: left top;  
                position: relative;
                min-height: 100%;
                }            
                /*            .card-header {
                                color: #333;
                                background-color: #f5f5f5;
                                border-color: #ddd;
                            }*/
                .background-colored{
                    /*background-color: #86b8b9;*/
                    background-color: white;
                    opacity: 0.95;   

                }

                .background-colored-light{
                    /*background-color: #86b8b9;*/
                    background-color: white;
                    opacity: 0.85;   

                }

                .info-message-trans {
                    padding: 1.25rem;
                    /*background-color:transparent;*/
                }

                .info-message {
                    padding: 1.25rem;
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


                h1,
                h2,
                h3,
                h4,
                h5,
                h6 {
                    margin-top: 0.5rem;
                    margin-bottom: 0.5rem;
                }
                .title { 
                    /*margin-top: 10vh;*/
                    color: white;
                    font-size: 250%;
                    font-weight: 300;
                    text-align: center;
                    line-height: 3.2;
                }
                .subtitle { 
                    /*margin-top: 10vh;*/
                    color: white;
                    font-weight: 600;
                    font-size: 100%;
                    text-align: center;
                    line-height: 2.8;
                }

                .sidehead { 
                    /*margin-top: 10vh;*/
                    color: white;
                    font-weight: 1000 !important;
                    text-align: center;
                    /*margin-top:1%;*/
                    /*margin-right:1%;*/
                    /*margin-left:1%;*/
                    display: flex;
                    align-items: center;
                }

                .belle-allure{
                    font-family: 'Belle-Allure';
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

                .welcome-card-header {
                    background-color: transparent; 
                    border-bottom-color: transparent;
                    font-family: 'Belle-Allure';
                    text-align: center;
                }
                .play-button {
                    /*width: 33vw;*/
                    white-space: normal;
                    font-size: 15px;
                    border: 1px;	
                    border-style: solid;
                    border-color: #285e8e !important; /*set the color you want here*/
                    border-radius: 3px;
                    /*padding: 2px 30px 1px 30px;*/
                    text-align: center;
                    /*    margin-left: 60px;
                        margin-right: 60px;
                        margin-bottom: 40px;
                        margin-top: 40px;*/
                    /*min-width: 200px;*/
                    /*max-width: 300px;*/
                    background-color: #b7e0ee;
                    -webkit-hyphens: auto;
                    -moz-hyphens: auto;
                    -ms-hyphens: auto;
                    -o-hyphens: auto;
                    hyphens: auto;
                    margin: 0.5% 2%;
                    display:inline-block;
                    color: black;
                } 

                .annotate-button {
                    /*width: 33vw;*/
                    white-space: normal;
                    font-size: 13px;
                    /*border: 1px;*/	
                    /*border-style: solid;*/
                    /*border-color: #285e8e !important; set the color you want here*/
                    border-radius: 3px;
                    /*padding: 2px 30px 1px 30px;*/
                    text-align: center;
                    /*    margin-left: 60px;
                        margin-right: 60px;
                        margin-bottom: 40px;
                        margin-top: 40px;*/
                    /*min-width: 200px;*/
                    /*max-width: 300px;*/
                    background-color: #e1ca52e0;
                    -webkit-hyphens: auto;
                    -moz-hyphens: auto;
                    -ms-hyphens: auto;
                    -o-hyphens: auto;
                    hyphens: auto;
                    margin: 0.5% 2%;
                    display:inline-block;
                    color: black;
                } 

                .validate-button {
                    /*width: 33vw;*/
                    white-space: normal;
                    font-size: 13px;
                    /*border: 1px;*/	
                    /*border-style: solid;*/
                    /*border-color: #285e8e !important; set the color you want here*/
                    border-radius: 3px;
                    /*padding: 2px 30px 1px 30px;*/
                    text-align: center;
                    /*    margin-left: 60px;
                        margin-right: 60px;
                        margin-bottom: 40px;
                        margin-top: 40px;*/
                    /*min-width: 200px;*/
                    /*max-width: 300px;*/
                    background-color: #b1ebccc4;
                    -webkit-hyphens: auto;
                    -moz-hyphens: auto;
                    -ms-hyphens: auto;
                    -o-hyphens: auto;
                    hyphens: auto;
                    margin: 0.5% 2%;
                    display:inline-block;
                    color: black;
                } 

                .button-wrapper { 
                    overflow:hidden;
                    margin:0 auto;
                    text-align:center;
                }

                #play-button-1 {
                    /*width:140px;*/
                } 
                #play-button-2 {
                    overflow:hidden;
                } 

                .nav-link:hover{
                    background-color:white;
                    color:black !important;

                    opacity:1;
                }
                .nav-link{
                    background-color:white;
                    color:black !important;
                    opacity:0.8;
                }
                .nav-link.active{
                    background-color:white;
                    color:black !important;

                    opacity:1;
                }

                .tooltip{
                    font-size: 20px !important;
                    color: white !important;
                }

                .active-button:hover {
                    color: black;
                    font-weight: bold;
                    opacity: 100% !important;
                    border: 1px;	
                    border-style: solid;
                    border-color: #285e8e !important; set the color you want here
                }


                .infobulle {
                    position: relative;  /* les .infobulle deviennent référents */

                    max-width: 30px;
                    /*cursor: help;*/
                }

                /* on génère un élément :after lors du survol et du focus :*/

                .infobulle:hover::after,
                .infobulle:focus::after {
                    content: attr(aria-label);  /* on affiche aria-label */
                    position: absolute;
                    /*top: -2.4em;*/
                    left: 100%;
                    border-radius:3px;
                    padding:5px;
                    background-color:white;
                    transform: translateX(-0%); /* on centre horizontalement  */
                    transform: translateY(-100%); /* on centre horizontalement  */
                    z-index: 1; /* pour s'afficher au dessus des éléments en position relative */
                    white-space: nowrap;  /* on interdit le retour à la ligne */
                }

                li.nav-item > a.no-hover:focus, li.nav-item > a.no-hover:hover{
                    color: #CECECE !important;
                }

                .dropdown-menu {
                    background-color: black !important;
                    border-color: whitesmoke !important;
                    color: white !important;
                }
                .navbar-default .navbar-nav .open .dropdown-menu {
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
                    border-radius: 15px;
                    border: 1px solid white;
                }
                .footer-container {
                    vertical-align: middle;
                    overflow-y : auto;
                    position : relative;
                    margin: 0 auto;
                }
                .container-fluid {
                    padding-bottom: 40px;
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
                #home {
                    padding-bottom: 40px;
                    font-size: 120%;
                }
                .btn-link {
                    color: rgb(206, 206, 206);
                }
                a.btn-link:hover, div.show a.btn-link {
                    color: #f69a47;
                    text-decoration: none;
                }

                ol, ul, dl {
                    margin-top: 1rem;
                    margin-bottom: 1rem;
                }

                .col-centered{
                    float: none;
                    margin: 0 auto;
                }

                .explanation-card {
                    margin-bottom: 1rem;
                }

                .center-button {
                    margin: 0 auto; 
                    display:block;
                }
                .btn-navbar {
                    font-size: 110% !important; 
                }
            </style>
            <link href="{{ asset('css/'.App::getLocale().'.css') }}" rel="stylesheet">

            @yield('style')

            @section('page-header')

            @stop
        </head>

        <body class="fill" id="app" style="max-width:100%; margin:0 auto;">

            @include('partials.nav')

            @include('shared/badges')

            @include('discussion/report')

            <div class="container-fluid">

                @include('shared/alerts')

                @yield('content')

            </div>
            @include('partials.footer-'.App::getLocale())
            <!-- JavaScripts -->
            <script type="text/javascript">
                var base_url = '{{ asset('') }}';
                var logged_in = {{ Auth::check()? 1 : 0 }};
            </script>    
            <script src="{{ asset('/js/all.js') }}"></script>

            <script type="text/javascript" src="{{ asset('js/navbar.js') }}"></script>
            <script type="text/javascript" src="{{ asset('js/master.js') }}"></script>

            @yield('scripts')

            @include('partials.modal-login')

        </body>

    </html>
