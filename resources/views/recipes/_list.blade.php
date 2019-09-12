<div class="card-columns">
    @each('recipes/_show', $recipes, 'recipe', 'recipes/_empty')
</div>

<div class="d-flex justify-content-center">
    {{ $recipes->links() }}
</div>

