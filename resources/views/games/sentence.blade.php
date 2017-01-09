@if($game_everything_is_annotated)
<div id=message-content>Merci d'avoir annoté tous les mots de la phrase précédente ! </div>
@endif

@foreach($sentence->words as $word)
<div class="word-container" style="text-align:center">
    <div class="word" id="{{ $word->id }}" value="{{$word->value}}" tag="{{$pretag[$word->id]}}">{{ $word->value }}</div>
    <div class="labels" style="text-align: center ; display:block" name="category-label[{{ $word->id }}]">
        <img class="leftlabel" id="left_{{ $word->id }}" style="padding-left: 2px; padding-right: 2px; display:none" src="/images/no.png">
        <img class="question-label" id="question_{{ $word->id }}" style="padding-left: 2px; padding-right: 2px; display:none" src="/images/question.png">
        <span class="category-label" > </span>
        <img class="rightlabel" id="right_{{ $word->id }}" style="padding-left: 2px; padding-right: 2px;display: none" src="/images/check.png">
    </div>
</div>
@endforeach
<div class="progress">
    <div class="progress-bar" role="progressbar" aria-valuenow="{{$progression}}"
         aria-valuemin="0" aria-valuemax="100" style="width:{{$progression}}%">
        <span>Phrase n°{{$game->sentence_index+1}} sur 4</span>
    </div>
</div>