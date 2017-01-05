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
    <div>
        <h2>Données courantes Bisame</h2>
        <h3>Total</h3>
        Word tokens : {{$total_tokens}}
        Word types : {{$total_types}}
        <h3>Données de référence</h3>
        Word tokens : {{$ref_tokens}}
        Word types : {{$ref_types}}
        <h3>Données brutes</h3>
        Word tokens : {{$non_ref_tokens}}
        Word types : {{$non_ref_types}}
    </div>
    
    <div>
        <h2>Wikipédia alémanique en alsacien (lieux exclus)</h2>
        Word tokens : 53826
        Word types : 12644
        Hapax : 14086 = 26%
    </div>
</div>
@endsection
