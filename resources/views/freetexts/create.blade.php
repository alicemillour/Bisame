@extends('layouts.app')

@section('content')

<div class="row">
    <div id="create-freetext" class="col-12 col-md-6 offset-md-3 background-freetext fancy-border background-colored">


        <h3 class="card-header text-center belle-allure" style="background-color: transparent; border-bottom-color: transparent"> {{ __($type.'.new') }} 
            <i class="fa fa-question-circle" 
               data-toggle="tooltip" data-placement="top" data-original-title="
               Les nouvelles {{__($type.'.type_pl')}} ainsi que les anecdotes sont intégrées au corpus collaboratif."
               style="font-size:20px; position:absolute; margin-right:5px;"></i></span> 

        </h3>
        <div class="card-body">
            {!! Form::open(['route' => 'freetexts.store', 'method' => 'post', 'id' => 'form-freetext']) !!}
            <!--category is 1 for freetexts-->

            @if ($type == "freetext")
            <input type = "hidden" name = "category_id" value = "2" />
            @endif
            

            {!! Form::control('text', 'col-12', 'title', $errors, null, null, null, __($type.'.title')) !!}
            
            
            {{ trans($type.'.titre-texte') }}
            <div class="form-group col-12 mt-3">
                {!! Form::textarea('content', null, array('class' => 'form-control', 'id' => 'content', 'placeholder'=>__($type.'.placeholder-description')) ) !!}
            </div>

            @if($errors->has('content'))
            <span class="invalid-feedback">{{ $errors->first('content') }}</span>
            @endif

            {!! Form::control('textarea', 'col-12', 'anecdote', $errors, null, old('anecdote')??'', null, __($type.'.add-anecdote') ) !!}
            <div class="d-flex flex-row" style="padding-right: 15px;padding-left: 15px;">

                <span class="input-group-btn">
                    <label class="btn btn-primary btn-sm">
                        <input type="file" id="photo" name="photo" style="display:none;"/>
                        <i class="fa fa-picture-o"></i> Ajouter une photo
                    </label>
                   (Choisissez une photo de taille inférieure à 1,5Mo. Le chargement de l'image peut prendre un peu de temps.)
                </span>
                <!--{{ Form::checkbox('open_source_picture') }} Je confirme que j'ai le droit d'utiliser cette photo (photo prise par vous-même ou libre de droit.-->

            </div>

            <div id="thumbnails">
                @if(old('photos'))
                @foreach(old('photos') as $photo)
                <div class="thumbnail ml-3 d-inline-block">
                    <img src="{{ asset($photo) }}" class="" />
                    <input type="hidden" name="photos[]" value="{{ $photo }}" /><br/>
                    <label>
                        <input type="radio" name="cover_picture" value="{{ $photo }}" {{ ($photo == old('cover_picture'))? 'checked="checked"':'' }}/> Photo de couverture
                    </label>
                </div>	
                @endforeach
                @endif
            </div>

            <div class="form-group col-12 mt-3">
                {!! Form::submit('Enregistrer le '.__($type.'.type'), ['id'=>'btn-create','class'=>'btn btn-success']) !!}
            </div>
            {!! Form::close() !!}
            
        </div>

    </div>
</div>
<div id="container-loader" class="d-none">
    <h1 id="text-loader" class="mx-auto text-center" style="">Traitement en cours. Veuillez patienter...</h1>
    <div class="text-center"><i id="loader" class="fa fa-spinner fa-spin fa-3x fa-fw mt-3"></i></div>
</div>
@endsection

@section('scripts')
<script type="text/javascript">
    @include('js.recipe')
</script>
@endsection
@section('style')
<style type="text/css">
#container-loader {
    position:absolute;
    top:0;
    left:0;
    background-color:black;
    opacity:0.8;
    height:100%;
    width:100%;
    z-index:200;
}
#text-loader {
    color:white;
    margin-top:5%;
}
#loader {
    color:white;
}

.ingredient-name{
    margin-bottom: 1em;
}
</style>
@endsection