<link href="{{ asset('/css/wordcloud.css') }}" rel="stylesheet">
<div style="text-align: center">
 Découvrez les mots du réseau <span id="reload_wordcloud"> <i class="fa fa-refresh" aria-hidden="true"></i> </span> <br>
<hr>
<div class="tegcloud" id="tegcloud">
        @foreach($random50words as $key=>$word)
        <!--{{ $word }}-->
            <a href="{{ route('words.show', $word) }}" style="display:none">{{ $word->value }}</a>
        @endforeach
</div>
</div>