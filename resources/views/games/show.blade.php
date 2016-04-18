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
        <article class="row bg-primary">
		<div class="col-md-12">
			<header>
				<h2>Cliquez sur les mots pour leur assigner une catégorie grammaticale  
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
	    			<th>Catégorie grammaticale</th>
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