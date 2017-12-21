/* Gestion of threads of discussion */
$(document).on('focus', '.message', function(){
    $(this).closest("form.form-message").find(".submitMessage").removeAttr("disabled");
});
$('.message-button').click(showThread);
$('#message-button').click(showThread);

$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();
});

function showThread(event){
    event.preventDefault();
    console.log("show thread");
    var entity_id = $(this).attr('data-id');
    var entity_type = $(this).attr('data-type');
    if(!$("#thread_"+entity_id).is(":visible")){
        $("#thread_"+entity_id).load(url_site('discussion/thread')+"?entity_id="+entity_id+"&entity_type="+entity_type, function(responseTxt, statusTxt, xhr){
            if(statusTxt == "success"){
                $("#thread_"+entity_id).slideDown(200,function(){
                    if($("#sentence").length>0){
                        var target_offset = $("#thread_"+entity_id).offset();
                        var target_top = target_offset.top-75;
                        $('.parallax').animate({
                            scrollTop: target_top
                        }, 500);
                    }                    
                });
            }
            if(statusTxt == "error")
                alert("Error: " + xhr.status + ": " + xhr.statusText);
        });
    } else {
        $("#thread_"+entity_id).slideUp(200);
    }
}
function followThread(){
    var annotation_id = $(this).attr('data-id');
    var $element = $(this);
    $.ajax({
        method : 'GET',
        url : base_url + 'discussion/follow-thread',
        data : {'id':annotation_id,'type':'annotation'},
        complete: function(response){
            $element.hide();
            $('span.unfollow-thread-button[data-id='+annotation_id+']').show();
        }
    });
}
function unFollowThread(){
    var annotation_id = $(this).attr('data-id');
    var $element = $(this);
    $.ajax({
        method : 'GET',
        url : base_url + 'discussion/un-follow-thread',
        data : {'id':annotation_id,'type':'annotation'},
        complete: function(response){
            $element.hide();
            $('span.follow-thread-button[data-id='+annotation_id+']').show();
        }
    });
}

$(document).on('click','.cancelReport', function(event){
    event.preventDefault();
    $(this).closest('.thread').slideUp();
});
$(document).on('click','.cancelAnswer', function(event){
    event.preventDefault();
    $(this).closest('.form-message').slideUp();
});

$(document).on('submit', ".form-message" ,function( event ) {
    event.preventDefault();
    var text = $.trim($(this).find("textarea").val());
    if(text!=""){
        var entity_id = $(this).attr('data-id');
        $.ajax({
            method : 'POST',
            url : base_url + 'discussion/new',
            data : $(this).serialize(),
            complete: function(response){
                $("#thread_"+entity_id).html(response.responseText);
            }
        });
    } else {
        alert("Veuillez saisir un message");
    }   
});
$(document).on('submit', ".form-anecdote" ,function( event ) {
    
    var text = $.trim($(this).find("textarea").val());
    if(text==""){
        event.preventDefault();
        alert("Veuillez saisir une anecdote");
    }   
});
$(document).on('click', ".delete-message" ,function( event ) {
    event.preventDefault();
    if(confirm('Are you sure ?')){
        var message_id = $(this).attr('data-message-id');
        var entity_id = $(this).attr('data-entity-id');
        var entity_type = $(this).attr('data-type');
        $.ajax({
            method : 'GET',
            url : base_url + 'discussion/delete?entity_id='+entity_id+'&message_id='+message_id+'&entity_type='+entity_type,
            complete: function(response){
                $("#thread_"+entity_id).html(response.responseText);
            }
        });
    }
});
$(document).on('click', ".report" ,function( event ) {
    event.preventDefault();
    $('#reportModal').modal('show');
});
