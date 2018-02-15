@extends('layouts.app')

@section('content')
<div class="container-fluid">
@include ('recipes/_search')
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
          <a href="{{ route('recipes.index') }}" class="btn btn-primary mt-lg-3 mt-xl-0">Consulter les recettes</a>
        </div>        
      </div>
    </div>
    <div class="col-sm-4">
      <div class="card">
        <h4 class="card-header text-center"><a href="{{ route('recipes.index') }}">Recettes à annoter</a></h4>
        <div class="card-body">
          @each('recipes/_show-welcome', $recipes_to_annotate, 'recipe', 'recipes/_empty')
        </div>
{{--         <div class="card-foote text-centerr">
          <a href="{{ route('recipes.index') }}" class="btn btn-primary mt-lg-3 mt-xl-0">Consulter les recettes</a>
        </div>  --}}       
      </div>
    </div>
    <div class="col-sm-4">
      <div class="card">
        <h4 class="card-header text-center"><a href="{{ route('recipes.index') }}">Recettes à valider</a></h4>
        <div class="card-body">
          @each('recipes/_show-welcome', $annotated_recipes, 'recipe', 'recipes/_empty')
        </div>
{{--         <div class="card-footer text-center">
          <a href="{{ route('recipes.index') }}" class="btn btn-primary mt-lg-3 mt-xl-0">Consulter les recettes</a>
        </div>  --}}       
      </div>
    </div>
</div>
</div>
@endsection