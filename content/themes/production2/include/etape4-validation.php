<?php

	/* Paiement */

	// TODO validation de la carte de crédit

	$validCarte = true;

	// 4 derniers chiffres de la carte de crédit
	$finCarte = substr($_POST['nocarte'],-4,4);

	if( $validCarte == true ){

		$val_etape_4 = true;



		/**********************************************
		 * Récupération des infos
		 **********************************************/
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
	else{
		$val_etape_4 = false;
	}

?>

