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
				<p>
					@foreach($sentence->words as $word)
						<span class="word">{{ $word->value }}</span>
					@endforeach
				</p>
			</div>
		</article>
        </div>
    </div>
</div>
@endsection