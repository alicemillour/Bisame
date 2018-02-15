<div class="card mb-2">
<h5 class="card-header text-center"><a href="{{ route('recipes.to-annotate') }}">{{ __('recipes.to-annotate') }}</a></h5>
	<div class="card-body">
		@each('recipes/_show-menu', $recipes_to_annotate, 'recipe', 'recipes/_empty')
	</div>
    <div class="card-footer text-right">
      <a href="{{ route('recipes.to-annotate') }}" class="">Voir toutes les recettes à annoter</a>
    </div>
</div>

<div class="card mb-2">
<h5 class="card-header text-center"><a href="{{ route('recipes.to-validate') }}">{{ __('recipes.to-validate') }}</a></h5>
	<div class="card-body">
		@each('recipes/_show-menu', $annotated_recipes, 'recipe', 'recipes/_empty')
	</div>
    <div class="card-footer text-right">
      <a href="{{ route('recipes.to-validate') }}" class="">Voir toutes les recettes à valider</a>
    </div>
</div>

<div class="card mb-2">
<h5 class="card-header text-center">Recettes annotées</h5>
	<div class="card-body">
		@each('recipes/_show-menu', $validated_recipes, 'recipe', 'recipes/_empty')
	</div>
</div>