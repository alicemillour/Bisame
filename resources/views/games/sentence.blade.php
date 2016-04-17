@foreach($sentence->words as $word)
	<div class="word-container">
		<div class="word" id="{{ $word->id }}" value="{{$word->value}}">{{ $word->value }}</div>
		<div class="category"> </div>
	</div>
@endforeach