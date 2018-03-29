@extends('emails.layout')

@section('content')
<div>
Une anecdote a été ajoutée sur une de vos recettes ou une recette que vous surveillez :<br/>
<a href="{{ route('recipes.show',['recipe'=>$recipe]) }}">Voir la recette</a><br/><br/>

Voici l'anecdote de {{ $anecdote->author->name }} :<br/>
<p>
{{ $anecdote->content }}
</p>
</div>
@endsection