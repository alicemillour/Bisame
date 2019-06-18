<!-- Fonctionnalité annotation : décommenter ci-dessous -->
<div>
	<a class="btn btn-primary float-right" href="{{ route('recipes.annotations', $recipe) }}">Annoter</a>
    <h4>{{ link_to_route('recipes.show', $recipe->title, $recipe) }}</h4>
</div>
<!-- Fonctionnalité annotation -->

<p class="card-text">
	<span class="text-muted">
		{{ __('recipes.recipe-by') }}
		@if($recipe->author->trashed())
			{{ $recipe->author->name }}
		@else
			{{ link_to_route('users.show', $recipe->author->name, $recipe->author) }}
		@endif			
	</span>
</p>
