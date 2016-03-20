@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class='btn btn-xs btn-info'>{!! link_to('/home/start', 'Commencer à jouer') !!}</div>
        </div>
    </div>
</div>
@endsection
