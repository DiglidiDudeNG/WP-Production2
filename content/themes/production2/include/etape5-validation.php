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
		$from = "livraison@bbqchickenpower.com";
		$subject = "Votre commande"; //sujet du courriel que le client reçoit
		
		$message = "Bonjour ". $prenom .", <br /> 
			
			<div>
				<table>
					<thead>
						<tr>
							<th>Résumé de la commande</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>
								<h3>". $spectacle_titre ."<br>
								<span>". $prestation_date." à ". $prestation_heure."</span><br />
								<span>Billets : ".$nb_billets." X</span></h3>
								
							</td>
						</tr>
					</tbody>
					<tfoot>
					<tr>
						<td><strong>Sous-total</strong></td>
						<td>". $sousTotal." $</td>
					</tr>
					<tr>
						<td><strong>TVQ 9.975%</strong></td>
						<td>
							". $spectacle_tvq." $
						</td>
					</tr>
					<tr>
						<td><strong>TPS 5.0%</strong></td>
						<td>
							". $spectacle_tps." $
						</td>
					</tr>					
					<tr>
						<td><strong>Frais de livraison</strong></td>
						<td>
							". $fraisLivraison ." $
						</td>
					</tr>					
					<tr>
						<td>
							<strong>Total</strong>
						</td>
						<td>
							". $spectacle_gtotal ." $
						</td>
					</tr>
					</tfoot>
				</table>
			</div>
			<br />
			<br />
			<br />
			<p>___________________________________________________________</p>
			Ceci est un courriel automatique. Merci de ne pas y repondre."; 
			
		$headers = "MIME-Version: 1.0\r\n"; 
		$headers .= "Content-type: text/html; charset=utf-8\r\n";  
		$headers .= "From: <karineboisvert@hotmail.com >"; 

		//ini_set("sendmail_from","karineboisvert@hotmail.com ");
		mail($destinataire,$subject,$message,$headers); //courriel envoyé au client

		 
	$mailSent = true;
	//session_destroy();
		 



