
// met le border du input en rouge si incorrect et en vert si correct

$(document).ready(function() {  //Référence: http://contactmetrics.com/blog/validate-contact-form-jquery

var reggen= /^[A-Za-zÀ-ÿ0-9\-. ]{2,50}$/;

validnom();
validprenom();
validadresse();
validville();
validpays();
validcourriel();
validcodepostal();

//nom
	function validnom(){
		$('#nom').on('change', function() {
			var input=$(this);
			var is_validgen= reggen.test(input.val()); //test au fur et à mesure
			if(is_validgen){
				input.removeClass("invalid").addClass("valid");		
				$("span.messageErreurNom").empty();}
			else{input.removeClass("valid").addClass("invalid");
				$('span.messageErreurNom').text(" Entrez un nom valide." );
			}
		});
	};

//prénom
	function validprenom(){
		$('#prenom').on('change', function() {
			var input=$(this);
			var is_validgen= reggen.test(input.val());
			if(is_validgen){
				input.removeClass("invalid").addClass("valid");		
				$("span.messageErreurPrenom").empty();}
			else{input.removeClass("valid").addClass("invalid");
				$('span.messageErreurPrenom').text(" Entrez un prénom valide." );
			}
		});
	};

//adresse
	function validadresse(){
		$('#adresse').on('change', function() {
			var input=$(this);
			var is_validgen= reggen.test(input.val());
			if(is_validgen){
				input.removeClass("invalid").addClass("valid");		
				$("span.messageErreurAdresse").empty();}
			else{input.removeClass("valid").addClass("invalid");
				$('span.messageErreurAdresse').text(" Entrez une adresse valide" );
			}
		});
	}

//ville
	function validville(){
		$('#ville').on('change', function() {
			var input=$(this);
			var is_validgen= reggen.test(input.val());
			if(is_validgen){
				input.removeClass("invalid").addClass("valid");		
				$("span.messageErreurVille").empty();}
			else{input.removeClass("valid").addClass("invalid");
				$('span.messageErreurVille').text(" Entrez un nom de ville valide." );
			}
		});
	};
//pays	
	function validpays(){
		$('#pays').on('change', function() {
			var input=$(this);
			var is_validgen= reggen.test(input.val());
			if(is_validgen){
				input.removeClass("invalid").addClass("valid");		
				$("span.messageErreurPays").empty();}
			else{input.removeClass("valid").addClass("invalid");

				$('span.messageErreurPays').text(" Entrez un nom de pays valide." );
			}
		});
	};


		
//Courriel
	function validcourriel(){
		$('#courriel').on('change', function() {
			var input=$(this);
			var re = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,15}(?:\.[a-z]{2,3})?)$/i ;
			var is_email=re.test(input.val());
			if(is_email){
				input.removeClass("invalid").addClass("valid");
				$("span.messageErreurCourriel").empty();}
			else{input.removeClass("valid").addClass("invalid");
				$('span.messageErreurCourriel').text(" Entrez un courriel valide (courriel@aaa.bbb)" );
			}
		});
	};

//Code postal
	function validcodepostal(){
		$('#codepostal').on('change', function() {
			var input=$(this);
			var repostal = /^[A-Za-z]\d[A-Za-z][ -]?\d[A-Za-z]\d$/; //vérifie le code postal
			var is_postal=repostal.test(input.val()); 
			if(is_postal){
				input.removeClass("invalid").addClass("valid");
				$("span.messageErreurCodepostal").empty();}
			else{input.removeClass("valid").addClass("invalid");
				$('span.messageErreurCodepostal').text("Entrez un code postal valide (A1A1A1)." );	
			}
		});
	};

	// carte de crédit

		
//vérifie si un bouton est cliqué
		$('.carte').on('focusout', function() { // En sortant d'un champs d'info de la carte de crédit
			if($('input[name=choixcarte]').is(':checked')) { // vérifie si un bouton est coché
			//si oui		

			}
			else{
			
				if(
					$("#choixcarte").next().is("p")){
				}
				else{
					$("#choixcarte input").removeClass("valid").addClass("invalid");
					$("#choixcarte input").after( "<p>Veuillez choisir un type de carte.</p>" );
				}
			}

		});
		
		//valide si visa ou master
			$('input[name=choixcarte]').on('change', function(){
					var valeur_selectionnee = $('input[type=radio][name=choixcarte]:checked').val();
								
					if(valeur_selectionnee=="visa"){ // si Visa est sélectionné
						$('#nocarte').on('focusout', function() {
							
							var input=$(this);
							var revisa = /^4[0-9]{12}(?:[0-9]{3})?$/;
							var is_visa = revisa.test(input.val());
							if(is_visa){
								input.removeClass("invalid").addClass("valid");
								$(".nocarte p").remove();
							}
							else{
								input.removeClass("valid").addClass("invalid");
								if (input.next().is("p")){					
								}
								else{
									input.after( "<p>Entrez un numéro de carte valide.</p>" );
								}
							}						
						});
					}
					else if(valeur_selectionnee=="mastercard"){		
						$('#nocarte').on('focusout', function() {
							var input=$(this);
							var remaster = /^5[1-5][0-9]{14}$/;
							var is_master=remaster.test(input.val());
							if(is_master){
								input.removeClass("invalid").addClass("valid");
								$(".nocarte p").remove();
							}
							else{
								input.removeClass("valid").addClass("invalid");
								if (input.next().is("p")){					
								}
								else{
									input.after( "<p>Entrez un numéro de carte valide.</p>" );
								}
							}
						});
					}				
				});
		

		
		//nom du détenteur de la carte de crédit
	function validnomcredit(){
		$('#nomdetenteur').on('focusout', function() {
			var input=$(this);
			var is_validgen= reggen.test(input.val()); //test au fur et à mesure
			if(is_validgen){
				input.removeClass("invalid").addClass("valid");		
				$(".nomdetenteur p").remove();}
			else{input.removeClass("valid").addClass("invalid");
				if (input.next().is("p")){					
				}
				else{
					input.after( "<p>Vous devez entrer le nom inscrit sur la carte.</p>" );
				}
			}
		});
	};
		//Expiration carte de crédit
		$('#expirationcarte').on('focusout', function() {
			var input=$(this);
			var reexp = /^(0[1-9]|1[0-2])\/?(1[5-9]|2[0-9])$/;
			var is_exp=reexp.test(input.val());
			if(is_exp){
				input.removeClass("invalid").addClass("valid");
				$(".expirationcarte p").remove();}
			else{input.removeClass("valid").addClass("invalid");
				if (input.next().is("p")){					
				}
				else{
					input.after( "<p>Entrez une date d'expiration valide (mmaa)</p>" );
				}
			}
		});

		//No. validation carte de crédit
		$('#verifcarte').on('focusout', function() {
			var input=$(this);
			var revalid = /^[0-9]{3}$/;
			var is_validc=revalid.test(input.val());
			if(is_validc){
				input.removeClass("invalid").addClass("valid");
				$(".verifcarte p").remove();}
			else{
				input.removeClass("valid").addClass("invalid");
				if (input.next().is("p")){					
				}
				else{
					input.after( "<p>Entrez un numéro valide (000)</p>" );
				}

			}
		});

		

// A modifier selon comment on met la page
	//After Form Submitted Validation
	$("#contact_submit button").click(function(event){
		var form_data=$("#contact").serializeArray();
		var error_free=true;
		for (var input in form_data){
			var element=$("#contact_"+form_data[input]['name']);
			var valid=element.hasClass("valid");
			var error_element=$("span", element.parent());
			if (!valid){error_element.removeClass("error").addClass("error_show"); error_free=false;}
			else{error_element.removeClass("error_show").addClass("error");}
		}
		if (!error_free){
			event.preventDefault(); 
		}
		else{
			alert('No errors: Form will be submitted');
		}
	});
	
	
	
});