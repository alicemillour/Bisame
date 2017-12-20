@extends('layouts.app')
@section('style')
<link href="{{ asset('css/home.css') }}" rel="stylesheet" type="text/css" >
@endsection
@section('content')
<div class="container text-center">
        <div class="fill">
                <div class="info-message-trans background-colored fancy-border">
                    
                <div class="card background-colored">
                    <h5 class="card-header text-center">Inscription (<i>Vos informations personnelles ne seront pas conservées</i>)</h5>
                    <div class="card-body">
                        <form class="form-horizontal" role="form" method="POST" action="{{ url('/register') }}">
                            {!! csrf_field() !!}
                            <div class="info-message mb-2">
                                Il est nécessaire de s'inscrire pour pouvoir participer. Pour toute question, 
                                <a href="mailto:alice.millour@abtela.eu?Subject=[Bisame]Inscription" style="color:black" target="_top">me contacter</a>
                            </div>
                                
                            <div class="form-group row{{ $errors->has('name') ? ' has-error' : '' }}">
                                <label class="col-md-4 col-form-label text-right">Nom d'utilisateur/Pseudo <span class="notbold" style="color: red;">*</span><br><span style="font-size: smaller"><i>(susceptible d'apparaître dans le tableau des scores)</i></span></label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="name" value="{{ old('name') }}">
                                    @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                                
                            <div class="form-group row{{ $errors->has('email') ? ' has-error' : '' }}">
                                <label class="col-md-4 col-form-label text-right">Adresse e-mail <span class="notbold" style="color: red;">**</span></label> 
                                    
                                <div class="col-md-6">
                                    <input type="email" class="form-control" name="email" value="{{ old('email') }}">
                                        
                                    @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                                
                            <div class="form-group row{{ $errors->has('password') ? ' has-error' : '' }}">
                                <label class="col-md-4 col-form-label text-right">Mot de passe</label>
                                    
                                <div class="col-md-6">
                                    <input type="password" class="form-control" name="password">
                                        
                                    @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                                
                            <div class="form-group row{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                                <label class="col-md-4 col-form-label text-right">Confirmation du mot de passe</label>
                                    
                                <div class="col-md-6">
                                    <input type="password" class="form-control" name="password_confirmation">
                                        
                                    @if ($errors->has('password_confirmation'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                                
                            <div class="form-group row">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fa fa-btn fa-user"></i>Inscription
                                    </button>
                                </div>
                            </div>
                            <div class="info-message text-center small">
                                <span class="notbold" style="color: red;">*</span> Choix du pseudonyme, exemples: personnage de BD/film/série, 3 lettres du nom+3 lettres du prénom (évitez de mettre votre nom de famille).<br/>
                                <span class="notbold" style="color: red;">**</span><strong>Facultatif</strong> (vous pouvez créer un compte sans adresse email. Le cas échéant,
                                nous ne serons pas en mesure de prendre contact avec vous, 
                                ni de réinitialiser votre mot de passe.)
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    
        <div class="fill mt-3 text-left">
            <div class="info-message-trans background-colored fancy-border">
                <alert>TODO : adapter la charte à la plate forme PLURAL</alert>
                @include('partials.' . App::getLocale() . '-charte')
            </div>
        </div>

        <div class="fill mt-3">
            <div class="info-message-trans background-colored fancy-border">
                @include('partials.' . App::getLocale() . '-intro')
        
            </div>
        </div>

        
</div>

@endsection

@section('style')
<style type="text/css">
    
    .notbold{
        font-weight:normal !important;
    }
</style>

@stop