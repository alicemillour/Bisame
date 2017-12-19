@extends('layouts.app')
@section('style')
<link target="_blank" href="{{ asset('css/game.css') }}" rel="stylesheet" type="text/css" >
@endsection
@section('scripts')
<!--<script type="text/javascript" src="{{ asset('js/game.js') }}"></script>-->
<script type="text/javascript" src="{{ asset('js/game.js') }}">
</script>
@endsection
@section('content')
<div class="main">    
    <div class="main-container semi-transparent fancy-border">     
        <div>
            <h2>Données courantes Bisame</h2>
            <h3>Total</h3>
            Word tokens : {{$total_tokens}}
            Word types : {{$total_types}}
            <h3>Données de référence</h3>
            Sentences : {{$ref_sentences}}
            Word tokens : {{$ref_tokens}}
            Word types : {{$ref_types}}
            <h3>Données brutes</h3>
            Sentences : {{$not_ref_sentences}}
            Word tokens : {{$non_ref_tokens}}
            Word types : {{$non_ref_types}}
            <h3>Corpus Altweiger</h3>
            Word tokens : {{$words_323}}
            Word types : {{$types_323}}
            Sentences : {{$sentences_323}}
        </div>
        <div>
            <h2> {{$days_of_annotation}} jours d'annotation </h2>
            <h2> Annotations </h2>
            Total annotations produites par les utilisateurs : {{$total_annotations}} <br>
            Total annotations produites par les utilisateurs sur du corpus inconnu : {{$total_annotations_not_reference}} correspond à {{$total_phrases_non_reference}} phrases soit {{$total_distinct_words_annotated_not_ref}} words.
            <br>
            Total annotations produites par les utilisateurs sur du corpus de ref : {{$total_annotations_reference}} correspond à {{$total_phrases_reference}} phrases soit {{$total_distinct_words_annotated_ref}} words.
            <h2> {{$trained_user}} participants ont finalisé la phase d'entraînement </h2>
            <h2> {{$participant}} participants ont produit des annotations </h2>

        </div>
        <div>
            <h2>Wikipédia alémanique en alsacien (lieux exclus)</h2>
            Word tokens : 53826
            Word types : 12644
            Hapax : 14086 = 26%
        </div>
    </div>
</div>
@endsection
