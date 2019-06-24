<!-- Fonctionnalité annotation : décommenter ci-dessous -->

@if(Route::currentRouteName()=='poems.favorite')
	<div class="card mb-2">
	<h5 class="card-header text-center welcome-card-header"><a href="{{ route('poems.to-annotate') }}">{{ __('poems.to-annotate') }}</a></h5>
		<div class="card-body">
			@each('poems/_show-welcome', $poems_to_annotate, 'poem', 'poems/_empty')
		</div>
	    <div class="card-footer text-right">
	      <a href="{{ route('poems.to-annotate') }}" class="">Voir toutes les recettes à annoter</a>
	    </div>
	</div>
@endif

@if(Route::currentRouteName()=='poems.favorite')
<div class="card mb-2">
<h5 class="card-header text-center welcome-card-header"><a href="{{ route('poems.to-validate') }}">{{ __('poems.to-validate') }}</a></h5>
	<div class="card-body">
		@each('poems/_show-welcome', $annotated_poems, 'poem', 'poems/_empty')
	</div>
    <div class="card-footer text-right">
      <a href="{{ route('poems.to-validate') }}" class="">Voir toutes les recettes à valider</a>
    </div>
</div>
@endif

<div class="card mb-2">
<h5 class="card-header text-center welcome-card-header">Recettes annotées</h5>
	<div class="card-body">
		@each('poems/_show-welcome', $validated_poems, 'poem', 'poems/_empty')
	</div>
</div>
<!-- Fonctionnalité annotation -->
