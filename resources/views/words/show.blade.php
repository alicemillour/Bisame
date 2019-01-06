    
@extends('layouts.app')
@section('style')
<link target="_blank" href="{{ asset('css/game.css') }}" rel="stylesheet" type="text/css" >
@endsection

@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-10">
            <div class="card explanation-card background-colored-light fancy-border">
                <div class="row">
                    <div class="col-md-10 col-centered">
                        @if($word->annotation_user(1))
                        @php
                        $annotation = $word->annotation_user(1);
                        @endphp
                        {{--{{$pos[$word->annotation_user(1)->postag_id]}}--}}
                        @endif
                        
                        <h3 class="card-header title text-center belle-allure" style="color:#b12078 ; background-color: transparent; border-bottom-color: transparent">
                            <div class="original_word" id="original_word" data-value="{{$word->value}}" data-id="{{$word->id}}" >{{$word->value}}
                                <!--<button class="btn btn-link" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                <i class="fa fa-question" aria-hidden="true"></i> 
                                </button>-->
                                    
                            </div>
                        </h3>
                        <h3>
                            
                            Le mot <span style="size:1.5em">{{$word->value}}</span>  apparaît {{$word_count}} fois sur ce site </h3>
                        {{-- @if(sizeof($word_cats)==0)
                                    <h3> la catégorie grammaticale du mot est inconnue pour le moment </h3>
                            Ajouter une catégories
                            @elseif(sizeof($word_cats)==1)
                                    <h3>Une catégorie grammaticale proposée pour ce mot :
                                    @foreach($word_cats as $cat)
                            <span style="font-style: italic; color: red; size:1.5em">{{$cat->postag_full_name}}</span> 
                        @endforeach
                        </h3><br><br>
                        @else
                        <h3>Catégories grammaticales proposées pour ce mot 
                            @foreach($word_cats as $cat)
                            <span style="font-style: italic; color: red; size:1.5em">{{$cat->postag_full_name}}</span> 
                            @endforeach
                        </h3><br><br>
                        voir si on fait valider la catégorie.
                        @endif
                        --}}
                        @if(sizeof($word_variants_unique)==0)
                        <h3> Aucune variante orthographique ou dialectale du mot n'est connue pour le moment </h3>
                        @else
                        @if(sizeof($word_variants_unique)==1)   
                        <h3>Une variante orthographique ou dialectale : 
                            @else 
                            <h3>Plusieurs variantes orthographiques ou dialectales: 
                                @endif
                                    
                                @foreach($word_variants_unique as $key => $variant)
                                @if($variant['original'] != $word->value)
                                <span style="font-style: italic; color: red; size:1.5em">{{$variant['original']}}  </span>(par {{$variant['user_name']}})
                                @endif
                                @if($variant['variant'] != $word->value)
                                <span style="font-style: italic; color: red; size:1.5em">{{$variant['variant']}} </span>(par {{$variant['user_name']}})
                                @endif    
                                @endforeach
                                @endif 
                                <h3 style='color:blue'>Et vous, vous l'auriez écrit comment ?</h3>
                                <form action="welcome.php" method="post">
                                    <textarea class="alternative-text-value" id="alternative-text-value" style="width:25%" spellcheck="false"/></textarea>
                                <input type="button" class="alternative-text-submit" value="Valider" ><br>

                                </form>
                                    
                            </h3>
                    </div>
                </div>
                
                <!-- préparation headers --> 
                
                <div class="row">
                    <div class="col-md-6 col-centered">
                        <h2>Exemple(s) d'apparition</h2>
                    </div>
                    <div class="col-md-4 col-centered">
                        <h2>Catégorie grammaticale proposée </h2>
                    </div>
                </div>
                
                <!--on parcourt les phrases--> 
                @foreach($sentences as $sentence)
                <div class="row">
                    <div class="col-md-6 col-centered">
                        <div class="word-container">
                            
                            @foreach($sentence->words as $cur_word)    
                            @if(strtolower(trim(preg_replace('~[^0-9a-z]+~i', '-', preg_replace('~&([a-z]{1,2})(acute|cedil|circ|grave|lig|orn|ring|slash|th|tilde|uml);~i', '$1', htmlentities($word['value'], ENT_QUOTES, 'UTF-8'))), ' '))
                            == strtolower(trim(preg_replace('~[^0-9a-z]+~i', '-', preg_replace('~&([a-z]{1,2})(acute|cedil|circ|grave|lig|orn|ring|slash|th|tilde|uml);~i', '$1', htmlentities($cur_word->value, ENT_QUOTES, 'UTF-8'))), ' ')) && $word['value']!=$cur_word->value)
                            <div class="word" style="color: blue; size:1.5em">{{ $cur_word['value'] }} </div> 
                            @elseif($word['value']==$cur_word->value)
                            <div class="word" style="color: red; size:1.5em">{{ $cur_word['value'] }} </div> 
                            @else
                            <div class="word">{{ $cur_word['value'] }} </div> 
                            @endif
                            
                            @endforeach
                        </div>
                    </div> 
                    <!--on ferme la colonne mais on est toujours dans la row et dans la loop--> 
                    <div class="col-md-4">                        
                        <h3>
                            
                            @foreach($word_cats as $word_cat)
                            <!--words cat sentence : {{$word_cat}} {{$word_cat->sentence_id}} <br><br>-->
                            @if($word_cat->sentence_id == $sentence->id)
                            <div style="color: blue">{{$word_cat->postag_full_name}}</div>
                            @if($word_cat->tagger != "")
                            (proposé par notre outil d'annotation) <br>
                            @else
                            (proposé par {{$word_cat->user_name}})<br>
                            @endif
                            @endif
                            @endforeach
                        </h3>
                    </div>       
                    <br>
                </div>
                
                <hr>   
                @endforeach
                
            </div>
            
        </div>
        <div class="col-md-2 col-centered">
            <div class="card background-colored fancy-border">
                <div id="wordcloud" class="card-body">
                    @include('info.wordcloud')
                </div>
            </div>            
        </div>
    </div>
        
        
        
</div>               
</div>               





@endsection

@section('scripts')
<script type="text/javascript">
//    var original_word = {{ $cur_word['value'] }};
function AddVariant(event){      
      console.log( $('#alternative-text-value').val());
      var new_text = $('#alternative-text-value').val();
      var original_text = $('#original_word').data("value");
      var word_id = $('#original_word').data("id");
//      var original_text = {!! json_encode($cur_word['value']) !!};

  
      console.log(original_text);
      console.log(new_text);

      if(new_text===original_text){
        alert( "Cette variante correspond au mot original." );
      } else {
        $.post( "{{ route('translations-words.store') }}", {
          word_id: word_id,
          alternative: new_text,
          original: original_text,
        }).done(function( data ) {
            alert( "Votre variante a bien été joutée, merci !" );
//            location.reload();
        }).fail(function( data ) {
          alert( "Quelque chose s'est mal passé... Nous allons tenter de résoude ce problème." );
        });
    }

      
     
    }
 
 window.onload = function() {
            $(".alternative-text-submit").click(function(event) {
            AddVariant(event);
        })
    }
    
</script>

@endsection
