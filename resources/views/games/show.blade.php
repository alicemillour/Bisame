@extends('layouts.app')
@section('style')
<link href="{{ asset('css/game.css') }}" rel="stylesheet" type="text/css" >
<!--<link href="{{ asset('css/home.css') }}" rel="stylesheet" type="text/css" >-->
@endsection
@section('script')
<script type="text/javascript" src="{{ asset('js/game.js') }}">
</script>
@endsection
@section('content')

@include('partials.nav')

<div class="main">    
    <div class="main-container semi-transparent fancy-border">      
        <!--            <div class="col-md-2 background-colored" id="Mon compte">
                        @include('partials/game/container')
                    </div>-->
        <!--            <div class="col-md-8 background-colored">-->

        <header> 
            @if($no_sentence)
            <h4> Vous avez annoté toutes les phrases disponibles, <a style="color:#AC1E44;text-align: center" href="/contact" style="color:black" target="_top">Contactez-moi !</a> </h4>


            @else
            @if($game['type']=='training')
            <h4> Bienvenue dans le mode Entraînement ! Ici, vous pouvez vérifier vos réponses au fur et à mesure. </h4>
            @else
            <h4> Bienvenue dans le mode Jeu ! Ici, nous ne corrigeons pas vos réponses. Vos points seront mis à jour à la fin de la séquence de quatre phrases. </h4>
            @endif

            <h2 class="ostrich">Cliquez sur les mots pour leur assigner une categorie grammaticale
                <div class="pull-right">
                </div>
            </h2>
            <!--<h4 class="ostrich alert-message">Nouveau !</h4>-->

        </header>
        <hr>
        <div class="sentence-container" id="sentence-container"> 
            @foreach($sentences[$game->sentence_index]->words as $word)
            <div class="word-container" style="text-align:center">
                @if( !empty($pretag) )
                <div class="word" id="{{ $word->id }}" value="{{$word->value}}" tag="{{$pretag[$word->id]}}">{{ $word->value }}</div>
                @else
                <div class="word" id="{{ $word->id }}" value="{{$word->value}}" tag="{{$pretag[$word->id]}}">{{ $word->value }}</div>
                @endif
                <div class="labels" style="text-align: center ; display:block" name="category-label[{{ $word->id }}]">
                    <img class="leftlabel" id="left_{{ $word->id }}" style="padding-left: 2px; padding-right: 2px; display:none" src="/images/no.png">
                    <span class="category-label" > </span>
                    <img class="rightlabel" id="right_{{ $word->id }}" style="padding-left: 2px; padding-right: 2px;display: none" src="/images/check.png">
                </div>
            </div>
            @endforeach
            <div class="progress" color="white">
                <div class="progress-bar" role="progressbar" aria-valuenow="{{$progression}}"
                     aria-valuemin="0" aria-valuemax="100" style="width:{{$progression}}%">
                    <div>{{$game->sentence_index+1}}/4</div>
                </div>
            </div>
        </div>


        <!--</div>-->
        <!--</article>-->

        <div class="main-button">
            @if($game['type']=='training')
            <button><b> Vérifier mes réponses </b></button>
            @else
            @if($game->sentence_index != 3)
            <button><b> Valider et passer à la phrase suivante </b> </button>
            @else
            <button><b> Terminer la séquence </b> </button>
            @endif
            @endif
        </div>
        @if($game['type']=='training')
        <h5><b> &nbsp &nbsp Vous pouvez vérifiez vos réponses à tout moment.</b></h5>
        @else
        <h5><b> &nbsp &nbsp Dans ce mode, vous pouvez passer à la phrase suivante même si vous n'avez pas annoté tous les mots.</b> </h5>
        @endif
        <div class="alert alert-success" id="message" hidden=true>
            <strong id=message-title>Bravo !</strong>
            <div id=message-content>Toutes vos annotations sont correctes !</div>
        </div>
    </div>

    @endif

    <!--        <div class="main-footer">
                <div class ="categorie-table-container pull-right">
                    <table class="table table-hover categories-table" hidden="true">
                        <thead>
                            <tr>
                                <th class="ostrich" style="text-align: center"> <h3> <b>Categories grammaticales</b></h3></th>
                            </tr>
                        </thead>
                        <tbody>
                            hello
                            hello
                        </tbody>
                    </table>
                    <div class="categories-button" hidden="true">
                        <button>Aucune de ces catégories ne convient</button>
                    </div>
                </div>
            </div>-->
    <div class="main-footer">
        <h3> Rappel sur les catégories </h3>
        <div class="fancy-border footer-container" >

            @foreach($postags as $postag)

            <button class="accordion" > {{ $postag->name }} ({{ $postag->full_name }})</button>
            <div class="panel semi-transparent">
                <h4> Quelques exemples :  </h4>
                <div style="text-align : left">
                    {!! $postag->description !!}
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div> 
@endsection