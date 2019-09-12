<!-- Fonctionnalité annotation : décommenter ci-dessous -->

@if(Route::currentRouteName()=='freetexts.favorite')
	<div class="card mb-2">
	<h5 class="card-header text-center welcome-card-header"><a href="{{ route('freetexts.to-annotate') }}">{{ __('freetexts.to-annotate') }}</a></h5>
		<div class="card-body">
			@each('freetexts/_show-welcome', $freetexts_to_annotate, 'freetext', 'freetexts/_empty')
		</div>
	    <div class="card-footer text-right">
	      <a href="{{ route('freetexts.to-annotate') }}" class="">Voir toutes les recettes à annoter</a>
	    </div>
	</div>
@endif

@if(Route::currentRouteName()=='freetexts.favorite')
<div class="card mb-2">
<h5 class="card-header text-center welcome-card-header"><a href="{{ route('freetexts.to-validate') }}">{{ __('freetexts.to-validate') }}</a></h5>
	<div class="card-body">
		@each('freetexts/_show-welcome', $annotated_freetexts, 'freetext', 'freetexts/_empty')
	</div>
    <div class="card-footer text-right">
      <a href="{{ route('freetexts.to-validate') }}" class="">Voir toutes les recettes à valider</a>
    </div>
</div>
@endif

<div class="card mb-2">
<h5 class="card-header text-center welcome-card-header">Recettes annotées</h5>
	<div class="card-body">
		@each('freetexts/_show-welcome', $validated_freetexts, 'freetext', 'freetexts/_empty')
	</div>
</div>
<!-- Fonctionnalité annotation -->
