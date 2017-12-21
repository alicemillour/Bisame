@extends('layouts.app')

@section('content')
    
    @include ('recipes/_search')
    
    <div class="p-2">
      <h2 class="page-title">{{ $title }}</h2>
    </div>
    <div id="recipes-index">
        @include ('recipes/_list')
    </div>
@endsection

