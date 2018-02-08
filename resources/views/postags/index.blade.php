@extends('layouts.admin')

@section('content-admin')

<table class="table table-striped">
<thead>
	<tr>
		<th scope="col">pos</th>
		<th scope="col">Fullname</th>
		<th scope="col">Category</th>
		<th scope="col">Order</th>
		<th scope="col">Difficulty</th>
		<th scope="col">Points</th>
	</tr>
</thead>
@foreach($postags as $postag)
	<tr class="postag" data-id="{{ $postag->id }}">
		<th scope="row">{{ $postag->name }}</th>
		<td>{{ $postag->full_name }}</td>
		<td>{{ $postag->category }}</td>
		<td>{{ $postag->order }}</td>
		<td>{{ $postag->difficulty }}</td>
		<td>{{ $postag->points }}</td>
	</tr>
@endforeach
</table>

@endsection

@section('scripts')

<script type="text/javascript">
    $('.postag').click(function(){
        var postag_id = $(this).attr('data-id');
        window.location.href = '{{ url('postag') }}/'+postag_id+'/edit';
    });	
</script>

@endsection