$(document).ready (function(){

	//temps rotation du carousel
	$('#carousel-example-generic').carousel({
	  interval: 4000
	});

	// Chloé?
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