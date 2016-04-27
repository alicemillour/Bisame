@if($game_everything_is_annotated)
    <div id=message-content>Merci d'avoir annoté tous les mots de la phrase précédente ! </div>
@endif

@foreach($sentence->words as $word)
	<div class="word-container">
		<div class="word" id="{{ $word->id }}" value="{{$word->value}}">{{ $word->value }}</div>
		<div class="category"> </div>
	</div>
@endforeach
<div class="progress">
    <div class="progress-bar" role="progressbar" aria-valuenow="{{$progression}}"
    aria-valuemin="0" aria-valuemax="100" style="width:{{$progression}}%">
    <span>Phrase n°{{$game->sentence_index+1}} sur 4</span>
    </div>
</div>