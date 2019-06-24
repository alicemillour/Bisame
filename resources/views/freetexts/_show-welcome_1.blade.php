<div>
    <div class="float-right pl-1" style="width:100%;">
        <div class="float-right">
            <i class="fa fa-heart likeable" aria-hidden="true" data-toggle="tooltip" data-placement="bottom" title="
               @auth
               @if(Auth::user()->likesEntity($poem))
               Vous aimez cette recette
               @else
               Aimer cette recette  
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
            if($poem->annotated)
            <img class="" style="width:20px;" src="{{ asset('img/badges/laurel.svg') }}"  data-toggle="tooltip" data-placement="bottom" title="Recette complétement annotée" />
            @endif
        </div>
    </div>
    <!--    <div class="float-right pl-1" style="width:24%;">
            <div class="float-right">
                <i class="fa fa-heart likeable" aria-hidden="true" data-toggle="tooltip" data-placement="bottom" title="
                   @auth
                   @if(Auth::user()->likesEntity($poem))
                   Vous aimez cette recette
                   @else
                   Aimer cette recette  
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
                if($poem->annotated)
                <img class="" style="width:20px;" src="{{ asset('img/badges/laurel.svg') }}"  data-toggle="tooltip" data-placement="bottom" title="Recette complétement annotée" />
                @endif
            </div>
                
        </div>-->
    @if($poem->medias->count()>0)
    <h4>{{ link_to_route('poems.show', $poem->title, $poem) }}</h4>
    <div class="container">
        <div class="row">
            <div class="col-md-6">            
                <img src="{{ asset($poem->medias->first()->filename) }}" style="margin-left: auto; 
                     margin-right: auto;
                     display: block;max-height:100%; max-width:100%;" />
                
            </div>
            <div class="col-md-6">
                
                
                
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
                
                <div class="card-text text-truncate">{{ $poem->content }}</div>
                <div class="card-text text-right">{{ link_to_route('poems.show', "lire la suite...", $poem) }}</div>
                <div class="card-text text-right">
                    @if(!$poem->annotated)
                    <a href="{{ route('poems.annotations', $poem) }}"  class="btn annotate-button active-button">Annoter la recette</a>
                    @elseif(!$poem->validated)
                    <a href="{{ route('poems.annotations', $poem) }}"  class="btn validate-button active-button">Valider la recette</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @else 
    
    <h4>{{ link_to_route('poems.show', $poem->title, $poem) }}</h4>
    
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
    
    <div class="card-text text-truncate">{{ $poem->content }}</div>
    <div class="card-text text-right">{{ link_to_route('poems.show', "lire la suite...", $poem) }}</div>
    <div class="card-text text-right">
        @if(!$poem->annotated)
        <a href="{{ route('poems.annotations', $poem) }}"  class="btn annotate-button active-button">Annoter la recette</a>
        @elseif(!$poem->validated)
        <a href="{{ route('poems.annotations', $poem) }}"  class="btn validate-button active-button">Valider la recette</a>
        @endif
    </div>
    @endif
</div>
<hr/>
