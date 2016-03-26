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
        $('.categories-table').show();
    });

    $('.categories-table').find('tr').click( function(){
        var row = $(this).find('td:first').text();
        var category =  $('.selected').parent().find('.category');
        category.text(row);
        category.show();
    });
 });