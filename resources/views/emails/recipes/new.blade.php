@extends('emails.layout')

@section('content')
<div>
Une nouvelle recette a été créée :<br/>
<a href="{{ route('recipes.show',['recipe'=>$recipe]) }}">Voir la recette</a>
</div>
@endsection