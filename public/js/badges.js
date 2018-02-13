$(function () {
  if($('#badgeModal').length>0){
    $('#badgeModal').modal('show');
	$('#badgeModal').on('shown.bs.modal', function (e) {
	  $('#badgeModal').delay(1500).fadeOut(2500, function(){
	      $('#badgeModal').modal('hide');
	  });
	})
  }
})