@extends('layouts.test-app')
    
    
@include('partials.test-nav')
    
    
@section('content')
<div class="container-fluid">
    {{-- @include ('recipes/_search') --}}
    <div class="row mt-4 mb-4">
        <div class="col-12">
            <div class="card">
                
                <div class="row ">
                    <div class="col-md-3" style="text-align:center">
                        <!--<img src="/images/recette-du-jour.png" class="w-100">-->
                        <div><b>Statistiques</b></div>
                        15 recettes enregistrées <br>
                        1234 annotations produites <br>
                        7 recettes validées <br>
                        
                        etc...
                    </div>
                    <div class="col-md-6 px-3">
                        <div class="card-block px-3">
                            <div class="card-body">
                            </div>
<!--                            <p class="card-text" style="text-align: center;">Partagez vos recettes alsacienne et faites avancer la recherche en renseignant des catégories grammaticales ! </p>
                            <p class="card-text">En savoir plus (?) -> explication de l'intérêt de l'annotation </p>-->
                            <div class="row ">
                                <div class="col-md-6">
                                    <div class="img-button-container">
                                        <a class="shinyup" href="{{ route('recipes.create') }}" class="btn btn-primary mt-lg-3 mt-xl-0" style="margin-left: 30%">Nouvelle recette</a>
                                        <img src="/images/new.png" alt="Snow" >
                                            
                                    </div> 
                                </div>
                                <div class="col-md-6">
                                    <div class="img-button-container">
                                        <img src="/images/help.png" alt="Snow" >
                                            
                                        <a class="shinydown" href="{{ route('recipes.create') }}" class="btn btn-primary mt-lg-3 mt-xl-0" style="margin-left: 30%">Annoter</a>
                                        <i class="ishiny"></i>
                                            
                                    </div> 
                                </div>
                            </div>
                            <div class="card-block text-xs-center">
                                <p class="card-text card-xs-center" style="text-align: center">En savoir plus (?) -> dérouler une explication de l'intérêt de l'annotation </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div><b>Leaderbord (2 onglets recettes/annotations)</b></div>
                        X a ajouté 5 recettes <br>
                        Y a ajouté 3 recettes <br>
                        Z a ajouté 1 recette <br>
                        
                        etc...
                    </div>
                </div>
            </div>
        </div>
    </div>   

    <div class="row mt-5">
        <div class="col-sm-4">
            <div class="card">
                <h4 class="card-header text-center"><a href="{{ route('recipes.index') }}">{{ __('recipes.last-recipes') }}</a></h4>
                <div class="card-body">
                    @each('recipes/_show-welcome', $recipes, 'recipe', 'recipes/_empty')
                </div>
                <div class="card-footer text-center">
                    <a href="{{ route('recipes.create') }}" class="btn btn-primary mt-lg-3 mt-xl-0">Ajouter une recette</a>
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
                    <a href="{{ route('recipes.to-annotate') }}" class="btn btn-primary mt-lg-3 mt-xl-0">Consulter les recettes</a>
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
                    <a href="{{ route('recipes.to-validate') }}" class="btn btn-primary mt-lg-3 mt-xl-0">Consulter les recettes</a>
                </div>        
            </div>
        </div>
    </div>
</div>

@endsection
