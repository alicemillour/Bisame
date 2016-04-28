@extends('layouts.app')
@section('style')
<link href="{{ asset('css/home.css') }}" rel="stylesheet" type="text/css" >
@endsection
@section('content')
<div class="container">
    <div class="title ostrich"> BISAME </div>
@if(!$game_available)
    <h3 class="info-message"> Commencez par l'entraînement (quatre phrases) pour débloquer le jeu et commencer à gagner des points : <br>
    </h3>
@endif
    <div class="row main-container">
        <span>
            <a class='btn btn-default play-button ostrich background-colored' href="/home/training">S'entrainer</a>
        </span> 
        @if($game_available)
	        <span>
	            <a class='btn btn-default play-button ostrich background-colored' href="/home/start">Produire des annotations !</a>
	        </span>
		@else
	        <span>
	            <a class='btn btn-default play-button ostrich background-colored' disabled>Produire des annotations !</a>
	        </span>
	@endif
    </div>
    <h4 class="info-message">
        <br><b><span class="ostrich"> BISAME</span> </b>est une application permettant de recueillir des annotations linguistiques auprès des locuteurs de l'alsacien. </br>
        <br>Assignez la bonne catégorie grammaticale aux mots proposés, nous construirons des ressources et des outils pour inclure l'alsacien dans les technologies du langage !</br>
    </h4>
</div>

@endsection
