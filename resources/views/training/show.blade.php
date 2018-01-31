@extends('layouts.app')

@section('content')

@php
$pos = [];
foreach($postags as $postag){
$pos[$postag->id] = $postag->name;
}  
@endphp

<div id="annotation" class="container bg-white p-3 noselect">
    <div class="row">
      <h5 id="message" class="mb-2 col-9">Voici les annotations produites par notre outil :</h5>
      <h5 id="message" class="mb-2 col-9">Validez ou invalidez les mots en surbrillance :</h5>
    </div>
    <div class="row">
      <div class="col-9" id="annotations">
        @foreach($corpus_training->sentences as $sentence)
          @foreach($sentence->words as $word)
          <div class="word_container" style="display:inline-block;text-align:center;vertical-align: top;">
            <span class="word" data-word-id="{{ $word->id }}" data-postag-id="{{ $word->annotation_melt->postag_id }}">{{ $word->value }}</span>
            <br/>
            @if($pos[$word->annotation_melt->postag_id]!="PUNCT")
              <img class="no invisible" src="{{ asset('images/no.png') }}" data-word-id="{{ $word->id }}" data-postag-id="{{ $word->annotation_melt->postag_id }}" />
              <span class="pos not-validated" data-word-id="{{ $word->id }}" data-postag-id="{{ $word->annotation_melt->postag_id }}">{{ $pos[$word->annotation_melt->postag_id] }}</span>
              <img class="check invisible" src="{{ asset('images/check.png') }}" data-word-id="{{ $word->id }}" data-postag-id="{{ $word->annotation_melt->postag_id }}"/>
            @endif
          </div>
          @endforeach
          <br/>
        @endforeach
        <div class="text-center">
          <button id="btn-next-postag" class="btn btn-warning d-none disabled btn-lg" data-toggle="tooltip" title="Validez ou invalidez tous les mots en surbrillance avant de continuer" data-placement="bottom">Postag suivant</button>
        </div>
      </div>
      <div class="col-3">
        @include ('postags/_list')
      </div>
    </div>

</div>

@endsection

@section('style')

<style>
.word_container{
  line-height: 1.1em;
  margin-bottom: 0.8em;
  font-size: 25px;
}
#annotation {
  font-size: 1.2em;
}
.list-group-item {
    padding: 0.5rem 1.25rem;
}
.pos {
  font-size: 14px;
}
.popper {
    position: absolute;
    background: white;
    color: #333;
    text-align: left;
    padding-top:0.1rem;
    padding-right:1rem;
    font-size:12px;
    padding:0px 5px;
    border:solid 1px rgba(0, 0, 0, 0.2);
}

.highlight-done {
    background-color: #E3F6CE;
}
.highlight-translated {
    background-color: #F5BCA9;
}
div.highlight-translatable, h1.highlight-translatable {
  padding: 1rem;
  background: whitesmoke;
}
td.highlight-translatable {
  padding-left: 1rem;
  padding-right: 1rem;
  background: whitesmoke;
}
.highlight, .highlight:hover {
    background-color: yellow;
}
.validated {
    background-color: #E3F6CE;
}
.recipe-ingredients {
  position: relative;
}
img.no, img.check {
  width: 20px;
}
img.no {
  /*padding-right: 4px;*/
}
img.check {
  /*padding-left: 4px;*/
}
.noselect {
  -webkit-touch-callout: none; /* iOS Safari */
    -webkit-user-select: none; /* Safari */
     -khtml-user-select: none; /* Konqueror HTML */
       -moz-user-select: none; /* Firefox */
        -ms-user-select: none; /* Internet Explorer/Edge */
            user-select: none; /* Non-prefixed version, currently
                                  supported by Chrome and Opera */
}
</style>
@endsection