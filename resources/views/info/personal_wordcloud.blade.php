<link href="{{ asset('/css/wordcloud.css') }}" rel="stylesheet">
<div class="card-body">
<h3 class="welcome-card-header belle-allure">{{ __('recipes.my-words') }}</h3>

<hr>

                    <p class="card-text">

<div class="tegcloud" id="tegcloud_perso">
@if(Auth::check())
@if ($personal_words!=null)
            @foreach($personal_words as $key=>$word)
                        <a href="{{ route('words.show', $word) }}" style="display:none"> {{$word->value}}</a>
            @endforeach
@else 
Ajoutez une recette pour créer votre nuage de mots !
@endif
@else
Authentifiez-vous pour découvrir votre nuage de mots !
@endif

</div>

</div>
