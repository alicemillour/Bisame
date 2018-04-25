@extends('layouts.app')

@section('content')


  <!--@include ('recipes/_search')--> 
  
<div id="recipe" class="container">
@if (session()->has('title'))
<div class="container-fluid">
    <div class="row">
        <div class="col-md-10 col-centered">
            <div class="card explanation-card background-colored-light fancy-border">
                <div class="p-2">
                    <h2 class="text-center belle-allure">{{ session()->get('title') }}</h2>
                </div>
                <div class="card-body">
                    <h4 class="text-center">{{ session()->get('subtitle') }}</h4>
                </div>
            </div>
        </div>
    </div>
</div>

@endif

  
  <ul class="nav nav-tabs" id="myTab" role="tablist">
    <li class="nav-item">
      <a class="nav-link page-title active" id="recipe-tab" data-toggle="tab" href="#recipe" role="tab" aria-controls="home" aria-selected="true">Voir la recette</a>
    </li>
    <li class="nav-item">
      <a class="nav-link page-title" id="plus-tab" data-toggle="tab" href="{{ route('recipes.alternative-versions',['recipe'=>$recipe]) }}?tab=plus" role="tab" aria-controls="plus" aria-selected="false">Moi je l'aurais dit comme ça !</a>
    </li>
    <li class="nav-item">
      <a class="nav-link page-title" id="pos-tab" data-toggle="tab" href="{{ route('recipes.annotations',['recipe'=>$recipe]) }}?tab=pos" role="tab" aria-controls="pos" aria-selected="false">Aidez-nous à améliorer nos outils</a>
    </li>
  </ul>

  <div class="bg-white p-3" id="content-recipe">
    <a class="float-right report link" href="#">Signaler du contenu inapproprié</a>
    <div class="plus-tab d-none alert alert-info">
      Pour proposer une version dans une variante orthographique ou régionale, double cliquez sur un mot de la recette ou sélectionnez du texte dans les zones grisées, renseignez votre variante et cliquez sur Valider !
    </div>
    <div class="row">
      <div class="col-sm-7">
      <div class="row">
        <div class="col-lg-7">
          <h1 class="translatable" data-type="App\Recipe" data-id="{{ $recipe->id }}" data-attribute="title">{{ $recipe->title }}</h1>
        </div>
        <div class="col-lg-5 d-flex flex-row text-right justify-content-end">
          <div class="p-2 text-nowrap">
            <i class="fa fa-heart fa-2x likeable" aria-hidden="true" data-toggle="tooltip" data-placement="bottom" title="
            @auth
                @if(Auth::user()->likesEntity($recipe))
                  Vous aimez cette recette
                @else
                  Aimer cette recette  
                @endif
            @else
              Veuillez vous connecter pour aimer cette recette
            @endauth
            " data-type="App\Recipe" data-id="{{ $recipe->id }}">
            </i>
            <span class="likes-count" data-id="{{ $recipe->id }}">{{ $recipe->likes->count() }}</span>
          </div>
        </div>
        <div class="col-lg-12 d-flex flex-row justify-content-start">
          @if($recipe->has_time)
            <div class="pl-0 py-2 pr-2 text-nowrap"><small>{{ $recipe->total_time }}</small> <i class="fa fa-clock-o fa-lg" aria-hidden="true"></i></div>
          @endif
          @if($recipe->servings)
            <div class="p-2 text-nowrap"><small>{{ $recipe->servings }} {{ trans_choice('recipes.servings',$recipe->servings) }}</small> <i class="fa fa-cutlery fa-lg" aria-hidden="true"></i></div>
          @endif
        </div>
      </div>
    <div class="mb-1 row">
      <div class="col-sm-8">
        <span class="text-muted">
          @component('users._avatar', ['user' => $recipe->author])
          @endcomponent
          {{ __('recipes.recipe-by') }}
          @if($recipe->author->trashed())
            {{ $recipe->author->name }}
          @else
            {{ link_to_route('users.show', $recipe->author->name, $recipe->author) }}
          @endif  
        </span>
        @if($recipe->has_time)
          <div class="mb-1">
            <small class="text-muted">{{ __('recipes.preparation-time') }} : {{ $recipe->preparation_time }}</small>
          </div>
          <div class="mb-1">
            <small class="text-muted">{{ __('recipes.cooking-time') }} : {{ $recipe->cooking_time }}</small>
          </div>
        @endif        
      </div>

      @if($recipe->contributors)
        <div class="col-sm-4 flex-column text-right plus-tab d-none">
          <div>{{ __('recipes.contributors') }}</div>
          <div>
            <span class="text-muted author" data-user-id="{{ $recipe->author->id }}">{{ $recipe->author->name }}</span>
          </div> 
          @foreach($recipe->contributors as $user)
          <div>
            <span class="text-muted contributor" data-user-id="{{ $user->id }}">{{ $user->name }}</span>
          </div> 
          @endforeach
        </div>
      @endif
    </div>
    @if($recipe->ingredients->count())
        <hr style="height: 1px; color: grey; background-color: black; width: 50%; margin-left: 0px " />
<!--<hr style="height: 0.5px; color: white; background-color: black; width: 50%; margin-left: 0px " />-->
    <h4>{{ __('recipes.ingredients') }}</h4>
    @endif
    @if($recipe->servings)
     ({{ $recipe->servings>1 ?__('recipes.for-n-persons',['number'=>$recipe->servings]):__('recipes.for-n-person',['number'=>$recipe->servings]) }})</h4>
    @endif
    <table>
      @foreach($recipe->ingredients as $ingredient)
      <tr>
{{--         <td class="translatable pl-2" data-type="App\Ingredient" data-id="{{ $ingredient->id }}" data-attribute="quantity">{{ $ingredient->quantity }} </td> --}}
        <td id="ingredient-{{ $ingredient->id }}" class="translatable" data-type="App\Ingredient" data-id="{{ $ingredient->id }}" data-attribute="name">{{ $ingredient->name }} </td>
      </tr>
      @endforeach
    </table>
        <hr style="height: 1px; color: grey; background-color: black; width: 75%; margin-left: 0px " />
<!--<hr style="height: 0.5px; color: white; background-color: black; width: 50%; margin-left: 0px " />-->
    <h4>{{ __('recipes.recipe') }}</h4>

    <div id="recipe" class="translatable" data-id="{{ $recipe->id }}" data-type="App\Recipe" data-attribute="content">{!! e($recipe->content) !!}</div>
    
    <h4 class="mt-2">{{ __('recipes.anecdotes') }}</h4>
    
    @each('anecdotes/_show', $recipe->anecdotes, 'anecdote', 'anecdotes/_empty')

    @include('anecdotes/_new',['recipe'=>$recipe])

    </div>

    <div class="col-sm-5">
      @if($recipe->medias->count()>0)
        <img src="{{ asset($recipe->medias->first()->filename) }}" style="width:100%;" />
      @endif
      <form id="form-recipe" action="{{ route('recipes.add-media',$recipe) }}" method="POST">
        {{ csrf_field() }}
        <span class="input-group-btn">
          <label class="btn btn-primary btn-sm">
              <input type="file" id="photo" name="photo" style="display:none;"/>
              <i class="fa fa-picture-o"></i> Ajouter une photo
          </label>
        </span>
        <div id="thumbnails">
          @if(old('photos'))
            @foreach(old('photos') as $photo)
            <div class="thumbnail ml-3 d-inline-block">
              <img src="{{ asset($photo) }}" class="" />
              <input type="hidden" name="photos[]" value="{{ $photo }}" /><br/>
              <label>
                <input type="radio" name="cover_picture" value="{{ $photo }}" {{ ($photo == old('cover_picture'))? 'checked="checked"':'' }}/> Photo de couverture
              </label>
            </div>  
            @endforeach
          @endif
        </div>
      </form>     
    </div>

    </div>

    <h5 class="mt-2">Laisser un commentaire</h5>
    @component('discussion.thread', ['entity' => $recipe])
        
    @endcomponent

  </div>
@auth
  @php
  $pos = [];
  foreach($postags as $_postag){
    $pos[$_postag->id] = $_postag->name;
  }  
  @endphp

  <div id="annotation" class="bg-white p-3 d-none noselect">
    <div class="annotation-header">
      @if($message)
            <h4 id="message-popup" class="mb-3">
              {{ $message }}
            </h4>
      @endif
      <!--<h4 id="title-tab-pos center-t"> </h4>-->
      <!--<div class="belle-allure text-center" style="margin-bottom:10px"><i> J'aide la science grâce à mes connaissances</i></div>--> 

        @if($annotator_to_validate)
        <h4 id="message" class="mb-2 explanation">Voici les catégories grammaticales proposées par un autre utilisateur :</h4>
        @else
        <h4 id="message" class="mb-2 explanation">  Cette recette fait désormais partie de notre base de textes en alsacien !  <br> 
            Notre outil a tenté de deviner les catégories grammaticales des mots de cette recette... Voici le résultat :</h4>
        @endif


        <h4 id="explanation" class="mb-2 d-none explanation">validez (<img src="{{ asset('images/check.png') }}">)
            ou invalidez (<img src="{{ asset('images/no.png') }}">) ce choix.
        </h4>
        <h4 id="explanation-free-annotation" class="mb-2 d-none explanation">Vous avez validé / invalidé tous les mots, mais il reste des mots sans étiquette. Cliquez sur les mots <span class="highlight" style="font-size: 0.8em">surlignés</span> pour leur en ajouter une.
        </h4>
        <h4 id="explanation-all-annotated" class="mb-2 d-none explanation"> Vos annotations ont bien été enregistrées ! Vous pouvez encore modifier l'étiquette d'un mot en cliquant dessus. Pour revenir à l'accueil, cliquer sur terminer.
        </h4>
    </div>
      
    <div class="row">
      <div class="col-12" id="annotations" style="position: -webkit-sticky; position: sticky; top: 10%; align-self: flex-start;">
      @if($corpus_recipe)
        @foreach($corpus_recipe->sentences as $sentence)
          @foreach($sentence->words as $word)
          <div class="word-container" style="display:inline-block;text-align:center;vertical-align: top;">

            @if($word->annotation_user(auth()->id()) && $word->annotation_user(auth()->id())->postag_id && $pos[$word->annotation_user(auth()->id())->postag_id]!="PUNCT")
              @php
                $annotation = $word->annotation_user(auth()->id());
              @endphp
              <span class="word validated" data-word-id="{{ $word->id }}" data-postag-id="{{ $annotation->postag_id }}">{{ $word->value }}</span>
              <br/>
              <img class="no no-display"  src="{{ asset('images/no.png') }}" data-word-id="{{ $word->id }}" data-postag-id="{{ $annotation->postag_id }}" />
              <span class="pos" data-word-id="{{ $word->id }}" data-postag-id="{{ $annotation->postag_id }}">{{ $pos[$annotation->postag_id] }}</span>
              <img class="check no-display"  src="{{ asset('images/check.png') }}" data-word-id="{{ $word->id }}" data-postag-id="{{ $annotation->postag_id }}"/>
            @elseif($word->annotation_user(auth()->id()) && !$word->annotation_user(auth()->id())->postag_id)
              <span class="word undefined" data-word-id="{{ $word->id }}" data-postag-id="0">{{ $word->value }}</span>
              <br/>
                <img class="no no-display"  src="{{ asset('images/no.png') }}" data-word-id="{{ $word->id }}" data-postag-id="0" />
                <span class="pos validated no-display" data-word-id="{{ $word->id }}" data-postag-id="0">UNDEF</span>
                <img class="check no-display"  src="{{ asset('images/check.png') }}" data-word-id="{{ $word->id }}" data-postag-id=""/>
            @else
              @php
                if($annotator_to_validate)
                  $annotation = $word->annotation_user($annotator_to_validate->id);
                else
                  $annotation = $word->annotation_melt;
              @endphp
              <span class="word not-validated" data-word-id="{{ $word->id }}" data-postag-id="{{ ($annotation)? $annotation->postag_id : '' }}">{{ $word->value }}</span>
              <br/>
              @if($annotation && $pos[$annotation->postag_id]!="PUNCT")
                <img class="no no-display"  src="{{ asset('images/no.png') }}" data-word-id="{{ $word->id }}" data-postag-id="{{ $annotation->postag_id }}" />
                <span class="pos not-validated" data-word-id="{{ $word->id }}" data-postag-id="{{ $annotation->postag_id }}">{{ $pos[$annotation->postag_id] }}</span>
                <img class="check no-display"   src="{{ asset('images/check.png') }}" data-word-id="{{ $word->id }}" data-postag-id="{{ $annotation->postag_id }}"/>
              @endif
            @endif
          </div>
          @endforeach
          <!--<br/>-->
        @endforeach
        <div class="text-center">
          <button id="btn-next-postag" class="btn btn-warning d-none disabled btn-lg" data-toggle="tooltip" title="Validez ou invalidez tous les mots en surbrillance avant de continuer" data-placement="bottom">Catégorie suivante</button>
          <a href="{{ route('home') }}" id="btn-finish" class="btn btn-primary d-none btn-lg" data-toggle="tooltip" title="Retour à l'accueil" data-placement="bottom">Terminer</a>
        </div>
      @else
        <alert>Aucune annotation pour cette recette.</alert>
      @endif
      <div class="annotation-header">

        @if(!$annotator_to_validate)
        <h5 id="submessage" class="mb-2 explanation"> Ce n'est pas mal, mais pas encore parfait... Contribuez à améliorer ses performances en corrigeant ses erreurs !<br> <br>  </h5>
        @endif
        <button class="btn play-button active-button center-button" id="btn-annotation">Améliorer ce résultat</button>

      </div>
      </div>
      <div class="col-4" id="tag-list" style="display :none">
        @include ('postags/_list')
      </div>
    </div>

  </div>
@endauth
</div>
@endsection

@section('scripts')

  <script type="text/javascript">
    @include('js.recipe')
  </script>

<script type="text/javascript">
@php
$alternative_texts = $recipe->alternative_texts()->with('user')->get()->toArray();
foreach($recipe->anecdotes as $anecdote){
  $alternative_texts = array_merge($alternative_texts,$anecdote->alternative_texts()->with('user')->get()->toArray());
}
foreach($recipe->ingredients as $ingredient){
  $alternative_texts = array_merge($alternative_texts,$ingredient->alternative_texts()->with('user')->get()->toArray());
}
@endphp

    var help = false;
    var recipe_id = {{ $recipe->id }};
    var alternative_texts = {!! json_encode($alternative_texts) !!};
    var postags = {!! json_encode($postags) !!};
    var postag = {!! json_encode($postag) !!};
    var selected_text;
    var keep_open = false;
    var current_postag_id = 0;
    var current_postag = null;
    var current_word_id = null;
    var img_no = $('<img class="no pr-1" src="{{ asset('images/no.png') }}" />');
    var img_check = $('<img class="check pl-1" src="{{ asset('images/check.png') }}" />');
    var img_question = $('<img class="question" src="{{ asset('images/no.png') }}" />');
    var total_count_not_validated = 0;
    var mode='';
    window.onload = function() {
      $('.translatable').each(function(){
        var text = $(this).html();
        displayText(text,$(this));
      });
      displayAlternativeTexts();
      initPlusTab();
      autosize($('.message'));
      autosize($('.anecdote'));
      $("#{{ $tab }}-tab").trigger("click");
      if(postag!='') {
        $('#btn-annotation').trigger("click");
      }
      if($('#message-popup').length==1){

          $('#message-popup').delay(10000).fadeOut(3000, function(){
              $('#message-popup').remove();
          });
       
      }
      if($('span.validated').length>0){
        $('#btn-annotation').trigger("click");
      }      
    };

    $('.help').click(function(event){
      event.preventDefault();
    });

    $('.postag').click(function(){
      if(help){
        help=false;
        return false;
      }
      $('#title-tab-pos').hide();
      if($(this).hasClass('warning')){
        if(confirm("Cette catégorie est difficile, faire la formation ?"))
          window.location.href = base_url+'training/'+$(this).attr('data-postag-id');
        return false;
      }
      if($(this).hasClass('disabled')){
        // alert("Validez ou invalidez tous les mots en surbrillance avant de continuer");
        return false;
      }
      current_postag_id = $(this).attr('data-postag-id');
      current_postag = getPostag(current_postag_id);
      // $('.word').removeClass('highlight');
      $('.postag').removeClass('highlight');
      $(this).addClass('highlight');
      // $(this).addClass('highlight').tooltip('disable');

      initAnnotationPostag();
      updateCountNotValidated();
      // $('.word[data-postag-id='+current_postag_id+']').addClass('highlight');
      // $('.pos').addClass('no-display');
      // $('.pos[data-postag-id='+current_postag_id+']').removeClass('no-display').addClass('visible');
    })

    $('.word').click(function(event){

      if(mode=='free-annotation'){
        displayPostagsList($(this));
        return false;
      }

      if(!current_postag) return false;

      var word_id = $(this).attr('data-word-id');
      var postag_id = $(this).attr('data-postag-id');
      if($(this).hasClass('validated') && postag_id!=0 && current_postag.id!=postag_id) return false;
      var postag_html = $('.pos[data-word-id='+word_id+']');

      if($(this).hasClass('highlight')||$(this).hasClass('validated')){
        invalidatePos($(this));
      } else {
        $(this).attr('data-postag-id',current_postag.id);
        postag_html.removeClass('no-display').addClass('visible').html(current_postag.name).attr('data-postag-id',current_postag.id);
        validatePos($(this));
      }
    })
    
    function displayPostagsList(word){
      $('*').popover('hide');
      var word_id = word.attr('data-word-id');
      var content = $('<div/>');
      var btn_close = $('<div style="text-align:right;cursor:pointer;">[ x ]</div>').click(function(){$('*').popover('hide');});
      content.append(btn_close);
      
      for(key in postags)
      {
        var pos = postags[key];
        var elm_postag = $('<div class="word-list" data-postag-id="'+pos.id+'" data-word-id="'+word_id+'">'+pos.full_name+'<em>('+pos.name+')</em></div>');
        elm_postag.click(function(){
          addPos($(this));
          $('*').popover('hide');
        });
        content.append(elm_postag);
      }
      word.popover({
        content:content,
        placement:'auto',
        html:true,
        animation:true,
        trigger:'focus',
        container: 'body'
      }).popover('show');
    }

    function invalidatePos(elm){
      var word_id = elm.attr('data-word-id');
      $('.pos[data-word-id='+word_id+']').removeClass('visible').removeClass('not-validated').addClass('invisible').attr('data-postag-id',0);
      $('img[data-word-id='+word_id+']').removeClass('visible').addClass('invisible').attr('data-postag-id',0);      
      $('.word[data-word-id='+word_id+']').removeClass('highlight').removeClass('validated').addClass('undefined').attr('data-postag-id',0);
      saveAnnotation(word_id, 0);
      updateCountNotValidated();
      initTooltips();
      checkPosFinished();
    }

    function validatePos(elm){
      var word_id = elm.attr('data-word-id');
      var postag_id = elm.attr('data-postag-id');
      $('.pos[data-word-id='+word_id+']').removeClass('not-validated');
      $('.word[data-word-id='+word_id+']').removeClass('highlight').addClass('validated');
      $('img[data-word-id='+word_id+']').removeClass('visible').addClass('invisible').attr('data-postag-id',0);
      saveAnnotation(word_id, postag_id);
      updateCountNotValidated();
      initTooltips();
      checkPosFinished();
    }

    function addPos(elm){
      var word_id = elm.attr('data-word-id');
      var postag_id = elm.attr('data-postag-id');
      var postag = getPostag(postag_id);
      $('.pos[data-word-id='+word_id+']').removeClass('no-display').html(postag.name);
      $('.word[data-word-id='+word_id+']').removeClass('highlight').removeClass('undefined').addClass('validated');
      $('img[data-word-id='+word_id+']').removeClass('visible').addClass('no-display').attr('data-postag-id',0);
      saveAnnotation(word_id, postag_id);
      updateCountNotValidated();
    }

    function checkPosFinished(){
      if($('img.visible').length==0){
        $('#btn-next-postag').removeClass('btn-warning disabled').addClass('btn-success').tooltip('disable');
        // var next_postag = $('.postag.highlight').next('.postag');
        // if(!next_postag.hasClass('warning'))
        //   next_postag.removeClass('disabled');
      }
    }

    $('img.no').click(function(){
      invalidatePos($(this));
    });

    $('img.check').click(function(){
      validatePos($(this));
    });

    $('#btn-annotation').click(function(){
      $('#title-tab-pos').hide();
      
        $('#annotations').addClass('col-8');
        $('#annotations').removeClass('col-12');
      $('#tag-list').show();
      var fisrt_postag = $('.postag').first();
      fisrt_postag.show();
      current_postag_id = fisrt_postag.attr('data-postag-id');
      current_postag = getPostag(current_postag_id);
      $('.postag').removeClass('highlight');
      updateCountNotValidated();
      if(fisrt_postag.hasClass('validated') || fisrt_postag.hasClass('disabled') ){
        fisrt_postag.nextAll('.postag').each(function(){
          if($(this).attr('data-count-todo')>0){
            current_postag_id = $(this).attr('data-postag-id');
            current_postag = getPostag(current_postag_id);
            $(this).addClass('highlight');
            return false; 
          }
        });
      } else {
        fisrt_postag.addClass('highlight');
      }
      initTooltips();
      initAnnotationPostag();
      if(postag!='') {
        $('#postag_'+postag.id).trigger("click");
      }      
    });

    $('#btn-next-postag').click(function(){
      if($('img.visible').length>0){
        alert("Validez ou invalidez tous les mots en surbrillance avant de continuer.");
        return false;        
      }
      var next_postag = $('.postag[data-postag-id='+current_postag.id+']').next('.postag');

      if($(next_postag).hasClass('disabled') || $(next_postag).hasClass('validated')){
        $(next_postag).nextAll('.postag').each(function(){
          if($(this).attr('data-count-todo')>0){
            next_postag = $(this);
            return false; 
          }
        });
      }
      if(next_postag.hasClass('warning')){
        if(confirm("la prochaine catégorie est difficile, faire la formation ?"))
          window.location.href = base_url+'training/'+next_postag.attr('data-postag-id');
        return false;
      }
      if(next_postag.length==0) return false;
      current_postag_id = next_postag.attr('data-postag-id');
      current_postag = getPostag(current_postag_id);
      $('.postag').removeClass('highlight');
      next_postag.addClass('highlight');
      // next_postag.addClass('highlight').tooltip('disable');
      initAnnotationPostag();
    });

    function initTooltips() {
      $('.postag').each(function(){
        var count_todo = $(this).attr('data-count-todo');
        if(count_todo==0)
          var title = "Aucun mot à valider / invalider dans cette catégorie.";
        else if(count_todo==1)
          var title = "Un mot à valider / invalider dans cette catégorie.";
        else
          var title = count_todo+" mots à valider / invalider dans cette catégorie.";
        $(this).tooltip({title:title,placement:'left'});
        $(this).attr('data-original-title',title);
        // $(this).tooltip('show');
      });
    }

    function initAnnotationPostag(postag) {
      updateCountNotValidated();
      initTooltips();

      if(total_count_not_validated==0)
        return false;

      $('#btn-validate').removeClass('d-none');
      $('#btn-next-postag').removeClass('d-none btn-success').addClass('btn-warning disabled').tooltip('enable');
      $('.word').removeClass('highlight');
      $('img.no').removeClass('visible').addClass('no-display');
      $('img.check').removeClass('visible').addClass('no-display');
      $('.pos.not-validated').addClass('no-display');
      $('.word.not-validated[data-postag-id='+current_postag_id+']').each(function(){
        var word_id = $(this).attr('data-word-id');
        $(this).addClass('highlight');
        $('.pos[data-word-id='+word_id+']').removeClass('no-display').addClass('visible');
        $('img[data-word-id='+word_id+']').removeClass('no-display').addClass('visible');        
      });
      
      // $('#message').html("Séctionnez/désélectionnez les mots du texte qui appartiennent/n'appartiennent pas à la catégorie <span style='color:red;'>"+current_postag.full_name+' <em>('+current_postag.name+')</em></span>');
      $('#message').html('Notre outil a attribué la catégorie <span class="belle-allure">'+current_postag.full_name+' </span> <em>('+current_postag.name+')</em> aux mots <span class="highlight" style="font-size: 0.8em">surlignés</span>');
      $('#submessage').html(''); //TODO ajouter message submessage par catégorie 
      $('#explanation').removeClass('d-none');

      $('#btn-annotation').hide();
      
      checkPosFinished();
      $(window).scrollTop(0);
    }

    function updateCountNotValidated() {
      total_count_not_validated = 0;
      for(key in postags)
      {
        var pos = postags[key];
        var count_not_validated = $('span.pos.not-validated[data-postag-id='+pos.id+']').length;
        total_count_not_validated+=count_not_validated;
        if($('.pos[data-postag-id='+pos.id+']').length>0 && count_not_validated==0){
          $('.postag[data-postag-id='+pos.id+']').addClass('validated');
        }else if($('.pos[data-postag-id='+pos.id+']').length==0 && count_not_validated==0){
          $('.postag[data-postag-id='+pos.id+']').addClass('disabled');
        }
        $('.postag[data-postag-id='+pos.id+']').attr('data-count-todo',count_not_validated);
        // $('.count-not-validated[data-postag-id='+pos.id+']').html(count_not_validated);
      }
      if(total_count_not_validated==0 && mode!="free-annotation"){
        $('.postag').removeClass('highlight').addClass('d-none');
        $('#free-annotation').removeClass('d-none').addClass('highlight');
        $('#message').hide();
        $('#explanation').hide();
        $('#btn-next-postag').hide();
        $('#explanation-free-annotation').removeClass('d-none');
        $('#btn-finish').removeClass('d-none');
        $('.validated').addClass('validated-no-display').removeClass('validated');
        $('.undefined').addClass('highlight');
        mode="free-annotation";
        $(window).scrollTop(0);
      }

      if($('span.undefined').length==0 && mode=="free-annotation"){
        $('#explanation-free-annotation').addClass('d-none');
        
        $('#btn-annotation').hide();
        $('#explanation-all-annotated').removeClass('d-none');
        // $(window).scrollTop(0);
        flagRecipeAsAnnotated();
      }

      if($('.postag[data-difficulty="very-easy"]').length==$('.postag[data-difficulty=very-easy][data-count-todo=0]').length){
        $('.postag').removeClass('d-none');
      }     
    }

    function getPostag(postag_id) {
      var postag = null;
      for(key in postags)
      {
        var pos = postags[key];
        if(pos.id == postag_id){
          postag=pos;
        }
        continue;
      }
      return postag;
    }

    function saveAnnotation(word_id, postag_id) {
      $.post( "{{ route('create-annotation') }}", { word_id: word_id, postag_id: postag_id }, function(data){
        console.log(data);
        $('.score').html(data.score);
        $('.NbAnnotations').html(data.NbAnnotations);
      } );
    }

    function flagRecipeAsAnnotated() {
      $.post( "{{ route('recipes.flag-as-annotated',$recipe) }}", function(){

      });
    }

    function getSelectionHtml() {
      var html = "";
      if (typeof window.getSelection != "undefined") {
          var sel = window.getSelection();
          if (sel.rangeCount) {
              var container = document.createElement("div");
              for (var i = 0, len = sel.rangeCount; i < len; ++i) {
                  container.appendChild(sel.getRangeAt(i).cloneContents());
              }
              html = container.innerHTML;
          }
      } else if (typeof document.selection != "undefined") {
          if (document.selection.type == "Text") {
              html = document.selection.createRange().htmlText;
          }
      }
      return html;
    }

    function showAlternativeTexts(token, show_input) {
        var container = $(token).closest('.translatable');
        var alternative_texts = token.data('alternative_texts');
        var arr = Array.from(alternative_texts);
        if(arr){
          arr.sort(function (a, b) {
            var offsets_a = a[0].split('_');
            var offsets_b = b[0].split('_');
            return (offsets_a[1] - offsets_a[0]) - (offsets_b[1] - offsets_b[0]);
          });
          $('.popper').remove();
          var text_popper ='';
          var content_popper = $('<div/>');
          var offset_start, offset_end;

          $(arr).each(function(key,elm){
            var id = elm[0];
            
            $(elm).each(function(key2,alt_text){

              $(alt_text).each(function(key3,alternative_text){
                offset_start = alternative_text.offset_start;
                offset_end = alternative_text.offset_end;
                text_popper+=alternative_text.text+' - <small>'+alternative_text.name+'</small><br/>';
              });
            });
            content_popper.html(text_popper);
            if(show_input){
              content_popper.append($('<span>Votre version :</span><br/>'));
              content_popper.append(getInputTranslation(container,offset_start, offset_end));              
              // content_popper+="Votre version :<br/>";
              // content_popper+=getInputTranslation(container, offset_start, offset_end);
            }
          });
        }
        showPopperTranslation(token, content_popper);
    }

    function getText(container, offset_start, offset_end){
      var text="";
      $('.token', container).each(function(index,node){
        var id = $(node).attr('id');
        if(id==undefined) return;
        node = $('#'+id);
        if(node.is( ":hidden" ) == true)
          return true;
        if(parseInt(node.attr('data-offset-start'))>=offset_start &&
            parseInt(node.attr('data-offset-end')) <= offset_end ){
           
          if(node.attr('data-type')=='crlf'){
            text+=node.html().replace(/<br\s*\/?>/gi,'');
          }
          else
            text+=node.html();
        }
      });
      return text;
    }

    function getInputTranslation(container, offset_start, offset_end){
      var original_text = getText(container, offset_start, offset_end);
      var id = offset_start+'_'+offset_end;
      var div = $('<form class="alternative-text"/>');
      var textarea = $('<textarea class="alternative-text-value" id="alternative-text-value-'+id+'" style="width:100%" spellcheck="false"/>');
      textarea.val(original_text);
      var btn_submit = $('<input type="button" class="alternative-text-submit" value="Valider" data-offset-start="'+offset_start+'"  data-offset-end="'+offset_end+'" data-attribute="'+container.attr('data-attribute')+'"  data-type="'+container.attr('data-type')+'" data-id="'+container.attr('data-id')+'" />');
      var btn_cancel = $('<input type="button" class="alternative-text-cancel" value="Annuler" />');
      div.append(textarea).append(btn_submit).append(btn_cancel);
      return div;
    }

    function showPopperTranslation(reference_element, content){
        if($('.popper').length>0)
          $('.popper').remove();
        var popper_translation = document.createElement("div");
        popper_translation.setAttribute('id','popper_translation');
        popper_translation.setAttribute('class','popper');
        $(popper_translation).append(content);
        document.body.appendChild(popper_translation);
        // var popper_translation = $('<div class="popper" id="popper_translation">'+content+'</div>');
        // popper_translation.hide();
        // $('body').append(popper_translation);
        var ref = document.getElementById(reference_element.attr('id'));
        var shiftEnd = new Popper(ref, popper_translation, {
          placement: 'bottom-start',
          modifiers: {
              flip: {
                  behavior: ['bottom-start', 'bottom-end']
              },
              preventOverflow: {
                  boundariesElement: document.getElementById('container'),
              },
          },
          onCreate: (data) => {
              // popper_translation.show();
              autosize($(".alternative-text-value"));
          },                          
        });

        $(".alternative-text-submit").click(function(event) {
            updateOriginalText(event);
        })

        $(".alternative-text-cancel").click(function() {
            cancelSelection();
        })
    }

    function displayAlternativeTexts() {
        $(alternative_texts).each(function(index,alternative_text){
          var offset_start = alternative_text.offset_start;
          var offset_end = alternative_text.offset_end;
          var attribute = alternative_text.translatable_attribute;
          var type = alternative_text.translatable_type;
          var id = alternative_text.translatable_id;
          var container = $(".translatable[data-attribute='"+attribute+"'][data-id='"+id+"'][data-type='"+type.replace("\\","\\\\")+"']");
            $('.token',container).each(function(index,node){
              var id = $(node).attr('id');
              if(id==undefined) return;
              node = $('#'+id);

                if(parseInt(node.attr('data-offset-start'))>=offset_start &&
                  parseInt(node.attr('data-offset-end')) <= offset_end ){
                      node.addClass('translated');

                      var alternative_texts_node = $(this).data('alternative_texts');
                      var key = alternative_text.offset_start+'_'+alternative_text.offset_end;

                      if(alternative_texts_node==undefined){
                        alternative_texts_node = new Map();
                      }
                      if(alternative_texts_node.get(key)==undefined){
                        alternative_texts_node.set(key, []);
                      }
                      var arr = alternative_texts_node.get(key);
                      arr.push({
                        text:alternative_text.value,
                        offset_start:alternative_text.offset_start,
                        offset_end:alternative_text.offset_end,
                        name:alternative_text.user.name
                      });
                      node.data('alternative_texts',alternative_texts_node);
                      
                      node.hover(function(e){
                        if(keep_open) return;
                        showAlternativeTexts($(this),false);
                      },function(e){
                        if(!keep_open){
                          $('.popper').remove();
                        }
                      });
                  }
            });
        });      
    }

    function cancelSelection(){
      keep_open = false;
      $('.token').removeClass('highlight');
      $('#version-user').val('');
      $('.popper').remove();
    }

    function showVersionContributor(user_id) {
      var texts = alternative_texts.filter(function( element ) {
        return user_id == element.user_id;
      });
      $('.alternative-token').remove();
      $('.token').show();
      $(texts).each(function(){

        var offset_start = this.offset_start;
        var offset_end = this.offset_end;
        var new_text = this.value;
        var attribute = this.translatable_attribute;
        token_index++;
        var new_span = $('<span id="'+token_index+'" class="token alternative-token highlight-done" data-offset-start="'+offset_start+'" data-offset-end="'+offset_end+'" data-type="word">'+new_text+'</span>');
        var elm_min = null;

          $('.token', $('.translatable[data-attribute='+attribute+']')).filter(function(){
            return (parseInt($(this).attr('data-offset-start'))>=parseInt(offset_start) && parseInt($(this).attr('data-offset-end'))<=parseInt(offset_end));
          }).hide();

          if(offset_start==0){
            $('.translatable[data-attribute='+attribute+']').prepend(new_span);
          } else {
            $('span.token[data-offset-end='+offset_end+']').after(new_span);
          }
      });

    }
    
    function showOriginalVersion() {
      $('.alternative-token').remove();
      $('.token').show();
    }

    function initPlusTab() {
      $('.translated').addClass('highlight-translated');
      $('.plus-tab').removeClass('d-none');
      $('.translatable').addClass('highlight-translatable');
      initTranslatable();
    }

    function initTranslatable() {

        $('.highlight-translatable').bind('mouseup', function(e){
          var container = $(e.target).closest('.translatable');

          $('.token').removeClass('highlight');

          var selectedHTML = getSelectionHtml();

          if( selectedHTML ){
            keep_open = true;
            var text ="";
            var offset_min = 10000;
            var offset_max = 0;
            selectedNodes = $(selectedHTML);
            
            if(selectedNodes.length==0){
              selectedNodes = $([$(e.target)]);
            }

            selectedNodes.each(function(index,node){
 
              var id = $(node).attr('id');

              if(id==undefined) return;
              node = $('#'+id);
              if(node.is( ":hidden" ) == true)
                return true;
              if( (index>0 &&  index<(selectedNodes.length-1)) || (index==0 && node.attr('data-type')=='word') || (index==(selectedNodes.length-1) && (node.attr('data-type')=='word'
                // || node.attr('data-type')=='punct'
                ))){
                
                if(node.attr('data-type')=='crlf'){
                  text+=node.html().replace(/<br\s*\/?>/gi,'');
                }
                else
                  text+=node.html();

                if(parseInt(node.attr('data-offset-start'))<offset_min)
                  offset_min = parseInt(node.attr('data-offset-start'));

                if(parseInt(node.attr('data-offset-end'))>offset_max)
                  offset_max = parseInt(node.attr('data-offset-end'));

                node.addClass('highlight');
              }
            });
            selected_text = text;

            var content_popper = $('<div/>');
            content_popper.append($('<span>Votre version :</span><br/>'));
            content_popper.append(getInputTranslation(container,offset_min, offset_max));
            // text+=getInputTranslation(container,offset_min, offset_max);
            var reference_element = $('.token[data-offset-start='+offset_min+']', container);

            showPopperTranslation(reference_element, content_popper);
            start = offset_min;
            end = offset_max;

          } else if($(e.target).hasClass('translated') || $(e.target).hasClass('highlight-done')){

            keep_open = true;
            showAlternativeTexts($(e.target),true);
          } 

        });
    }

    function updateOriginalText(event){
      var start = $(event.target).attr('data-offset-start');
      var end = $(event.target).attr('data-offset-end');
      var attribute = $(event.target).attr('data-attribute');
      var type = $(event.target).attr('data-type');
      var id = $(event.target).attr('data-id');
      var container = $(".translatable[data-attribute='"+attribute+"'][data-id='"+id+"'][data-type='"+type.replace("\\","\\\\")+"']");
      keep_open = false;
      
      var new_text = $('#alternative-text-value-'+start+'_'+end).val();
      var original_text = getText(container,start,end);

      if(new_text==original_text){
        $('.popper').remove();
        return false;
      }

      $.post( "{{ route('translations.store') }}", {
        translatable_id: id, 
        translatable_attribute: attribute,
        translatable_type: type,
        value: new_text,
        offset_start: start,
        offset_end: end
      }).done(function( data ) {

      }).fail(function( data ) {
        alert( "Veuillez vous connecter pour enregistrer une traduction." );
      });

      $('.popper').remove();
      var elm_min = null;
      var offset_min = -1;

      $('.token', container).each(function(index,token){
        var offset_start = parseInt($(token).attr('data-offset-start'));
        if(offset_start<parseInt(start) && offset_start>offset_min){
          elm_min = token;
          offset_min = offset_start;
        }

        if(parseInt($(token).attr('data-offset-start'))>=parseInt(start) && parseInt($(token).attr('data-offset-end'))<=parseInt(end))
          $(token).hide();
      });

      token_index++;
      
      var new_span = $('<span id="'+token_index+'" class="token" data-offset-start="'+start+'" data-offset-end="'+end+'" data-type="word">'+new_text+'</span>');
      var key = start+'_'+end;

      alternative_texts_node = new Map();

      alternative_texts_node.set(key, []);

      var arr = alternative_texts_node.get(key);
      arr.push({
        text:original_text,
        offset_start:start,
        offset_end:end,
        name:"texte original"
      });
      new_span.data('alternative_texts',alternative_texts_node);      

      new_span.addClass('highlight-done');
      
      new_span.data('original_text',selected_text);
      new_span.hover(function(e){
        if(keep_open) return;
        showAlternativeTexts($(this),false);
      },function(e){
        if(!keep_open){
          $('.popper').remove();
        }
      });      

      if(elm_min!=null)
        $(elm_min).after(new_span);
      else
        container.prepend(new_span);

     
    }

    $("#plus-tab").click(function(event) {
        if(!isLoggedIn()){
          window.location.href = $(this).attr('href');
          return false;
        }
        $('#annotation').addClass('d-none');
        $('#content-recipe').removeClass('d-none');
        initPlusTab();
    })

    $("#pos-tab").click(function(event) {
        if(!isLoggedIn()){
          window.location.href = $(this).attr('href');
          return false;
        }      
        $('#content-recipe').addClass('d-none');
        $('#annotation').removeClass('d-none');
    })

    $("#recipe-tab").click(function(event) {
        $('#annotation').addClass('d-none');
        $('#content-recipe').removeClass('d-none');
        $('.translated').removeClass('highlight-translated');
        $('.plus-tab').addClass('d-none');
        $('.translatable').removeClass('highlight-translatable');
    })

    $("#cancel").click(function() {
        cancelSelection();
    })
    $(".contributor").click(function() {
        var user_id = $(this).attr('data-user-id');
        showVersionContributor(user_id);
    })
    $(".author").click(function() {
        var user_id = $(this).attr('data-user-id');
        showOriginalVersion();
    })
    $("body").click(function(event) {
      var elm = $(event.target).closest('.popper');
      if(elm.length==0 && !$(event.target).hasClass('token') && !$(event.target).hasClass('translatable')){
        cancelSelection();
      }
    })

    const WHITE_SPACE=1;
    const PUNCT=2;
    const CRLF=3;
    const ALPHANUM=4;
    var token_index = 1;
    function setDataType(span,data_type){
      switch (data_type) {
        case WHITE_SPACE :
            span.attr('data-type',"white_space");
        break;
        case PUNCT :
            span.attr('data-type',"punct");
        break;
        case ALPHANUM :
            span.attr('data-type',"word");
        break;
        case CRLF :
            span.attr('data-type',"crlf");
        break;
      }  
    }

    function displayText(text,container){
      container.html('');
      let arr = Array.from(text);
      var regularExpPunct = /[«»’\.,-\/#!$%'"^&*;:{}=_`~()-]/ig;
      var regularExpCR = /[\r\n]/;
      var regularExpWhiteSpace = /[ ]/;

      var type_previous_char="";

      var current_word="";
      var current_span=$('<span/>');
      current_span.attr('id',token_index++);
      current_span.attr('data-offset-start',0);
      var result = $('<div/>');
      $(arr).each(function(index,character){
        
        var type_current_char;
        if(character.match(regularExpWhiteSpace)){
          type_current_char = WHITE_SPACE;    
        }
        else if(character.match(regularExpPunct)){
          type_current_char = PUNCT;
        }
        else if(character.match(regularExpCR)){
          type_current_char = CRLF;
        }
        else {
          type_current_char = ALPHANUM;
        }
        if(index==0){
          setDataType(current_span,type_current_char)
          type_previous_char = type_current_char;
          current_word+=character;
          return;
        }
        current_span.addClass('token');
        switch (type_current_char) {
          case WHITE_SPACE :
            if(type_previous_char!=WHITE_SPACE){
              current_span.attr('data-offset-end',index);
              current_span.html(current_word);
              current_word = "";
              container.append(current_span);
              current_span = $('<span/>');
              current_span.attr('id',token_index++);
              current_span.attr('data-offset-start',index);
              current_span.attr('data-type',"white_space");
            }
          break;
          case PUNCT :
              current_span.attr('data-offset-end',index);
              current_span.html(current_word);
              current_word = "";
              container.append(current_span);
              current_span = $('<span/>');
              current_span.attr('id',token_index++);
              current_span.attr('data-offset-start',index);
              current_span.attr('data-type',"punct");
          break;
          case ALPHANUM :
            if(type_previous_char!=ALPHANUM){
              current_span.attr('data-offset-end',index);
              current_span.html(current_word);
              current_word = "";
              container.append(current_span);
              current_span = $('<span/>');
              current_span.attr('id',token_index++);
              current_span.attr('data-offset-start',index);
              current_span.attr('data-type',"word");    
            }
          break;
          case CRLF :
              character += "<br>";
              if(type_previous_char!=CRLF){
                current_span.attr('data-offset-end',index);
                current_span.html(current_word);
                current_word = "";
                container.append(current_span);
                current_span = $('<span/>');
                current_span.attr('id',token_index++);
                current_span.attr('data-offset-start',index);
                current_span.attr('data-type',"crlf");    
              }
          break;
        }
        current_word+=character;      
        type_previous_char = type_current_char;
      })
      current_span.attr('data-offset-end',arr.length);
      current_span.addClass('token');
      current_span.html(current_word);
      container.append(current_span);
    }
</script>

@endsection

@section('style')

<style>
.explanation {
  /*color: #337ab7;*/
  background-color: white;
  text-align: center;
}
.annotation-header{
        margin-bottom: 3em;
}
      


.center-t {
    text-align:center;
}

#message-popup {
  font-family: Trebuchet MS, Helvetica, arial, sans-serif;
  color: chocolate;
  background-color: white;
}
.list-group-item.disabled,.list-group-item.disabled:hover, .list-group-item:disabled {
  /*background-color: #e9ecef;*/
  background: repeating-linear-gradient(
    -45deg,
    rgba(0, 0, 0, 0.1),
    rgba(0, 0, 0, 0.1) 10px,
    rgba(0, 0, 0, 0.2) 10px,
    rgba(0, 0, 0, 0.2) 20px
  );
  
}
.word-container{
  line-height: 1.1em;
  margin-bottom: 0.8em;
  font-size: 25px;
}
.word-list:hover{
  background-color:#ddd;
  cursor:pointer;
}
#annotation {
  font-size: 1rem;
}
.list-group-item {
    padding: 0.5rem 1.25rem;
}
.pos {
  font-size: 14px;
}
.popper {
    position: absolute;
    background: white;
    color: #333;
    text-align: left;
    padding-top:0.1rem;
    padding-right:1rem;
    font-size:12px;
    padding:0px 5px;
    border:solid 1px rgba(0, 0, 0, 0.2);
}

.highlight-done {
    background-color: #E3F6CE;
}
.highlight-translated {
    background-color: #F5BCA9;
}
div.highlight-translatable, h1.highlight-translatable {
  padding: 1rem;
  background: whitesmoke;
}
td.highlight-translatable {
  padding-left: 1rem;
  padding-right: 1rem;
  background: whitesmoke;
}
.highlight, .highlight:hover {
    background-color: #ffd47b;
}
.validated {
    background-color: #E3F6CE;
}
.recipe-ingredients {
  position: relative;
}
img.no, img.check {
  width: 20px;
}
img.no {
    cursor: pointer;
  /*padding-right: 4px;*/
}
img.check {    
    cursor: pointer;

  /*padding-left: 4px;*/
}
.noselect {
  -webkit-touch-callout: none; /* iOS Safari */
    -webkit-user-select: none; /* Safari */
     -khtml-user-select: none; /* Konqueror HTML */
       -moz-user-select: none; /* Firefox */
        -ms-user-select: none; /* Internet Explorer/Edge */
            user-select: none; /* Non-prefixed version, currently
                                  supported by Chrome and Opera */
}

.no-display {
    display: none;
}

</style>
@endsection
