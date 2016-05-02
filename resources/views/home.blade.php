@extends('layouts.app')
@section('style')
<link href="{{ asset('css/home.css') }}" rel="stylesheet" type="text/css" >
@endsection
<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script type="text/javascript" src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>

{{$coming_from}}
@section('content')
<!--@if($coming_from == game )
coucou
@endif
 Modal 
<div class="modal fade" id="memberModal" tabindex="-1" role="dialog" aria-labelledby="memberModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="memberModalLabel">Thank you for signing in!</h4>
      </div>
      <div class="modal-body">
        <p>However the account provided is not known.<BR>
        If you just got invited to the group, please wait for a day to have the database synchronized.</p>

        <p>You will now be shown the Demo site.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>


<div class="modal fade" id="memberModal" tabindex="-1" role="dialog" aria-labelledby="memberModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="memberModalLabel">Thank you for signing in!</h4>
      </div>
      <div class="modal-body">
        <p>However the account provided is not known.<BR>
        If you just got invited to the group, please wait for a day to have the database synchronized.</p>

        <p>You will now be shown the Demo site.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>-->

<div class="scroll-left background-colored fina">
<p>{{$nb_total_annotations}} annotations produites à ce jour !</p>
</div>

<div class="container">
    <div class="title ostrich">BISAME</div>
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
        <br><b><span class="ostrich">BISAME</span> </b>est une application permettant de recueillir des annotations linguistiques auprès des locuteurs de l'alsacien. </br>
        <br>Assignez la bonne catégorie grammaticale aux mots proposés, nous construirons des ressources et des outils pour inclure l'alsacien dans les technologies du langage !</br>
    </h4>
</div>

@endsection
