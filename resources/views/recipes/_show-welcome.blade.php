<h6 class="card-subtitle mb-1 text-muted">{{ link_to_route('recipes.show', $recipe->title, $recipe, ['class' => 'card-link' ]) }}
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
</h6>
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
{{-- @if(!$recipe->annotated) --}}
  <a href="{{ route('recipes.annotations', $recipe) }}" class="btn annotate-button active-button">annoter la recette</a>  
{{-- @endif --}}
</p>
<hr/>