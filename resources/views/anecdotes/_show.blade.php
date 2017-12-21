<div class="anecdote mb-4">
	<label>{{ __('recipes.anecdote-by',['name'=>$anecdote->author->name]) }}</label>
	<div class="translatable" data-id="{{ $anecdote->id }}" data-type="App\Anecdote" data-attribute="content">{!! e($anecdote->content) !!}</div>
	<a class="float-right report link" href="#">signaler</a>
</div>