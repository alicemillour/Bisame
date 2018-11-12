<div>
<div>
    <h4>
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
        <span style="font-size: 1.4em; text-align: center;">
            {{ link_to_route('recipes.show', $recipe->title, $recipe) }} </span></h4>
</div>
    <div>

        
        
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
        @if($recipe->medias->count()>0)
        <img src="{{ asset($recipe->medias->first()->filename) }}" style="max-height:100%;max-width:100%;margin-left: auto; 
             margin-right: auto;
             display: block;" />
        <hr style="margin-left: 16.5%;width: 66%;">
        @endif
        <div class="card-text text-truncate">{{ $recipe->content }}</div>
        <div class="card-text text-right">{{ link_to_route('recipes.show', "lire la suite...", $recipe) }}</div>
        <!-- Fonctionnalité annotation : décommenter ci-dessous -->
{{--        <div class="card-text text-right">
            @if(!$recipe->annotated)
            <a href="{{ route('recipes.annotations', $recipe) }}"  class="btn annotate-button active-button">Annoter la recette</a>
            @elseif(!$recipe->validated)
            <a href="{{ route('recipes.annotations', $recipe) }}"  class="btn validate-button active-button">Valider la recette</a>
            @endif
        </div>--}}
        <!-- Fonctionnalité annotation -->
    </div>
</div>
<hr style="margin-left: 1%; color:black;background-color: black; width: 98%;"/>
