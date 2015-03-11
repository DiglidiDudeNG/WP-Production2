$(document).ready (function(){

	$('#carousel-example-generic').carousel({
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



    slideFormLivraisonWrapper();

    $('[name="envoi"]').click(function(){
        slideAdresseLivraisonDifferente();
        slideFormLivraisonWrapper();
    });
    $('#AdresseLivraison').click(function(){
        slideFormLivraisonWrapper();
    });

});


function slideAdresseLivraisonDifferente(){
    if( $('#parPoste').prop('checked') )
    {
        $('.adresseLivraisonDifferenteWrapper').slideDown();
    }
    else
    {
        $('.adresseLivraisonDifferenteWrapper').slideUp();
    }
};

function slideFormLivraisonWrapper(){
    if( $('#parPoste').prop('checked') && $('#AdresseLivraison').prop('checked'))
    {
        $('.formLivraisonWrapper').slideDown();
    }
    else
    {
        $('.formLivraisonWrapper').slideUp();
    }
};