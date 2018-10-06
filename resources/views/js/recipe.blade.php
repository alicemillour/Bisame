$('.trash-photo').click(function(){
	trashPhoto(this);
})

function trashPhoto(element){
	$(element).closest('.thumbnail').remove();
	if($("input.cover_picture:checked").length==0 && $("input.cover_picture").length>0)
		$("input.cover_picture").prop('checked','checked');
}
$( "#form-recipe" ).submit(function( event ) {
	$(window).scrollTop(0);
  	$('#container-loader').removeClass('d-none');
});
$('#photo').change(function(){
	var formData = new FormData($('#form-recipe')[0]);
	jQuery.ajax
	({
	        url: '{{ route('media.upload') }}',
	        type: "POST",
	        data:   formData,
	        dataType: 'json',
	        mimeType: "multipart/form-data",
	        success: function(data)
	        {
	        	var div_thumbnail = $('<div class="thumbnail ml-3 d-inline-block"/>');
	        	div_thumbnail.append($('<img/>').attr('src',base_url+data.url));
	        	div_thumbnail.append($('<input/>').attr('type','hidden').attr('name','photos[]').attr('value',data.url));
	        	div_thumbnail.append($('<br/>'));
	        	var radio_button = $('<input/>').attr('type','radio')
	        						.attr('name','cover_picture')
	        						.attr('class','cover_picture')
	        						.attr('value',data.url);

	        	if($("input.cover_picture:checked").length==0)
	        		radio_button.prop('checked','checked');

	        	if($('#btn-create').length>0){
		        	var label = $('<label> Photo de couverture</label>').prepend(radio_button);
		        	div_thumbnail.append(label);
	        	}
	        	var trash = $('<i class="fa fa-trash-o float-right fa-2" aria-hidden="true"></i>');
	        	trash.click(function(){
	        		trashPhoto(this);
	        	});
	        	div_thumbnail.append(trash);
	        	$('#thumbnails').append(div_thumbnail);
	        	if($('#btn-create').length==0 && $('#btn-validate').length==0) {
	        		var btn_validate = $('<button class="btn btn-primary btn-sm">Enregistrer</button>');
	        		div_thumbnail.append(btn_validate);
	        	}
	        },
	        error: function(data)
	        {
	            alert( 'Désolée, la photo que vous avez choisie est trop grande. Choisissez une image de taille inférieure à 1.5Mo' );
	        },
			cache: false,
	        contentType: false,
	        processData: false
	});

});

window.onload = function() {
	autosize($('#content'));
	autosize($('#anecdote'));
	$('input.time').each(function(){
	console.log($(this).val());

		if($(this).val()!=0)
			$('#collapseTimes').collapse("show");
	});
	console.log($('#servings').val());
	if($('#servings').val()>0)
		$('#collapseServings').collapse("show");
};
$('input[type=number]').change(function(event){
	if(!$(this).val().match(/^[0-9]+$/))
	$(this).val(0);
});
var new_ingredient_html = function(index,quantity,name){
	quantity = quantity || '';
	name = name || '';
			return '<div class="d-flex row-ingredient"><div class="col-6"> \
			<input id="ingredient-'+index+'" type="text" name="ingredient['+index+'][name]" class="form-control d-inline ingredient-name" value="'+name+'" style="width:100%"  \
			placeholder="{{  __('recipes.ingredient') }}"> \
		</div> \
			<div class="col-auto my-auto"> \
			<i class="fa fa-plus-circle add-ingredient mr-2" aria-hidden="true" onclick="addIngredient()"></i> \
			<i class="fa fa-trash remove-ingredient" aria-hidden="true" onclick="removeIngredient(this)"></i> \
			<input type="hidden" name="ingredient['+index+'][index]" value="'+index+'" /> \
		</div></div>';
}

function addIngredient(){
	$('.remove-ingredient').show();
	$('#container-ingredients').append(new_ingredient_html(++index_ingredient));
	$('#ingredient-'+index_ingredient).focus();

}

function removeIngredient(elm){
	if($('.row-ingredient').length>1){
		$(elm).closest('.row-ingredient').remove();
	} else {
		$('.quantity').val('');
		$('.ingredient-name').val('');
	}
}
var index_ingredient = {{ $index_ingredient??0 }};
index_ingredient++;
$(document).keypress(function(e) {
    if(e.which == 13) {
    	if($(e.target).hasClass('ingredient-name')){
    		e.preventDefault();
	        addIngredient();
    	}
    }
});
