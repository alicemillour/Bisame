@extends('layouts.app')

@section('content')

@php
$pos = [];
foreach($postags as $_postag){
$pos[$_postag->id] = $_postag->name;
}
$solutions = [];
@endphp

<div id="annotation" class="container bg-white p-3 noselect">
    <div class="row">
        <div class="col-12">
            <h4 class="explanation">Bienvenue dans le mode <b>Entraînement </b> de la catégorie <span class="highlight"><span class="belle-allure">{{ $postag->full_name }}</span></span> <em> ({{ $postag->name }})</em> !</h4>

            <h4 class="explanation">Lorsqu'une catégorie est suggérée
                (mots <span class="highlight" style="font-size: 0.8em">surlignés</span>), il faut la valider
                (<img src="{{ asset('images/check.png') }}">)
                ou l'invalider (<img src="{{ asset('images/no.png') }}">).
            </h4>
            <h4 class="explanation">En cas de doute, consultez les exemples ci-dessous ou 
                <a style="color:#1e1eac;" href="mailto:{{ config('mail.from.adress') }}?Subject=[Bisame]Contact" style="color:black" target="_top">contactez-moi</a>
            </h4>
        </div>
        <div style="width:100%;"><hr style="height: 1px; color: white; background-color: black; width: 50%; "> </div>
        <div style="display:inline-block;margin: 0 auto">

            <h5>Quelques exemples :</h5>
            {!! $postag->description !!}
        </div>
        <br>
        <div style="width:100%;"><hr style="height: 1px; color: white; background-color: black; width: 50%; "> </div>
        <br>
        <div class="col-12">

            <h4 id="result" class="d-none"></h4>
        </div>
    </div>
    <div class="row mt-3">

        <div class="col-12" id="annotations" style="padding:3%">
            @foreach($corpus_training->sentences as $sentence)
            @foreach($sentence->words as $word)
            @if(isset($word->annotation_training))
            <div class="word_container" style="display:inline-block;text-align:center;vertical-align: top;">
                @if($pos[$word->annotation_training->postag_id]==$postag->name)
                <span class="word highlight" data-word-id="{{ $word->id }}" data-postag-id="{{ $word->annotation_training->postag_id }}">{{ $word->value }}</span>
                <br/>            
                <img class="no visible" src="{{ asset('images/no.png') }}" data-word-id="{{ $word->id }}" data-postag-id="{{ $word->annotation_training->postag_id }}" />
                <span class="pos not-validated" data-word-id="{{ $word->id }}" data-postag-id="{{ $word->annotation_training->postag_id }}">{{ $pos[$word->annotation_training->postag_id] }}</span>
                <img class="check visible" src="{{ asset('images/check.png') }}" data-word-id="{{ $word->id }}" data-postag-id="{{ $word->annotation_training->postag_id }}"/>
                @elseif($pos[$word->annotation_training->postag_id]!="PUNCT")
                <span class="word" data-word-id="{{ $word->id }}" data-postag-id="{{ $word->annotation_training->postag_id }}">{{ $word->value }}</span>
                <br/>            
                <img class="no no-display" src="{{ asset('images/no.png') }}" data-word-id="{{ $word->id }}" data-postag-id="{{ $word->annotation_training->postag_id }}" />
                <span class="pos invisible not-validated" data-word-id="{{ $word->id }}" data-postag-id="{{ $word->annotation_training->postag_id }}">{{ $pos[$word->annotation_training->postag_id] }}</span>
                <img class="check no-display" src="{{ asset('images/check.png') }}" data-word-id="{{ $word->id }}" data-postag-id="{{ $word->annotation_training->postag_id }}"/>
                @endif
            </div>
            @endif
            @if(isset($word->annotation_solution))
            @php
            $solutions[$word->id]=$word->annotation_solution;
            @endphp          
            @endif
            @endforeach
            <br/>
            @endforeach
            <div class="text-center">
                <button id="btn-check-solution" class="btn btn-warning disabled btn-lg mb-5" data-toggle="tooltip" title="Validez ou invalidez tous les mots en surbrillance avant de continuer" data-placement="top">Vérifier mes réponses</button>
            </div>        
        </div>

    </div>

</div>
@endsection

@section('scripts')

<script type="text/javascript">
    var previous_url = "{!! url()->previous() !!}";
    var postags = {!! json_encode($postags) !!};
    var current_postag = {!! json_encode($postag) !!};
    var solutions = {!! json_encode($solutions) !!};
    var parser = document.createElement('a');
    parser.href = previous_url;
    previous_url = parser.protocol + '//' + parser.hostname + parser.pathname;
    $('.word').click(function(){

    var word_id = $(this).attr('data-word-id');
    var postag_id = $(this).attr('data-postag-id');
    if ($(this).hasClass('validated') && postag_id != 0 && current_postag.id != postag_id) return false;
    var postag_html = $('.pos[data-word-id=' + word_id + ']');
    if ($(this).hasClass('highlight') || $(this).hasClass('validated')){
    invalidatePos($(this));
    } else {
    $(this).attr('data-postag-id', current_postag.id);
    postag_html.removeClass('no-display').addClass('visible').html(current_postag.name).attr('data-postag-id', current_postag.id);
    validatePos($(this));
    }
    })

            $('img.no').click(function(){
    invalidatePos($(this));
    });
    $('img.check').click(function(){
    validatePos($(this));
    });
    function getPostag(postag_id) {
    var postag = null;
    for (key in postags)
    {
    var pos = postags[key];
    if (pos.id == postag_id){
    postag = pos;
    }
    continue;
    }
    return postag;
    }

    function invalidatePos(elm){
    var word_id = elm.attr('data-word-id');
    $('.pos[data-word-id=' + word_id + ']').removeClass('visible').removeClass('not-validated').addClass('invisible');
    $('img[data-word-id=' + word_id + ']').removeClass('visible').addClass('invisible');
    $('.word[data-word-id=' + word_id + ']').removeClass('highlight').removeClass('validated');
    checkPosFinished();
    }

    function validatePos(elm){
    var word_id = elm.attr('data-word-id');
    $('.pos[data-word-id=' + word_id + ']').removeClass('not-validated');
    $('.word[data-word-id=' + word_id + ']').removeClass('highlight').addClass('validated').attr('data-postag-id', current_postag.id);
    $('img[data-word-id=' + word_id + ']').removeClass('visible').addClass('invisible');
    checkPosFinished();
    }

    function checkPosFinished(){
    console.log($('img.visible').length);
    if ($('img.visible').length == 0){
    $('#btn-check-solution').removeClass('btn-warning disabled').addClass('btn-success').tooltip('disable');
    }
    }

    function checkSolution(){

    var count_errors = 0;
    for (key in solutions)
    {
    var word = $('.word[data-word-id=' + key + ']');
    var word_id = word.attr('data-word-id');
    var postag_html = $('.pos[data-word-id=' + key + ']');
    // var pos_solution 
    var solution = solutions[key];
    if (solution.postag_id == current_postag.id && !word.hasClass('validated')) {
    word.addClass('highlight');
    postag_html.html(current_postag.name).removeClass('invisible').addClass('visible');
    $('img[data-word-id=' + word_id + ']').removeClass('invisible').addClass('visible');
    count_errors++;
    } else if (solution.postag_id != current_postag.id && word.hasClass('validated')){
    var postag = getPostag(solution.postag_id);
    postag_html.html(current_postag.name);
    word.removeClass('validated').addClass('highlight');
    $('img[data-word-id=' + word_id + ']').removeClass('invisible').addClass('visible');
    count_errors++;
    }
    }

    if (count_errors == 0){
    var url_redirection = previous_url + '?tab=pos&pos=' + current_postag.id;
    var message = "Félicitations ! C'est un sans-faute !";
    $.post("{{ route('validate-training') }}", { postag_id: current_postag.id }, function(){
    window.location.href = url_redirection;
    });
    // window.location.href = url_redirection;
    } else if (count_errors == 1)
            var message = "Vous avez " + count_errors + " erreur à corriger.";
    else
            var message = "Vous avez " + count_errors + " erreurs à corriger.";
    $('#btn-check-solution').removeClass('btn-success').addClass('btn-warning disabled').tooltip('enable');
    // $('img[data-postag-id='+current_postag.id+']').removeClass('invisible').addClass('visible');
    // $('.pos[data-postag-id='+current_postag.id+']').removeClass('invisible').addClass('visible');
    // $('.word[data-postag-id='+current_postag.id+']').removeClass('invisible').addClass('visible');
    $('#result').removeClass('d-none').html(message);
    $(window).scrollTop(0);
    }

    $('#btn-check-solution').click(function(){
    if ($(this).hasClass('disabled'))
            return false;
    checkSolution();
    });


</script>

@endsection

@section('style')

<style>
    #result {
        color: red;
    }
    .highlight-error {
        background-color: #F5BCA9;
    }
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
        background-color: #ffd47b;
    }
    .validated {
        background-color: #E3F6CE;
    }
    .recipe-ingredients {
        position: relative;
    }
    img.no, img.check {
        width: 20px;
        cursor:pointer;
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
    .explanation {
        /*color: #337ab7;*/
        background-color: white;
        text-align: center;
    }


    .no-display {
        display: none;
    }

</style>
@endsection