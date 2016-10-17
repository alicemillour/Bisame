<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
<!--<link rel="stylesheet" type="text/css" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css">-->

<nav class="navbar navbar-default navbar-fixed-top light-background-colored"  id="topnavbar">
    <div class="container-fluid">
        <div class="light-background-colored">
            <div class="navbar-header ">

                <!-- Collapsed Hamburger -->
                <button type="button" class="navbar-toggle collapsed light-background-colored" data-toggle="collapse" data-target="#app-navbar-collapse">
                    <span class="sr-only">Toggle Navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

                <!-- Branding Image -->
                <a class="navbar-brand ostrich title-app-navbar my-navbar-hover" href="{{ url('/') }}">
                    <b> Bisame </b> 
                </a>
            </div>

            <div class="collapse navbar-collapse" id="app-navbar-collapse">
                <!-- Left Side Of Navbar -->
                <ul class="nav navbar-nav navbar-button-text">
                    <li><a class="my-navbar-hover" href="{{ url('/home') }}">Accueil</a></li>
                </ul>
                <!-- Right Side Of Navbar -->

                <ul class="nav navbar-nav navbar-right navbar-button-text">

                    <!-- Authentication Links -->
                    @if (Auth::guest())
                    <li><a  class="my-navbar-hover" href="{{ url('/login') }}">Connexion</a></li>
                    <li><a  class="my-navbar-hover"  href="{{ url('/register') }}">Inscription</a></li>
                    @else     
                    <li><a class ="incognito"><b> Déjà {{$nb_total_annotations}} annotations produites</b> !</a></li>
                    <li><a class ="incognito" >Niveau : {{$niveau}}</a></li>
                    @if ($real_score == 0)
                    <li><a class ="incognito">Score : {{$real_score}} point</a></li>
                    @else
                    <li><a class ="incognito">Score : {{$real_score}} points</a></li>
                    @endif
                    @if ($nb_annotations == 0)
                    <li><a class ="incognito">Vous n'avez pas encore produit d'annotation.</a></li>
                    @else
                    <li><a class ="incognito">Vous avez produit {{$nb_annotations}} annotations !</a></li>
                    @endif
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle my-navbar-hover my-navbar-click" data-toggle="dropdown" role="button" aria-expanded="false">
                            {{$name}}<span class="caret"></span>
                        </a>

                        <ul class="dropdown-menu" role="menu">
                            <li><a href="{{ url('/logout') }}"><i class="fa fa-btn fa-sign-out"></i>Déconnexion</a></li>
                        </ul>
                    </li>
                                        <li> <i class="icon-search icon-white"></i>
                        <a class="my-navbar-hover" href="/contact"> <i class="fa fa-envelope-o" aria-hidden="true"></i> Un commentaire ?</a>
                    </li>
                    @endif
                </ul>
            </div>
        </div>
    </div>
</nav>