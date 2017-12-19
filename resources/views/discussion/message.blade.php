<ul class="messages">
@foreach($thread as $key=>$message)
	<?php
	if($parent_id!=$message->parent_message_id) continue;
	?>
	<li>
		{{ link_to('users/'.$message->user->id,$message->user->name,['target'=>'_blank']) }} 
		<span class="small text-info">a écrit 
		<?php
			\Carbon\Carbon::setLocale(App::getLocale());
			$date_message = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $message->created_at);
			echo $date_message->diffForHumans(); 
		?>
		 : </span>
		<br/>
		@if($message->trashed())
			@if($message->deletion_reason->slug!='user-update')
				<em>{{ trans('discussion.'.$message->deletion_reason->slug) }}</em>
			@endif
		@else
			<p>{!! nl2br(htmlentities($message->content)) !!}</p>
		<div>
			@if(Auth::check() && Auth::user()->isAdmin())
				<span class="delete-message link" data-message-id="{{ $message->id }}" data-entity-id="{{ $entity->id }}" data-type="{{ get_class($entity) }}">Supprimer</span> - 
			@endif
			<span class="open-asnwer btn btn-secondary btn-sm mb-3" onclick="$(this).next('.form-message').slideDown();">Répondre</span>
			  {!! Form::open(['url' => 'report/send', 'style'=>'display:none;', 'method' => 'post', 'role' => 'form', 'class'=>'form-message', 'data-id'=>$entity->id]) !!}
				<div class="form-group">
					<textarea class="message" name="content" type="text" placeholder="Répondre." style="width: 100%;"></textarea><br/>
{{--					<input type="checkbox" name="follow-thread" value="1" /> {{ __('discussions.follow') }} <a target="_blank" href="{{ url('faq#follow-thread') }}" class="scroll badge-help badge badge-pill badge-success">?</a>
--}}
				</div>
				<input type="hidden" name="entity_id" value="{{ $entity->id }}" />
				<input type="hidden" name="entity_type" value="{{ get_class($entity) }}" />
				<input type="hidden" name="parent_message_id" value="{{ $message->id }}" />
				<button type="submit" disabled="disabled" class="btn btn-success submitMessage">{{ __('forms.actions.publish') }}</button>
				<button type="button" class="btn btn-danger btn-default cancelAnswer"  onclick="$(this).next('.fade').removeClass('in').addClass('hide');" >{{ __('forms.actions.cancel') }}</button>
			  {!! Form::close() !!}					
		</div>
		@endif
		@include('discussion.message',['parent_id'=>$message->id])
	</li>
@endforeach
</ul>