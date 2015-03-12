<?php

	

	/***********************************************************
	 * Récupération et assainissement des champs du formulaire
	 ***********************************************************/
	$courriel = trim($_POST['courriel']);
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

	$envoi = trim($_POST['envoi']);
	$envoi = filter_var($envoi, FILTER_SANITIZE_STRING);
	


	/***********************************************************
	 * Validation des champs du formulaire
	 ***********************************************************/
	if( empty($courriel) ) {
		$erreurCourriel = true;
		$messageErreurCourriel = "*Champs requis";
	}
	elseif(preg_match("/^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/", $courriel) == false)
	{
		$erreurCourriel = true;
		$messageErreurCourriel = "*Veuillez entrer une adresse courriel valide";
	}
	if( empty($nom) ) {
		$erreurNom = true;
		$messageErreurNom = "*Champs requis";
	}
	if( empty($prenom) ) {
		$erreurPrenom = true;
		$messageErreurPrenom = "*Champs requis";
	}
	if( empty($adresse) ) {
		$erreurAdresse = true;
		$messageErreurAdresse = "*Champs requis";
	}
	if( empty($ville) ) {
		$erreurVille = true;
		$messageErreurVille = "*Champs requis";
	}
	if( empty($codepostal) ) {
		$erreurCodepostal = true;
		$messageErreurCodepostal = "*Champs requis";
	}
	elseif(preg_match("/^[ABCEGHJKLMNPRSTVXY]{1}\d{1}[A-Z]{1} *\d{1}[A-Z]{1}\d{1}$/i", $codepostal) == false)
	{
		$erreurCodepostal = true;
		$messageErreurCodepostal = "*Veuillez entrer un code postal valide";
	}
	if( empty($province) ) {
		$erreurProvince = true;
		$messageErreurProvince = "*Champs requis";
	}
	if( empty($pays) ) {
		$erreurPays = true;
		$messageErreurPays = "*Champs requis";
	}

	/* Méthode d'envoi */
	if( empty($envoi) ) {
		$erreurEnvoi = true;
		$messageErreurEnvoi = "*Veuillez choisir une méthode d'envoi des billets";
	}



	// Si le user veut se faire envoyer les billets par la poste,
	// Et si il a coché la case "Utiliser une autre adresse pour la livraison",
	// On valide les champs de la 2e adresse
	if( $envoi == 'poste-envoie' && isset($_POST['AdresseLivraison']) ){

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


		if( empty($noml) ) {
			$erreurNoml = true;
			$messageErreurNoml = "*Champs requis";
		}
		if( empty($prenoml) ) {
			$erreurPrenoml = true;
			$messageErreurPrenoml = "*Champs requis";
		}
		if( empty($adressel) ) {
			$erreurAdressel = true;
			$messageErreurAdressel = "*Champs requis";
		}
		if( empty($villel) ) {
			$erreurVillel = true;
			$messageErreurVillel = "*Champs requis";
		}
		if( empty($codepostall) ) {
			$erreurCodepostall = true;
			$messageErreurCodepostall = "*Champs requis";
		}
		elseif(preg_match("/^[ABCEGHJKLMNPRSTVXY]{1}\d{1}[A-Z]{1} *\d{1}[A-Z]{1}\d{1}$/i", $codepostall) == false)
		{
			$erreurCodepostall = true;
			$messageErreurCodepostall = "*Veuillez entrer un code postal valide";
		}
		if( empty($provincel) ) {
			$erreurProvincel = true;
			$messageErreurProvincel = "*Champs requis";
		}
		if( empty($paysl) ) {
			$erreurPaysl = true;
			$messageErreurPaysl = "*Champs requis";
		}

	}

	


	if( $erreurCourriel
		|| $erreurNom
		|| $erreurPrenom
		|| $erreurAdresse
		|| $erreurVille
		|| $erreurCodepostal
		|| $erreurProvince
		|| $erreurPays
		|| $erreurEnvoi
		|| $erreurNoml
		|| $erreurPrenoml
		|| $erreurAdressel
		|| $erreurVillel
		|| $erreurCodepostall
		|| $erreurProvincel
		|| $erreurPaysl )
	{
		$val_etape_3 = false;
	}
	else
	{
		$val_etape_3 = true;

		$_SESSION['courriel'] = $courriel;
		$_SESSION['nom'] = $nom;
		$_SESSION['prenom'] = $prenom;
		$_SESSION['adresse'] = $adresse;
		$_SESSION['ville'] = $ville;
		$_SESSION['codepostal'] = $codepostal;
		$_SESSION['province'] = $province;
		$_SESSION['pays'] = $pays;
		$_SESSION['envoi'] = $envoi;

		if( $envoi == 'poste-envoie' && isset($_POST['AdresseLivraison']) ){

			$_SESSION['noml'] = $noml;
			$_SESSION['prenoml'] = $prenoml;
			$_SESSION['adressel'] = $adressel;
			$_SESSION['villel'] = $villel;
			$_SESSION['codepostall'] = $codepostall;
			$_SESSION['provincel'] = $provincel;
			$_SESSION['paysl'] = $paysl;

		}
		elseif( $envoi == 'poste-envoie' ){
			$_SESSION['noml'] = $nom;
			$_SESSION['prenoml'] = $prenom;
			$_SESSION['adressel'] = $adresse;
			$_SESSION['villel'] = $ville;
			$_SESSION['codepostall'] = $codepostal;
			$_SESSION['provincel'] = $province;
			$_SESSION['paysl'] = $pays;
		}
		elseif( $envoi == 'courriel-envoie' ){

			if( isset($_SESSION['noml']) ){				
				unset($_SESSION['noml']);
				unset($_SESSION['prenoml']);
				unset($_SESSION['adressel']);
				unset($_SESSION['villel']);
				unset($_SESSION['codepostall']);
				unset($_SESSION['provincel']);
				unset($_SESSION['paysl']);
			}
			
		}

	}




	


?>

