@extends('layouts.app')

@section('content')

	<h1 class="text-center">{{ $user->name }}</h1>

	<div class="row">
		<div class="col-lg-6">
			<div class="card">
				<div class="card-body">
					<h3 class="card-title">Badges</h3>
					<p class="card-text">
						@include('users/_badges')
					</p>
				</div>
			</div>
		</div>
		<div class="col-lg-6 pt-3 pt-lg-0">
			<div class="card">
			<div class="card-body">
				<h3 class="card-title">Statistiques</h3>
			</div>
			</div>
		</div>
		<div class="col-lg-6 pt-3 pt-lg-0">
		<div class="card mt-3">
			<div class="card-body">
				<h3 class="card-title">{{ __('recipes.last-recipes') }}</h3>

				@forelse ($recipes as $recipe)
					<h6 class="card-subtitle mb-1 text-muted">{{ link_to_route('recipes.show', $recipe->title, $recipe, ['class' => 'card-link' ]) }}</h6>
				    <p class="card-text text-truncate">{{ $recipe->content }}</p>
				    
				@empty
				    <p class="card-text">Vous n'avez pas encore saisi de recette</p>
				@endforelse	
				<a href="{{ route('recipes.create') }}" class="card-link">{{ __('recipes.new-recipe') }}</a>
			</div>
		</div>
		</div>
		
	</div>

@endsection
