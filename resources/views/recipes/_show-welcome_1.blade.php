<div>
    <div class="float-right pl-1" style="width:24%;">
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
            if($recipe->annotated)
            <img class="" style="width:20px;" src="{{ asset('img/badges/laurel.svg') }}"  data-toggle="tooltip" data-placement="bottom" title="Recette complétement annotée" />
            @endif
        </div>
            
            
    </div>
    @if($recipe->medias->count()>0)
    <div class="row">
            <div class="col-md-6">
                
                
            <img src="{{ asset($recipe->medias->first()->filename) }}" style="margin-left: auto; 
                 margin-right: auto;
                 display: block;max-height:100%; max-width:100%;" />
            @endif
        </div>
        <div class="col-md-6">
            
            <h4>{{ link_to_route('recipes.show', $recipe->title, $recipe) }}</h4>
            
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
            
            <div class="card-text text-truncate">{{ $recipe->content }}</div>
            <div class="card-text text-right">{{ link_to_route('recipes.show', "lire la suite...", $recipe) }}</div>
            <div class="card-text text-right">
                @if(!$recipe->annotated)
                <a href="{{ route('recipes.annotations', $recipe) }}"  class="btn annotate-button active-button">Annoter la recette</a>
                @elseif(!$recipe->validated)
                <a href="{{ route('recipes.annotations', $recipe) }}"  class="btn validate-button active-button">Valider la recette</a>
                @endif
            </div>
        </div>
    </div>
    
</div>
<hr/>
<!--<h4 class="card-subtitle mb-1 text-muted" >{{ link_to_route('recipes.show', $recipe->title, $recipe, ['class' => 'card-link' ]) }}
    <div class="d-inline float-right">
        <i class="fa fa-heart like"></i>
        <span class="likes-count">{{ $recipe->likes_count }}</span>
        <br/>
        @if($recipe->validated)
        <img class="" style="width:20px;" src="{{ asset('img/badges/colored-laurel.svg') }}" />
        @elseif($recipe->annotated)
        <img class="" style="width:20px;" src="{{ asset('img/badges/laurel.svg') }}"  data-toggle="tooltip" data-placement="bottom" title="Recette complétement annotée" />
        @endif        
    </div>
</h4>
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
<br/>
<p class="card-text text-truncate mb-0">{{ $recipe->content }}</p>
<p class="text-right"><a class="" href="{{ route('recipes.show',$recipe) }}">lire la suite...</a>
    <br/>
        
    @if(!$recipe->annotated)
    <a href="{{ route('recipes.annotations', $recipe) }}"  class="btn annotate-button active-button">Annoter la recette</a>
    @elseif(!$recipe->validated)
    <a href="{{ route('recipes.annotations', $recipe) }}"  class="btn validate-button active-button">Valider la recette</a>
    @endif
</p>-->