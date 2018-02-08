@extends('layouts.app')

@section('content')
    
    
    <div class="p-2">
      <h2 class="page-title text-center">{{ $title }}</h2>
    </div>

    <div id="recipes-index">
        @include ('recipes/_search')
        <div class="row">
        	<div class="col-9">
        		@include ('recipes/_list')
        	</div>
        	<div class="col-3">
        		@include ('recipes/_menu')
        	</div>
    	</div>
    </div>
@endsection

