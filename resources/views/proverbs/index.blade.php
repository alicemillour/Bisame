@extends('layouts.app')

@section('content')

<div class="row">
    
    <div class="col-md-10 col-centered"  >
        
        <div class="card explanation-card background-colored fancy-border">
        <div class="p-2">
            <h2 class="text-center belle-allure">{{ $title }}</h2>
        </div>
            @if ($subtitle)
            <div class="card-body">
                <h4 class="text-center">{{ $subtitle }}</h4>
            </div>
            @endif
        </div>

        <div id="poems-index">
            <!--@include ('poems/_search')-->
            <div class="row">
                <div class="col-9">
                    @include ('poems/_list')
                </div>
                <div class="col-3">
                    @include ('poems/_menu')
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

