@extends('layouts.app')

@section('content')
<div class="row">
<div id="create-recipe" class="col-12 col-md-6 offset-md-3 background-recipe">

<h1 class="text-center">{{ __('recipes.new-recipe') }}</h1>

{!! Form::open(['route' => 'recipes.store', 'method' => 'post']) !!}

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
{{-- 		<div class="col-3">
			<input type="text" name="ingredient[{{ $index_ingredient }}][quantity]" class="form-control d-inline quantity {{ ($errors->has('ingredient.'.$ingredient['index'].'.quantity') ? ' is-invalid' : '') }}" value="{{ $ingredient['quantity'] }}" style="width:100%" placeholder="{{  __('recipes.quantity') }}">
			@if($errors->has('ingredient.'.$ingredient['index'].'.quantity'))
			    <span class="invalid-feedback">{{ $errors->first('ingredient.'.$ingredient['index'].'.quantity') }}</span>
			@endif
		</div>
		<div class="col-auto">
			(de)
		</div> --}}
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
{{-- 		<div class="col-3">
			<input type="text" name="ingredient[0][quantity]" class="form-control d-inline quantity" value="" style="width:100%" placeholder="{{  __('recipes.quantity') }}">
		</div>
		<div class="col-auto">
			(de)
		</div> --}}
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
	<textarea id="content" name="content" class="form-control" placeholder="Préparation de la recette (texte libre)" cols="50" rows="10">{{ old('content')??'' }}</textarea>
</div>
@if($errors->has('content'))
    <span class="invalid-feedback">{{ $errors->first('preparation_time_minute') }}</span>
@endif
{{-- {!! Form::control('textarea', 'col-12 mt-3', 'content', $errors, null, old('content')??'', null, 'Préparation de la recette (texte libre)') !!} --}}
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
		<div class="col-2">
			
			<input type="number" name="preparation_time_hour" class="form-control d-inline {{ ($errors->has('preparation_time_hour') ? ' is-invalid' : '') }}" value="{{ old('preparation_time_hour')??0 }}" style="width:4rem">
			<label for="description" class="control-label">{{ __('recipes.hours') }}</label>

			@if($errors->has('preparation_time_hour'))
			    <span class="invalid-feedback">{{ $errors->first('preparation_time_minute') }}</span>
			@endif

		</div>
		<div class="col-3">
			
			<input type="number" name="preparation_time_minute" class="form-control d-inline {{ ($errors->has('preparation_time_minute') ? ' is-invalid' : '') }}" value="{{ old('preparation_time_minute')??0 }}" style="width:4rem">
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
		<div class="col-2">
			<input type="number" name="cooking_time_hour" class="form-control d-inline {{ ($errors->has('cooking_time_hour') ? ' is-invalid' : '') }}" value="{{ old('cooking_time_hour')??0 }}" style="width:4rem"> 
			<label for="cooking_time_hour" class="control-label">{{ __('recipes.hours') }}</label>
			@if($errors->has('cooking_time_hour'))
			    <span class="invalid-feedback">{{ $errors->first('cooking_time_hour') }}</span>
			@endif
		</div>
		<div class="col-3">
			<input type="number" name="cooking_time_minute" class="form-control d-inline {{ ($errors->has('cooking_time_minute') ? ' is-invalid' : '') }}" value="{{ old('cooking_time_minute')??0 }}" style="width:4rem">
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
			<input type="number" name="servings" class="form-control d-inline {{ ($errors->has('servings') ? ' is-invalid' : '') }}" value="{{ old('servings')??4 }}" style="width:4rem"> 
			<label for="servings" class="control-label">{{ __('recipes.persons') }}</label>
			@if($errors->has('servings'))
			    <span class="invalid-feedback">{{ $errors->first('servings') }}</span>
			@endif		
		</div>
	</div>
</div>
<div class="d-flex flex-row" style="padding-right: 15px;padding-left: 15px;">
	<span class="input-group-btn">
		<button id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary btn-sm">
			<i class="fa fa-picture-o"></i> Ajouter une photo
		</button>
	</span>
	<input id="thumbnail" readonly="true" class="form-control {{ ($errors->has('filepath') ? ' is-invalid' : '') }}" type="text" name="filepath" value="{{ old('filepath') }}">
	@if($errors->has('filepath'))
		<span class="invalid-feedback">{{ $errors->first('filepath') }}</span>
	@endif
</div>
 <img id="holder" style="margin-top:15px;max-height:100px;" {!! old('filepath')? ' src="'.asset(old('filepath')).'"':''  !!} >

<div class="form-group col-12 mt-3">
	{!! Form::submit('Enregistrer la recette', ['id'=>'btn-create','class'=>'btn btn-success']) !!}
</div>

{!! Form::close() !!}
</div>
</div>
@endsection

@section('style')
<style type="text/css">
#holder {
  padding-left:15px;
}	
</style>

@endsection

@section('scripts')
<script src="{{ asset('vendor/laravel-filemanager/js/lfm.js') }}"></script>
<script type="text/javascript">
	$('#lfm').filemanager('image',{'prefix': '{{ asset('laravel-filemanager') }}' });
</script>
<script type="text/javascript">
    window.onload = function() {
      autosize($('#content'));
      autosize($('#anecdote'));
    };	
	var new_ingredient_html = function(index,quantity,name){
		quantity = quantity || '';
		name = name || '';
			// 	return '<div class="d-flex row-ingredient"><div class="col-3"> \
			// 	<input type="text" name="ingredient['+index+'][quantity]" class="form-control d-inline quantity" value="'+quantity+'"  \
			// 	 style="width:100%" placeholder="{{  __('recipes.quantity') }}"> \
			// </div><div class="col-auto">(de)</div> \
			// <div class="col-3"> \
			// 	<input type="text" name="ingredient['+index+'][name]" class="form-control d-inline ingredient-name" value="'+name+'" style="width:100%"  \
			// 	placeholder="{{  __('recipes.ingredient') }}"> \
			// </div> \
			// 	<div class="col-auto"> \
			// 	<i class="fa fa-plus-circle add-ingredient" aria-hidden="true" onclick="addIngredient()"></i> \
			// 	<i class="fa fa-trash remove-ingredient" aria-hidden="true" onclick="removeIngredient(this)"></i> \
			// 	<input type="hidden" name="ingredient['+index+'][index]" value="'+index+'" /> \
			// </div></div>';
				return '<div class="d-flex row-ingredient"><div class="col-6"> \
				<input id="ingredient-'+index+'" type="text" name="ingredient['+index+'][name]" class="form-control d-inline ingredient-name" value="'+name+'" style="width:100%"  \
				placeholder="{{  __('recipes.ingredient') }}"> \
			</div> \
				<div class="col-auto my-auto"> \
				<i class="fa fa-plus-circle add-ingredient mr-2" aria-hidden="true" onclick="addIngredient()"></i> \
				<i class="fa fa-trash remove-ingredient" aria-hidden="true" onclick="removeIngredient(this)"></i> \
				<input type="hidden" name="ingredient['+index+'][index]" value="'+index+'" /> \
			</div></div>';
	}

	function addIngredient(){
		$('.remove-ingredient').show();
		$('#container-ingredients').append(new_ingredient_html(++index_ingredient));
		$('#ingredient-'+index_ingredient).focus();

	}

	function removeIngredient(elm){
		if($('.row-ingredient').length>1){
			$(elm).closest('.row-ingredient').remove();
		} else {
			$('.quantity').val('');
			$('.ingredient-name').val('');
		}
	}
	var index_ingredient = {{ $index_ingredient??0 }};
	index_ingredient++;
    $(document).keypress(function(e) {
        if(e.which == 13) {
        	if($(e.target).hasClass('ingredient-name')){
        		e.preventDefault();
		        addIngredient();
	    	}
        }
    });
	// $(document).ready(function() {
	// 	if(ingredients.length>0){
	// 		$(ingredients).each(function(index,ingredient){
	// 			$('#container-ingredients').append(new_ingredient_html(index_ingredient++,ingredient.quantity,ingredient.name));
	// 		})
	// 	} else
	// 		$('#container-ingredients').append(new_ingredient_html(index_ingredient++));
	// });
	// $('.add-ingredient').click(addIngredient(););

</script>
@endsection