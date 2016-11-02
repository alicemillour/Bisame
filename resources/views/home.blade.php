@extends('layouts.app')
@section('style')
<link href="{{ asset('css/home.css') }}" rel="stylesheet" type="text/css" >
@endsection
@section('script')
<!--<script type="text/javascript" src="{{ asset('js/game.js') }}"></script>-->
<script type="text/javascript" src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
@endsection
@section('content')
<div class="main">
    <div class="main-container">
        <br><br>
        <div class="flash-message">
            @foreach (['danger', 'warning', 'success', 'info'] as $msg)
            @if(Session::has($msg))
            <p class="alert alert-{{ $msg }} fade-in">{{ Session::get($msg) }} <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></p>
            @endif
            @endforeach
        </div>

        <div class="title ostrich">BISAME</div>
        @if(!$game_available)
        <h3 class="info-message">Commencez par l'entraînement (quatre phrases) pour débloquer le jeu et commencer à gagner des points :
        </h3>
        <br>
        @else
        <h3 class="info-message">Bravo, vous avez débloqué la phase de production d'annotations ! A vous de jouer !
        </h3>
        <br>
        @endif
        <div class="button-wrapper">
            <span>
                <a class='btn btn-default play-button active-button ostrich' id="play-button-1" href="/home/training">S'entrainer</a>
            </span> 
            @if($game_available)
            <span>
                <a class='btn btn-default play-button active-button ostrich' id="play-button-2" href="/home/start">Produire des annotations !</a>
            </span>
            @else
            <span>
                <a class='btn btn-default play-button b-disabled ostrich' id="play-button-2" disabled>Produire des annotations !</a>
            </span>
            @endif

        </div>

        <h4 class="info-message">
            <br><b><span class="ostrich">BISAME</span> </b>est une application permettant de recueillir des annotations linguistiques auprès des locuteurs de l'alsacien. </br>
            <br>Assignez la bonne catégorie grammaticale aux mots proposés, nous construirons des ressources et des outils pour inclure l'alsacien dans les technologies du langage !</br>
        </h4>
        <h4 class="info-message">
            <br>Contact : Alice Millour - alice.millour@abtela.eu </br>
        </h4>
    </div>
    <div class="main-footer">
        <div class="footer-container" id="scoreboard">
            @include('partials.scoreboard')
        </div> 
    </div> 
</div>

@endsection
