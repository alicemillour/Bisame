<!--<link href="{{ asset('/css/welcome.css') }}" rel="stylesheet">--> 
@extends('layouts.app')


@section('content')
<div class="container-fluid">
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
                            <h4 class="card-header text-center welcome-card-header"><a href="{{ route('recipes.index') }}">{{ __('recipes.last-recipes') }}</a></h4>
                            <div class="card-body">
                                @each('recipes/_show-welcome', $recipes, 'recipe', 'recipes/_empty')
                            </div>
                            <div class="card-footer text-center">
                                <a href="{{ route('recipes.create') }}" class="btn play-button active-button">Ajouter une recette</a>
                            </div>        
                        </div>
                        <!--</div>-->
                    </div>
                    <div class="col-md-6 px-3">
                        <div class="card background-colored fancy-border">
                            <h3 class="card-header text-center belle-allure" style="background-color: transparent; border-bottom-color: transparent">
                                <a>Aujourd'hui, je contribue !
                                    <!--<button class="btn btn-link" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                    <i class="fa fa-question" aria-hidden="true"></i> 
                                    </button>-->
                                </a>
                            </h3>
                            <!--<div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">-->
                            <div class="card-body">
                                <span class="belle-allure"> Corpus en sauce </span> est une plateforme collaborative qui recueille :
                                <br>
                                <ol>
                                    <li>Des <span class="belle-allure"> recettes de cuisine  </span> (<b> ùf elsassisch&nbsp;! </b>) </li>
                                    <li>Des <span class="belle-allure"> annotations grammaticales </span>  servant à développer de nouveaux outils pour le traitement automatique de l'alsacien</li>
                                    <li>Des <span class="belle-allure"> variantes orthographiques ou dialectales </span> permettant un meilleur traitement de la variation en alsacien </li>
                                </ol>
                            </div>
                            <!--</div>-->
                            <hr style="margin-left: 25%;height:1px;color: white; color:black;background-color: black; width: 50%;">

                            <div class="card-body">

                                <div class="row" style="text-align:center">

                                    <div class="col-md-4"  >
                                        <a href="{{ route('recipes.create') }}" class="btn play-button active-button" > Nouvelle recette</a> <br> <br>
                                        <div class="belle-allure"> Je partage une recette </div> 
                                    </div>                                    
                                    <div class="col-md-4"  >
                                        <a  href="{{ route('recipes.to-annotate') }}" class="btn play-button active-button" >Annoter des recettes</a> <br>  <br>
                                        <!--<a  href="{{ route('recipes.to-validate') }}" class="btn play-button active-button" >Valider des recettes</a> <br>  <br>-->
                                        <div class="belle-allure"> J'aide la science grâce à mes connaissances</div> <br>
                                    </div>

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
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-6"  >
                                <div class="card background-colored fancy-border">
                                    <h4 class="card-header welcome-card-header"><a href="{{ route('recipes.to-annotate') }}">{{ __('recipes.to-annotate') }}</a></h4>
                                    <div class="card-body">
                                        @each('recipes/_show-welcome', $recipes_to_annotate, 'recipe', 'recipes/_empty')
                                    </div>
                                    <div class="card-footer text-center">
                                        <a href="{{ route('recipes.to-annotate') }}" class="btn play-button active-button">Voir toutes les recettes</a>
                                    </div>        
                                </div>
                            </div>
                            <div class="col-md-6"  >
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
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <!--<img src="/images/recette-du-jour.png" class="w-100">-->
                        <div class="card background-colored fancy-border">
                            <h4 class="card-header text-center belle-allure" style="background-color: transparent; border-bottom-color: transparent"><a>Classements</a></h4>
                            <ul class="nav nav-tabs" id="scoreboards">
                                <li class="nav-item" style="font-size: 1em;" ><a class="nav-link active"  data-toggle="pill" style="color:black" href="#recipes"> Recettes </a></li>
                                <li class="nav-item" style="font-size: 1em;" ><a class="nav-link" data-toggle="pill" style="color:black" href="#annotations"> Annotations </a></li>
                                <li class="nav-item"><a class="nav-link" data-toggle="pill" style="color:black; font-size: 1em" href="#variantes" > Variantes </a></li>
                            </ul>

                            <div class="tab-content">
                                <div id="recipes" class="tab-pane in active">
                                    <div style="text-align: center; margin-top: 5px;">
                                        <div class="score" style="color:black;text-align: center;">
                                            @foreach($top5_nb_recipes as $key=>$user)
                                            @if($key == 0)
                                            <div  style="text-align: center; font-size: 1.5em;"> {{$key + 1}}. {{$user->name}} ({{intval($user->recipe_count)}}&nbsp;recettes)
                                            </div>

                                            @else
                                            <div  style="text-align: center; font-size: 1em;"> {{$key + 1}}. {{$user->name}} ({{intval($user->recipe_count)}}&nbsp;recettes)
                                            </div>

                                            @endif
                                            @endforeach
                                        </div>
                                    </div>
                                </div>

                                <div id="annotations" class="tab-pane" >
                                    <div style="text-align: center; margin-top: 5px; ">
                                        <div class="score" style="color:black;text-align: center;">
                                            @foreach($top5_annotations as $key=>$user)
                                            @if($key == 0)
                                            <div  style="text-align: center; font-size: 1.5em;"> {{$key + 1}}. {{$user->name}} ({{intval($user->quantity)}}&nbsp;annotations)
                                            </div>

                                            @else
                                            <div  style="text-align: center; font-size: 1em;"> {{$key + 1}}. {{$user->name}} ({{intval($user->quantity)}}&nbsp;annotations)
                                            </div>

                                            @endif
                                            @endforeach
                                        </div>
                                    </div>
                                </div>

                                <div id="variantes" class="tab-pane">
                                    <div style="text-align: center; margin-top: 5px;">
                                        <div class="score" style="color:black; text-align: center;">
                                            @foreach($top5_variantes as $key=>$user)
                                            @if($key == 0)
                                            <div  style="text-align: center; font-size: 1.5em;"> {{$key + 1}}. {{$user->name}} ({{intval($user->quantity)}}&nbsp;variante(s))
                                            </div>

                                            @else
                                            <div  style="text-align: center; font-size: 1em;"> {{$key + 1}}. {{$user->name}} ({{intval($user->quantity)}}&nbsp;variante(s)
                                            </div>

                                            @endif
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br>

<!--                        <div class="row">
                            <div class="col-md-12">
                                <div class="card background-colored fancy-border">
                                    <h4 class="card-header text-center belle-allure" style="background-color: transparent; border-bottom-color: transparent"><a>Contributeur à l'honneur</a></h4>
                                    <div class="card-body">
                                        Eventuellement ici : le profil de la personne ayant le plus de points
                                    </div>

                                </div>
                            </div>
                        </div>-->
                    </div>
                </div>

            </div>
        </div>
        <!--=======
        {{-- @include ('recipes/_search') --}}
        <div class="row">
          <div class="col-12 mb-4">
              <div class="card">
                <h4 class="card-header text-center"><a href="{{ route('recipes.index') }}">Bienvenue sur Plural !</a></h4>
                <div class="card-body">
                  <alert>TODO : description de la plate forme PLURAL (qui sommes-nous, raison d'être et objectif de la plate-forme)</alert>
                </div>
              </div>    
          </div>
        </div>
        
        <div class="row">
            <div class="col-sm-4">
              <div class="card">
                <h4 class="card-header text-center"><a href="{{ route('recipes.index') }}">{{ __('recipes.last-recipes') }}</a></h4>
                <div class="card-body">
                  @each('recipes/_show-welcome', $recipes, 'recipe', 'recipes/_empty')
                </div>
                <div class="card-footer text-center">
                  <a href="{{ route('recipes.index') }}" class="btn btn-primary mt-lg-3 mt-xl-0">Voir toutes les recettes</a>
                </div>        
              </div>
            </div>
            <div class="col-sm-4">
              <div class="card">
                <h4 class="card-header text-center"><a href="{{ route('recipes.to-annotate') }}">{{ __('recipes.to-annotate') }}</a></h4>
                <div class="card-body">
                  @each('recipes/_show-welcome', $recipes_to_annotate, 'recipe', 'recipes/_empty')
                </div>
                <div class="card-footer text-center">
                  <a href="{{ route('recipes.to-annotate') }}" class="btn btn-primary mt-lg-3 mt-xl-0">Voir toutes les recettes</a>
                </div>        
              </div>
            </div>
            <div class="col-sm-4">
              <div class="card">
                <h4 class="card-header text-center"><a href="{{ route('recipes.to-validate') }}">{{ __('recipes.to-validate') }}</a></h4>
                <div class="card-body">
                  @each('recipes/_show-welcome', $annotated_recipes, 'recipe', 'recipes/_empty')
                </div>
                <div class="card-footer text-center">
                  <a href="{{ route('recipes.to-validate') }}" class="btn btn-primary mt-lg-3 mt-xl-0">Voir toutes les recettes</a>
                </div>        
              </div>
        >>>>>>> 08d800b80129ce3aa3cad72d3241c7191be4a8d3-->
    </div>
</div>


@endsection

