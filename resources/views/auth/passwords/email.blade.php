@extends('layouts.app')

<!-- Main Content -->
@section('content')
<div class="container text-center">
    <div class="fill">
        <div class="info-message-trans">
            
            <div class="card background-colored">
                <h5 class="card-header text-center">Renouvellement du mot de passe</h5>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/password/email') }}">
                        {!! csrf_field() !!}

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label class="col-md-8 control-label">Entrez votre adresse e-mail pour définir un nouveau mot de passe</label>

                            <div class="col-md-6 offset-md-3">
                                <input type="email" class="form-control" name="email" value="{{ old('email') }}">

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 offset-md-3">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-btn fa-envelope"></i>Envoyer un lien de renouvellement de mot de passe
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
