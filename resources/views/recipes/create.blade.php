@extends('layouts.app')

@section('content')
<div class="row">
    <div id="create-recipe" class="col-12 col-md-6 offset-md-3 background-recipe fancy-border background-colored">

        <h1 class="text-center">{{ __('recipes.new-recipe') }} 
            <i class="fa fa-question-circle" 
               data-toggle="tooltip" data-placement="bottom" data-original-title="
               Les nouvelles recettes ainsi que les anecdotes sont intégrées au corpus collaboratif."


               style="font-size:20px; position:absolute; margin-right:5px;
               "></i></span> 

        </h1>
        {!! Form::open(['route' => 'recipes.store', 'method' => 'post', 'id' => 'form-recipe']) !!}

        {!! Form::control('text', 'col-12', 'title', $errors, null, null, null, __('recipes.title')) !!}

        <div class="align-content-start" id="container-ingredients">
            <div class="d-flex">
                <div class="col-6">
                    <label for="description" class="control-label">{{ __('recipes.label-ingredient') }}</label>
                </div>
            </div>

            @php
            $_ingredients = array();
            if(null!==(old('ingredient')))
            foreach(old('ingredient') as $ingredient){
            $_ingredients[]=$ingredient;
            }
            @endphp

            @forelse ($_ingredients as $index_ingredient => $ingredient)
            <div class="d-flex row-ingredient">
                <div class="col-6">
                    <input type="text" name="ingredient[{{ $index_ingredient }}][name]" class="form-control d-inline ingredient-name {{ ($errors->has('ingredient.'.$ingredient['index'].'.name') ? ' is-invalid' : '') }}" value="{{ $ingredient['name'] }}" style="width:100%" placeholder="{{  __('recipes.ingredient') }}">
                    @if($errors->has('ingredient.'.$ingredient['index'].'.name'))
                    <span class="invalid-feedback">{{ $errors->first('ingredient.'.$ingredient['index'].'.name') }}</span>
                    @endif
                </div>
                <div class="col-auto my-auto">
                    <i class="fa fa-plus-circle add-ingredient mr-2" aria-hidden="true" onclick="addIngredient()"></i>
                    <i class="fa fa-trash remove-ingredient" aria-hidden="true" onclick="removeIngredient(this)"></i>
                    <input type="hidden" name="ingredient[{{ $index_ingredient }}][index]" value="{{ $index_ingredient }}" />
                </div>
            </div>
            @empty
            <div class="d-flex row-ingredient">
                <div class="col-6">
                    <input type="text" name="ingredient[0][name]" class="form-control d-inline ingredient-name" value="" style="width:100%" placeholder="{{  __('recipes.ingredient') }}">
                </div>
                <div class="col-auto my-auto">
                    <i class="fa fa-plus-circle add-ingredient mr-2" aria-hidden="true" onclick="addIngredient()"></i>
                    <i class="fa fa-trash remove-ingredient" aria-hidden="true" onclick="removeIngredient(this)"></i>
                    <input type="hidden" name="ingredient[0][index]" value="0" />
                </div>
            </div>
            @endforelse
        </div>

        <div class="form-group col-12 mt-3">
            {!! Form::textarea('content', null, array('class' => 'form-control', 'id' => 'content', 'placeholder'=>__('Préparation de la recette (texte libre)')) ) !!}
        </div>

        @if($errors->has('content'))
        <span class="invalid-feedback">{{ $errors->first('content') }}</span>
        @endif

        {!! Form::control('textarea', 'col-12', 'anecdote', $errors, null, old('anecdote')??'', null, __('recipes.add-anecdote') ) !!}
        <div class="ml-3 mb-3">
            <button class="btn btn-primary btn-sm" type="button" data-toggle="collapse" data-target="#collapseTimes" aria-expanded="false" aria-controls="collapseTimes">
                Ajouter les temps de préparation et cuisson
            </button>
            <button class="btn btn-primary btn-sm d-none" type="button" data-toggle="collapse" data-target="#collapseServings" aria-expanded="false" aria-controls="collapseServings">
                Ajouter le nombre de portions
            </button>
        </div>
        <div class="collapse mb-1" id="collapseTimes">
            <div class="d-flex">
                <div class="col-3 align-content-start">
                    <label for="description" class="control-label">{{ __('recipes.preparation-time') }}</label>	
                </div>
                <div class="col-3">

                    <input type="number" name="preparation_time_hour" class="time form-control d-inline {{ ($errors->has('preparation_time_hour') ? ' is-invalid' : '') }}" value="{{ old('preparation_time_hour')??0 }}" style="width:4rem">
                    <label for="description" class="control-label">{{ __('recipes.hours') }}</label>

                    @if($errors->has('preparation_time_hour'))
                    <span class="invalid-feedback">{{ $errors->first('preparation_time_hour') }}</span>
                    @endif

                </div>
                <div class="col-3">

                    <input type="number" name="preparation_time_minute" class="time form-control d-inline {{ ($errors->has('preparation_time_minute') ? ' is-invalid' : '') }}" value="{{ old('preparation_time_minute')??0 }}" style="width:4rem">
                    <label for="description" class="control-label">{{ __('recipes.minutes') }}</label>

                    @if($errors->has('preparation_time_minute'))
                    <span class="invalid-feedback">{{ $errors->first('preparation_time_minute') }}</span>
                    @endif

                </div>
            </div>
            <div class="d-flex">
                <div class="col-3 align-content-start">
                    <label for="description" class="control-label">{{ __('recipes.cooking-time') }}</label>
                </div>
                <div class="col-3">
                    <input type="number" name="cooking_time_hour" class="time form-control d-inline {{ ($errors->has('cooking_time_hour') ? ' is-invalid' : '') }}" value="{{ old('cooking_time_hour')??0 }}" style="width:4rem"> 
                    <label for="cooking_time_hour" class="control-label">{{ __('recipes.hours') }}</label>
                    @if($errors->has('cooking_time_hour'))
                    <span class="invalid-feedback">{{ $errors->first('cooking_time_hour') }}</span>
                    @endif
                </div>
                <div class="col-3">
                    <input type="number" name="cooking_time_minute" class="time form-control d-inline {{ ($errors->has('cooking_time_minute') ? ' is-invalid' : '') }}" value="{{ old('cooking_time_minute')??0 }}" style="width:4rem">
                    <label for="cooking_time_minute" class="control-label">{{ __('recipes.minutes') }}</label>
                    @if($errors->has('cooking_time_minute'))
                    <span class="invalid-feedback">{{ $errors->first('cooking_time_minute') }}</span>
                    @endif
                </div>
            </div>
        </div>
        <div class="ml-3 mb-3">
            <button class="btn btn-primary btn-sm d-none" type="button" data-toggle="collapse" data-target="#collapseTimes" aria-expanded="false" aria-controls="collapseTimes">
                Ajouter les temps de préparation et cuisson
            </button>
            <button class="btn btn-primary btn-sm" type="button" data-toggle="collapse" data-target="#collapseServings" aria-expanded="false" aria-controls="collapseServings">
                Ajouter le nombre de portions
            </button>
        </div>
        <div class="collapse mb-1" id="collapseServings">
            <div class="d-flex">
                <div class="col-3 align-content-start">
                    <label for="description" class="control-label">{{ __('recipes.label-servings') }}</label>
                </div>
                <div class="col-3">
                    <input type="number" name="servings" id="servings" class="form-control d-inline {{ ($errors->has('servings') ? ' is-invalid' : '') }}" value="{{ old('servings')??0 }}" style="width:4rem">
                    <label for="servings" class="control-label">{{ __('recipes.persons') }}</label>
                    @if($errors->has('servings'))
                    <span class="invalid-feedback">{{ $errors->first('servings') }}</span>
                    @endif		
                </div>
            </div>
        </div>
        <div class="d-flex flex-row" style="padding-right: 15px;padding-left: 15px;">

            <span class="input-group-btn">
                <label class="btn btn-primary btn-sm">
                    <input type="file" id="photo" name="photo" style="display:none;"/>
                    <i class="fa fa-picture-o"></i> Ajouter une photo
                </label>
            </span>

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
            {!! Form::submit('Enregistrer la recette', ['id'=>'btn-create','class'=>'btn btn-success']) !!}
        </div>

        {!! Form::close() !!}
    </div>
</div>
@endsection

@section('scripts')
<script type="text/javascript">
    @include('js.recipe')
</script>
@endsection