@extends('layouts.app')
@section('style')
<link href="{{ asset('css/home.css') }}" rel="stylesheet" type="text/css" >
@endsection
@section('content')
<div class="title ostrich"> BISAME </div>
@if(!$game_available)
    <h3 class="info-message">Commencez par l'entraînement pour débloquer le jeu :
    </h3>
@endif
<div class="container fill">
    <div class="row main-container">
        <span>
            <a class='btn btn-default play-button ostrich' href="/home/training">S'entrainer</a>
        </span> 
        @if($game_available)
	        <span>
	            <a class='btn btn-default play-button ostrich' href="/home/start">Jouer</a>
	        </span>
		@else
	        <span>
	            <a class='btn btn-default play-button ostrich' disabled>Jouer</a>
	        </span>
	@endif
    </div>
</div>
    <h4 class="info-message">
        <br><spanclass="ostrich"> BISAME</span> est une application permettant de recueillir des annotations linguistiques auprès des locuteurs de l'alsacien. </br>
        <br>Assignez des catégories grammaticales aux mots proposés, nous construirons des ressources et des outils pour inclure l'alsacien dans les technologies du langage !</br>.
    </h4>
@endsection
