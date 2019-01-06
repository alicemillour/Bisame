function AddVariant(event){      
      var new_text = $('#alternative-text-value').val();
      var original_text = "original-test-word"; // aller choper le contenu de la value dans la balise du mot quelque part sur la page
      console.log("On ajoute une variante à la mano");
  
      console.log(original_text);
      console.log(new_text);

      if(new_text==original_text){
        return false;
      }

//      $.post("{{ route('create-annotation') }}", { word_id: word_id, postag_id: postag_id })

      $.post( "{{ route('translations.store') }}", {
        alternative: new_text,
        original: original_text,
      }).done(function( data ) {

      }).fail(function( data ) {
        alert( "fail de création de variante" );
      });

      
     
    }
 
 window.onload = function() {
            $(".alternative-text-submit").click(function(event) {
            AddVariant(event);
        })
    }