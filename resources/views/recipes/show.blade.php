@extends('layouts.app')

@section('content')
  
  @include ('recipes/_search') 
  
<div id="recipe" class="container">
  
  <ul class="nav nav-tabs" id="myTab" role="tablist">
    <li class="nav-item">
      <a class="nav-link page-title" id="recipe-tab" data-toggle="tab" href="#recipe" role="tab" aria-controls="home" aria-selected="true">Voir la recette</a>
    </li>
    <li class="nav-item">
      <a class="nav-link page-title active" id="plus-tab" data-toggle="tab" href="#plus" role="tab" aria-controls="plus" aria-selected="false">Moi je l'aurais dit comme ça !</a>
    </li>
    <li class="nav-item">
      <a class="nav-link page-title" id="pos-tab" data-toggle="tab" href="#pos" role="tab" aria-controls="pos" aria-selected="false">Annotation</a>
    </li>
  </ul>

  <div class="bg-white p-3" id="content-recipe">
    <div class="plus-tab d-none alert alert-info">
      Pour proposer une version dans une autre variété d'alsacien, sélectionnez du texte dans les zones grisées ou cliquez sur du texte en surbrillance.
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
          {{ __('recipes.recipe-by') }}{{ link_to_route('users.show', $recipe->author->name, $recipe->author) }}
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
      <h4>{{ __('recipes.ingredients') }}
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
    
    <h4 class="mt-2">{{ __('recipes.recipe') }}</h4>
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
  
  @php
  $pos = [];
  foreach($postags as $postag){
    $pos[$postag->id] = $postag->name;
  }  
  @endphp

  <div id="annotation" class="bg-white p-3 d-none">
    <h4>Aidez-nous à améliorer nos outils ! <button class="btn btn-primary" id="btn-annotation">Annoter la recette</button></h4>
    <h5 id="message" class="mb-2">Voici les annotations produites par notre outil :</h5>
    <div class="row">
      <div class="col-9" id="annotations">
      @if($corpus_recipe)
        @foreach($corpus_recipe->sentences as $sentence)
          @foreach($sentence->words as $word)
          <div class="word_container" style="display:inline-block;text-align:center;vertical-align: top;">
            <span class="word" data-word-id="{{ $word->id }}" data-postag-id="{{ $word->annotation_melt->postag_id }}">{{ $word->value }}</span>
            <br/>
            @if($pos[$word->annotation_melt->postag_id]!="PUNCT")
              <span class="pos" data-word-id="{{ $word->id }}" data-postag-id="{{ $word->annotation_melt->postag_id }}">{{ $pos[$word->annotation_melt->postag_id] }}</span>
            @endif
          </div>
          @endforeach
          <br/>
        @endforeach
      @else
      <alert>Aucune annotation pour cette recette.</alert>
      @endif
      </div>
      <div class="col-3">
        @foreach($postags as $postag)
          @if($pos[$postag->id]!='PUNCT')
            <div class="postag" data-postag-id="{{ $postag->id }}">{{ $postag->full_name }} <em>({{ $postag->name }})</em></div>
          @endif
        @endforeach
      </div>
    </div>
    <div class="row">
      <div class="offset-4 col-6">
        <button id="btn-next-postag" class="btn btn-primary d-none">Postag suivant</button>
        <button id="btn-validate" class="btn btn-primary d-none">Enregistrer mes annotations</button>
      </div>
    </div>
  </div>

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

    var alternative_texts = {!! json_encode($alternative_texts) !!};
    var postags = {!! json_encode($postags) !!};
    console.log(postags);
    var selected_text;
    var keep_open = false;
    var current_postag_id = 0;
    var current_postag = null;
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
    };

    $('.postag').click(function(){
      current_postag_id = $(this).attr('data-postag-id');
      current_postag = getPostag(current_postag_id);
      // $('.word').removeClass('highlight');
      $('.postag').removeClass('highlight');
      $(this).addClass('highlight');
      initAnnotationPostag();
      // $('.word[data-postag-id='+current_postag_id+']').addClass('highlight');
      // $('.pos').addClass('invisible');
      // $('.pos[data-postag-id='+current_postag_id+']').removeClass('invisible').addClass('visible');
    })

    $('.word').click(function(){
      if(!current_postag) return false;

      var word_id = $(this).attr('data-word-id');
      var postag_html = $('.pos[data-word-id='+word_id+']');

      if($(this).hasClass('highlight')){
        $(this).removeClass('highlight');
        $(this).attr('data-postag-id',0);
        postag_html.removeClass('visible').addClass('invisible').html('').attr('data-postag-id',0);
      } else {
        $(this).addClass('highlight');
        $(this).attr('data-postag-id',current_postag.id);
        postag_html.removeClass('invisible').addClass('visible').html(current_postag.name).attr('data-postag-id',current_postag.id);
      }


    })
  
    $('#btn-annotation').click(function(){
      var fisrt_postag = $('.postag').first();
      current_postag_id = fisrt_postag.attr('data-postag-id');
      current_postag = getPostag(current_postag_id);
      $('.postag').removeClass('highlight');
      fisrt_postag.addClass('highlight');      
      initAnnotationPostag();
    });

    $('#btn-next-postag').click(function(){
      var next_postag = $('.postag.highlight').next('.postag');
      if(next_postag.length==0) return false;
      current_postag_id = next_postag.attr('data-postag-id');
      current_postag = getPostag(current_postag_id);
      $('.postag').removeClass('highlight');
      next_postag.addClass('highlight');      
      initAnnotationPostag();
    });

    function initAnnotationPostag(postag) {
      $('#btn-validate').removeClass('d-none');
      $('#btn-next-postag').removeClass('d-none');
      $('.word').removeClass('highlight');
      $('.word[data-postag-id='+current_postag_id+']').addClass('highlight');
      $('.pos').addClass('invisible');
      $('.pos[data-postag-id='+current_postag_id+']').removeClass('invisible').addClass('visible');
      $('#message').html("Séctionnez ou désélectionnez les mots du texte qui appartiennent à la catégorie <span style='color:red;'>"+current_postag.full_name+' <em>('+current_postag.name+')</em></span>');
      $('#btn-annotation').hide();
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
      console.log(postag);
      return postag;
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
          console.log('remove popper 4');
          $('.popper').remove();
          var content_popper ='';
          var offset_start, offset_end;

          $(arr).each(function(key,elm){
            var id = elm[0];
            
            $(elm).each(function(key2,alt_text){

              $(alt_text).each(function(key3,alternative_text){
                offset_start = alternative_text.offset_start;
                offset_end = alternative_text.offset_end;
                content_popper+=alternative_text.text+' - <small>'+alternative_text.name+'</small><br/>';
              });
            });
            if(show_input){
              content_popper+="Votre version :<br/>";
              content_popper+=getInputTranslation(container, offset_start, offset_end);
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
      return '<div class="alternative-text"><textarea class="alternative-text-value" id="alternative-text-value-'+id+'" style="width:100%" spellcheck="false">'+original_text+'</textarea><input type="button" class="alternative-text-submit" value="Valider" data-offset-start="'+offset_start+'"  data-offset-end="'+offset_end+'" data-attribute="'+container.attr('data-attribute')+'"  data-type="'+container.attr('data-type')+'" data-id="'+container.attr('data-id')+'" /><input type="button" class="alternative-text-cancel" value="Annuler" /></div>';
    }

    function showPopperTranslation(reference_element, content){
        var popper_translation = document.createElement("div");
        popper_translation.setAttribute('id','popper_translation');
        popper_translation.setAttribute('class','popper');
        popper_translation.innerHTML = content;
        document.body.appendChild(popper_translation);
        // var popper_translation = $('<div class="popper" id="popper_translation">'+content+'</div>');
        // popper_translation.hide();
        // $('body').append(popper_translation);
        console.log(reference_element);
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
              console.log('show');
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
                          console.log('remove popper 5');
                          $('.popper').remove();
                        }
                      });
                  }
            });
        });      
    }

    function cancelSelection(){
      console.log('remove popper 1');
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
          console.log("mouseup");
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

            text = 'Votre version :<br/>';
            text+=getInputTranslation(container,offset_min, offset_max);
            var reference_element = $('.token[data-offset-start='+offset_min+']', container);

            showPopperTranslation(reference_element, text);
            start = offset_min;
            end = offset_max;

          } else if($(e.target).hasClass('translated') || $(e.target).hasClass('highlight-done')){

            keep_open = true;
            showAlternativeTexts($(e.target),true);
          } 

        });
    }

    function updateOriginalText(event){
      console.log("updateOriginalText");
      var start = $(event.target).attr('data-offset-start');
      var end = $(event.target).attr('data-offset-end');
      var attribute = $(event.target).attr('data-attribute');
      var type = $(event.target).attr('data-type');
      var id = $(event.target).attr('data-id');
      var container = $(".translatable[data-attribute='"+attribute+"'][data-id='"+id+"'][data-type='"+type.replace("\\","\\\\")+"']");
      keep_open = false;
      var new_text = $('#alternative-text-value-'+start+'_'+end).val();
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
      
      var original_text = getText(container,start,end);

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
          console.log('remove popper 5');
          $('.popper').remove();
        }
      });      

      if(elm_min!=null)
        $(elm_min).after(new_span);
      else
        container.prepend(new_span);

     
    }

    $("#plus-tab").click(function(event) {
        $('#annotation').addClass('d-none');
        $('#content-recipe').removeClass('d-none');
        initPlusTab();
    })

    $("#pos-tab").click(function(event) {
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
      console.log(elm);
      console.log($(event.target));
      if(elm.length==0 && !$(event.target).hasClass('token') && !$(event.target).hasClass('translatable')){
        console.log('cancelSelection42');
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
.word_container{
  line-height: 1.1em;
  margin-bottom: 1em;
}
#annotation {
  font-size: 1.2em;
}
.pos {
  font-size: 0.8em;
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
.highlight {
    background-color: yellow;
}
.recipe-ingredients {
  position: relative;
}
</style>
@endsection
