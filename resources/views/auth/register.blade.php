@extends('layouts.app')
@section('style')
<link href="{{ asset('css/home.css') }}" rel="stylesheet" type="text/css" >
@endsection
@section('content')
    
@include('partials.nav')
<br>
<div class="container ">
    <div class="main-container ">
        <div class="fill">
                <div class="info-message-trans background-colored fancy-border">
                
                <div class="panel panel-default background-colored">
                    <div class="panel-heading background-colored text-center">Inscription (<i>Vos informations personnelles ne seront pas conservées</i>)</div>
                    <div class="panel-body">
                        <form class="form-horizontal" role="form" method="POST" action="{{ url('/register') }}">
                            {!! csrf_field() !!}
                            <h4 class="info-message text-center">
                                Il est nécessaire de s'inscrire pour pouvoir participer. Pour toute question, 
                                <a href="mailto:alice.millour@abtela.eu?Subject=[Bisame]Inscription" style="color:black" target="_top">me contacter</a>
                            </h4>
                            <br>
                            
                            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                <label class="col-md-4 control-label">Nom d'utilisateur <br><span style="font-size: smaller"><i>(susceptible d'apparaître dans le tableau des scores)</i></span></label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="name" value="{{ old('name') }}">
                                    @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            
                            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                <label class="col-md-4 control-label">Adresse e-mail <span class="notbold" style="color: red;">*</span></label> 
                                
                                <div class="col-md-6">
                                    <input type="email" class="form-control" name="email" value="{{ old('email') }}">
                                    
                                    @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            
                            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                <label class="col-md-4 control-label">Mot de passe</label>
                                
                                <div class="col-md-6">
                                    <input type="password" class="form-control" name="password">
                                    
                                    @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            
                            <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                                <label class="col-md-4 control-label">Confirmation du mot de passe</label>
                                
                                <div class="col-md-6">
                                    <input type="password" class="form-control" name="password_confirmation">
                                    
                                    @if ($errors->has('password_confirmation'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fa fa-btn fa-user"></i>Inscription
                                    </button>
                                </div>
                            </div>
                            <h5 class="info-message text-center">
                                <span class="notbold" style="color: red;">*</span> Vous pouvez créer un compte avec une adresse invalide. Le cas échéant,
                                nous ne serons pas en mesure de prendre contact avec vous, 
                                ni de réinitialiser votre mot de passe.
                            </h5>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
        <br/>
    <div class="main-container">
        <div class="fill">
            <div class="info-message-trans background-colored fancy-border">
                <!-- TODO DIFF @include('partials.alsacien-intro') -->
                @include('partials.creole-intro')
            </div>
        </div>
    </div>
    
</div>
    
@endsection
    
@section('css')
<style type="text/css">
    
    .notbold{
        font-weight:normal !important;
    }
</style>
    
@stop