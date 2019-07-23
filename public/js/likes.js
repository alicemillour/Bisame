$(function () {
  // $('.likeable').hover(function(e){

  //   var content = $(this).attr('data-content');

  //   var popper = $('<div class="popper tooltip"><p class="bold">'+content+'</p></div>');
  //   $('body').append(popper);
  //   var shiftEnd = new Popper($(this), popper, {
  //     placement: 'bottom',
  //   });
  // },function(e){
  //     $('.tooltip').remove();
  // });  
  $('[data-toggle="popover"]').popover()
})

$('.likeable').click(function(event){
  var type = $(event.target).attr('data-type');
  var id = $(event.target).attr('data-id');      
  $.post( base_url+'likes', {
    likeable_id: id, 
    likeable_type: type
  }).done(function( data ) {
    $('.likes-count[data-id='+id+']').html(data.likes_count);
    $('.likeable[data-id='+id+']').attr('data-original-title',"Vous aimez ce texte");
  }).fail(function( data ) {
    alert( "Veuillez vous connecter pour aimer une recette." );
  });      
});    