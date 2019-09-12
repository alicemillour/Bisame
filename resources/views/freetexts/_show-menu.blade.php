<!-- Fonctionnalité annotation : décommenter ci-dessous -->
<div>
	<a class="btn btn-primary float-right" href="{{ route('freetexts.annotations', $freetext) }}">Annoter</a>
    <h4>{{ link_to_route('freetexts.show', $freetext->title, $freetext) }}</h4>
</div>
<!-- Fonctionnalité annotation -->

<p class="card-text">
	<span class="text-muted">
		{{ __('freetexts.freetext-by') }}
		@if($freetext->author->trashed())
			{{ $freetext->author->name }}
		@else
			{{ link_to_route('users.show', $freetext->author->name, $freetext->author) }}
		@endif			
	</span>
</p>
