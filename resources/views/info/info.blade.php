@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <!--{{-- @include ('recipes/_search') --}}-->

    <div class="row mt-4 mb-4"  style="background-color:transparent;">
            <div class="col-1"></div>
        <div class="col-10">
            <div class="card background-colored fancy-border">
                    @include('partials.' . App::getLocale() . '-intro')
            </div>
        </div>
    </div>
</div>
@endsection
