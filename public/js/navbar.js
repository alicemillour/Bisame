/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$(document).ready(function () {
    console.log("ready navbar");
    // getting the color before the color is changed ( not sure this is needed )
    var thecolor = $('a.incognito').css("color");
    $("a.incognito").mouseover(function () {
        // setting the color previously picked
        $(this).css({'color': thecolor});
    });
    $(document.body).css('padding-top', $('#topnavbar').height() + 10);
    $(window).resize(function () {
        console.log("adding padding");
        $(document.body).css('padding-top', $('#topnavbar').height() + 10);
    });
});