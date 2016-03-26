$(document).ready(function(){
    console.log("ready");

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $('.word').hover(function() {
        $(this).addClass('highlighted');
    },
    function() {
        $(this).removeClass('highlighted');
    });
     $('.word').click(function() {
        $('.word').removeClass('selected');
        $(this).addClass('selected');
        $('.categories-table').show();
    });

    $('.categories-table').find('tr').click( function(){
        var row = $(this).find('td:first');
        var category =  $('.selected').parent().find('.category');
        category.text(row.text());
        category.attr('id', row.attr('id'));
        category.show();
    });

    $('.main-button').click( function() {
        $.ajax({
            method : 'POST',
            url : "http://localhost:8000/annotations",
            data : {
                postag_id : $('.selected').parent().find('.category').attr('id'),
                word_id : $('.selected').attr('id')
            },
            success : function(response){
                console.log("ANNOTATION CREATED");
            },
            dataType : 'text'
        });
    });
 });