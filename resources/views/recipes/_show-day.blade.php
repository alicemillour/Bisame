<div>
    <div class="float-right">
        <i class="fa fa-heart likeable" aria-hidden="true" data-toggle="tooltip" data-placement="bottom" title="
           @auth
           @if(Auth::user()->likesEntity($recipe))
           Vous aimez cette recette
           @else
           Aimer cette recette  
           @endif
           @else
           Veuillez vous connecter pour aimer une recette
           @endauth
           " data-type="App\Recipe" data-id="{{ $recipe->id }}">
        </i>
        <span class="likes-count" data-id="{{ $recipe->id }}">{{ $recipe->likes_count }}</span>
        <br/>
        @if($recipe->validated)
        <img class="" style="width:20px;" src="{{ asset('img/badges/colored-laurel.svg') }}" />
        @elseif($recipe->annotated)
        <img class="" style="width:20px;" src="{{ asset('img/badges/laurel.svg') }}"  data-toggle="tooltip" data-placement="bottom" title="Recette complétement annotée" />
        @endif
    </div>
    <h4>{{ link_to_route('recipes.show', $recipe->title, $recipe) }}</h4>
</div>
<p class="card-text">
    <span class="text-muted">
        @component('users._avatar', ['user' => $recipe->author])

        @endcomponent
        {{ __('recipes.recipe-by') }}
        @if($recipe->author->trashed())
        {{ $recipe->author->name }}
        @else
        {{ link_to_route('users.show', $recipe->author->name, $recipe->author) }}
        @endif			
    </span>

</p>
<div class="float-right pl-1" style="width:100%; margin-bottom: 2px">
    @if($recipe->medias->count()>0)
    <img src="{{ asset($recipe->medias->first()->filename) }}" style="width:100%;" />
    @endif
</div>



<div class="card-text text-truncate">{{ $recipe->content }}</div>
<div class="card-text text-right">{{ link_to_route('recipes.show', "lire la suite...", $recipe) }}</div>
<<<<<<< HEAD
<!-- Fonctionnalité annotation : décommenter ci-dessous -->
{{--<div class="card-text text-right">
    @if(!$recipe->annotated)
    <a href="{{ route('recipes.annotations', $recipe) }}"  class="btn annotate-button active-button">Annoter la recette</a>
    @elseif(!$recipe->validated)
    <a href="{{ route('recipes.annotations', $recipe) }}"  class="btn validate-button active-button">Valider la recette</a>
    @endif
<<<<<<< HEAD
</div>--}}
<!-- Fonctionnalité annotation -->
