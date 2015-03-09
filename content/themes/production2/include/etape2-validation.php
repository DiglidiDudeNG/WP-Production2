<?php


	// Récupération des ID de la prestation et du spectacle en cours d'achat
	$id_spectacle = $_SESSION['id_spectacle'];
	$id_prestation = $_SESSION['id_prestation'];


	// Récupération et assainissement du nombre de billets entré
	$nb_billets = trim($_POST['nb_billets']);
	$nb_billets = filter_var($nb_billets, FILTER_SANITIZE_STRING);



	/**********************************
	 * Validation du nombre de billets
	 **********************************/
	if( empty($nb_billets) ){

		$messageErreurNbBillets = "*Champs requis";

		$val_etape_2 = false;
	}
	elseif( !preg_match('/^\d+$/', $nb_billets) ){

		$messageErreurNbBillets = "*Veuillez entrer un nombre de billets valide";

		$val_etape_2 = false;
	}
	elseif( $nb_billets >= 50 ){

		$messageErreurNbBillets = "*Veuillez contacter le gérant pour les achats de 50 billets et plus";

		$val_etape_2 = false;
	}
	else{
		
		$val_etape_2 = true;

		$_SESSION['nb_billets'] = $nb_billets;
	}


?>

