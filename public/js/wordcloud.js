$(document).ready(function(){
    var classes = ["teg-1", "teg-2", "teg-3", "teg-4", "teg-5"];

    $(".tegcloud a").each(function(){
        $(this).css("display", "inline");
        $(this).addClass(classes[~~(Math.random()*classes.length)]);
    });
//    setInterval('actualise_div_messages_book_gold();', 4000); // 1 seconde est abusé je sais.

    $("#reload_wordcloud").click(function() {
        var url = window.location.href;   
        $('#tegcloud').load(url + ' #tegcloud', function(){$.getScript("js/reload_wordcloud.js")});
    });
});