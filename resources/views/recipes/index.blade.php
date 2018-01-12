@extends('layouts.app')

@section('content')
    
    
    <div class="p-2">
      <h2 class="page-title text-center">{{ $title }}</h2>
    </div>

    <div id="recipes-index">
        @include ('recipes/_search')
        @include ('recipes/_list')
    </div>
@endsection

