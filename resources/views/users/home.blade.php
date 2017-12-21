@extends('layouts.app')

@section('content')
<h1 class="text-center"> Hopla {{ $user->name }} !</h1>

<div class="row">
    <div class="col-lg-7">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Profil</h4>
                <p class="card-text">
                    @include('users/_profil')
                </p>
                <!--<div class="container">-->
                    <button type="button" class="btn btn-danger"onclick="$('#modalDeleteAccount').modal();">Supprimer mon compte</button>
                <!--</div>-->
            </div>
        </div>
    </div>
    <div class="col-lg-5 pt-3 pt-lg-0">
        <div class="card">
            <div class="card-body">
                <h3 class="card-title">Statistiques</h3>
            </div>
        </div>
        <div class="card mt-3">
            <div class="card-body">
                <h3 class="card-title">{{ __('recipes.your-last-recipes') }}</h3>
                
                @forelse ($recipes as $recipe)
                <h6 class="card-subtitle mb-1 text-muted">{{ link_to_route('recipes.show', $recipe->title, $recipe, ['class' => 'card-link' ]) }}</h6>
                <p class="card-text text-truncate">{{ $recipe->content }}</p>
                
                @empty
                <p class="card-text">Vous n'avez pas encore saisi de recette</p>
                @endforelse	
                <a href="{{ route('recipes.create') }}" class="card-link">{{ __('recipes.new-recipe') }}</a>
                <br> <a href="{{ route('recipes.user',$user) }}" class="card-link">{{ __('recipes.my-recipes') }}</a>
                <br> <a href="{{ route('recipes.show',$user) }}" class="card-link">{{ __('recipes.all') }}</a>
            </div>
        </div>
        <div class="card mt-3">
            <div class="card-body">
                <h3 class="card-title">Badges</h3>
                <p class="card-text">
                    @include('users/_badges')
                </p>
            </div>
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
