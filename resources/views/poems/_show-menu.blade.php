<!-- Fonctionnalité annotation : décommenter ci-dessous -->
<div>
	<a class="btn btn-primary float-right" href="{{ route('poems.annotations', $poem) }}">Annoter</a>
    <h4>{{ link_to_route('poems.show', $poem->title, $poem) }}</h4>
</div>
<!-- Fonctionnalité annotation -->

<p class="card-text">
	<span class="text-muted">
		{{ __('poems.poem-by') }}
		@if($poem->author->trashed())
			{{ $poem->author->name }}
		@else
			{{ link_to_route('users.show', $poem->author->name, $poem->author) }}
		@endif			
	</span>
</p>
