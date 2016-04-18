@if($game_everything_is_annotated)
    <div id=message-content>Merci d'avoir annoté tous les mots de la phrase précédente ! On recommence ?</div>
@endif

@foreach($sentence->words as $word)
	<div class="word-container">
		<div class="word" id="{{ $word->id }}" value="{{$word->value}}">{{ $word->value }}</div>
		<div class="category"> </div>
	</div>
@endforeach