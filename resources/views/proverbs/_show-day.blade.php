<div>
    <h4>
        <div class="float-right">
        <i class="fa fa-heart likeable" aria-hidden="true" data-toggle="tooltip" data-placement="bottom" title="
           @auth
           @if(Auth::user()->likesEntity($proverb))
           Vous aimez cette recette
           @else
           Aimer cette recette  
           @endif
           @else
           Veuillez vous connecter pour aimer une recette
           @endauth
           " data-type="App\Recipe" data-id="{{ $proverb->id }}">
        </i>
        <span class="likes-count" data-id="{{ $proverb->id }}">{{ $proverb->likes_count }}</span>
        <br/>
        @if($proverb->validated)
        <img class="" style="width:20px;" src="{{ asset('img/badges/colored-laurel.svg') }}" />
        @elseif($proverb->annotated)
        <img class="" style="width:20px;" src="{{ asset('img/badges/laurel.svg') }}"  data-toggle="tooltip" data-placement="bottom" title="Recette complétement annotée" />
        @endif
    </div>
        <span style="font-size: 1.8em; text-align: center;">
            {{ link_to_route('proverbs.show', $proverb->title, $proverb) }} </span></h4>
</div>
<p class="card-text">
    <span class="text-muted">
        @component('users._avatar', ['user' => $proverb->author])

        @endcomponent
        {{ __('proverbs.proverb-by') }}
        @if($proverb->author->trashed())
        {{ $proverb->author->name }}
        @else
        {{ link_to_route('users.show', $proverb->author->name, $proverb->author) }}
        @endif			
    </span>

</p>
<div class="float-right pl-1" style="width:100%; margin-bottom: 2px">
    @if($proverb->medias->count()>0)
    <img src="{{ asset($proverb->medias->first()->filename) }}" style="width:100%;" />
    @endif
</div>



<div class="card-text text-truncate">{{ $proverb->content }}</div>
<div class="card-text text-right">{{ link_to_route('proverbs.show', "lire la suite...", $proverb) }}</div>

<!-- Fonctionnalité annotation : décommenter ci-dessous -->

<div class="card-text text-right">
    @if(!$proverb->annotated)
    <a href="{{ route('proverbs.annotations', $proverb) }}"  class="btn annotate-button active-button">Annoter la {{ __('proverbs.type') }} </a>
    @elseif(!$proverb->validated)
    <a href="{{ route('proverbs.annotations', $proverb) }}"  class="btn validate-button active-button">Valider la recette</a>
    @endif
</div>

<!-- Fonctionnalité annotation -->
