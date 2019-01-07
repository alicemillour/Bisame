<link href="{{ asset('/css/wordcloud.css') }}" rel="stylesheet">
<div style="text-align: center">
 Vos mots 
<hr>


<div class="tegcloud" id="tegcloud_perso">
@if(Auth::check())
@if ($personal_words!=null)
            @foreach($personal_words as $key=>$word)
                        <a href="{{ route('words.show', $word) }}" style="display:none"> {{$word->value}}</a>
            @endforeach
@else 
Ajoutez une recette ou des variantes dans le réseau pour créer votre nuage de mots !
@endif
@else
Authentifiez-vous pour découvrir votre nuage de mots !
@endif

</div>

</div>


{{-- 
    
            @foreach($personal_words as $key=>$word)
        <span style="color:red"> dans personal words, key</span>
            @php
            $inside=$personal_words[$key]           
            @endphp
            {{$inside}}
                    @endforeach

    HELLO
            <br>
                        <a href="{{ route('words.show', $new_word) }}" style="display:none"> {{$new_word->value}}</a>

             --}}