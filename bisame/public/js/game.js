$(document).ready(function(){
    console.log("ready");
    $('.word').hover(function() {
        $(this).addClass('highlighted');
    },
    function() {
        $(this).removeClass('highlighted');
    });
     $('.word').click(function() {
        $('.word').removeClass('selected');
        $(this).addClass('selected');
    });
 });