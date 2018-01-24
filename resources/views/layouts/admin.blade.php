@extends('layouts.app')

@section('content')

<div id="admin" class="container-fluid">

<div class="row">
	<div class="list-group col-2">
		<a href="{{ route('postag.index') }}" class="list-group-item list-group-item-action">
		Postags
		</a>
{{-- 		<a href="#" class="list-group-item list-group-item-action">Dapibus ac facilisis in</a>
		<a href="#" class="list-group-item list-group-item-action">Morbi leo risus</a>
		<a href="#" class="list-group-item list-group-item-action">Porta ac consectetur ac</a>
		<a href="#" class="list-group-item list-group-item-action">Vestibulum at eros</a> --}}
	</div>
	<div class="col-10 card">
		@yield('content-admin')
	</div>
</div>

</div>

@endsection