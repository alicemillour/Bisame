@if(Route::currentRouteName()!='recipes.to-annotate')
	<div class="card mb-2">
	<h5 class="card-header text-center welcome-card-header"><a href="{{ route('recipes.to-annotate') }}">{{ __('recipes.to-annotate') }}</a></h5>
		<div class="card-body">
			@each('recipes/_show-welcome', $recipes_to_annotate, 'recipe', 'recipes/_empty')
		</div>
	    <div class="card-footer text-right">
	      <a href="{{ route('recipes.to-annotate') }}" class="">Voir toutes les recettes à annoter</a>
	    </div>
	</div>
@endif

@if(Route::currentRouteName()!='recipes.to-validate')
<div class="card mb-2">
<h5 class="card-header text-center welcome-card-header"><a href="{{ route('recipes.to-validate') }}">{{ __('recipes.to-validate') }}</a></h5>
	<div class="card-body">
		@each('recipes/_show-welcome', $annotated_recipes, 'recipe', 'recipes/_empty')
	</div>
    <div class="card-footer text-right">
      <a href="{{ route('recipes.to-validate') }}" class="">Voir toutes les recettes à valider</a>
    </div>
</div>
@endif

<div class="card mb-2">
<h5 class="card-header text-center welcome-card-header">Recettes annotées</h5>
	<div class="card-body">
		@each('recipes/_show-welcome', $validated_recipes, 'recipe', 'recipes/_empty')
	</div>
</div>