@extends('layouts.app', ['meta_description' => 'Contact Form'])

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card background-colored">
                <h6 class="card-header text-center" style="font-size: 1.3em"> <b> Une question, un commentaire, une critique, une idée d’amélioration ? C'est ici !</b>
                </h6>
                <div class="card-body"></div>
                <form class="form-horizontal" role="form" method="POST" action="{{ url('/contact') }}">
                    {!! csrf_field() !!}

                    <div class="form-group row{{ $errors->has('name') ? ' has-error' : '' }}">
                        <label class="col-md-4 col-form-label text-right">Nom</label>
                        <div class="col-md-6">
                            @if (Auth::guest())
                            <input type="text" class="form-control" name="name" value="{{old('name')}}">
                            @else
                            <input type="text" class="form-control" name="name" value="{{$name}}"> 
                            @endif
                            @if ($errors->has('name'))
                            <span class="help-block">
                                <strong>{{ $errors->first('name') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row{{ $errors->has('email') ? ' has-error' : '' }}">
                        <label class="col-md-4 col-form-label text-right">Adresse e-mail</label>
                        <div class="col-md-6">
                            @if (Auth::guest())
                            <input type="email" class="form-control" name="email" value="{{old('email')}}">
                            @else
                            <input type="email" class="form-control" name="email" value="{{$email}}">
                            @endif
                            @if ($errors->has('email'))
                            <span class="help-block">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div> 
                    <div class="form-group row{{ $errors->has('message') ? ' has-error' : '' }}">
                        <label class="col-md-4 col-form-label text-right">Votre message</label>
                        <div class="col-md-6">
                            <textarea rows="8" class="form-control" id="message"
                                      accesskey="" name="message" placeholder="">{{ old('message') }}</textarea>
                            @if ($errors->has('message'))
                            <span class="help-block">
                                <strong>{{ $errors->first('message') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div> 
                    <div class="form-group row">
                        <div class="col-md-6 offset-md-8">
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-btn fa-envelope-o"></i>Envoyer
                            </button>
                        </div>
                    </div>
            </div>
            </form>
        </div>
    </div>
</div>
@endsection