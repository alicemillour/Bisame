@extends('layouts.app')
@section('style')
<link target="_blank" href="{{ asset('css/game.css') }}" rel="stylesheet" type="text/css" >
@endsection
@section('script')
<!--<script type="text/javascript" src="{{ asset('js/game.js') }}"></script>-->
<script type="text/javascript" src="{{ asset('js/game.js') }}">
</script>
@endsection
@section('content')

@include('partials.nav')
<div class="main">
    <div class="main-container">
        <h3 style="color:white"> Vous trouverez sur cette page les liens vers les différents textes utilisés </h3>
        <br>
        @include('partials.textes-'.App::getLocale())
    </div>
    
    <div class="main-footer">
        
    </div>
</div>
@endsection
