@extends('layouts.app')

@section('content')

<div id="home" style="max-width: 95%; margin: 0 auto;">
    <div class="row">
        <div class="col-lg-7 clearfix">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title text-center "> <span class="belle-allure"> Hopla {{ $user->name }} !</span>
                        <span class="float-right">                    	
                            @if($user->avatar)
                            <img id="avatar"  style="width:50px" src="{{ asset('img/avatars/'.$user->avatar->image) }}" />
                            <button onclick="$('#avatarsModal').modal('show');" class="btn btn-success">Modifier mon avatar</button>
                            @else
                            <button id="choose-avatar" onclick="$('#avatarsModal').modal('show');" class="btn btn-success">Choisi un avatar</button>
                            @endif
                        </span>
                    </h4>
                    <p class="card-text">
                        @include('users/_profil')
                    </p>
                    <hr/>
                    <h4 class="card-title mt-3" id="notifications">Notifications par email </h4>
                    <h5 class="card-title mt-3">M'avertir quand :</h5>
                    {!! Form::open(['url' => route('users.update-notifications')]) !!}
                    @foreach($notifications as $notification)
                        @if(!$notification->is_admin)
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="notification{{ $notification->id }}" name="notifications[]" value="{{ $notification->id }}" {{ $user->isSuscribedTo($notification->id)?'checked':'' }}>
                                <label class="form-check-label" for="notification{{ $notification->id }}">{{ __('notifications.'.$notification->slug) }}</label>
                            </div>
                        @endif
                    @endforeach
                    @if($user->isAdmin())
                        <h5 class="card-title mt-3">Notifications pour les admins</h5>
                        @foreach($notifications as $notification)
                            @if($notification->is_admin)
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="notification{{ $notification->id }}" name="notifications[]" value="{{ $notification->id }}" {{ $user->isSuscribedTo($notification->id)?'checked':'' }}>
                                    <label class="form-check-label" for="notification{{ $notification->id }}">{{ __('notifications.'.$notification->slug) }}</label>
                                </div>
                            @endif
                        @endforeach
                    @endif
                    <div class="text-right">
                        <button type="submit" class="btn btn-success">Enregistrer</button>
                    </div>
                    {!! Form::close() !!}
                    <hr/>
                    <h4 class="card-title mt-3">Suppression de votre compte</h4>
                    <div class="text-right">
                        <button type="button" class="btn btn-danger"onclick="$('#modalDeleteAccount').modal();">Supprimer mon compte</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-5 pt-3 pt-lg-0">
            <div class="card">
                <div class="card-body">
                    <h3 class="welcome-card-header belle-allure">{{ __('recipes.my-badges') }}</h3>
                    <p class="card-text">
                        @include('users/_badges')
                    </p>
                </div>
            </div>        	
            <div class="card mt-3">
                <div class="card-body">
                    <h3 class="card-title">{{ __('recipes.my-last-recipes') }}</h3>
                    
                    @forelse ($recipes as $recipe)
                    <h6 class="card-subtitle mb-1 text-muted">{{ link_to_route('recipes.show', $recipe->title, $recipe, ['class' => 'card-link' ]) }}
                        <div class="d-inline float-right">
                            <i class="fa fa-heart like"></i>
                            <span class="likes-count">{{ $recipe->likes->count() }}</span>
                        </div>
                    </h6>
                    <p class="card-text text-truncate mb-0">{{ $recipe->content }}</p>
                    <p class="card-text text-right">{{ link_to_route('recipes.show', "lire la suite...", $recipe, ['class' => '' ]) }}</p>
                    <hr/>
                    @empty
                    <p class="card-text">Vous n'avez pas encore saisi de recette</p>
                    @endforelse	
                    <a href="{{ route('recipes.create') }}" class="card-link">{{ __('recipes.new-recipe') }}</a>
                    <br> <a href="{{ route('recipes.user',$user) }}" class="card-link">{{ __('recipes.my-recipes') }}</a>
                    <br> <a href="{{ route('recipes.index') }}" class="card-link">{{ __('recipes.all') }}</a>
                </div>
            </div>
<!--            <div class="card mt-3">
                <div class="card-body">
                    <h3 class="welcome-card-header">{{ __('recipes.my-stats') }}</h3>
                    @include('users/_leaderboard')
                </div>
            </div>            -->
        </div>
    </div>
</div>

<div class="modal fade" id="modalDeleteAccount" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h1>Suppression du compte</h1>
                {!! Form::open(['url' => 'user/delete', 'method' => 'get', 'role' => 'form', 'id'=>'form-delete']) !!} 
                <div class="form-group">
                    {{ trans('site.confirm-delete-account') }}
                </div>
                <button type="submit" class="btn btn-success">{{ trans('site.button-validate') }}</button>
                <button type="submit" class="btn btn-danger btn-default" data-dismiss="modal">{{ trans('site.cancel') }}</button>
                {!! Form::close() !!}		                					       	
                <div class="modal-footer">
                    
                </div>			        
            </div>        
        </div>
    </div>
</div>        

@endsection
