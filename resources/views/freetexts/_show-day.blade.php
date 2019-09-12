<div>
    <h4>
        <div class="float-right">
        <i class="fa fa-heart likeable" aria-hidden="true" data-toggle="tooltip" data-placement="bottom" title="
           @auth
           @if(Auth::user()->likesEntity($freetext))
           Vous aimez ce texte
           @else
           Aimer ce texte  
           @endif
           @else
           Veuillez vous connecter pour aimer une recette
           @endauth
           " data-type="App\Recipe" data-id="{{ $freetext->id }}">
        </i>
        <span class="likes-count" data-id="{{ $freetext->id }}">{{ $freetext->likes_count }}</span>
        <br/>
        @if($freetext->validated)
        <img class="" style="width:20px;" src="{{ asset('img/badges/colored-laurel.svg') }}" />
        @elseif($freetext->annotated)
        <img class="" style="width:20px;" src="{{ asset('img/badges/laurel.svg') }}"  data-toggle="tooltip" data-placement="bottom" title="Recette complétement annotée" />
        @endif
    </div>
        <span style="font-size: 1.8em; text-align: center;">
            {{ link_to_route('freetexts.show', $freetext->title, $freetext) }} </span></h4>
</div>
<p class="card-text">
    <span class="text-muted">
        @component('users._avatar', ['user' => $freetext->author])

        @endcomponent
        {{ __('freetexts.freetext-by') }}
        @if($freetext->author->trashed())
        {{ $freetext->author->name }}
        @else
        {{ link_to_route('users.show', $freetext->author->name, $freetext->author) }}
        @endif			
    </span>

</p>
<div class="float-right pl-1" style="width:100%; margin-bottom: 2px">
    @if($freetext->medias->count()>0)
    <img src="{{ asset($freetext->medias->first()->filename) }}" style="width:100%;" />
    @endif
</div>



<div class="card-text text-truncate">{{ $freetext->content }}</div>
<div class="card-text text-right">{{ link_to_route('freetexts.show', "lire la suite...", $freetext) }}</div>

<!-- Fonctionnalité annotation : décommenter ci-dessous -->

<div class="card-text text-right">
    @if(!$freetext->annotated)
    <a href="{{ route('freetexts.annotations', $freetext) }}"  class="btn annotate-button active-button">Annoter la {{ __('freetexts.type') }} </a>
    @elseif(!$freetext->validated)
    <a href="{{ route('freetexts.annotations', $freetext) }}"  class="btn validate-button active-button">Valider la recette</a>
    @endif
</div>

<!-- Fonctionnalité annotation -->
