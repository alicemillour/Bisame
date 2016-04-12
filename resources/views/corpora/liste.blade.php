@extends('template')

@section('header')
	@if(Auth::check())
		<div class="btn-group pull-right">
			{!! link_to('logout', 'Deconnexion', ['class' => 'btn btn-warning']) !!}
		</div>
	@else
		{!! link_to('login', 'Se connecter', ['class' => 'btn btn-info pull-right']) !!}
	@endif
@stop

@section('contenu')
	@if(isset($info))
		<div class="row alert alert-info">{{ $info }}</div>
	@endif
	
	{!! $links !!}
	@foreach($corpora as $corpus)
		<article class="row bg-primary">
			<div class="col-md-12">
				<header>
					<h1>{{ $corpus->name }}
						<div class="pull-right">
						</div>
					</h1>
				</header>
				<hr>
				<p>
					@foreach($corpus->sentences as $sentence)
						@foreach($sentence->words as $word)
							{!! link_to('corpus/', $word->value, ['class' => 'btn btn-xs btn-info']) !!}
						@endforeach
					@endforeach
				</p>
			</div>
		</article>
		<br>
	@endforeach
	{!! $links !!}

@stop