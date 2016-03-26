@foreach($sentence->words as $word)
	<div class="word-container">
		<div class="word" id="{{ $word->id }}">{{ $word->value }}</div>
		<div class="category"> </div>
	</div>
@endforeach