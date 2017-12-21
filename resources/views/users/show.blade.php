@extends('layouts.app')

@section('content')

	<h1 class="text-center page-title">
	    @component('users._avatar', ['user' => $user])
        @endcomponent
		{{ $user->name }}

	</h1>

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
				<h3 class="card-title">{{ __('recipes.last-recipes-by', ['name'=>$user->name]) }}</h3>

				@forelse ($recipes as $recipe)
					<h6 class="card-subtitle mb-1 text-muted">{{ link_to_route('recipes.show', $recipe->title, $recipe, ['class' => 'card-link' ]) }}</h6>
				    <p class="card-text text-truncate mb-0">{{ $recipe->content }}</p>
				    <p class="card-text text-right">{{ link_to_route('recipes.show', "lire la suite", $recipe, ['class' => 'card-link' ]) }}</p>
				    <hr/>
				@empty
				    <p class="card-text">{{ $user->name }} n'a pas encore saisi de recette</p>
				@endforelse	
				<a href="{{ route('recipes.user',$user) }}" class="card-link btn-sm btn btn-primary">Toutes les recettes de {{ $user->name }}</a>
				<a href="{{ route('recipes.index') }}" class="card-link btn btn-sm btn-primary">Toutes les recettes</a>
				<a href="{{ route('recipes.create') }}" class="card-link btn btn-sm btn-primary">{{ __('recipes.new-recipe') }}</a>
			</div>
		</div>
		</div>
		
	</div>

@endsection
