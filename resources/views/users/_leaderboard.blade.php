<div style="margin-top: 5px; display: inline-block;">
    <span class="score" style="color:black;text-align: center; display: inline-block;">
        @if($around_users != null)
            
        @foreach($around_users as $key=>$ar_user)
        @if($ar_user->id == $user->id)
        <span  style="text-align: center; display: inline-block; font-size: 1.3em;"> {{$rank + $key }}. @component('users._avatar', ['user' => $ar_user])@endcomponent
            {{$ar_user->name}} ({{intval($ar_user->real_score)}}&nbsp;points)
                   <!--</span> <span style="font-size: 0.7em; line-height: 10%">({{intval($user->score * $user->quantity)}}&nbsp; points) </span>--> 
        </span>
        @else
        <span  style="text-align: center; display: inline-block; font-size: 1em;"> {{$rank + $key }}. @component('users._avatar', ['user' => $ar_user])@endcomponent
            {{$ar_user->name}} ({{intval($ar_user->real_score)}}&nbsp;points)
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