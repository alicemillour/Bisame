ErrorLevel = {
    error: 0,
    warning: 1,
    ok: 2
};

/* fix for popovers */
$('body').on('hidden.bs.popover', function (e) {
    $(e.target).data("bs.popover").inState.click = false;
});

/* set help menu to screen height */
$('.footer-container').css('max-height', $(window).height() * 0.8);

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
        $(this).css('display', 'none');
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
            word_id = $(this).prop('id')
            if (!/^[!"#$%&'()*+, \-./:;<=>?@ [\\\]^_`{|}~„“]$/.test($(this).attr('value'))) {
                get_words_postags($(this).attr('id'));
                $(this).addClass('not-punct');
                console.log("pretag");
                console.log($(this).attr('tag'))
                if ($(this).attr('tag')) {
                    $('#right_' + word_id).css({'display': 'inline'});
                    $('#left_' + word_id).css({'display': 'inline'});
                    $('#right_' + word_id).css({'visibility': 'hidden'});
                    $('#left_' + word_id).css({'visibility': 'hidden'});
                    var category = $(this).parent().find('.category-label');
                    category.addClass('auto-annotated');
                    category.text($(this).attr('tag'));
                    category.show();
                } else {
                    $('#question_' + word_id).css({'display': 'inline'});
                }
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
        console.log("loading js on labels");
        $('.word').hover(
                function () {
                    word_id = $(this).attr('id').match(/[0-9]+/);
                    console.log(word_id);
                    $(this).css('display', 'block');
                    $('#right_' + word_id).css({'visibility': 'visible'});
                    $('#left_' + word_id).css({'visibility': 'visible'});
                }
        );
        $('.word').mouseleave(function () {
            word_id = $(this).attr('id').match(/[0-9]+/);
            console.log(word_id);
            $('#right_' + word_id).css({'visibility': 'hidden'});
            $('#left_' + word_id).css({'visibility': 'hidden'});
        }
        );

        $('.labels').hover(
                function () {
                    word_id = $(this).attr('name').match(/[0-9]+/);
                    console.log(word_id);
                    $(this).css('display', 'block');
                    $('#right_' + word_id).css({'visibility': 'visible'});
                    $('#left_' + word_id).css({'visibility': 'visible'});
                }
        );
        $('.labels').mouseleave(function () {
            word_id = $(this).attr('name').match(/[0-9]+/);
            console.log(word_id);
            $('#right_' + word_id).css({'visibility': 'hidden'});
            $('#left_' + word_id).css({'visibility': 'hidden'});
        }
        );

        $('.question-label').click(function () {
            $('.word.selected').popover('hide');
            $('.word').removeClass('selected');
            var category = $(this).parent().find('.category-label');
            category.empty();
            category.removeClass('auto-annotated');
            word_id = $(this).attr('id').match(/[0-9]+/);
            $('#' + word_id).addClass('selected');
            $('#' + word_id).popover('show');
        });

        $('.leftlabel').click(function () {
            word_id = $(this).attr('id').match(/[0-9]+/);
            $('.word.selected').popover('hide');
            $('.word').removeClass('selected');
            $('#right_' + word_id).css({'display': 'none'});
            $('#left_' + word_id).css({'display': 'none'});
            var category = $(this).parent().find('.category-label');
            category.empty();
            category.removeClass('auto-annotated');
            $('#' + word_id).addClass('selected');
            $('#' + word_id).popover('show');
            $('#' + word_id).removeClass('auto-annotated');
        });

        $('.rightlabel').click(function () {
            word_id = $(this).attr('id').match(/[0-9]+/);
            $('.word.selected').popover('hide');
            $('.word').removeClass('selected');
            $('#right_' + word_id).css({'display': 'none'});
            $('#left_' + word_id).css({'display': 'none'});
            $('#' + word_id).addClass('selected');
            $('#' + word_id).removeClass('auto-annotated');
            var category = $(this).parent().find('.category-label');
            category.text($('#'+word_id).attr('tag'));  
            category.attr('id', $('#'+word_id).attr('potential_tag_id'));
            category.removeClass('auto-annotated');
        });
        
        /* enable click on rows in categories tables */
        add_on_click_on_categories_table()
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
//            content += '<tr  data-trigger="hover" title="Exemples" data-container="body" data-placement="left" data-toggle="popover" data-content="' + postags[i]['description'] + '">';
            content += '<tr>';
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
            content += ' </i>) :';
            content += ' <h4 style="text-align:center"> Quelques exemples <h4> <br> ';
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
                    /*TODO DIFF $('#message-title').text("Annotation incorrecte… Awa ! ti ni on érrè. Rappel sur les catégories choisies :");*/
                    $('#message-title').text("Certaines catégories ne sont pas les bonnes. Rappel sur les catégories choisies :");
                } else {
                    /* no word has been annotated yet */
                    $('#message-title').text("Vous ne pouvez pas passer la phrase dans le mode entraînement : choisissez des catégories et validez vos réponses pour tous les mots de la phrase.");
                }
                var content = create_errors_content(postag_names, postag_full_names, postag_descriptions);
                $('#message-content').empty().append(content)
                $('#message').removeClass('alert-success alert-warning').addClass('alert-danger my-alert');
                break;
            case ErrorLevel.warning:
                /* TODO DIFF $('#message-title').text("Annotation(s) correcte(s) ! Woulo !"); */
                $('#message-title').text("Annotation(s) correcte(s) !");
                $('#message-content').text("Annotez les mots restants pour pouvoir passer à la phrase suivante.");
                $('#message').removeClass('alert-success alert-danger').addClass('alert-warning my-alert');
                break;
            case ErrorLevel.success:
                $('#message-title').text("Bravo !");
                $('#message-content').text("Vous avez tout bon");
                $('#message').removeClass('alert-danger alert-warning').addClass('alert-success my-alert');
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
        $(document).on('click', ".table > tbody > tr", function () {
            console.log("in click on categories table");
            var row = $(this).find('td:first');
            $('.selected').removeClass('is-in-error');
            word_id = $('.selected').attr('id').match(/[0-9]+/);

            var category = $('.selected').parent().find('.category-label');
            var question = $('.selected').parent().find('.question-label');
            category.text(row.text().split(" ")[0]);
            category.attr('id', row.attr('id'));
            category.show();
            category.removeClass('auto-annotated');
            question.css({'display': 'none'});
            $('.word.selected').popover('hide');

            $('#right_' + word_id).css({'display': 'none'});
            $('#left_' + word_id).css({'display': 'none'});

        });

    }
    /* js for accordion help menu */

   var acc = document.getElementsByClassName("accordion");
    var i;
/*     $(acc[0]).css({'border-top-left-radius': '10px', 'border-top-right-radius': '10px'});
    $(acc[acc.length - 1]).css({'border-bottom-left-radius': '10px', 'border-bottom-right-radius': '10px'});
    var toggle_acc = false;
    $(acc[acc.length - 1]).on('click', function () {
        if (toggle_acc == false) {
            $(acc[acc.length - 1]).css({'border-bottom-left-radius': '0px', 'border-bottom-right-radius': '0px'})
            toggle_acc = true;
        } else {
            $(acc[acc.length - 1]).css({'border-bottom-left-radius': '10px', 'border-bottom-right-radius': '10px'})
            toggle_acc = false;
        }
    }); */
    for (i = 0; i < acc.length; i++) {
        acc[i].onclick = function () {
            this.classList.toggle("active");
            this.nextElementSibling.classList.toggle("show");
        }
    }
    reload_javascript_on_words();
});