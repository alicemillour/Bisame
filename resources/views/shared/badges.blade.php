@if(Session::has('badge'))
    @component('components.modals.default', ['id' => 'badgeModal', 'footer'=>false])
        @slot('title')
            {{ __('badges.new') }}
        @endslot
        <div class="text-center">
        @if(Session::get('badge.required_value'))
            <h4>{{ (Session::get('badge.required_value')>1)? __('badges.'.Session::get('badge.key').'s',['number'=>Session::get('badge.required_value')]) : __('badges.'.Session::get('badge.key')) }}</h4>
        @else
            <h4>{{ __('badges.'.Session::get('badge.key'),['value'=>Session::get('badge.required_value_string')]) }}</h4>
        @endif
        <img style="width:50%;" src="{{ asset('img/badges/'.Session::get('badge.image')) }}" /><br/>
        @if(Session::has('next_badge'))
            @php
                $next_value = Session::get('next_badge.required_value') - Session::get('badge.required_value');
            @endphp
            <div class="my-4">
                {{ __('badges.next') }}
                <img class="" style="width:32px;" src="{{ asset('img/badges/'.Session::get('next_badge.image')) }}" />
                {{ ($next_value>1)? __('badges.next_badge.'.Session::get('badge.key').'s',['number' => $next_value]) : __('badges.next_badge.'.Session::get('badge.key')) }}
            </div>
        @endif
        </div>
    @endcomponent
@endif