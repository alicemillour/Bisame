<div class="card">

  <div class="card-body">
  	<div>
	    <div class="float-right pl-1" style="width:47%;">
	      @if($recipe->medias->count()>0)
	        <img src="{{ asset($recipe->medias->first()->filename) }}" style="width:100%;" />
	      @endif
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
				@if($recipe->validated)
					<img class="" style="width:32px;" src="{{ asset('img/badges/colored-laurel.svg') }}" />
				@elseif($recipe->annotated)
					<img class="" style="width:32px;" src="{{ asset('img/badges/laurel.svg') }}"  data-toggle="tooltip" data-placement="bottom" title="Recette complétement annotée" />
				@endif
			</div>

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
	
    <div class="card-text text-truncate">{{ $recipe->content }}</div>
    <div class="card-text text-right">{{ link_to_route('recipes.show', "lire la suite...", $recipe) }}</div>


  </div>
</div>