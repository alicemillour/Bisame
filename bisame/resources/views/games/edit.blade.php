@extends('layouts.app')
@section('style')
<link href="{{ asset('css/game.css') }}" rel="stylesheet" type="text/css" >
@endsection
@section('script')
<script type="text/javascript" src="{{ asset('js/game.js') }}"></script>
@endsection
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <article class="row bg-primary">
			<div class="col-md-12">
				<header>
					<h1>Annotez ces mots
						<div class="pull-right">
						</div>
					</h1>
				</header>
				<hr>
				<div class="sentence-container">
					@foreach($sentence->words as $word)
						<div class="word-container">
							<div class="word">{{ $word->value }}</div>
							<div class="category"> </div>
						</div>
					@endforeach
				</div>
			</div>
		</article>
        </div>
    </div>
    <table class="table table-hover categories-table" hidden="true">
    	<head>
    		<tr>
    			<th>Categorie</th>
    		</tr>
    	</head>
    	<tbody>
    		@foreach($postags as $postag)
    		<tr>
    			<td>{{ $postag->name }}</td>
    		</tr>
    		@endforeach
    	</tbody>
    </table>
</div>
@endsection