@extends('layouts.admin')

@section('content-admin')

{!! Form::model($postag, ['url' => url('postag/'.$postag->id), 'method' => 'post', 'id' => 'form-postag']) !!}	
<input type="hidden" name="_method" value="PUT">

{!! Form::control('text', 'col-12', 'name', $errors, "Name", null, null, "name") !!}
{!! Form::control('text', 'col-12', 'full_name', $errors, "Fullname", null, null, "fullname") !!}
{!! Form::control('textarea', 'col-12', 'description', $errors, "Description", null, null, "description") !!}
{!! Form::control('text', 'col-12', 'order', $errors, "Order", null, null, "") !!}
{!! Form::selection('difficulty', 'Difficulty', ['very-easy'=>'very easy','easy'=>'easy','hard'=>'hard']) !!}
{!! Form::control('number', 'col-12', 'points', $errors, "Points", null, null, "") !!}
{!! Form::selection('category', 'Category', ['open'=>'open','closed'=>'closed','other'=>'other']) !!}
<div class="form-group col-12 mt-3">
	{!! Form::submit('Enregistrer', ['id'=>'btn-create','class'=>'btn btn-success']) !!}
</div>
@endsection

@section('scripts')

<script type="text/javascript">

</script>

@endsection