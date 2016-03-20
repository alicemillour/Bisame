@extends('layouts.app')

<script type="text/javascript">
    $(".word").click(function () {
       $(this).css("background-color","yellow");
    });
</script>

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <article class="row bg-primary">
			<div class="col-md-12">
				<header>
					<h1>Annotez ces mots
						<div class="pull-right">
						</div>
					</h1>
				</header>
				<hr>
				<p>
					@foreach($sentence->words as $word)
						<span class="word">{{ $word->value }}</span>
					@endforeach
				</p>
			</div>
		</article>
        </div>
    </div>
</div>
@endsection
