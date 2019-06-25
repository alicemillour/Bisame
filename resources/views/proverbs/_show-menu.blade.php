<!-- Fonctionnalité annotation : décommenter ci-dessous -->
<div>
	<a class="btn btn-primary float-right" href="{{ route('proverbs.annotations', $proverb) }}">Annoter</a>
    <h4>{{ link_to_route('proverbs.show', $proverb->title, $proverb) }}</h4>
</div>
<!-- Fonctionnalité annotation -->

<p class="card-text">
	<span class="text-muted">
		{{ __('proverbs.proverb-by') }}
		@if($proverb->author->trashed())
			{{ $proverb->author->name }}
		@else
			{{ link_to_route('users.show', $proverb->author->name, $proverb->author) }}
		@endif			
	</span>
</p>
