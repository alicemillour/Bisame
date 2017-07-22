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
@include('partials.nav')
<div class="main">
    <div class="main-container">

        <div class="title ostrich">  Krik !  </div>
        <div class="fill">
              <div class="info-message-trans background-colored fancy-border">
            
        <div class="button-wrapper" >
            @if (Auth::guest())
            <span>
                <a class='btn btn-default play-button active-button ostrich' href="/login">Connexion</a>
            </span>

            <span>
                <a class='btn btn-default play-button active-button ostrich' href="/register">Inscription</a>
            </span>
        </div>
            @else
            @if(!$game_available)
            <h3 class="info-message">Commencez par l'entraînement (quatre phrases) pour débloquer le jeu et commencer à gagner des points :
            </h3>
            <br>
            @else
            <h3 class="info-message" style="-webkit-backdrop-filter: blur(5px); backdrop-filter:blur(5px)">Bravo, vous avez débloqué la phase de production d'annotations ! A vous de jouer !
            </h3>
            <br>
                                                <div class="progress" style="width:50%; margin: 0 auto">
                                            <div class="progress-bar progress-bar-success progress-bar-striped" role="progressbar" aria-valuenow="{{$progression}}"
                                                 aria-valuemin="0" aria-valuemax="100" style="width:{{$progression}}%">
                                            </div>
                            <div class="percent" style="font-size:0.8em">Plus que <b> {{$unannotated_words->count}} mots à annoter (ensemble)</b></div >
                                        </div>
                        <br>
            @endif
            <div class="button-wrapper">
                <span>
                    <a class='btn btn-default play-button active-button' id="play-button-1" href="/home/training"> Essayé é komprann jé la <br> <span class="ostrich" style="font-size: 0.9em"> (S'entrainer) </span> </a>
                </span> 
                @if($game_available)
                <span>
                    <a class='btn btn-default play-button active-button ' id="play-button-2" href="/home/start"> Maké sé fraz-la ! <br> <span class="ostrich" style="font-size: 0.9em"> (Produire des annotations) </span> </a>
                </span>
                @else
                <span>
                    <a class='btn btn-default play-button b-disabled ostrich' id="play-button-2" disabled>Produire des annotations !</a>
                </span>
                @endif
            </div>

              </div>
        
            @endif
          </div>
        <br>

        <div class="fill">
            <div class="info-message-trans background-colored fancy-border">
               @include('partials.creole-intro')
            </div>
        </div>
        <br>
          
       <!--  
        </div>
        <div class="info-wrapper"> 
            <h3 class="info-message" style="text-align: center; margin: 0 auto;">-->


        </div>
</div>
    <div class="main-footer">
        <div class="footer-container" id="scoreboard">
            @include('partials.scoreboard')
        </div> 
    </div> 
</div>
@endsection
