
// met le border du input en rouge si incorrect et en vert si correct

$(document).ready(function() {  //Référence: http://contactmetrics.com/blog/validate-contact-form-jquery

var reggen= /^[A-Za-zÀ-ÿ0-9\-. ]{2,50}$/;

//étape 2: formulaire du haut info client
validnom();
validprenom();
validadresse();
validville();
validpays();
validcourriel();
validcodepostal();

//étape 2: formulaire du bas adresse de livraison
validnoml();
validprenoml();
validadressel();
validvillel();
validpaysl();
validcourriell();
validcodepostall();

//étape 3: Validation carte de crédit
//validdisablecredit();
validNocarte();
validExpcredit();
validNomcredit();
validNoverif();

var valid = false;
	
//étape 2 formulaire du haut informations client
//nom
	function validnom(){
		$('#nom').on('blur', function() {
			var input=$(this);
			var is_validgen= reggen.test(input.val()); //test au fur et à mesure
			if(is_validgen){
				input.removeClass("invalid").addClass("valid");		
				$("span.messageErreurNom").empty();
				valid = true;
			}
			else{input.removeClass("valid").addClass("invalid");
				$('span.messageErreurNom').text(" Entrez un nom valide." );
				valid = false;
			}
		});
	};

//prénom
	function validprenom(){
		$('#prenom').on('blur', function() {
			var input=$(this);
			var is_validgen= reggen.test(input.val());
			if(is_validgen){
				input.removeClass("invalid").addClass("valid");		
				$("span.messageErreurPrenom").empty();
				valid = true;}
			else{input.removeClass("valid").addClass("invalid");
				$('span.messageErreurPrenom').text(" Entrez un prénom valide." );
				valid = false;
			}
		});
	};

//adresse
	function validadresse(){
		$('#adresse').on('blur', function() {
			var input=$(this);
			var is_validgen= reggen.test(input.val());
			if(is_validgen){
				input.removeClass("invalid").addClass("valid");		
				$("span.messageErreurAdresse").empty();
				valid = true;}
			else{input.removeClass("valid").addClass("invalid");
				$('span.messageErreurAdresse').text(" Entrez une adresse valide" );
				valid = false;
			}
		});
	}

//ville
	function validville(){
		$('#ville').on('blur', function() {
			var input=$(this);
			var is_validgen= reggen.test(input.val());
			if(is_validgen){
				input.removeClass("invalid").addClass("valid");		
				$("span.messageErreurVille").empty();
				valid = true;}
			else{input.removeClass("valid").addClass("invalid");
				$('span.messageErreurVille').text(" Entrez un nom de ville valide." );
				valid = false;
			}
		});
	};
//pays	
	function validpays(){
		$('#pays').on('blur', function() {
			var input=$(this);
			var is_validgen= reggen.test(input.val());
			if(is_validgen){
				input.removeClass("invalid").addClass("valid");		
				$("span.messageErreurPays").empty();
				valid = true;}
			else{input.removeClass("valid").addClass("invalid");
				$('span.messageErreurPays').text(" Entrez un nom de pays valide." );
				valid = false;
			}
		});
	};
		
//Courriel
	function validcourriel(){
		$('#courriel').on('blur', function() {
			var input=$(this);
			var re = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,15}(?:\.[a-z]{2,3})?)$/i ;
			var is_email=re.test(input.val());
			if(is_email){
				input.removeClass("invalid").addClass("valid");
				$("span.messageErreurCourriel").empty();
				valid = true;}
			else{input.removeClass("valid").addClass("invalid");
				$('span.messageErreurCourriel').text(" Entrez un courriel valide (courriel@aaa.bbb)" );
				valid = false;
			}
		});
	};

//Code postal
	function validcodepostal(){
		$('#codepostal').on('blur', function() {
			var input=$(this);
			var repostal = /^[A-Za-z]\d[A-Za-z][ -]?\d[A-Za-z]\d$/; //vérifie le code postal
			var is_postal=repostal.test(input.val()); 
			if(is_postal){
				input.removeClass("invalid").addClass("valid");
				$("span.messageErreurCodepostal").empty();
				valid = true;}
			else{input.removeClass("valid").addClass("invalid");
				$('span.messageErreurCodepostal').text("Entrez un code postal valide (A1A1A1)." );
				valid = false;
			}
		});
	};
//étape 2 formulaire principal du bas adresse de livraison

//nom
	function validnoml(){
		$('#noml').on('blur', function() {
			var input=$(this);
			var is_validgen= reggen.test(input.val()); //test au fur et à mesure
			if(is_validgen){
				input.removeClass("invalid").addClass("valid");		
				$("span.messageErreurNoml").empty();
				valid = true;}
			else{input.removeClass("valid").addClass("invalid");
				$('span.messageErreurNoml').text(" Entrez un nom valide." );
				valid = false;
			}
		});
	};

//prénom
	function validprenoml(){
		$('#prenoml').on('blur', function() {
			var input=$(this);
			var is_validgen= reggen.test(input.val());
			if(is_validgen){
				input.removeClass("invalid").addClass("valid");		
				$("span.messageErreurPrenoml").empty();
				valid = true;}
			else{input.removeClass("valid").addClass("invalid");
				$('span.messageErreurPrenoml').text(" Entrez un prénom valide." );
				valid = false;
			}
		});
	};

//adresse
	function validadressel(){
		$('#adressel').on('blur', function() {
			var input=$(this);
			var is_validgen= reggen.test(input.val());
			if(is_validgen){
				input.removeClass("invalid").addClass("valid");		
				$("span.messageErreurAdressel").empty();
				valid = true;}
			else{input.removeClass("valid").addClass("invalid");
				$('span.messageErreurAdressel').text(" Entrez une adresse valide" );
				valid = false;
			}
		});
	}

//ville
	function validvillel(){
		$('#villel').on('blur', function() {
			var input=$(this);
			var is_validgen= reggen.test(input.val());
			if(is_validgen){
				input.removeClass("invalid").addClass("valid");		
				$("span.messageErreurVillel").empty();
				valid = true;}
			else{input.removeClass("valid").addClass("invalid");
				$('span.messageErreurVillel').text(" Entrez un nom de ville valide." );
				valid = false;
			}
		});
	};
//pays	
	function validpaysl(){
		$('#paysl').on('blur', function() {
			var input=$(this);
			var is_validgen= reggen.test(input.val());
			if(is_validgen){
				input.removeClass("invalid").addClass("valid");		
				$("span.messageErreurPaysl").empty();
				valid = true;}
			else{input.removeClass("valid").addClass("invalid");
				$('span.messageErreurPaysl').text(" Entrez un nom de pays valide." );
				valid = false;
			}
		});
	};
		
//Courriel
	function validcourriell(){
		$('#courriell').on('blur', function() {
			var input=$(this);
			var re = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,15}(?:\.[a-z]{2,3})?)$/i ;
			var is_email=re.test(input.val());
			if(is_email){
				input.removeClass("invalid").addClass("valid");
				$("span.messageErreurCourriell").empty();
				valid = true;}
			else{input.removeClass("valid").addClass("invalid");
				$('span.messageErreurCourriell').text(" Entrez un courriel valide (courriel@aaa.bbb)" );
				valid = false;
			}
		});
	};

//Code postal
	function validcodepostall(){
		$('#codepostall').on('blur', function() {
			var input=$(this);
			var repostal = /^[A-Za-z]\d[A-Za-z][ -]?\d[A-Za-z]\d$/; //vérifie le code postal
			var is_postal=repostal.test(input.val()); 
			if(is_postal){
				input.removeClass("invalid").addClass("valid");
				$("span.messageErreurCodepostall").empty();
				valid = true;}
			else{input.removeClass("valid").addClass("invalid");
				$('span.messageErreurCodepostall').text("Entrez un code postal valide (A1A1A1)." );	
				valid = false;
			}
		});
	};

	// empêcher de continuer sur la prochaine page si un champ est vide ou mal rempli
	$("#infos_clients_form").submit(function(e){	
		var idToCheck = $('#pays, #nom, #prenom, #adresse, #ville, #courriel, #codepostal, #paysl, #noml, #prenoml, #adressel, #villel, #courriell, #codepostall');
			if ((idToCheck.hasClass('invalid'))||(idToCheck == "")){
			e.preventDefault(); 
		}
	});


// --------------- carte de crédit --------------------------------

		
//valide si visa ou master
	function validNocarte(){
		//$('input[name=carte]').on('click', function(){
			$('#nocarte').on('blur', function(){
			var valeur_selectionnee = $('input[type=radio][name=carte]:checked').val();			
			if(valeur_selectionnee=="visa"){ // si Visa est sélectionné
				//$('#nocarte').on('blur', function() {
					
					var input=$(this);
					var revisa = /^4[0-9]{12}(?:[0-9]{3})?$/;
					var is_visa = revisa.test(input.val());
					if(is_visa){
						input.removeClass("invalid").addClass("valid");
						$("span.messageErreurNocarte").empty();
						$("span.messageErreurChoixcarte").empty();
					}
					else{
						input.removeClass("valid").addClass("invalid");
						$('span.messageErreurNocarte').text( "Entrez un numéro de carte valide." );
					}						
				//});
			}
			else if(valeur_selectionnee=="master"){		
				//$('#nocarte').on('blur', function() {
					var input=$(this);
					var remaster = /^5[1-5][0-9]{14}$/;
					var is_master=remaster.test(input.val());
					if(is_master){
						input.removeClass("invalid").addClass("valid");
						$("span.messageErreurNocarte").empty();
						$("span.messageErreurChoixcarte").empty();
					}
					else{
						input.removeClass("valid").addClass("invalid");
						$('span.messageErreurNocarte').text( "Entrez un numéro de carte valide." );
						
					}
				//});
			}	
			else{
				$('span.messageErreurChoixcarte').text( "Veuillez choisir une carte." );
				$('#nocarte').removeClass("valid").addClass("invalid");
			}
			
		});
	};


	//nom du détenteur de la carte de crédit
	function validNomcredit(){
		$('#nomdetenteur').on('blur', function() {

			var input=$(this);
			var is_validgen= reggen.test(input.val()); //test au fur et à mesure
			if(is_validgen){
				input.removeClass("invalid").addClass("valid");		
				$("span.messageErreurNomdetenteur").empty();}
			else{input.removeClass("valid").addClass("invalid");
				$('span.messageErreurNomdetenteur').text( "Vous devez entrer le nom inscrit sur la carte." );		
			}
		});
	};

	//Expiration carte de crédit
	function validExpcredit(){
		var mois = $('#expirationmois');
		var annee = $('#expirationcarte');

		validExpcreditMois();
		validExpcreditAn();

		function validExpcreditMois(){
			mois.on('blur', function() {
				var input=$(this);
				var today = new Date();
				var year = today.getFullYear();
				var month = today.getMonth()+1;

				if((input.val() >= 1) && (input.val() <= 12)){
					input.removeClass("invalid").addClass("valid");
					$("span.messageErreurExpcarte").empty();}
				else{input.removeClass("valid").addClass("invalid");
					$('span.messageErreurExpcarte').text( "Entrez une date d'expiration valide (mmaaaa)" );					
				}				
			});
		};

		function validExpcreditAn(){	
			annee.on('blur', function() {
				var input=$(this);
				var today = new Date();
				var year = today.getFullYear();
				var month = today.getMonth()+1;
				var mois = $('#expirationmois');

				if(input.val() == year){
					if(mois.val() > month){
						input.removeClass("invalid").addClass("valid");
						$("span.messageErreurExpcarte").empty();
					}
					else{mois.removeClass("valid").addClass("invalid");
						$('span.messageErreurExpcarte').text( "Entrez une date d'expiration valide (mmaaaa)");
					}
				}

				else if ((input.val() >= year)&& (input.val() <= 2050)) {				
					input.removeClass("invalid").addClass("valid");
					$("span.messageErreurExpcarte").empty();
				}

				else{input.removeClass("valid").addClass("invalid");
					$('span.messageErreurExpcarte').text( "Entrez une date d'expiration valide (mmaaaa)" );
				}
			});
		};
	};


	//No. validation carte de crédit
	function validNoverif(){
		$('#verifcarte').on('blur', function() {
			var input=$(this);
			var revalid = /^[0-9]{3}$/;
			var is_validc=revalid.test(input.val());
			if(is_validc){
				input.removeClass("invalid").addClass("valid");
				$("span.messageErreurNoverif").empty();}
			else{
				input.removeClass("valid").addClass("invalid");
				$('span.messageErreurNoverif').text( "Entrez un numéro valide (000)" );
			}
		});
	};

// empêcher de continuer sur la prochaine page si un champ est vide ou mal rempli
	$("#paiement_form").submit(function(e){	
		var idToCheckCredit = $('#nocarte,#nomdetenteur, #expirationmois, #expirationcarte, #verifcarte, #boutonCarte');
			if ((idToCheckCredit.hasClass('invalid'))||(idToCheck == "")){
			e.preventDefault(); 
		}
	});
	
	
}); //document ready