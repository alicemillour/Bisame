@extends('layouts.app')
@section('style')



<link href="{{ asset('css/home.css') }}" rel="stylesheet" type="text/css" >
@endsection
@section('script')
<script type="text/javascript" src="{{ asset('js/home.js') }}"></script>
<<<<<<< HEAD
=======

>>>>>>> 9fd843829189326bf6dcd04a266efde6786ced58
<script type="text/javascript" src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>

@endsection
@section('content')
@include('partials.nav')
<div class="main">
    <div class="main-container">
        <div  style="max-width:100%;margin:0 auto;">
            <!-- TODO DIFF <div class="title ostrich">&nbsp;Krik !</div> -->
            <div class="title ostrich"> {{ trans('home.app-name') }} </div>
        </div>
        

        <!--<button onclick="document.getElementById('id01').style.display='block'" style="width:auto;">Login</button>-->

        <div id="id01" class="modal">

          <form class="modal-content animate" action="/action_page.php">
            <div class="imgcontainer">
              <span onclick="document.getElementById('id01').style.display='none'" class="close" title="Close Modal">&times;</span>
            </div>

            <div class="container">
                <h3> Un nouveau site est disponible ! Rendez-vous sur <a href="http://krik.paris-sorbonne.fr/recettes">Recettes de Grammaire</a> pour en savoir plus !
                </h3>
            </div>


          </form>
        </div>
        <div class="fill">
            <div class="info-message-trans background-colored fancy-border">
                
                @if (Auth::guest())
                <div class="button-wrapper" >
                    
                    <span>
                        <a class='btn btn-default play-button active-button ostrich' href="/login">Connexion</a>
                    </span>
                    
                    <span>
                        <a class='btn btn-default play-button active-button ostrich' href="/register">Inscription</a>
                    </span>  
                    @include('partials.why-'.App::getLocale())
<!--                    <span>
                        <a class='btn btn-default play-button active-button ostrich' href="/login">Connexion</a>
                    </span>
                    
                    <span>
                        <a class='btn btn-default play-button active-button ostrich' href="/register">Inscription</a>
                    </span>-->
                </div>
                
                @else
                @if(!$game_available)
                <h3 class="info-message">Commencez par l'entraînement (quatre phrases) pour débloquer le jeu et commencer à gagner des points :
                </h3>
                <br>
                @else
                <h3 class="info-message" style="-webkit-backdrop-filter: blur(5px); backdrop-filter:blur(5px)">Bravo, vous avez débloqué la phase de production d'annotations ! A vous de jouer !
                </h3>
                <!--@include('partials.news')-->
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
                        <a class='btn btn-default play-button active-button' id="play-button-1" href="/home/training"> <span class="ostrich" style="font-size: 0.9em"> S'entrainer </span> </a>
                    </span> 
                    @if($game_available)
                    <span>
                         <!--TODO DIFF <a class='btn btn-default play-button active-button ' id="play-button-2" href="/home/start"> Maké sé fraz-la ! <span class="ostrich" style="font-size: 0.9em"> (Produire des annotations) </span> </a>-->          
                        <a class='btn btn-default play-button active-button ' id="play-button-2" href="/home/start">{{ trans('home.message-button-part1') }} <span class="ostrich" style="font-size: 0.9em"> {{ trans('home.message-button-part2') }}</span> </a>
                    </span>                    
                    @else
                    <span>
                         <!--TODO DIFF <a class='btn btn-default play-button b-disabled ostrich' id="play-button-2" disabled>Maké sé fraz-la ! <br> <span class="ostrich" style="font-size: 0.9em"> (Produire des annotations) </span> </a>--> 
                        <a class='btn btn-default play-button b-disabled' id="play-button-2" disabled>{{ trans('home.message-button-part1') }} <span class="ostrich" style="font-size: 0.9em"> {{ trans('home.message-button-part2') }} </span> </a>
                    </span>
                    @endif
                </div>
                <br>
                <br>    
<!--                @include('partials.why-'.App::getLocale())-->

                @endif      
            </div>       
        </div>        

        
        <br>
        <br>  
        <div class="fill">
            <div class="info-message-trans background-colored fancy-border">
                @include('partials.' . App::getLocale() . '-intro')
            </div>
        </div>
        <br>
    </div>         
</div> 
<div class="main-footer">
    <div class="footer-container" id="scoreboard">
        @include('partials.scoreboard')
    </div> 
</div>   





@endsection
