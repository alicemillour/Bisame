@extends('layouts.app')
@section('style')
<link href="{{ asset('css/home.css') }}" rel="stylesheet" type="text/css" >
@endsection
<script type="text/javascript" src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>

@section('content')
<div style="background-image:url('{{ url('images/strasOK.jpg') }}'); background-size: cover; 
    background-repeat: no-repeat;    background-attachment: fixed;
    background-position: center">
<div class="container">
    <div class="title ostrich">BISAME</div>
@if(!$game_available)
    <h3 class="info-message"> Commencez par l'entraînement (quatre phrases) pour débloquer le jeu et commencer à gagner des points : <br>
    </h3>
@else
    <h3 class="info-message"> Bravo, vous avez débloqué la phase de production d'annotations ! A vous de jouer !<br>
    </h3>
@endif
    <div class="row main-container">
        <span>
            <a class='btn btn-default play-button active-button ostrich' href="/home/training">S'entrainer</a>
        </span> 
        @if($game_available)
	        <span>
	            <a class='btn btn-default play-button active-button ostrich' href="/home/start">Produire des annotations !</a>
	        </span>
		@else
	        <span>
	            <a class='btn btn-default play-button b-disabled ostrich' disabled>Produire des annotations !</a>
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
 <BR>&nbsp;<BR>
 <BR>&nbsp;<BR>
 <BR>&nbsp;<BR>
 <BR>&nbsp;<BR>

</div>

@endsection
