$(document).ready(function(){
    console.log("ready");
    $('.word').hover(function() {
        $(this).css('color', 'red');
    },
    function() {
        $(this).css('color', 'white');
    });
 });