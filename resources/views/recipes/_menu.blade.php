<div class="card mb-2">
<h5 class="card-header text-center">Recettes à annoter</h5>
	<div class="card-body">
		@each('recipes/_show-menu', $recipes_to_annotate, 'recipe', 'recipes/_empty')
	</div>
</div>

<div class="card mb-2">
<h5 class="card-header text-center">Recettes à valider</h5>
	<div class="card-body">
		@each('recipes/_show-menu', $annotated_recipes, 'recipe', 'recipes/_empty')
	</div>
</div>

<div class="card mb-2">
<h5 class="card-header text-center">Recettes annotées</h5>
	<div class="card-body">
		@each('recipes/_show-menu', $validated_recipes, 'recipe', 'recipes/_empty')
	</div>
</div>