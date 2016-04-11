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
				<h1>Annotez ces mots
					<div class="pull-right">
					</div>
				</h1>
			</header>
			<hr>
			<div class="sentence-container" id="sentence-container">
				@foreach($sentences[$game->sentence_index]->words as $word)
					<div class="word-container">
						<div class="word" id="{{ $word->id }}">{{ $word->value }}</div>
						<div class="category"> </div>
					</div>
				@endforeach
			</div>
		</div>
		</article>
		<div class="main-button">
			<button>Valider</button>
		</div>
		<div class="row" id="message" hidden=true>
			<h2 id=message-title>Bravo</h2>
			<p id=message-content>Vous avez tout bon !</p>
		</div>
    </div>
    <div class ="categorie-table-container pull-right">
	    <table class="table table-hover categories-table" hidden="true">
	    	<thead>
	    		<tr>
	    			<th>Categorie</th>
	    		</tr>
	    	</thead>
	    	<tbody>
	    	</tbody>
	    </table>
	</div>
</div>
@endsection