@extends('layouts.app')

@section('content')
    
    @include ('recipes/_search')
    
    <div class="p-2">
      <h2>{{ $title }}</h2>
    </div>
    
    @include ('recipes/_list')

@endsection

