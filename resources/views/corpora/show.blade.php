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
            <h2>Liens de téléchargement pour les corpus bruts et annotés</h2>
            
            <h3> Corpus de référence annoté par André Thibault, Karën Fort, Gwladys Feler et Alice Millour (format BROWN) : </h3>
            <h4>Sous-corpus issu d'articles de la 
                    <a href="https://incubator.wikimedia.org/wiki/Wp/gcf/Main_Page" 
                   target="https://incubator.wikimedia.org/wiki/Wp/gcf/Main_Page">
                    Wikipédia test en créole guadeloupéen (GCF)</a> et de proverbes de l'article  
                    <a href="https://fr.wikipedia.org/wiki/Cr%C3%A9ole_guadeloup%C3%A9en" 
                       target="https://fr.wikipedia.org/wiki/Cr%C3%A9ole_guadeloup%C3%A9en">
                    Créole guadeloupéen</a> de la Wikipédia française
            
            
            (publiés sous licence <a href="https://creativecommons.org/licenses/by-sa/3.0/" 
                               target=" https://creativecommons.org/licenses/by-sa/3.0/">
                     Creative Commons Attribution - Partage dans les Mêmes Conditions 3.0 non transposé (CC BY-SA 3.0)</a>).
            <a href="{{ url('/download_txt/krik_ref_wiki-brown.txt')  }}" target="_blank"> 
                <b>Télécharger</b> </a>
            <br>
            </h4>
            
            <h4>Sous-corpus issu de transcriptions de corpus oraux : 
                <a href="http://purl.org/poi/crdo.vjf.cnrs.fr/crdo-GCF_1022"
                    target="http://purl.org/poi/crdo.vjf.cnrs.fr/crdo-GCF_1022">
                    Créoles 1</a>, 
                <a href="http://purl.org/poi/crdo.vjf.cnrs.fr/crdo-GCF_1024"
                    target="http://purl.org/poi/crdo.vjf.cnrs.fr/crdo-GCF_1024">
                    Créoles 2</a>, 
                <a href="http://purl.org/poi/crdo.vjf.cnrs.fr/crdo-GCF_1032"
                    target="http://purl.org/poi/crdo.vjf.cnrs.fr/crdo-GCF_1032">
                    Enfance en Guadeloupe</a>, 
                <a href="http://purl.org/poi/crdo.vjf.cnrs.fr/crdo-GCF_1016"
                    target="http://purl.org/poi/crdo.vjf.cnrs.fr/crdo-GCF_1016">
                    Journal</a>, 
                <a href="http://purl.org/poi/crdo.vjf.cnrs.fr/crdo-GCF_1036"
                    target="http://purl.org/poi/crdo.vjf.cnrs.fr/crdo-GCF_1036">
                    Marie-Galante 1</a>, 
                <a href="http://purl.org/poi/crdo.vjf.cnrs.fr/crdo-GCF_1037"
                    target="http://purl.org/poi/crdo.vjf.cnrs.fr/crdo-GCF_1037">
                    Marie-Galante 2</a>, 
                <a href="http://purl.org/poi/crdo.vjf.cnrs.fr/crdo-GCF_1029"
                    target="http://purl.org/poi/crdo.vjf.cnrs.fr/crdo-GCF_1029">
                    Récits d’enfance</a>, 
                <a href="http://purl.org/poi/crdo.vjf.cnrs.fr/crdo-GCF_1041"
                    target="http://purl.org/poi/crdo.vjf.cnrs.fr/crdo-GCF_1041">
                    Langue des signes</a>
            (publiées sous licence <a href="https://creativecommons.org/licenses/by-nc-sa/3.0/deed.fr" 
                               target="https://creativecommons.org/licenses/by-nc-sa/3.0/deed.fr">
                     Attribution - Pas d’Utilisation Commerciale - Partage dans les Mêmes Conditions 3.0 non transposé (CC BY-NC-SA 3.0)</a>).
            <a href="{{ url('/download_txt/krik_ref_cocoon-brown.txt')  }}" target="_blank"> 
                <b>Télécharger</b> </a>
            <br>
            </h4>
            
            <hr>
            <h3> Corpus annotés grâce à la plateforme KRIK: </h3>
            <h4>Sous-corpus issu d'articles de la 
                    <a href="https://incubator.wikimedia.org/wiki/Wp/gcf/Main_Page" 
                   target="https://incubator.wikimedia.org/wiki/Wp/gcf/Main_Page">
                    Wikipédia test en créole guadeloupéen (GCF)</a> et de proverbes de l'article  
                    <a href="https://fr.wikipedia.org/wiki/Cr%C3%A9ole_guadeloup%C3%A9en" 
                       target="https://fr.wikipedia.org/wiki/Cr%C3%A9ole_guadeloup%C3%A9en">
                    Créole guadeloupéen</a> de la Wikipédia française
            
            
            (publiés sous licence <a href="https://creativecommons.org/licenses/by-sa/3.0/" 
                               target=" https://creativecommons.org/licenses/by-sa/3.0/">
                     Creative Commons Attribution - Partage dans les Mêmes Conditions 3.0 non transposé (CC BY-SA 3.0)</a>).
            <a href="{{ url('/download_txt/krik_0919_wiki-brown.txt')  }}" target="_blank"> 
                <b>Télécharger</b> </a>
            <br>
            </h4>
            
            <h4>Sous-corpus issu de transcriptions de corpus oraux : 
                <a href="http://purl.org/poi/crdo.vjf.cnrs.fr/crdo-GCF_1022"
                    target="http://purl.org/poi/crdo.vjf.cnrs.fr/crdo-GCF_1022">
                    Créoles 1</a>, 
                <a href="http://purl.org/poi/crdo.vjf.cnrs.fr/crdo-GCF_1024"
                    target="http://purl.org/poi/crdo.vjf.cnrs.fr/crdo-GCF_1024">
                    Créoles 2</a>, 
                <a href="http://purl.org/poi/crdo.vjf.cnrs.fr/crdo-GCF_1032"
                    target="http://purl.org/poi/crdo.vjf.cnrs.fr/crdo-GCF_1032">
                    Enfance en Guadeloupe</a>, 
                <a href="http://purl.org/poi/crdo.vjf.cnrs.fr/crdo-GCF_1016"
                    target="http://purl.org/poi/crdo.vjf.cnrs.fr/crdo-GCF_1016">
                    Journal</a>, 
                <a href="http://purl.org/poi/crdo.vjf.cnrs.fr/crdo-GCF_1036"
                    target="http://purl.org/poi/crdo.vjf.cnrs.fr/crdo-GCF_1036">
                    Marie-Galante 1</a>, 
                <a href="http://purl.org/poi/crdo.vjf.cnrs.fr/crdo-GCF_1037"
                    target="http://purl.org/poi/crdo.vjf.cnrs.fr/crdo-GCF_1037">
                    Marie-Galante 2</a>, 
                <a href="http://purl.org/poi/crdo.vjf.cnrs.fr/crdo-GCF_1029"
                    target="http://purl.org/poi/crdo.vjf.cnrs.fr/crdo-GCF_1029">
                    Récits d’enfance</a>, 
                <a href="http://purl.org/poi/crdo.vjf.cnrs.fr/crdo-GCF_1041"
                    target="http://purl.org/poi/crdo.vjf.cnrs.fr/crdo-GCF_1041">
                    Langue des signes</a>
            (publiées sous licence <a href="https://creativecommons.org/licenses/by-nc-sa/3.0/deed.fr" 
                               target="https://creativecommons.org/licenses/by-nc-sa/3.0/deed.fr">
                     Attribution - Pas d’Utilisation Commerciale - Partage dans les Mêmes Conditions 3.0 non transposé (CC BY-NC-SA 3.0)</a>).
            <a href="{{ url('/download_txt/krik_0919_cocoon-brown.txt')  }}" target="_blank"> 
                <b>Télécharger</b> </a>
            <br>
            </h4>
            
            <hr>
            <h3> Modèle MElt entraîné (corpus d'entraînement de 1500 tokens, exactitude moyenne de 82 %) : </h3>
            <h4><a href="{{ url('/download_zip/MElt_creole-guadeloupe_1500-tokens.tar.gz')  }}" target="_blank"><b>Télécharger</b></a></h4>
            
        </div>
    </div>
</div>


@endsection
