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

@endsection
