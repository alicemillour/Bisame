@extends('layouts.app')
@section('style')
<link href="{{ asset('css/home.css') }}" rel="stylesheet" type="text/css" >
@endsection
@section('content')
<div class="container">
    <div class="title ostrich"> BISAME </div>


    <h4 class="info-message">
        <br><b><span class="ostrich"> BISAME</span> </b>est une application permettant de recueillir des annotations linguistiques auprès des locuteurs de l'alsacien. </br>
        <br>Assignez la bonne catégorie grammaticale aux mots proposés, nous construirons des ressources et des outils pour inclure l'alsacien dans les technologies du langage !</br>
    </h4>
</div>

@endsection
