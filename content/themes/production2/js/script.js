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






    // Gestion des sections du formulaire de l'achat étape 2
    slideFormLivraisonWrapper();

    // Listeners sur les checkboxs du formulaire de l'achat étape 2
    $('[name="envoi"]').click(function(){
        slideAdresseLivraisonDifferente();
        slideFormLivraisonWrapper();
    });
    $('#AdresseLivraison').click(function(){
        slideFormLivraisonWrapper();
    });






    // Listener pour calcuer les taxes lors de l'étape 1 de l'achat
    $('#nb_billets').on('change keyup', function(){
        calculTaxesLive();
    });

    // Listener pour calculer les taxes lors de l'étape 1 de l'achat
    // si l'usager utilise les boutons back ou forward du browser
    $(window).on("pageshow", function() {

        // La fonctoin sera démarrée uniquement si la page contient l'élément '#nb_billets'
        if( $('#nb_billets').length ){
            calculTaxesLive();
        }
    });


});







// Gestion des sections du formulaire de l'achat étape 2
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
// Gestion des sections du formulaire de l'achat étape 2
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




function calculTaxesLive(){

    // Récupération du nombre de billets et du prix du spectacle
    var nb_billets = $('#nb_billets').val();
    var spectacle_prix = $('.panier-item-prix').text();

    // Retrait du signe de $ afin de permettre les calculs
    var spectacle_prix = spectacle_prix.substring(0, spectacle_prix.length - 1);

    // Calcul des taxes et totaux
    var sousTotal = (nb_billets * spectacle_prix).toFixed(2);
    var tvq = (sousTotal * 0.09975).toFixed(2);
    var tps = (sousTotal * 0.05).toFixed(2);
    var gtotal = ( parseFloat(sousTotal) + parseFloat(tvq) + parseFloat(tps) ).toFixed(2);

    // Update des taxes et totaux
    $('.sous-total-text').text(sousTotal + '$');
    $('.tvq-text').text(tvq + '$');
    $('.tps-text').text(tps + '$');
    $('.gtotal-text').text(gtotal + '$');

};