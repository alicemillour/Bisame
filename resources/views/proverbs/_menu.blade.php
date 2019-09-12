<!-- Fonctionnalité annotation : décommenter ci-dessous -->

@if(Route::currentRouteName()=='proverbs.favorite')
	<div class="card mb-2">
	<h5 class="card-header text-center welcome-card-header"><a href="{{ route('proverbs.to-annotate') }}">{{ __('proverbs.to-annotate') }}</a></h5>
		<div class="card-body">
			@each('proverbs/_show-welcome', $proverbs_to_annotate, 'proverb', 'proverbs/_empty')
		</div>
	    <div class="card-footer text-right">
	      <a href="{{ route('proverbs.to-annotate') }}" class="">Voir tous les proverbes à annoter</a>
	    </div>
	</div>
@endif

@if(Route::currentRouteName()=='proverbs.favorite')
<div class="card mb-2">
<h5 class="card-header text-center welcome-card-header"><a href="{{ route('proverbs.to-validate') }}">{{ __('proverbs.to-validate') }}</a></h5>
	<div class="card-body">
		@each('proverbs/_show-welcome', $annotated_proverbs, 'proverb', 'proverbs/_empty')
	</div>
    <div class="card-footer text-right">
      <a href="{{ route('proverbs.to-validate') }}" class="">Voir tous les proverbes à valider</a>
    </div>
</div>
@endif

<div class="card mb-2">
<h5 class="card-header text-center welcome-card-header">Recettes annotées</h5>
	<div class="card-body">
		@each('proverbs/_show-welcome', $validated_proverbs, 'proverb', 'proverbs/_empty')
	</div>
</div>
<!-- Fonctionnalité annotation -->
