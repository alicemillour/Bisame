@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <!--{{-- @include ('recipes/_search') --}}-->

    <div class="row mt-4 mb-4"  style="background-color:transparent;">
            <div class="col-1"></div>
        <div class="col-10">
            <div class="card background-colored fancy-border">
                <h3 class="card-header text-center belle-allure" style="background-color: transparent; border-bottom-color: transparent">
                    <a>Recettes de Grammaire ? Wàs ìsch dàs ?
                        <!--<button class="btn btn-link" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                        <i class="fa fa-question" aria-hidden="true"></i> 
                        </button>-->
                    </a>
                </h3>
                <div class="card-body">
                    @include('partials.' . App::getLocale() . '-intro')
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
