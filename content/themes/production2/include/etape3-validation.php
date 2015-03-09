<?php

	

	/***********************************************************
	 * Récupération et assainissement des champs du formulaire
	 ***********************************************************/
	$courriel = trim($_POST['email']);
	$courriel = filter_var($courriel, FILTER_SANITIZE_STRING);

	if( empty($courriel) ) {
		$erreurCourriel = true;
		$messageErreurCourriel = "*Champs requis";
	}
	elseif(preg_match("/^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/", $courriel) == false)
	{
		$erreurCourriel = true;
		$messageErreurCourriel = "*Veuillez entrer une adresse courriel valide";
	}

	$nom = $_POST['nom'];
	$adresse = $_POST['adresse'];
	$ville = $_POST['ville'];
	$codePostal = $_POST['codePostal'];
	$telephone = $_POST['telephone'];
	

	//Si une validation du formulaire a déjà été tentée et qu'il y a des messages d'erreur,
	//on les place dans des variables afin de les afficher.
	if(isset($_POST['messageErreurNom'])){								
		$messageErreurNom = $_POST['messageErreurNom'];
		$messageErreurEmail = $_POST['messageErreurEmail'];
		$messageErreurAdresse = $_POST['messageErreurAdresse'];
		$messageErreurVille = $_POST['messageErreurVille'];
		$messageErreurCodePostal = $_POST['messageErreurCodePostal'];
		$messageErreurTelephone = $_POST['messageErreurTelephone'];
	}
	//Sinon les variables sont simplement initialisées
	else{
		$messageErreurNom = "";
		$messageErreurEmail = "";
		$messageErreurAdresse = "";
		$messageErreurVille = "";
		$messageErreurCodePostal = "";
		$messageErreurTelephone = "";
	}


	if( $erreurEmail ){
		$val_etape_3 = false;
	}
	else{
		$val_etape_3 = true;
	}




	


?>

