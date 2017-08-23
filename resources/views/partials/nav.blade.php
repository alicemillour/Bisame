<nav class="navbar navbar-default navbar-fixed-top dark-background-colored" role="navigation" id="topnavbar">
    <div class="container-fluid">
        <div class="dark-background-colored">
            <div class="navbar-header ">
                
                <!-- Collapsed Hamburger -->
                <button type="button" class="navbar-toggle collapsed dark-background-colored" data-toggle="collapse" data-target="#app-navbar-collapse" aria-expanded="false" aria-controls="navbar">
                    <span class="sr-only">Toggle Navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                
                <!-- Branding Image -->
                <a class="navbar-brand ostrich title-app-navbar my-navbar-hover" style="white-space: nowrap;" href="{{ url('/') }}">
                    <i class="fa fa-home fa-fw" aria-hidden="true"></i><b> Bisame </b> 
                </a>
                <!--<div class="collapse navbar-collapse" id="app-navbar-collapse">-->
                <ul class="nav navbar-nav navbar-right navbar-button-text">
                    <li><a class="my-navbar-hover navbar-nav nav navbar-button-text" href="{{ url('/textes') }}">
                            <b> Les textes originaux</b>  !                 </a></li>
                </ul>
                <!--</div>-->
            </div>
            
            <div class="collapse navbar-collapse" id="app-navbar-collapse">
                <!-- Right Side Of Navbar -->
                
                <ul class="nav navbar-nav navbar-right">
                    <!-- <li><a class="my-navbar-hover navbar-nav nav navbar-button-text" href="{{ url('/textes') }}">
                       <b> Les textes originaux</b>  ! 
                    </a></li> -->
                    <li><a class="no-hover" style="float: none;display: inline-block;text-align: center;">
                            <b>Déjà {{$non_admin_annotations}} annotations produites par {{$nb_total_users}} participants </b> !</a></li>
                    <!-- Authentication Links -->
                    @if (Auth::guest())
                    <li><a  class="my-navbar-hover" href="{{ url('/login') }}">Connexion</a></li>
                    <li><a  class="my-navbar-hover"  href="{{ url('/register') }}">Inscription</a></li>
                    @else     
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
                            <li><a href="{{ url('/profile') }}"><i class="fa fa-btn fa-user"></i>Mon profil</a></li>
                            <li><a href="{{ url('/logout') }}"><i class="fa fa-btn fa-sign-out"></i>Déconnexion</a></li>
                        </ul>
                    </li>
                    @endif
                                        <li> <i class="icon-search icon-white"></i>
                        <a class="my-navbar-hover" href="/contact"> <i class="fa fa-envelope-o" aria-hidden="true"></i> Contact </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>