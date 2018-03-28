<div class="masthead">
    <div class="row">
        <!--        <div class="col-md-3 belle-allure sidehead justify-content-end" style=""> 
                    @if (Auth::check())
                    <span style="text-align:center; border-width:1px; border-style:double; border-color:white; padding: 1em;float: right !important; ">
        
                        @component('users._avatar', ['user' => Auth::user()])
                        @endcomponent Mes statistiques... 
                        <hr style="height: 2px; color: white; background-color: whitesmoke; width: 50%; border: 1px; ">
        
                            {{ $nb_recipes_user }}  recettes <br>
                            {{ $nb_annotations }}  mots annotés <br>
                            {{ $nb_variantes_user }}  mots alternatifs proposés<br>
        
                    </span>
                    @endif
                </div>-->
        <div class="col-md-3 belle-allure sidehead justify-content-end" style=""> 
            <span style="text-align:center; border-width:1px; border-style:double; border-color:white; padding: 1em">
                @if (Auth::check())
                Statistiques globales
                @else
                Statistiques
                @endif
                <hr style="height: 1px; color: white; background-color: whitesmoke; width: 50%; ">
                {{ $nb_total_users }}  participants <br>
                {{ $nb_recipes }}  recettes <br>
                {{ $nb_recipe_annotations }}  mots annotés <br>
                {{ $nb_recipe_versions }}  mots alternatifs proposés <br> 
            </span>
        </div>
        <div class="col-md-6 "> 
            <div class="title belle-allure"> Corpus en sauce</div>
            <div class="subtitle belle-allure">&laquo; <i>  Construisons ensemble des resources linguistiques pour l'alsacien&nbsp;!</i>&raquo;</div>
        </div>
        <div class="col-md-3 sidehead right belle-allure" >
            @if (Auth::check())
            <span style="text-align:center; border-width:1px; border-style:double; border-color:white; padding: 1em;float: right !important; ">
                <span style="transform: translate(-120%, -3%);"> @component('users._avatar', ['user' => Auth::user()])
                    @endcomponent </span>
                Mes statistiques
                <hr style="height:1px;color: white; background-color: whitesmoke; width: 50%;">
                <span class="score">{{ Auth::user()->getScore() }}</span> points<br/>
                {{ $nb_recipes_user }}  recettes <br>
                {{ $nb_annotations }}  mots annotés <br>
                {{ $nb_variantes_user }}  mots alternatifs proposés<br>
                
            </span>
            @endif


        </div>
    </div>
</div>
<!-- /container -->
<div class="navbar affix-top dark-background-colored py-0" style="width: 95%;margin:0 auto; margin-bottom: 1%" data-spy="affix" data-offset-top="150" >
    <div class="container">
        <ul class="navbar-nav mt-2 mt-lg-0">
            <li class="nav-item">
                <a class="btn btn-link" href="{{ route('home') }}">
                    <i class="fa fa-home" aria-hidden="true"></i> Accueil
                </a>
            </li>
        </ul>
        @if(Auth::check())
        <div class="dropdown">
            <a href="#" class="btn btn-link dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                @component('users._avatar', ['user' => Auth::user()])
                @endcomponent
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

        
            @if (!Auth::check())
                <a class="btn btn-link" href="{{ url('/login') }}">
                    Connexion
                </a>
                <a class="btn btn-link" href="{{ url('/register') }}">
                    Inscription
                </a>
            @endif


        <ul>
            <li class="nav-item">
                {!! Form::open(['route' => 'recipes.search', 'method' => 'get']) !!}
                <div class="d-flex flex-row justify-content-md-center">
                    <div class="mr-3">
                        <input type="text" name="search" class="form-control" placeholder="Trouver une recette..." />
                    </div>
                    <div class="mr-3">
                        <button type="submit" class=" btn btn link" style="color:white; background-color: black; border-color:white; border-width: 1px  "><i class="fa fa-search"></i></button>
                    </div>
                </div>
                {!! Form::close() !!}
            </li>
        </ul>
        <a class="btn btn-link" href="{{ route('contact') }}">
            <i class="fa fa-envelope-o" aria-hidden="true"></i> Contact  </a>

        <a class="btn btn-link" href="{{ route('info') }}">
            <i class="fa fa-question" aria-hidden="true"></i>  </a>
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
        </ul>    
        @endif

    </div>
</div>

<!-- navbar -->
