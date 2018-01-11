@extends('layouts.app')
@section('style')
<link href="{{ asset('css/home.css') }}" rel="stylesheet" type="text/css" >
@endsection
@section('content')
<div class="container text-center">
    <div class="fill">
        <div class="info-message-trans">
            
            <div class="card background-colored">
                <h5 class="card-header text-center">Inscription (<i>Vos informations personnelles ne sont pas conservées</i>)</h5>
                <div class="card-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/register') }}">
                        {!! csrf_field() !!}
                        <div class="form-group row{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label class="col-md-4 col-form-label text-right">Nom d'utilisateur / Pseudo&nbsp;<br><span style="font-size: smaller"></span></label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" name="name" value="{{ old('name') }}" >
                                @if ($errors->has('name'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="info-message small">
                            <strong> Exemples </strong>: personnage de BD/film/série, 3 lettres de votre prénom+3 lettres de votre nom <br>(afin de préserver votre anonymat, nous conseillons de ne pas utiliser votre prénom et votre nom de famille complets dans votre pseudonyme).<br/>
                            <br>
                        </div>
                        <div class="form-group row{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label class="col-md-4 col-form-label text-right">Mot de passe&nbsp;</label>
                                
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
                            <label class="col-md-4 col-form-label text-right">Confirmation du mot de passe&nbsp;</label>
                                
                            <div class="col-md-6">
                                <input type="password" class="form-control" name="password_confirmation">
                                    
                                @if ($errors->has('password_confirmation'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('password_confirmation') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        
                        
                        <hr>
                        <div class="form-group row{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label class="col-md-4 col-form-label text-right">Adresse e-mail </label> 
                                
                            <div class="col-md-6">
                                <input type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="(facultatif)">
                                    
                                @if ($errors->has('email'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="info-message text-center small">
                            Vous pouvez créer un compte sans adresse e-mail ; le cas échéant,
                            nous ne serons pas en mesure de prendre contact avec vous, 
                            ni de réinitialiser votre mot de passe. <br><br>
                        </div>                        
                        <hr>
                        <div class="form-group row">
                            <div class="col-md-6 offset-md-3">
                                <button type="submit" class="btn btn-success btn-lg">
                                    Valider mon inscription
                                </button>
                            </div>
                        </div>
                        <div class="info-message mb-2">
                            Pour toute question, contactez-nous <i>via</i> le
                            {!! link_to('contact','formulaire de contact',['target'=>'_blank']) !!}
                        </div> 
                    </form>
                </div>
            </div>
        </div>
    </div>
        
    <div class="fill mt-3 text-left">
        <div class="info-message-trans">
            
            <div class="card background-colored">
                <div class="info-message background-colored fancy-border">
                    @include('partials.' . App::getLocale() . '-charte')
                </div>
            </div>
        </div>
    </div>
        
    <div class="fill mt-3">
        <div class="info-message-trans">
            
            <div class="card background-colored">
                <div class="info-message background-colored fancy-border">
                    @include('partials.' . App::getLocale() . '-intro')
                        
                </div>
            </div>
        </div>
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