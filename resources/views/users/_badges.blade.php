@php
  $badges_user = $user->badges->pluck('key','id');
  $key ='';
@endphp

@foreach($badges as $badge)
	@if($badge->key!=$key)
		{{-- <h6>{{ __('badges.label-'.$badge->key) }}</h6> --}}
		<div class="mb-2"></div>
		@php
		  $key =$badge->key;
		@endphp		
	@endif
	@if($badge->required_value_string)
	  <img data-toggle="tooltip" title="{{ __('badges.tooltip.'.$badge->key, ['value'=>$badge->required_value_string]) }}" class="badge-user {{ $badges_user->has($badge->id)? '':'disabled-badge' }}" src="{{ asset('img/badges/'.$badge->image) }}" />
	@else
	  <img data-toggle="tooltip" title="{{ ($badge->required_value>1) ? __('badges.tooltip.'.$badge->key.'s', ['number'=>$badge->required_value]) : __('badges.tooltip.'.$badge->key.'') }}" class="badge-user {{ $badges_user->has($badge->id)? '':'disabled-badge' }}" src="{{ asset('img/badges/'.$badge->image) }}" />
	@endif
@endforeach