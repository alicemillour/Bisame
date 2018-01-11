<div style="margin-top: 5px; display: inline-block;">
    <span class="score" style="color:black;text-align: center; display: inline-block;">
        @if($around_users != null)
            @foreach($around_users as $key=>$user)
            @if($key == 2)
            <span  style="text-align: center; display: inline-block; font-size: 1.3em;"> {{$rank + $key - 2}}. @component('users._avatar', ['user' => $user])@endcomponent
     {{$user->name}} ({{intval($user->real_score)}}&nbsp;points)
            <!--</span> <span style="font-size: 0.7em; line-height: 10%">({{intval($user->score * $user->quantity)}}&nbsp; points) </span>--> 
            </span>
            @else
            <span  style="text-align: center; display: inline-block; font-size: 1em;"> {{$rank + $key - 2}}. @component('users._avatar', ['user' => $user])@endcomponent
     {{$user->name}} ({{intval($user->real_score)}}&nbsp;points)
                <!--<span style="font-size: 0.7em; line-height: 10%">({{intval($user->score * $user->quantity)}}&nbsp; points) </span>--> 
            </span>
            @endif
            <br>
            @endforeach
        @else 
            Rédigez des recettes ou annotez pour apparaître dans le classement !
        @endif
        </span>
</div>