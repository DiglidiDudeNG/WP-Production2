/* Liste de #
courriel : courriel
facturationform
nom
prenom
adresse
ville
codepostal
province
pays

livraisonform
noml
prenoml
adressel
villel
codepostall
provincel
paysl

visa
mastercard

nomdetenteur
nocarte
expirationcarte
verifcarte */

// met le border du input en rouge si incorrect et en vert si correct

$(document).ready(function() {  //Référence: http://contactmetrics.com/blog/validate-contact-form-jquery
		// Validation en temps réel 
		// Ne peut être vide pour tous les input
		$('#nom, #prenom, #adresse, #ville, #pays, #nomdetenteur').on('input', function() {
			var input=$(this);
			var nonvide=input.val().substring(1); // avoir au moins 2 caractères
			if(nonvide){input.removeClass("invalid").addClass("valid");}
			else{input.removeClass("valid").addClass("invalid");}
		});
		
		//Courriel
		$('#courriel').on('input', function() {
			var input=$(this);
			var re = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;
			var is_email=re.test(input.val());
			if(is_email){input.removeClass("invalid").addClass("valid");}
			else{input.removeClass("valid").addClass("invalid");}
		});

		//Code postal
		$('#codepostal').on('input', function() {
			var input=$(this);
			var repostal = /^[A-Za-z]\d[A-Za-z][ -]?\d[A-Za-z]\d$/; //vérifie le code postal
			var is_postal=repostal.test(input.val());
			if(is_postal){input.removeClass("invalid").addClass("valid");}
			else{input.removeClass("valid").addClass("invalid");}
		});

		//No carte de crédit
//$("input[type=checkbox][checked]"); // All checkboxes in the document that are checked pour case à cocher
//$('#element option[value="visa"]').attr("selected", "selected"); // savoir si une case a été sélectionnée

		$('#nocarte').on('input', function() {
			//var input=$(this);
			if ('#choixcarte option[value="visa"].attr("selected", "selected"){  // vérifier Visa
				var renocarte = /^4[0-9]{12}(?:[0-9]{3})?$/;
				var is_nocarte = renocarte.test(input.val());
				if(is_nocarte){input.removeClass("invalid").addClass("valid");}
				else{input.removeClass("valid").addClass("invalid");}
			}
			else{ // vérifier Mastercard
				var renocarte = /^5[1-5][0-9]{14}$/;
				var is_nocarte=renocarte.test(input.val());
				if(is_nocarte){input.removeClass("invalid").addClass("valid");}
				else{input.removeClass("valid").addClass("invalid");}
			}

		});


		//Expiration carte de crédit
		$('#expirationcarte').on('input', function() {
			var input=$(this);
			var reexp = /^(0[1-9]|1[0-2])\/?([0-9]{4}|[0-9]{2})$/;
			var is_exp=reexp.test(input.val());
			if(is_exp){input.removeClass("invalid").addClass("valid");}
			else{input.removeClass("valid").addClass("invalid");}
		});

		//No. validation carte de crédit
		$('#verifcarte').on('input', function() {
			var input=$(this);
			var revalid = /^[0-9]{3}$/;
			var is_validc=revalid.test(input.val());
			if(is_validc){input.removeClass("invalid").addClass("valid");}
			else{input.removeClass("valid").addClass("invalid");}
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