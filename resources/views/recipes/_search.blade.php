{!! Form::open(['route' => 'recipes.search', 'method' => 'get']) !!}
  <div class="d-flex flex-row justify-content-md-center">
    <div class="mr-3">
      <input type="text" name="search" class="form-control" placeholder="Trouver une recette...">
    </div>
    <div class="mr-2">
      <button type="submit" class=" btn btn primary">Rechercher</button>
    </div>
    <a class="btn btn-primary" href="{{ route('recipes.create') }}">Ajouter une recette</a>
  </div>
{!! Form::close() !!}