@extends('layouts.app', ['meta_description' => 'Contact Form'])

@section('content')
<br>
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default background-colored">
                <div class="panel-heading background-colored center">Formulaire de contact</div>
                <div class="panel-body"></div>
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/contact') }}">
                    <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                        <div class="form-group">
                            <label class="col-md-4 control-label">Nom</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="name" value="{{ old('name') }}"> 
                                </div>
                        </div>
                        
                        <div class="form-group">
                        <label class="col-md-4 control-label">Adresse e-mail</label>
                            <div class="col-md-6">
                                    <input type="email" class="form-control" name="email" value="{{ old('email') }}">
                            </div>
                        </div> 
                        <div class="form-group">
                        <label class="col-md-4 control-label">Votre message</label>
                            <div class="col-md-6">
                                <textarea rows="8" class="form-control" id="message"
                                          accesskey=""name="message">{{ old('message') }}</textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-8">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-btn fa-envelope-o"></i>Envoyer
                                </button>
                            </div>
                        </div>
                    </form>
                
            </div>
            
                            
        </div>
    </div>                    
      </div>
    </div>
  </div>
@endsection