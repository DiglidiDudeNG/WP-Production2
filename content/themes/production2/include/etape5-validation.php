<?php

	/* Paiement */

	/***********************************************************
	 * Récupération et assainissement des champs du formulaire
	 ***********************************************************/


		$val_etape_5 = true;
		
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


		
		
// _____________________ ENVVOIE DU COURRIEL ____________________  

// Envoyer un courriel avec les infos mais pas de message pour nous 

// une fois le bouton submit appuyé et validation correct envoyer courriel: 
	
		$destinataire = $courriel; // courriel du client
		$from = "kboisvert3@gmail.com";
		$subject = "Votre commande"; //sujet du courriel que le client reçoit
		$message = "Bonjour ".$nom . ", 
			Voici un résumé de votre commande: <br/> 
			<h3>Informations client</h3>
			<p>Bonjour ". $nom; $prenom;

			"</p>
			
					
			____ <br/> 

			Ceci est un mail automatique. Merci de ne pas y repondre."; 
			
		$headers = "MIME-Version: 1.0\r\n"; 
		$headers .= "Content-type: text/html; charset=utf-8\r\n";  
		$headers .= "From:". $from; 

		mail($destinataire,$subject,$message,$headers); //courriel envoyé au client

		 
	$mailSent = true;
	session_destroy();
		 
	////
		//Informations de l'usager pour le courriel de confirmation
   /* $destinataire = $_SESSION['email'];
    $from = "livraison@bbqchickenpower.com";
    $nom = $_SESSION['nom'];
    $sujet = "Livraison BBQ Chicken Power";

    //Message du courriel qui contient les infos de livraison et les infos de la commande
    $message = "Merci d'avoir commander chez BBQ Chicken Power! \n"
    			. "Si les informations suivantes sont inexactes, veuillez nous appeler dans les plus brefs délais au 418-444-4444: \n\n" 
    			. "Adresse de livraison: \n" 
    			. $_SESSION['nom'] . "\n"
    			. $_SESSION['adresse'] . "\n"
    			. $_SESSION['ville'] . "\n"
    			. $_SESSION['codePostal'] . "\n"
    			. $_SESSION['telephone'] . "\n\n"
    			. $commande;

    $headers = "De:" . $from;

    //Envoi du courriel de confirmation
    mail($destinataire,$sujet,$message,$headers);

    //Maintenant que la commande et le courriel sont envoyés,
    //On détruit toutes les informations de l'usager
	session_destroy();
		*/


