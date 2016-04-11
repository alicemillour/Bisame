$(document).ready(function(){
    console.log("ready");

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
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
        $.ajax({
            method : 'PUT',
            context: $("#main-container"),
            data : {
                annotations : annotations
            },
            success : function(response){
                console.log(response);
                if (response) {
                    if (response.constructor === Array) {
                        console.log("FALSE");
                        show_message(true);
                        render_correction(response);
                    } else {
                        show_message(false);
                        console.log("ANNOTATION CREATED");
                        $("#sentence-container").html(response);
                        reload_javascript_on_words();
                    }
                } else {
                    window.location.href = 'http://localhost:8000/home';
                }
            },
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

    function render_correction(answers) {
        for (var i = 0; i < answers.length; i++) {
            if (answers[i]['is_correct'] == true) {
                $('#' + answers[i]['word_id'] + '.word').removeClass('is-in-error').addClass('is-correct');
            } else {
                $('#' + answers[i]['word_id'] + '.word').removeClass('is-correct').addClass('is-in-error');
            }
        }
    }

    function create_table_with_postags(postags) {
        var content = '';
        for (var i = 0; i < postags.length; i++){
            content += '<tr>';
            content += '<td id=' + postags[i]['id'] + '>'+ postags[i]['name'] + '</td>';
            content += '</tr>';
        }
        return content;
    }

    function show_message(is_in_error) {
        if (is_in_error) {
            $('#message-title').text("Erreur");
            $('#message-content').text("T'es trop nul");
            $('#message').removeClass('message-correct').addClass('message-error');
        } else {
            $('#message-title').text("Bravo");
            $('#message-content').text("Vous avez tout bon");
            $('#message').removeClass('message-error').addClass('message-correct');
        }
        $('#message').show();
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
            add_on_click_on_categories_table();
            $('.categories-table').show();
            }
        });
    }

    function add_on_click_on_categories_table() {
        $('.categories-table').find('tr').click( function(){
        var row = $(this).find('td:first');
        var category =  $('.selected').parent().find('.category');
        category.text(row.text());
        category.attr('id', row.attr('id'));
        category.show();
        });
    }

    reload_javascript_on_words();
 });