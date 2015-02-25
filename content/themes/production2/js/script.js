$(document).ready (function(){

	$('.carousel').carousel({
	  interval: 2000
	});

	$('#moncarousel').carousel({
	  interval: 4000
	});

  $(".container").on("click", ".flip-js", function(e){
    var self = $(this);
    if(self.hasClass("hover")) {
      self.removeClass("hover");
    } else {
      $(".hover").removeClass("hover");  
      self.toggleClass("hover");
    } 
  });
});