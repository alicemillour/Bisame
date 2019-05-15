@extends('layouts.app')
@section('style')
<link target="_blank" href="{{ asset('css/game.css') }}" rel="stylesheet" type="text/css" >
@endsection
@section('scripts')
<!--<script type="text/javascript" src="{{ asset('js/game.js') }}"></script>-->
<script type="text/javascript" src="{{ asset('js/game.js') }}">
</script>
@endsection
@section('content')

<div class="main">    

    <div class="main-container semi-transparent fancy-border">     
        <div>
             @include('partials.' . App::getLocale() . '-download')
    </div>
</div>


@endsection
