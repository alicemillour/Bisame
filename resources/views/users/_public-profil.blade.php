<h3 class="card-title">Badges</h3>
<p class="card-text">
@php
  $badges_user = $user->badges->pluck('key','id');
@endphp

  @foreach($badges as $badge)
    @if($badges_user->has($badge->id))
      <img data-toggle="tooltip" title="{{ ($badge->required_value>1) ? __('badges.tooltip.recipes', ['number'=>$badge->required_value]) : __('badges.tooltip.recipe') }}" class="badge-user" src="{{ asset('img/badges/'.$badge->image) }}" />
    @else
      <img data-toggle="tooltip" title="{{ ($badge->required_value>1) ? __('badges.tooltip.recipes', ['number'=>$badge->required_value]) : __('badges.tooltip.recipe') }}" class="badge-user disabled-badge" src="{{ asset('img/badges/'.$badge->image) }}" />
    @endif
  @endforeach
</p>
