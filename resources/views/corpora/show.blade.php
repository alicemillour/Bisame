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
            <h2> Corpus</h2> <br>
            
            <h3> Corpus_MElt (3 357 tokens) : textes présents sur la plateforme (pré-)annotés par MElt entraîné sur un corpus annoté manuellement de 54 phrases  : </h3>
           
    
            (publiés sous licence <a href="https://creativecommons.org/licenses/by-sa/3.0/" 
                               target=" https://creativecommons.org/licenses/by-sa/3.0/">
                     Creative Commons Attribution - Partage dans les Mêmes Conditions 3.0 non transposé (CC BY-SA 3.0)</a>).
            <a href="{{ url('/download_txt/ayo_melt_sentences.txt')  }}" target="_blank"> 
                <b>Télécharger</b> </a>
            <br>
            
            
            <h3> Corpus_Participants (1 712 tokens) : textes présents sur la plateforme annoté par les participants sur la plateforme : </h3>
           
    
            (publiés sous licence <a href="https://creativecommons.org/licenses/by-sa/3.0/" 
                               target=" https://creativecommons.org/licenses/by-sa/3.0/">
                     Creative Commons Attribution - Partage dans les Mêmes Conditions 3.0 non transposé (CC BY-SA 3.0)</a>).
            <a href="{{ url('/download_txt/ayo_users_sentences.txt')  }}" target="_blank"> 
                <b>Télécharger</b> </a>
            <br>
            <br>
            <h2> Variantes </h2> <br>  
            <h3>
                Liste des variantes orthographiques proposées par les participants sur la plateforme.</h3>
            (publiés sous licence <a href="https://creativecommons.org/licenses/by-sa/3.0/" 
                               target=" https://creativecommons.org/licenses/by-sa/3.0/">
                     Creative Commons Attribution - Partage dans les Mêmes Conditions 3.0 non transposé (CC BY-SA 3.0)</a>).
            <a href="{{ url('/download_txt/alternative_words.csv')  }}" target="_blank"> 
                <b>Télécharger</b> </a>
            <br>
            </h3>
        </div>
    </div>
</div>


@endsection
