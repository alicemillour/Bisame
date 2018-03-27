$(function(){
var tabs = $('#scoreboards a');
    var counter = 0;
    window.setInterval(activateTab, 5000);
    function activateTab(){
      // remove active class from all the tabs
       tabs.removeClass('active');
       console.log(tabs);
       var currentLink = tabs[counter];
       <!--console.log(jQuery(currentLink));-->
       <!--console.log(recettes);-->
       $('.tab-pane').removeClass('.active').hide();
       jQuery(currentLink).addClass('active');
       $(jQuery(currentLink).attr('href')).addClass('active').addClass('in').show();
       if(counter < tabs.length - 1)
         counter = counter + 1;
       else 
         counter = 0;
    }
});