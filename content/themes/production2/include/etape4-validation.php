<?php


	/**************************************
	 * Validation de la carte de crédit
	 *************************************/
	$typeCarte 			= $_POST['carte'];
	$noCarte 			= $_POST['nocarte'];
	$nomDetenteur 		= $_POST['nomdetenteur'];
	$expirationMois 	= $_POST['expirationmois'];
	$expirationAnnee 	= $_POST['expirationannee'];
	$verifCarte 		= $_POST['verifcarte'];

	$messageErreurChoixcarte = "";
	$messageErreurNocarte = "";
	$messageErreurNomdetenteur = "";
	$messageErreurExpcarte = "";
	$messageErreurNoverif = "";

	$typeCarteValid = true;
	$noCarteValid = true;
	$nomDetenteurValid = true;
	$dateExpirationValid = true;
	$noVerifValid = true;

	$moisCourant = date('m');
	$anneeCourante = date('Y');
	

	// Validation du type de carte et du numéro de carte
	if( $typeCarte == 'visa' ){
		$pattern = "/^([4]{1})([0-9]{12,15})$/"; //Visa
		if( !preg_match($pattern, $noCarte) ) {		
			$noCarteValid = false;
			$messageErreurNocarte = "*Veuillez entrer un numéro de carte Visa valide";
		}
	}
	elseif( $typeCarte == 'master' ){
		$pattern = "/^([51|52|53|54|55]{2})([0-9]{14})$/"; //Mastercard

		if( !preg_match($pattern, $noCarte) ) {			
			$noCarteValid = false;
			$messageErreurNocarte = "*Veuillez entrer un numéro de carte Mastercard valide";
		}
	}
	else{
		$typeCarteValid = false;
		$messageErreurChoixcarte = "*Veuillez choisir un type de carte";
	}

	// Validation du nom du détenteur
	$patternNom = "/^[A-Za-zÀ-ÿ0-9\-. ]{2,50}$/";
	if( !preg_match($patternNom, $nomDetenteur) ) {		
		$nomDetenteurValid = false;
		$messageErreurNomdetenteur = "*Veuillez entrer un nom valide";
	}

	// Validation de la date d'expiration
	if( $expirationMois<1 || $expirationMois>12 ){
		$dateExpirationValid = false;
		$messageErreurExpcarte = "*Veuillez entrer une date d'expiration valide (MMAAAA)";
	}	
	elseif( $expirationAnnee < $anneeCourante || $expirationAnnee > $anneeCourante+10){
		$dateExpirationValid = false;
		$messageErreurExpcarte = "*Veuillez entrer une date d'expiration valide (MMAAAA)";
	}
	elseif( $expirationMois <= $moisCourant && $expirationAnnee == $anneeCourante ){
		$dateExpirationValid = false;
		$messageErreurExpcarte = "*Veuillez entrer une date d'expiration valide (MMAAAA)";
	}

	// Validation du numéro de vérification
	$patternNoVerif = "/^[0-9]{3}$/";
	if( !preg_match($patternNoVerif, $verifCarte) ) {			
		$noVerifValid = false;
		$messageErreurNoverif = "*Veuillez entrer un numéro de vérification valide";
	}

	echo($anneeCourante+10);




	if( $typeCarteValid == true
		&& $noCarteValid == true
		&& $nomDetenteurValid == true
		&& $dateExpirationValid == true
		&& $noVerifValid == true )
	{
		$validCarte = true;
	}
	else
	{
		$validCarte = false;
	}

	


	// Si la validation de la carte a échouée
	if( $validCarte == false ){

		$val_etape_4 = false;
	}
	// Si la validation de la carte a réussie
	else{

		$val_etape_4 = true;

		/**********************************************
		 * Récupération des infos
		 **********************************************/

		// 4 derniers chiffres de la carte de crédit		
		$finCarte = substr($_POST['nocarte'],-4,4);

		// Récupération des infos du client
		$courriel 	= $_SESSION['courriel'];
		$nom 		= $_SESSION['nom'];
		$prenom 	= $_SESSION['prenom'];
		$adresse 	= $_SESSION['adresse'];
		$ville 		= $_SESSION['ville'];
		$codepostal = $_SESSION['codepostal'];
		$province	= $_SESSION['province'];
		$pays 		= $_SESSION['pays'];
		$envoi 		= $_SESSION['envoi'];

		// Si c'est un envoi par la poste
		if( $envoi == 'poste-envoie' ){

			// Récupération des infos de livraison
			$noml 			= $_SESSION['noml'];
			$prenoml 		= $_SESSION['prenoml'];
			$adressel 		= $_SESSION['adressel'];
			$villel 		= $_SESSION['villel'];
			$codepostall 	= $_SESSION['codepostall'];
			$provincel		= $_SESSION['provincel'];
			$paysl 			= $_SESSION['paysl'];

			$modeDeLivraison = "Envoi postal";
			$fraisLivraison	= "2.00";
		}
		else{
			$modeDeLivraison = "Courriel";
			$fraisLivraison	= "0.00";
		}

		// Récupération des infos du spectacle
		$id_prestation 		= $_SESSION['id_prestation'];
		$id_spectacle 		= $_SESSION['id_spectacle'];
		$spectacle_titre 	= $_SESSION['spectacle_titre'];
		$prestation_date 	= $_SESSION['prestation_date'];
		$prestation_heure 	= $_SESSION['prestation_heure'];

		// Récupération des infos de la commande
		$nb_billets 		= $_SESSION['nb_billets'];
		$spectacle_prix 	= $_SESSION['spectacle_prix'];
		$sousTotal 			= $_SESSION['sousTotal'];
		$spectacle_tvq 		= $_SESSION['spectacle_tvq'];
		$spectacle_tps		= $_SESSION['spectacle_tps'];
		$spectacle_gtotal 	= $_SESSION['spectacle_gtotal'] + $fraisLivraison;

	}

?>

