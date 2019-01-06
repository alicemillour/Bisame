$(document).ready(function(){
    var classes = ["teg-1", "teg-2", "teg-3", "teg-4", "teg-5"];

    $("#tegcloud a").each(function(){
        $(this).css("display", "inline");
        $(this).addClass(classes[~~(Math.random()*classes.length)]);
    });
    
});/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


