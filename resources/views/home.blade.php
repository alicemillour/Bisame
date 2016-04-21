@extends('layouts.app')
@section('style')
<link href="{{ asset('css/home.css') }}" rel="stylesheet" type="text/css" >
@endsection
@section('content')
<div class="container">
    <div class="row main-container">
        <span>
            <a class='btn btn-default play-button' href="/home/training">S'entraîner</a>
        </span>
        @if($game_available)
	        <span>
	            <a class='btn btn-default play-button' href="/home/start">Jouer</a>
	        </span>
		@else
	        <span>
	            <a class='btn btn-default play-button' disabled>Jouer</a>
	        </span>
	    @endif
    </div>
</div>
@endsection
