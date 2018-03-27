@extends('layouts.app')

@section('content')

<div class="row">
    
    <div class="col-md-10 col-centered"  >
        
        <div class="card explanation-card background-colored-light fancy-border">
        <div class="p-2">
            <h2 class="text-center belle-allure">{{ $title }}</h2>
        </div>
            @if ($subtitle)
            <div class="card-body">
                <h4 class="text-center">{{ $subtitle }}</h4>
            </div>
            @endif
        </div>

        <div id="recipes-index">
            <!--@include ('recipes/_search')-->
            <div class="row">
                <div class="col-9">
                    @include ('recipes/_list')
                </div>
                <div class="col-3">
                    @include ('recipes/_menu')
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

