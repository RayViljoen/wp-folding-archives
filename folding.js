$(document).ready(function(){
  
  $(".archive-title").click( function(){
    $(this).next("ul").slideToggle("slow");return false;});
    
    $("#collapsible-archives ul").each(function(){
    var numPosts = $(this).children().size(); 
    $(this).prev("p").prepend("<span>(" + numPosts + ") </span>" );});
    
  $("#collapsible-archives p").css({'background': "url(/wp-content/plugins/folding-archives/images/close-bullet.png) no-repeat 0 center", 'padding-left': '15px'});
  $("#collapsible-archives p").click(function(){ 
    if($(this).hasClass("open")){
      $(this).css({'background': "url(/wp-content/plugins/folding-archives/images/close-bullet.png) no-repeat 0 center"}).removeClass("open");
    }else{
      $(this).css({'background': "url(/wp-content/plugins/folding-archives/images/open-bullet.png) no-repeat 0 center"}).addClass("open");
    }  
   });
});
