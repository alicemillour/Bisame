@if($user->avatar)
<img src="{{ asset('img/avatars/'.$user->avatar->image) }}" class="avatar d-inline" />
@endif