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
    <div class="main-container semi-transparent fancy-border">     
        <div>
            <h2>Liens de téléchargement pour les corpus</h2>
            Corpus de référence annoté par Delphine Bernhard et Lucie Steiblé (CSV) : 
            <a href="{{ url('/download_zip/reference-corpus.tar.gz')  }}" target="_blank">
                <b>Télécharger</b>
            <br>
            <br>
            </a>
            Corpus annoté <i>via</i> BISAME : Phrases issues des articles de Wikipedia <a href="https://als.wikipedia.org/wiki/Altweltgeier">Altweltgeier</a><a href=" https://als.wikipedia.org/wiki/Tony_Troxler">Tony_Troxler</a> <a href="https://als.wikipedia.org/wiki/Kernkraftwerk_Fessenheim" >Kernkraftwerk_Fessenheim</a> <a href=" https://als.wikipedia.org/wiki/Delphine_Wespiser" target="_blank">Delphine_Wespiser</a> <a href=" https://als.wikipedia.org/wiki/Wort:Franz%C3%B6sische_W%C3%B6rter_im_Els%C3%A4ssischen" target="_blank">Franz%C3%B6sische_W%C3%B6rter_im_Els%C3%A4ssischen</a> <a href=" https://als.wikipedia.org/wiki/E_Friehjohr_fer_unseri_Sproch">E_Friehjohr_fer_unseri_Sproch</a> <a href=" https://als.wikipedia.org/wiki/Els%C3%A4ssische_Vornamen">Els%C3%A4ssische_Vornamen</a> publiés sous la <a href="https://creativecommons.org/licenses/by-sa/3.0/deed.fr">licence Creative Commons Attribution - Partage dans les Mêmes Conditions 3.0 non transposé (CC BY-SA 3.0)</a>
            : <a href="{{ url('/download_txt/wikipedia-20160406-bisame.conll')  }}" target="_blank"><b>Télécharger (CONLL)</b>
        </a>
            <br>
            <br>
            </a>
            Modèle MElt entraîné
            : <a href="{{ url('/download_zip/melt-20160406-bisame.tar.gz')  }}" target="_blank"><b>Télécharger</b>
        </a>
        </div>
    </div>
</div>


@endsection
