<nav class="navbar navbar-expand-sm navbar-dark fixed-top dark-background-colored py-0" role="navigation" id="topnavbar">
  <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
    <div class="navbar-brand mr-auto">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="p-0 pt-1 nav-link ostrich title-app-navbar" style="white-space: nowrap;" href="{{ url('/') }}">
                    <i class="fa fa-home fa-fw" aria-hidden="true"></i><b> {{ trans('home.app-name') }} </b> 
                </a>
            </li>
            <li class="nav-item">
                <a class="p-0 pl-4 nav-link navbar-nav nav navbar-button-text" href="{{ url('/textes') }}">
                    <b>Les textes originaux</b>&nbsp;!
                </a>
            </li>
        </ul>
    </div>
    <div class="dropdown">
        <a class="btn btn-link dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        Recettes
        </a>

        <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
            <a class="dropdown-item" href="{{ route('recipes.index') }}">Toutes les recettes</a>
            <a class="dropdown-item" href="{{ route('recipes.favorite') }}">Mes recettes favorites</a>
            <a class="dropdown-item" href="{{ route('recipes.create') }}">Ajouter une recette</a>
        </div>
    </div>
    @if(Auth::check())
    <div class="dropdown">
        <a href="#" class="btn btn-link dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
            {{$name}}<span class="caret"></span>
        </a>
        
        <ul class="dropdown-menu" role="menu">     
            <li><a class="dropdown-item" href="{{ route('users.home') }}"><i class="fa fa-btn fa-user"></i>Mon profil</a></li>
            <li>
                <a href="{{ url('/logout') }}"
                    class="dropdown-item"
                    onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();">
                    <i class="fa fa-btn fa-sign-out"></i>
                    Déconnexion
                </a>

                <form id="logout-form" class="d-none" action="{{ url('/logout') }}" method="POST">
                    {{ csrf_field() }}
                </form>
            </li>
        </ul>
    </div>
    @endif
    <ul class="navbar-nav mt-2 mt-lg-0">
    @if (!Auth::check())
        <li class="nav-item">
            <a class="nav-link btn btn-link" href="{{ url('/login') }}">
                Connexion
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link btn btn-link" href="{{ url('/register') }}">
                Inscription
            </a>
        </li>
    @endif
    <li class="nav-item">
        <i class="icon-search icon-white"></i>
        <a class="nav-link btn btn-link" href="{{ route('contact') }}">
            <i class="fa fa-envelope-o" aria-hidden="true"></i> Contact 
        </a>
    </li>
    </ul>
    <ul class="navbar-nav mt-2 mt-lg-0 d-none">
        <li class="nav-item">
            <a class="nav-link no-hover" style="float: none;display: inline-block;text-align: center;">
                <b>Déjà {{$non_admin_annotations}} annotations produites par {{$nb_total_users}} participants </b> !
            </a>
        </li>
        <!-- Authentication Links -->
        @if (!Auth::check())
        <li class="nav-item">
            <a class="nav-link" href="{{ url('/login') }}">
                Connexion
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ url('/register') }}">
                Inscription
            </a>
        </li>
        @else     
            <li class="nav-item"><a class="incognito" >Niveau : {{$niveau}}</a></li>
            
            @if ($real_score == 0)
                <li class="nav-item"><a class="incognito">Score : {{$real_score}} point</a></li>
            @else
                <li class="nav-item"><a class="incognito">Score : {{$real_score}} points</a></li>
            @endif
        
            @if ($nb_annotations == 0)
                <li class="nav-item"><a class="incognito">Vous n'avez pas encore produit d'annotation.</a></li>
            @else
                <li class="nav-item"><a class="incognito">Vous avez produit {{$nb_annotations}} annotations !</a></li>
            @endif

        <li class="dropdown">
            <a href="#" class="dropdown-toggle my-navbar-hover my-navbar-click" data-toggle="dropdown" role="button" aria-expanded="false">
                {{$name}}<span class="caret"></span>
            </a>
            
            <ul class="dropdown-menu" role="menu">     
                <li><a class="dropdown-item" href="{{ route('users.home') }}"><i class="fa fa-btn fa-user"></i>Mon profil</a></li>
                <li>
                    <a href="{{ url('/logout') }}"
                        class="dropdown-item"
                        onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();">
                        <i class="fa fa-btn fa-sign-out"></i>
                        Déconnexion
                    </a>

                    <form id="logout-form" class="d-none" action="{{ url('/logout') }}" method="POST">
                        {{ csrf_field() }}
                    </form>
                </li>
            </ul>
        </li>

        @endif

  </div>
</nav>