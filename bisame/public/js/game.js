$(document).ready(function(){
    console.log("ready");

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
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
            method : 'PUT',
            context: $("#main-container"),
            data : {
                annotations : annotations
            },
            success : function(response){
                if (response) {
                    console.log("ANNOTATION CREATED");
                    $("#sentence-container").html(response);
                    reload_javascript_on_words();
                } else {
                    window.location.href = 'http://localhost:8000/home';
                }
            },
            dataType : 'text'
        });
    });

    function reload_javascript_on_words() {
        $('.word').hover(function() {
            $(this).addClass('highlighted');
        },
        function() {
            $(this).removeClass('highlighted');
        });
         $('.word').click(function() {
            $('.word').removeClass('selected');
            $(this).addClass('selected');
            $('.sentence-main-container').width('60%');
            get_words_postags($(this).attr('id'));
        });
    };

    function create_table_with_postags(postags) {
        var content = '';
        for (var i = 0; i < postags.length; i++){
            content += '<tr>';
            content += '<td id=' + postags[i]['id'] + '>'+ postags[i]['name'] + '</td>';
            content += '</tr>';
        }
        return content;
    }

    function get_words_postags(word_id) {
        $.ajax({
            method : 'GET',
            url : "http://localhost:8000/postags",
            dataType: 'json',
            data: {
                word_id: word_id
            },
            success : function(response){
            var content = create_table_with_postags(response);
            $('.categories-table').find('tbody').empty().append(content);
            $('.categories-table').show();
            }
        });
    }

    reload_javascript_on_words();
 });