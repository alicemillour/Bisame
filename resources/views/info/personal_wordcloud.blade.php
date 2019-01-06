<link href="{{ asset('/css/wordcloud.css') }}" rel="stylesheet">
<div style="text-align: center">
 Vos mots 
<hr>

@if(Auth::check())
<div class="tegcloud" id="tegcloud_perso">

            @foreach($personal_words as $key=>$word)
                        <a href="{{ route('words.show', $word) }}" style="display:none"> {{$word->value}}</a>
            @endforeach

</div>
@endif
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