  {!! Form::open(['url' => 'recipes/add-anecdote', 'method' => 'post', 'role' => 'form', 'class'=>'form-anecdote' ]) !!}
  <div class="form-group">
    <h5>{{ __('recipes.add-anecdote') }}</h5>
    <textarea name="anecdote" class="anecdote form-control" placeholder="{{ __('recipes.placeholder-add-anecdote') }}">{{ old('anecdote')??'' }}</textarea>
  </div>
  <input type="hidden" name="recipe_id" value="{{ $recipe->id }}" />

    <button type="submit" class="btn btn-success btn-sm submitMessage">{{ __('forms.actions.publish-anecdote') }}</button>
{{--   <button type="button" class="btn btn-danger btn-default cancelReport">{{ __('forms.actions.cancel') }}</button> --}}
  {!! Form::close() !!}