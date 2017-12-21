@extends('layouts.app')

@section('content')
<div class="container-fluid">
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
        <h4 class="card-header text-center"><a href="{{ route('recipes.index') }}">{{ __('recipes.app-name') }}</a></h4>
        <div class="card-body">
          {{-- <div class="">{{ __('recipes.text-intro') }}</div> --}}
          <div class="text-center btn-wrapper">
            <a href="{{ route('recipes.create') }}" class="btn btn-primary">{{ __('recipes.new-recipe') }}</a>
            <a href="{{ route('recipes.index') }}" class="btn btn-primary mt-lg-3 mt-xl-0">Consulter les recettes</a>
          </div>
          <hr/>
          <h4 class="card-text">{{ __('recipes.last-recipes') }}</h4>

          @forelse ($recipes as $recipe)
            <h6 class="card-subtitle mb-1 text-muted">{{ link_to_route('recipes.show', $recipe->title, $recipe, ['class' => 'card-link' ]) }}</h6>
            <small class="text-muted">
              @component('users._avatar', ['user' => $recipe->author])

              @endcomponent
              {{ __('recipes.recipe-by') }}
              {{ link_to_route('users.show', $recipe->author->name, $recipe->author) }}
            </small>
            <br/>
            <p class="card-text text-truncate mb-0">{{ $recipe->content }}</p>
            <p class="text-right"><a class="" href="{{ route('recipes.show',$recipe) }}">lire la suite...</a></p>
            <hr/>
          @empty
              <p class="card-text">Aucune recette</p>
          @endforelse 
          
        </div>
      </div>
    </div>
    <div class="col-sm-4">
      <div class="card">
        <h4 class="card-header text-center"><a href="#">{{ __('improvisation-game.app-name') }}</a></h4>
        <div class="card-body text-center">
          <p class="card-text">{{ __('improvisation-game.text-intro') }}</p>
        </div>
      </div>
    </div>
    <div class="col-sm-4">
    <div class="card">
      <h4 class="card-header text-center"><a href="{{ route('home-game') }}">{{ __('game.app-name') }}</a></h4>
      <div class="card-body text-center">
        <div class="card-text">{{ __('game.text-intro') }}</div>
        <a href="{{ route('home-game') }}" class="card-link btn btn-primary mt-3">Participer</a>  
      </div>
    </div>
    </div>
</div>
</div>
@endsection