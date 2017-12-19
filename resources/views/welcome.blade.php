@extends('layouts.app')

@section('content')
<div class="container-fluid">
<div class="row">
    <div class="col-sm-4">
      <div class="card">
        <h4 class="card-header text-center"><a href="{{ route('recipes.index') }}">{{ __('recipes.app-name') }}</a></h4>
        <div class="card-body">
          <div class="">{{ __('recipes.text-intro') }}</div>
          <a href="{{ route('recipes.create') }}" class="card-link">{{ __('recipes.new-recipe') }}</a>
          <a href="{{ route('recipes.index') }}" class="card-link">Consulter les recettes</a>           
          <hr/>
          <h4 class="card-text">{{ __('recipes.last-recipes') }}</h4>

          @forelse ($recipes as $recipe)
            <h6 class="card-subtitle mb-1 text-muted">{{ link_to_route('recipes.show', $recipe->title, $recipe, ['class' => 'card-link' ]) }}</h6>
              <p class="card-text text-truncate">{{ $recipe->content }}</p>
              
          @empty
              <p class="card-text">Aucune recette</p>
          @endforelse 
       
        </div>
      </div>
    </div>
    <div class="col-sm-4">
      <div class="card">
        <h4 class="card-header text-center"><a href="#">{{ __('improvisation-game.app-name') }}</a></h4>
        <div class="card-body">
          <p class="card-text">{{ __('improvisation-game.text-intro') }}</p>
        </div>
      </div>
    </div>
    <div class="col-sm-4">
    <div class="card">
      <h4 class="card-header text-center"><a href="{{ route('annotator') }}">{{ __('game.app-name') }}</a></h4>
      <div class="card-body">
        <div class="card-text">{{ __('game.text-intro') }}</div>
      </div>
    </div>
    </div>
</div>
</div>
@endsection