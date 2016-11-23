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
<div class="main">
    <div class="main-container">
        <h3> Vous trouverez sur cette page les liens vers les différents textes utilisés </h3>
        <br>
        <div class="fancy-border " >
            <button class="accordion" > <i class="fa fa-wikipedia-w" aria-hidden="true"></i> Pages Wikipédia </button>
            <div style="" class="panel semi-transparent ">
                <ul>
                    <li><a style="color: black" target="_blank" href="https://als.wikipedia.org/wiki/Els%C3%A4ssisches_Museum_(Stra%C3%9Fburg)"> Elsassisch Museum (Stroßburri) </a> </li>
                    <br>
                    <li><a style="color: black" target="_blank" href="https://als.wikipedia.org/wiki/Johannes_Mentelin"> Johannes Mentelin </a> </li>
                    <br>
                    <li><a style="color: black" target="_blank" href="https://als.wikipedia.org/wiki/Orthal"> Orthal </a> </li>

                </ul>
            </div>
            <div class="semi-transparent"> <br> </div>
            <button class="accordion" > <i class="fa fa-cutlery" aria-hidden="true"></i> Recettes de cuisine </button>
            <div class="panel semi-transparent">
                <ul>
                    <li><a style="color: black" target="_blank" href="http://www.olcalsace.org/sites/default/files/publications/recette_saumon_lentilles.pdf"> Dos de saumon lardé aux lentilles vertes et crème de raifort  </a> </li>
                    <br>
                    <li><a style="color: black" target="_blank" href="http://www.olcalsace.org/sites/default/files/publications/recette_flan_asperges.pdf"> Flan aux asperges </a> </li>
                    <br>
                    <li><a style="color: black" target="_blank" href="http://www.olcalsace.org/sites/default/files/publications/recette_sabayon.pdf"> Fraises et rhubarbe au sabayon </a> </li>

                </ul>
            </div>
            <div class="semi-transparent"> <br> </div>

            <button class="accordion" > <i class="fa fa-book" aria-hidden="true"></i> Œuvres littéraires </button>
            <div class="panel semi-transparent">
                <ul>
                    <li><a style="color: black" target="_blank" href=" https://archive.org/details/drhoflieferantel00stos"> <i> D'r Hoflieferant </i> - G. STOSKOPF  - 1906, p. 53  </a> </li>
                    <br>
                </ul>
            </div>
            <div class="semi-transparent"> <br> </div>
        </div>
        <br>
    </div>

    <div class="main-footer">

    </div>
</div>
@endsection
