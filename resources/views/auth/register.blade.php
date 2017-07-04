@extends('layouts.app')

@section('content')

@include('partials.nav')
<br>
<div class="container ">
    <div class="row">
        <div class="col-md-8 col-md-offset-2 ">
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
    <div class="info-wrapper">
        <h3 class="info-message" style="text-align: center; margin: 0 auto;">
            <br> L'<b class="ostrich">alsacien</b> fait partie de la grande majorité des "langues peu dotées" au sens des technologies du langage.</br>  
            <br> Aucun des outils des nouvelles technologies de la langue - par exemple : correction orthographique, aide à la traduction, extraction d'information - qui contribuent à faire exister les langues sur Internet n'est développé pour l'alsacien.</br> 
            <br> La raison ? Il existe très peu de données "annotées", c'est-à-dire enrichies d'informations linguistiques, à partir desquelles développer de tels outils.
            C'est pourquoi nous faisons appel à vous : locuteurs de l'alsacien, passionnés ou non de grammaire, désireux dans tous les cas de contribuer au déploiement de votre langue, participez grâce à <b><span class="ostrich"> BISAME</span> </b> à la création d'un corpus de l'alsacien annoté en catégories grammaticales !</br> 
            <br> Pour tout complément d'information sur ce projet de recherche réalisé dans le cadre d'un doctorat en Traitement Automatique des Langues à la Sorbonne en collaboration avec l'équipe du projet RESTAURE du LiLPa de Strasbourg, 
            <a style="color:#AC1E44;" href="mailto:alice.millour@abtela.eu?Subject=[Bisame]Contact" style="color:black" target="_top">Me contacter par mail</a>
            . </br> Ce projet étant en cours d'amélioration n'hésitez pas à me transmettre vos remarques ou suggestions !<br>
            <br> Alice 
            <br>
            <a style="color:#AC1E44;" href="https://www.francebleu.fr/emissions/l-alsace-vue-par-le-net-en-alsacien/elsass/l-alsace-vue-par-le-net-en-alsacien-57"
               target="_blank"> <br> <b> Lien vers la chronique de Pierre Nuss (France Bleu Elsass)</b></a> 
            <span>
                <img style="margin:1%" height="42" width="42" src="/images/fbe.png"/>  

            </span>
        </h3>
    </div>
    <center><h4>La création d'un compte ne vous engage à rien. Si vous ne souhaitez pas communiquer votre adresse e-mail, vous pouvez donner une adresse factice. Il faudra simplement vous en souvenir pour pouvoir vous connecter à nouveau !</h4>
    </center>
</div>

@endsection

@section('css')
<style type="text/css">

    .notbold{
        font-weight:normal !important;
    }
</style>

@stop