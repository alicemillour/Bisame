ErrorLevel = {
    error: 0,
    warning: 1,
    ok: 2
};
/* fix for popovers */
$('body').on('hidden.bs.popover', function (e) {
    $(e.target).data("bs.popover").inState.click = false;
});
$(document).ready(function () {
    console.log("ready");
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    /*enable click button in popover */
    $(document).on('click', ".words-categories-button", function () {
        console.log("click sur autres categories");
        get_words_postags(null);
    });


    /* enable click on rows in categories tables */
    $(document).on('click', ".table > tbody > tr", function () {
        console.log("in click on categories table");
        var row = $(this).find('td:first');
        $('.selected').removeClass('is-in-error');
        var category = $('.selected').parent().find('.category-label');
        category.text(row.text());
        category.attr('id', row.attr('id'));
        category.show();
        $('.word.selected').popover('hide');
    });

    $('.main-button').click(function () {
        annotations = [];
        $('.word-container').each(function (index, word_container) {
            annotation = {};
            annotation['postag_id'] = $(word_container).find('.category-label').attr('id');
            annotation['word_id'] = $(word_container).find('.word').attr('id');
            if (annotation['postag_id']) {
                annotations.push(annotation);
            }
        });
        $.ajax({
            method: 'PUT',
            context: $("#main-container"),
            data: {
                annotations: annotations
            },
            success: function (response) {
                if (response) {
                    if (response.constructor === Array) {
                        console.log("FALSE");
                        render_correction(response);
                    } else {
                        console.log("ANNOTATION CREATED");
                        $('#message').hide();
                        $("#sentence-container").html(response);
                        reload_javascript_on_words();
                    }
                } else {
                    window.location.href = '/home';
                }
            }
        });
    });
    function reload_javascript_on_words() {
        console.log("reload");
        console.log("loading postags");
        $('.word').each(function () {
            if (!/^[!"#$%&'()*+, \-./:;<=>?@ [\\\]^_`{|}~„“]$/.test($(this).attr('value'))) {
                get_words_postags($(this).attr('id'));
                $(this).addClass('not-punct');
            }
        });
        $('.word').not(".is-correct").hover(
                function () {
                    if (!/^[!"#$%&'()*+, \-./:;<=>?@ [\\\]^_`{|}~„“]$/.test($(this).attr('value'))) {
                        $(this).addClass('highlighted');
                    }
                },
                function () {
                    if (!/^[!"#$%&'()*+, \-./:;<=>?@ [\\\]^_`{|}~„“]$/.test($(this).attr('value'))) {
                        $(this).removeClass('highlighted');
                    }
                }
        );
        $('.word').not(".is-correct").click(
                function () {
                    if (!/^[!"#$%&'()*+, \-./:;<=>?@ [\\\]^_`{|}~„“]$/.test($(this).attr('value'))) {
                        $('.word').removeClass('selected');
                        $('.word').removeClass('is-in-error');
                        $(this).addClass('selected');
                        $('.sentence-main-container').width('60%');
                    }
                }
        );
    }
    ;
    function render_correction(answers) {
        postags_descriptions = [];
        postags_full_names = [];
        postags_names = [];
        error_status = ErrorLevel.error;
        for (var i = 0; i < answers.length; i++) {
            if (answers[i]['is_correct'] === true) {
                word = $('#' + answers[i]['word_id'] + '.word');
                word.removeClass('is-in-error').addClass('is-correct');
                error_status = ErrorLevel.warning;
                word.removeClass('highlighted');
                word.off('click');
                word.unbind('mouseenter mouseleave');
            } else {
                $('#' + answers[i]['word_id'] + '.word').removeClass('is-correct').addClass('is-in-error');
                if (postags_names.indexOf(answers[i]['postag_name']) === -1) {
                    postags_descriptions.push(answers[i]['postag_description']);
                    postags_full_names.push(answers[i]['postag_full_name']);
                    postags_names.push(answers[i]['postag_name']);
                }
            }
        }
        if (postags_descriptions.length > 0) {
            error_status = ErrorLevel.error;
        }
        show_message(error_status, postags_names, postags_full_names, postags_descriptions);
    }

    function create_table_with_postags(postags) {
        var content = '';
        for (var i = 0; i < postags.length; i++) {
            content += '<tr  data-trigger="hover" title="Exemples" data-container="body" data-placement="left" data-toggle="popover" data-content="' + postags[i]['description'] + '">';
            content += '<td id=' + postags[i]['id'] + '>' + postags[i]['name'];
            content += '<span class=full-name-category> (' + postags[i]['full_name'] + ') ';
            content += '</span>';
            content += '</td>';
            content += '</tr>';
        }
        return content;
    }
    function create_table_with_postags_on_word(postags, word_id) {
        var content = '';
        content += '<table class="table table-hover categories-table" id="categories-table[' + word_id + ']" style="display: table;">';
        content += '<thead>';
        content += '<tr>';
        content += '<th class="ostrich" style="text-align: center"> <h3> <b>Categories grammaticales</b></h3></th>';
        content += '</tr>';
        content += '</thead>';
        content += '<tbody>';
        for (var i = 0; i < postags.length; i++) {
            content += '<tr  data-trigger="hover" title="Exemples" data-container="body" data-placement="left" data-toggle="popover" data-content="' + postags[i]['description'] + '">';
            content += '<td  id=' + postags[i]['id'] + '>' + postags[i]['name'];
            content += '<span class=full-name-category> (' + postags[i]['full_name'] + ') ';
            content += '</span>';
            content += '</td>';
            content += '</tr>';
        }
        content += '</tbody> </table>';
        content += '<div class="words-categories-button">'
        content += '<button>Aucune de ces catégories ne convient</button>'
        content += '</div>'
        return content;
    }

    function create_errors_content(postag_names, postag_full_names, postag_descriptions) {
        var content = '';
        content += '<ul>';
        for (var i = 0; i < postag_descriptions.length; i++) {
            content += '<li><p>';
            content += postag_names[i];
            content += ' (<i>';
            content += postag_full_names[i];
            content += ' </i>) : ';
            content += postag_descriptions[i];
            content += '</p></li>';
        }
        content += '</ul>';
        return content;
    }

    function show_message(is_in_error, postag_names, postag_full_names, postag_descriptions) {
        switch (is_in_error) {
            case ErrorLevel.error:
                if (postag_names.length > 0) {
                    $('#message-title').text("Vous avez des erreurs. Rappel sur les catégories que vous avez choisies :");
                } else {
                    /* no word has been annotated yet */
                    $('#message-title').text("Vous ne pouvez pas passer la phrase dans le mode entraînement");
                    /* Je veux des messages différents en fonction du type de jeu 
                     * $('#message-title').text("Vous devez annoter au moins un mot !");
                     */
                }
                var content = create_errors_content(postag_names, postag_full_names, postag_descriptions);
                $('#message-content').empty().append(content)
                $('#message').removeClass('alert-success alert-warning').addClass('alert-danger');
                break;
            case ErrorLevel.warning:
                $('#message-title').text("Bravo !");
                $('#message-content').text("Annotez les mots restants pour pouvoir passer à la phrase suivante.");
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
            method: 'GET',
            url: "/postags",
            dataType: 'json',
            data: {
                word_id: word_id
            },
            success: function (response) {
                console.log("in get_words_postags");
                var content_words = create_table_with_postags_on_word(response['postags'], word_id);
                /* used to fill categories when all categories displayed */
                var content = create_table_with_postags(response['postags']);
                $('.categories-table').find('tbody').empty().append(content);
//                if (!response['all_categories']) {
//                    $('.categories-button').show();
//                } else {
//                    $('.categories-button').hide();
//                }
                $('#' + word_id).popover({
                    placement: 'bottom',
                    html: true,
                    animation: true,
                    content: content_words,
                }).popover();
                $('#' + word_id).on('click', function () {
                    $('.word').not(this).popover('hide');
                });
                console.log("end get_words_postags");
                add_on_click_on_categories_table();
            }
        });
    }

    function add_on_click_on_categories_table() {
//        $('.categories-table').find('tr').click(function () {
//            console.log("in click on categories table");
//            var row = $(this).find('td:first');
//            $('.selected').removeClass('is-in-error');
//            var category = $('.selected').parent().find('.category-label');
//            category.text(row.text());
//            category.attr('id', row.attr('id'));
//            category.show();
//            $('.word.selected').popover('hide');
//        });
        $('.word.selected').find('tr').click(function () {
            var row = $(this).find('td:first');
            $('.selected').removeClass('is-in-error');
            var category = $('.selected').parent().find('.category-label');
            category.text(row.text());
            category.attr('id', row.attr('id'));
            category.show();
        });
    }

    reload_javascript_on_words();
});