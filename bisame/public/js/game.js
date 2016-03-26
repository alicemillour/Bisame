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
        annotations = [];
        $('.word-container').each(function(index , word_container) {
            annotation = {};
            annotation['postag_id'] = $(word_container).find('.category').attr('id');
            annotation['word_id'] = $(word_container).find('.word').attr('id');
            if (annotation['postag_id']) {
                annotations.push(annotation);
            }
        });
        console.log(annotations);
        $.ajax({
            method : 'POST',
            url : "http://localhost:8000/annotations",
            data : {
                annotations : annotations
            },
            success : function(response){
                console.log("ANNOTATION CREATED");
            },
            dataType : 'text'
        });
    });
 });