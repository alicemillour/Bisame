<div class="container-thread" id="thread_{{ $entity->id }}">
  {!! Form::open(['url' => 'report/send', 'method' => 'post', 'role' => 'form', 'class'=>'form-message', 'data-id'=>$entity->id, 'data-type'=>'']) !!} 
    <div class="form-group">
        <textarea class="message" name="content" type="text" style="resize:auto;padding:7px;overflow: hidden; word-wrap: break-word; min-height: 60px; height: 60px;width: 100%;color:#3C3C3C" placeholder="{{ __('recipes.discuss-recipe') }}"></textarea><br/>
        {{--<input type="checkbox" name="follow-thread" value="1" /> {{ __('discussions.follow') }} <a target="_blank" href="{{ url('faq#follow-thread') }}" class="scroll badge-help badge badge-pill badge-success">?</a>--}}
    </div>
  <input type="hidden" name="entity_id" value="{{ $entity->id }}" />
	<input type="hidden" name="entity_type" value="{{ get_class($entity) }}" />
    <button type="submit" disabled="disabled" class="btn btn-success btn-sm submitMessage">{{ __('forms.actions.publish') }}</button>
{{--    <button type="button" class="btn btn-danger btn-default cancelReport">{{ __('forms.actions.cancel') }}</button> --}}
  {!! Form::close() !!}

@if($entity->hasDiscussion())
	@php
		$thread = $entity->discussion->messages;
	@endphp
	{{ count($thread) }} {{ trans_choice('discussions.comments',count($thread)) }}
	@include('discussion.message',['parent_id'=>null])
@else
	Personne n'a encore commenté.
@endif
</div>