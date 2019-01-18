<link href="{{ asset('/css/welcome.css') }}" rel="stylesheet">


@extends('layouts.app')


@section('content')
<div class="container-fluid" style="max-width: 95%; margin: 0 auto;">
    <!--{{-- @include ('recipes/_search') --}}-->
    <div class="row mt-4 mb-4"  style="background-color:transparent">
        <div class="col-12">
            <div class="card"  style="background-color:transparent; border-style: none">
                
                <div class="row">
                    <div class="col-md-3">
                        <!--<img src="/images/recette-du-jour.png" class="w-100">-->
                        <div class="card background-colored fancy-border">
                            <h4 class="card-header text-center welcome-card-header"><a>Recette du jour</a></h4>
                            <div class="card-body">
                                @each('recipes/_show-day', $recipe_of_the_day, 'recipe', 'recipes/_empty')
                            </div>
                        </div>
                        <br>
                        <div class="card background-colored fancy-border">
                            <h4 class="card-header text-center welcome-card-header"><a href="{{ route('recipes.index') }}">{{ __('recipes.to-annotate') }}</a></h4>
                            <div class="card-body">
                                @each('recipes/_show-welcome_1', $recipes_to_annotate, 'recipe', 'recipes/_empty')
                            </div>
                            <div class="card-footer text-center">
                                <a href="{{ route('recipes.create') }}" class="btn play-button active-button">Ajouter une recette</a>
                            </div>        
                        </div>
                        <!--</div>-->
                    </div>
                    <div class="col-md-6"  >
                        <div class="card background-colored fancy-border">
                            <div id="wordcloud" class="card-body">
                                @include('info.wordcloud')
                            </div>
                        </div>
                        <br>

                        {{--                                <h4 class="card-header welcome-card-header"><a href="{{ route('recipes.to-annotate') }}">{{ __('recipes.to-annotate') }}</a></h4>
                        <div class="card-body">
                            @each('recipes/_show-welcome_1', $recipes_to_annotate, 'recipe', 'recipes/_empty')
                        </div>
                        <div class="card-footer text-center">
                            <a href="{{ route('recipes.to-annotate') }}" class="btn play-button active-button">Voir toutes les recettes</a>
                        </div>        --}}
                        
                        <br>
                        <div class="card background-colored fancy-border">
                            <h3 class="card-header text-center belle-allure" style="background-color: transparent; border-bottom-color: transparent">
                                <a>Aujourd'hui, je contribue ! 
                                    
                                    
                                </a>
                            </h3>
                            <a class="btn" style="text-align: center;"onclick="document.getElementById('slider').classList.toggle('open');">Plus d'informations <i class="fa fa-question" aria-hidden="true"></i></a>
                            
                            <div class="card-body"  >
                                
                                <div id="slider" class="slider">
                                    <span class="belle-allure"> Recettes de Grammaire </span> est une plateforme collaborative qui recueille :
                                    <br>
                                    
                                    <!-- Fonctionnalité annotation : décommenter ci-dessous -->
                                    
                                    <ol>
                                        <li>Des <span class="belle-allure"> recettes de cuisine  </span> (<b> {{ trans('home.precision_langue') }}</b> &nbsp;!) </li>
                                        <li>Des <span class="belle-allure"> annotations grammaticales </span>  servant à développer de nouveaux outils pour le traitement automatique {{ trans('home.langue-de') }}</li>
                                        <li>Des <span class="belle-allure"> variantes {{ trans('home.variantes-types') }} </span> permettant un meilleur traitement de la variation en {{ trans('home.langue-sans-art') }} </li>
                                    </ol>
                                    
                                    <!-- Fonctionnalité annotation : commenter ci-dessous -->
                                    
                                    <!-- <ol>
                                        <li>Des <span class="belle-allure"> recettes de cuisine  </span> (<b> {{ trans('home.precision_langue') }}</b> &nbsp;!) </li>
                                        <li>Des <span class="belle-allure"> variantes {{ trans('home.variantes-types') }} </span> permettant un meilleur traitement de la variation en {{ trans('home.langue-sans-art') }} </li>
                                         à commenter éventuellement 
                                        <li><i>Prochainement :</i> Des <span class="belle-allure"> annotations grammaticales </span>  servant à développer de nouveaux outils pour le traitement automatique {{ trans('home.langue-de') }}</li>
                                    </ol>-->
                                    <!-- Fonctionnalité annotation -->
                                    
                                    <!--</div>-->
                                    <hr style="margin-left: 25%;height:1px;color: white; color:black;background-color: black; width: 50%;">
                                    
                                </div>
                                
                                <div class="row" style="text-align:center">
                                    
                                    <div class="col-md-4"  >
                                        <a href="{{ route('recipes.create') }}" class="btn play-button active-button" > Nouvelle recette</a> <br> <br>
                                        <div class="belle-allure"> Je partage une recette {{ trans('home.precision_langue') }}</div> 
                                    </div>                                    
                                    
                                    <!-- Fonctionnalité annotation : décommenter ci-dessous -->
                                    
                                    <div class="col-md-4"  >
                                        <a  href="{{ route('recipes.to-annotate') }}" class="btn play-button active-button" >Annoter des recettes</a> <br>  <br>
                                        <!--<a  href="{{ route('recipes.to-validate') }}" class="btn play-button active-button" >Valider des recettes</a> <br>  <br>-->
                                        <div class="belle-allure"> J'aide la science grâce à mes connaissances</div> <br>
                                    </div>
                                    
                                    <!-- Fonctionnalité annotation : commenter ci-dessous -->
                                    
                                    {{-- <div class="col-md-4"  >
                                                <a  href="{{ route('recipes.to-annotate') }}" class="btn play-button inactive-button disabled" >Annoter des recettes</a> <br>  <br>
                                    <!--<a  href="{{ route('recipes.to-validate') }}" class="btn play-button active-button" >Valider des recettes</a> <br>  <br>-->
                                    (inactif pour l'instant)
                                    <div class="belle-allure"> J'aide la science grâce à mes connaissances</div> <br>
                                </div> --}}
                                
                                <!-- Fonctionnalité annotation -->
                                
                                <div class="col-md-4"  >
                                    <a href="{{ route('recipes.add-alt-version') }}" class="btn play-button active-button" >J'ajoute des variantes</a> <br> <br>
                                    <div class="belle-allure"> J'aurais dit ça autrement&nbsp;!</div> <br>
                                </div>
                                
                            </div>
                            <div class="row" style="text-align:center">
                                <div class="col-md-4"  >
                                    <img src="{{ asset('images/recette-black.png') }}" class="w-25"> <br>
                                </div>                                    
                                <div class="col-md-4"  >
                                    <img src="{{ asset('images/recette-black-ann.png') }}" class="w-25">
                                </div>
                                <div class="col-md-4"  >
                                    <img src="{{ asset('images/recette-var.png') }}" class="w-25">
                                </div>
<!--                                <div class="col-md-12" style="padding: 1.25rem" >
                                    <span style="font-weight: bold; color:red ; font-size: 1.5rem">NOUVEAU <i class="fa fa-arrow-right"></i> </span> <a href="{{ route('alternative-participation') }}" class="btn play-button active-button alert-button" >Je n'ai pas de recette en {{ trans('home.langue-sans-art') }} mais je souhaite contribuer !</a> 
                                    <span style="font-weight: bold; color:red ; font-size: 1.5rem"> <i class="fa fa-arrow-left"></i> NOUVEAU </span>
                                </div>-->
                            </div>
                        </div>
                        <!--</div>-->  
                        <br>
                        
                        
                    </div>
                    
                </div>
                
                
                <div class="col-md-3">
                                            <div class="card background-colored fancy-border">
                            
                            <div id="wordcloud" class="card-body">
                                @include('info.personal_wordcloud')</div>
                        </div> 
                    <br>
                    
                    
                    <div class="card background-colored fancy-border">
                        <h4 class="card-header text-center belle-allure" style="background-color: transparent; border-bottom-color: transparent"><a>Classements</a></h4>
                        <ul class="nav nav-tabs" id="scoreboards">
                            <!-- Fonctionnalité annotation : décommenter ci-dessous -->
                            <li class="nav-item" style="font-size: 1em;" ><a class="nav-link "  data-toggle="pill" style="color:black" href="#recipes"> Recettes </a></li>
                            <li class="nav-item" style="font-size: 1em;" ><a class="nav-link active" data-toggle="pill" style="color:black" href="#annotations"> Annotations </a></li>
                            <!-- Fonctionnalité annotation : commenter ci-dessous -->
                            <!--<li class="nav-item" style="font-size: 1em;" ><a class="nav-link active"  data-toggle="pill" style="color:black" href="#recipes"> Recettes </a></li>-->
                            <!-- Fonctionnalité annotation -->
                            <li class="nav-item"><a class="nav-link" data-toggle="pill" style="color:black; font-size: 1em" href="#variantes" > Variantes </a></li>
                            
                        </ul>
                        
                        <div class="tab-content">
                            <div id="recipes" class="tab-pane in active">
                                <div class="scoreboard_pannel">
                                    <div class="score" style="color:black;">
                                        @foreach($top5_nb_recipes as $key=>$user)
                                        @if($key == 0)
                                        <div  style="font-size: 2em;"> {{$key + 1}}.  @component('users._avatar', ['user' => $user])@endcomponent {{$user->name}} ({{intval($user->recipe_count)}}&nbsp;recettes)
                                        </div>
                                        
                                        @else
                                        <div  style="font-size: 1.5em;"> {{$key + 1}}. @component('users._avatar', ['user' => $user])@endcomponent {{$user->name}} ({{intval($user->recipe_count)}}&nbsp;recettes)
                                        </div>
                                        
                                        @endif
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <!-- Fonctionnalité annotation : décommenter ci-dessous -->
                            
                            <div id="annotations" class="tab-pane" >
                                <div class="scoreboard_pannel">
                                    <div class="score" style="color:black;">
                                        @foreach($top5_annotations as $key=>$user)
                                        @if($key == 0)
                                        <div  style="font-size: 2em;"> {{$key + 1}}. @component('users._avatar', ['user' => $user])@endcomponent {{$user->name}} ({{intval($user->quantity)}}&nbsp;annotations)
                                        </div>
                                        
                                        @else
                                        <div  style="font-size: 1.5em;"> {{$key + 1}}. @component('users._avatar', ['user' => $user])@endcomponent {{$user->name}} ({{intval($user->quantity)}}&nbsp;annotations)
                                        </div>
                                        
                                        @endif
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <!-- Fonctionnalité annotation -->
                            
                            <div id="variantes" class="tab-pane">
                                <div class="scoreboard_pannel">
                                    <div class="score" style="color:black;">
                                        @foreach($top5_variantes as $key=>$user)
                                        @if($key == 0)
                                        <div  style="font-size: 2em;"> {{$key + 1}}. @component('users._avatar', ['user' => $user])@endcomponent {{$user->name}} ({{intval($user->quantity)}}&nbsp;variante(s))
                                        </div>
                                        
                                        @else
                                        <div  style="font-size: 1.5em;"> {{$key + 1}}. @component('users._avatar', ['user' => $user])@endcomponent {{$user->name}} ({{intval($user->quantity)}}&nbsp;variante(s)
                                        </div>
                                        
                                        @endif
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                    <!-- Fonctionnalité annotation : décommenter ci-dessous -->
                    
                    <div class="card background-colored fancy-border">
                        <h4 class="card-header text-center belle-allure" style="background-color: transparent; border-bottom-color: transparent">
                            <a href="{{ route('recipes.to-validate') }}">{{ __('recipes.to-validate') }}</a></h4>
                        <div class="card-body">
                            @each('recipes/_show-welcome', $annotated_recipes, 'recipe', 'recipes/_empty')
                        </div>
                        <br>
                        <div class="card-footer text-center">
                            <a href="{{ route('recipes.to-validate') }}" class="btn play-button active-button">Voir toutes les recettes</a>
                        </div>        
                    </div>
                    <!-- Fonctionnalité annotation -->
                </div>
            </div>
        </div>
    </div>
</div>
</div>



@endsection

