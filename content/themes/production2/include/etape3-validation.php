<?php

	

	/***********************************************************
	 * Récupération et assainissement des champs du formulaire
	 ***********************************************************/
	$courriel = trim($_POST['email']);
	$courriel = filter_var($courriel, FILTER_SANITIZE_STRING);

	$nom = trim($_POST['nom']);
	$nom = filter_var($nom, FILTER_SANITIZE_STRING);

	$prenom = trim($_POST['prenom']);
	$prenom = filter_var($prenom, FILTER_SANITIZE_STRING);

	$adresse = trim($_POST['adresse']);
	$adresse = filter_var($adresse, FILTER_SANITIZE_STRING);

	$ville = trim($_POST['ville']);
	$ville = filter_var($ville, FILTER_SANITIZE_STRING);

	$codepostal = trim($_POST['codepostal']);
	$codepostal = filter_var($codepostal, FILTER_SANITIZE_STRING);

	$province = trim($_POST['province']);
	$province = filter_var($province, FILTER_SANITIZE_STRING);

	$pays = trim($_POST['pays']);
	$pays = filter_var($pays, FILTER_SANITIZE_STRING);


	if( isset($_POST['livraison_poste']){
		$noml = trim($_POST['noml']);
		$noml = filter_var($noml, FILTER_SANITIZE_STRING);

		$prenoml = trim($_POST['prenoml']);
		$prenoml = filter_var($prenoml, FILTER_SANITIZE_STRING);

		$adressel = trim($_POST['adressel']);
		$adressel = filter_var($adressel, FILTER_SANITIZE_STRING);

		$villel = trim($_POST['villel']);
		$villel = filter_var($villel, FILTER_SANITIZE_STRING);

		$codepostall = trim($_POST['codepostall']);
		$codepostall = filter_var($codepostall, FILTER_SANITIZE_STRING);

		$provincel = trim($_POST['provincel']);
		$provincel = filter_var($provincel, FILTER_SANITIZE_STRING);

		$paysl = trim($_POST['paysl']);
		$paysl = filter_var($paysl, FILTER_SANITIZE_STRING);
	}
	


	if( !isset($messageErreurNom) ) 			{ $messageErreurNom=""; }
	if( !isset($messageErreurPrenom) ) 			{ $messageErreurPrenom=""; }
	if( !isset($messageErreurAdresse) ) 		{ $messageErreurAdresse=""; }
	if( !isset($messageErreurVille) ) 			{ $messageErreurVille=""; }
	if( !isset($messageErreurCodepostal) ) 		{ $messageErreurCodepostal=""; }
	if( !isset($messageErreurProvince) ) 		{ $messageErreurProvince=""; }
	if( !isset($messageErreurPays) ) 			{ $messageErreurPays=""; }

	if( !isset($messageErreurNom1) ) 			{ $messageErreurNom1=""; }
	if( !isset($messageErreurPrenom1) ) 		{ $messageErreurPrenom1=""; }
	if( !isset($messageErreurAdresse1) ) 		{ $messageErreurAdresse1=""; }
	if( !isset($messageErreurVille1) ) 			{ $messageErreurVille1=""; }
	if( !isset($messageErreurCodepostal1) ) 	{ $messageErreurCodepostal1=""; }
	if( !isset($messageErreurProvince1) ) 		{ $messageErreurProvince1=""; }
	if( !isset($messageErreurPays1) ) 			{ $messageErreurPays1=""; }

	if( empty($courriel) ) {
		$erreurCourriel = true;
		$messageErreurCourriel = "*Champs requis";
	}
	elseif(preg_match("/^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/", $courriel) == false)
	{
		$erreurCourriel = true;
		$messageErreurCourriel = "*Veuillez entrer une adresse courriel valide";
	}
	



	if( $erreurCourriel
		|| $erreurNom
		|| $erreurPrenom
		|| $erreurAdresse
		|| $erreurVille
		|| $erreurCodepostal
		|| $erreurProvince
		|| $erreurPays
		|| $erreurNom1
		|| $erreurPrenom1
		|| $erreurAdresse1
		|| $erreurVille1
		|| $erreurCodepostal1
		|| $erreurProvince1
		|| $erreurPays1 ){
		$val_etape_3 = false;
	}
	else{
		$val_etape_3 = true;
	}




	


?>

