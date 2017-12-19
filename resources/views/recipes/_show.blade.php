<div class="card">


  <div class="card-body">
  	<div>
	    <div class="float-right pl-1" style="width:47%;">
	      @if($recipe->medias->count()>0)
	        <img src="{{ asset($recipe->medias->first()->filename) }}" style="width:100%;" />
	      @endif
		    <div class="float-right">
		        <i class="fa fa-heart fa-2x likeable" aria-hidden="true" data-toggle="tooltip" data-placement="bottom" title="
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
				<span class="likes-count badge badge-pill badge-primary badge-notify" data-id="{{ $recipe->id }}">{{ $recipe->likes_count }}</span>
			</div>	

	    </div>
	    <h4>{{ link_to_route('recipes.show', $recipe->title, $recipe) }}</h4>
	</div>
	<p class="card-text">
		<small class="text-muted">
		{{ __('recipes.recipe-by') }}
		{{ link_to_route('users.show', $recipe->author->name, $recipe->author) }}</small>
	</p>
	
    <div class="card-text text-truncate">{{ $recipe->content }}</div>
    {{-- <p class="card-text"><small class="text-muted">{{ $recipe->created_at  }}</small></p> --}}

  </div>
</div>