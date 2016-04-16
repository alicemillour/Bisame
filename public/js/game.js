ErrorLevel = {
    error : 0,
    warning : 1,
    ok : 2
}

$(document).ready(function(){
    console.log("ready");

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('.categories-button').click( function() {
        get_words_postags(null);
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
                        render_correction(response);
                    } else {
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
        postags_descriptions = [];
        error_status = ErrorLevel.error;
        for (var i = 0; i < answers.length; i++) {
            if (answers[i]['is_correct'] == true) {
                $('#' + answers[i]['word_id'] + '.word').removeClass('is-in-error').addClass('is-correct');
                error_status = ErrorLevel.warning;
            } else {
                $('#' + answers[i]['word_id'] + '.word').removeClass('is-correct').addClass('is-in-error');
                postags_descriptions.push(answers[i]['postag_description']);
            }
        }
        if (postags_descriptions.length > 0) {error_status = ErrorLevel.error}
        show_message(error_status, postags_descriptions);
    }

    function create_table_with_postags(postags) {
        var content = '';
        for (var i = 0; i < postags.length; i++){
            content += '<tr>';
            content += '<td id=' + postags[i]['id'] + '>'+ postags[i]['name'] ;
            content += '<span class=full-name-category> (' + postags[i]['full_name'] + ')</span>' ;
            content += '</td>';
            content += '</tr>';
        }
        return content;
    }

    function create_errors_content(postag_descriptions) {
        var content = '';
        for (var i = 0; i < postag_descriptions.length; i++){
            content += '<p>';
            content += postag_descriptions[i];
            content += '</p>';
        }
        return content;
    } 

    function show_message(is_in_error, postag_descriptions) {
        switch(is_in_error) {
            case ErrorLevel.error:
            $('#message-title').text("Erreur");
            var content = create_errors_content(postag_descriptions);
            $('#message-content').empty().append(content);
            $('#message').removeClass('alert-success alert-warning').addClass('alert-danger');
            break;
            case ErrorLevel.warning:
            $('#message-title').text("Bravo !");
            $('#message-content').text("Annotez les mots restant pour pouvoir passer à la suivante.");
            $('#message').removeClass('alert-success alert-danger').addClass('alert-warning');
            break;
            case ErrorLevel.success:
            $('#message-title').text("Bravo !");
            $('#message-content').text("Vous avez tout bon");
            $('#message').removeClass('alert-danger alert-warning').addClass('alert-success');
            break;
        }
        $('#message').show();
    }
    function get_words_postags(word_id) {
        $.ajax({
            method : 'GET',
            url : "/postags",
            dataType: 'json',
            data: {
                word_id: word_id
            },
            success : function(response){
                console.log(response);
                var content = create_table_with_postags(response['postags']);
                $('.categories-table').find('tbody').empty().append(content);
                add_on_click_on_categories_table();
                $('.categories-table').show();
                if (!response['all_categories']) {
                    $('.categories-button').show();
                } else {
                    $('.categories-button').hide();
                }
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