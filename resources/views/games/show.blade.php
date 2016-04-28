@extends('layouts.app')
@section('style')
<link href="{{ asset('css/game.css') }}" rel="stylesheet" type="text/css" >
@endsection
@section('script')
<script type="text/javascript" src="{{ asset('js/game.js') }}">
</script>
@endsection
@section('content')
<div class="container" id="main-container">
    <div class="row sentence-main-container">
        <article class="row bg-primary ">
		<div class="col-md-12 background-colored">
			<header>
                            
                            @if($game['type']=='training')
                            <h4> Bienvenue dans le mode Entraînement ! Ici, vous pouvez vérifier vos réponses au fur et à mesure. </h4>
                            @else
                            <h4> Bienvenue dans le mode Jeu ! Ici, nous ne corrigeons pas vos réponses. Vos points seront mis à jour à la fin de la séquence de quatre phrases. </h4>
                            @endif
                            
				<h2 class="ostrich">Cliquez sur les mots pour leur assigner une categorie grammaticale
					<div class="pull-right">
					</div>
				</h2>
                            
                           
			</header>
                        <hr>
                        <div class="sentence-container" id="sentence-container"> 
                            	@foreach($sentences[$game->sentence_index]->words as $word)
					<div class="word-container">
						<div class="word" id="{{ $word->id }}" value="{{$word->value}}">{{ $word->value }}</div>
						<div class="category"> </div>
					</div>
				@endforeach
                                <div class="progress" color="white">
                                <div class="progress-bar" role="progressbar" aria-valuenow="{{$progression}}"
                                aria-valuemin="0" aria-valuemax="100" style="width:{{$progression}}%">
                                <span>Phrase {{$game->sentence_index+1}}/4</span>     
                                </div>
                            </div>
			</div>
                        
		</div>
                </article>
		<div class="main-button">
                        @if($game['type']=='training')
                            <button>Vérifier mes réponses</button>
                        @else
                            <button>Valider et passer à la phrase suivante</button>
                        @endif
		</div>
		<div class="alert alert-success" id="message" hidden=true>
			<strong id=message-title>Bravo !</strong>
			<div id=message-content>Toutes vos annotations sont correctes !</div>
		</div>
    </div>
    <div class ="categorie-table-container pull-right">
	    <table class="table table-hover categories-table" hidden="true">
	    	<thead>
	    		<tr>
                            <th class="ostrich" <h2>Categories grammaticales</h2></th>
	    		</tr>
	    	</thead>
	    	<tbody>
	    	</tbody>
	    </table>
		<div class="categories-button" hidden=true>
			<button>Afficher toutes les catégories</button>
		</div>
	</div>
</div>
@endsection