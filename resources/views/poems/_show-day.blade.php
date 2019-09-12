<div>
    <h4>
        <div class="float-right">
        <i class="fa fa-heart likeable" aria-hidden="true" data-toggle="tooltip" data-placement="bottom" title="
           @auth
           @if(Auth::user()->likesEntity($poem))
           Vous aimez ce texte
           @else
           Aimer ce texte  
           @endif
           @else
           Veuillez vous connecter pour aimer une recette
           @endauth
           " data-type="App\Recipe" data-id="{{ $poem->id }}">
        </i>
        <span class="likes-count" data-id="{{ $poem->id }}">{{ $poem->likes_count }}</span>
        <br/>
        @if($poem->validated)
        <img class="" style="width:20px;" src="{{ asset('img/badges/colored-laurel.svg') }}" />
        @elseif($poem->annotated)
        <img class="" style="width:20px;" src="{{ asset('img/badges/laurel.svg') }}"  data-toggle="tooltip" data-placement="bottom" title="Recette complétement annotée" />
        @endif
    </div>
        <span style="font-size: 1.8em; text-align: center;">
            {{ link_to_route('poems.show', $poem->title, $poem) }} </span></h4>
</div>
<p class="card-text">
    <span class="text-muted">
        @component('users._avatar', ['user' => $poem->author])

        @endcomponent
        {{ __('poems.poem-by') }}
        @if($poem->author->trashed())
        {{ $poem->author->name }}
        @else
        {{ link_to_route('users.show', $poem->author->name, $poem->author) }}
        @endif			
    </span>

</p>
<div class="float-right pl-1" style="width:100%; margin-bottom: 2px">
    @if($poem->medias->count()>0)
    <img src="{{ asset($poem->medias->first()->filename) }}" style="width:100%;" />
    @endif
</div>



<div class="card-text text-truncate">{{ $poem->content }}</div>
<div class="card-text text-right">{{ link_to_route('poems.show', "lire la suite...", $poem) }}</div>

<!-- Fonctionnalité annotation : décommenter ci-dessous -->

<div class="card-text text-right">
    @if(!$poem->annotated)
    <a href="{{ route('poems.annotations', $poem) }}"  class="btn annotate-button active-button">Annoter la {{ __('poems.type') }} </a>
    @elseif(!$poem->validated)
    <a href="{{ route('poems.annotations', $poem) }}"  class="btn validate-button active-button">Valider la recette</a>
    @endif
</div>

<!-- Fonctionnalité annotation -->
