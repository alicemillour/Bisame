@extends('layouts.app')
@section('style')
<link href="{{ asset('css/home.css') }}" rel="stylesheet" type="text/css" >
@endsection
@section('content')
<div class="container text-center">
    <div class="fill">
        <div class="info-message-trans">
            
            <div class="card background-colored">
                <h5 class="card-header text-center">Connexion</h5>
                <div class="card-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/login') }}">
                        {!! csrf_field() !!}
                        
                        <div class="form-group row{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label class="col-md-4 col-form-label text-right">Adresse e-mail ou Pseudo</label>
                            
                            <div class="col-md-6">
                                <input type="text" class="form-control" name="email" value="{{ old('email') }}">
                                
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
                                <a class="btn btn-link" href="{{ url('/password/reset') }}">Mot de passe oublié ?</a>
                                @if ($errors->has('password'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>                        
                        <div class="form-group row">
                            <div class="col-md-6 offset-md-3">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="remember"> Retenir mon mot de passe
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-6 offset-md-3">
                                <button type="submit" class="btn btn-success btn-lg">
                                    <i class="fa fa-btn fa-sign-in"></i>Connexion
                                </button>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-6 offset-md-3">
                                <a href="{{ url('register') }}">Pas encore inscrit ?</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
