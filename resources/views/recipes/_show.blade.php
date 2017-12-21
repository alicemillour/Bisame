<div class="card">

  <div class="card-body">
  	<div>
	    <div class="float-right pl-1" style="width:47%;">
	      @if($recipe->medias->count()>0)
	        <img src="{{ asset($recipe->medias->first()->filename) }}" style="width:100%;" />
	      @endif
		    <div class="float-right">
		        <i class="fa fa-heart likeable" style="color:#ac1e44;" aria-hidden="true" data-toggle="tooltip" data-placement="bottom" title="
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
			</div>

	    </div>
	    <h4>{{ link_to_route('recipes.show', $recipe->title, $recipe) }}</h4>
	</div>
	<p class="card-text">
		<small class="text-muted">
		@component('users._avatar', ['user' => $recipe->author])

		@endcomponent
		{{ __('recipes.recipe-by') }}
		{{ link_to_route('users.show', $recipe->author->name, $recipe->author) }}</small>
	</p>
	
    <div class="card-text text-truncate">{{ $recipe->content }}</div>

  </div>
</div>