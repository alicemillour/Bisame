@extends('layouts.app')
@section('style')
<link href="{{ asset('css/game.css') }}" rel="stylesheet" type="text/css" >
@endsection
@section('script')
<script type="text/javascript" src="{{ asset('js/game.js') }}">
//    $('#btnYes').click(function() {
//            // handle redirect here
//            console.log("clicked yes");
//            location.href = 'home';
//            $('#myModal').modal('hide');
//        });
</script>
@endsection
@section('content')

<!-- Modal -->
<!--<div class="modal fade" id="memberModal" tabindex="-1" role="dialog" aria-labelledby="memberModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <a type="button" class="close" data-dismiss="modal" aria-label="Close" href="/home"><span aria-hidden="true">&times;</span></a>
        <h4 class="modal-title" id="memberModalLabel">Fin de la séquence !</h4>
      </div>
      <div class="modal-body">
        <p>Vous gagnez {{$nb_annotations}}<BR>

      </div>
      <div class="modal-footer">
        <a href="/home" id="btnYes" class="btn agree">Ok !</a>
      </div>
    </div>
  </div>
</div>-->

<!--<div class="container">
  <a href="#" class="confirm-link" data-link="http://bootply.com/login">Link</a><br>
</div>-->

<!--<div id="myModal" class="modal hide">
    <div class="modal-header">
        <a href="#" data-dismiss="modal" aria-hidden="true" class="close">×</a>
         <h3>Agree</h3>
    </div>
    <div class="modal-body">
        <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, 
        totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae 
        dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia cor magni dolores 
        eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, 
        </p><p>Do you want to agree?</p>
    </div>
    <div class="modal-footer">
      <a href="#" id="btnYes" class="btn agree">Yes</a>
      <a href="#" data-dismiss="modal" aria-hidden="true" class="btn secondary">No</a>
    </div>
</div>-->

<div class="container" id="main-container">
    <div class="row sentence-main-container">
        <article class="row bg-primary ">
		<div class="col-md-12 background-colored">
			<header>  
                            @if($game['type']=='training')
                            <h4> Bienvenue dans le mode Entraînement ! Ici, vous pouvez vérifier vos réponses au fur et à mesure. </h4>
                            @else
                            <h4> Bienvenue dans le mode Jeu ! Ici, nous ne corrigeons pas vos réponses. Vos points seront mis à jour à la fin de la séquence de quatre phrases. </h4>
                            @endif
                            
				<h2 class="ostrich">Cliquez sur les mots pour leur assigner une categorie grammaticale
					<div class="pull-right">
					</div>
				</h2>
                            
                           
			</header>
                        <hr>
                        <div class="sentence-container" id="sentence-container"> 
                            	@foreach($sentences[$game->sentence_index]->words as $word)
					<div class="word-container">
						<div class="word" id="{{ $word->id }}" value="{{$word->value}}">{{ $word->value }}</div>
						<div class="category"> </div>
					</div>
				@endforeach
                                <div class="progress" color="white">
                                <div class="progress-bar" role="progressbar" aria-valuenow="{{$progression}}"
                                aria-valuemin="0" aria-valuemax="100" style="width:{{$progression}}%">
                                <span>Phrase {{$game->sentence_index+1}}/4</span>     
                                </div>
                            </div>
			</div>
                        
		</div>
                </article>
		<div class="main-button">
                        @if($game['type']=='training')
                            <button><b> Vérifier mes réponses </b></button>
                        @else
                            <button><b> Valider et passer à la phrase suivante </b> </button>
                        @endif
		</div>
                    @if($game['type']=='training')
                    <h5><b> &nbsp &nbsp Vous pouvez vérifiez vos réponses à tout moment.</b></h5>
                    @else
                    <h5><b> &nbsp &nbsp Dans ce mode, vous pouvez passer à la phrase suivante même avec une phrase partiellement annotée.</b> </h5>
                    @endif
		<div class="alert alert-success" id="message" hidden=true>
			<strong id=message-title>Bravo !</strong>
			<div id=message-content>Toutes vos annotations sont correctes !</div>
		</div>
    </div>
    <div class ="categorie-table-container pull-right">
	    <table class="table table-hover categories-table" hidden="true">
	    	<thead>
	    		<tr>
                            <th class="ostrich" <h1>Categories grammaticales</h1></th>
	    		</tr>
	    	</thead>
	    	<tbody>
	    	</tbody>
	    </table>
		<div class="categories-button" hidden=true>
			<button>Afficher toutes les catégories</button>
		</div>
	</div>
</div>
@endsection