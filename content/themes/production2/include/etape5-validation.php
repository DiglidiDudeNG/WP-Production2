<?php

	/* Paiement */

	/***********************************************************
	 * Récupération et assainissement des champs du formulaire
	 ***********************************************************/


		$val_etape_5 = true;
		
		
// _____________________ ENVVOIE DU COURRIEL ____________________  

// Envoyer un courriel avec les infos mais pas de message pour nous 

// une fois le bouton submit appuyé et validation correct envoyer courriel: 
<?php
	if(empty($messages)){ //s'il n'y a pas de message d'erreur à revoir selon la validation de JO
	
		$from = $_SESSION['courriel']; // courriel du client
		$nom = $_SESSION['nom']; //nom du client
		$subject1 = "Votre commande"; //sujet du courriel que le client reçoit
		$message1 = "Bonjour ".$nom . ", 
			Voici un résumé de votre commande: <br/> 
			<h3>Informations client</h3>
			<p>".<?php echo $_SESSION['courriel']?>."</p><!-- mettre les bonnes variables -->
			<p>
				".<?php echo $_SESSION['prenom']?> <?php echo $_SESSION['nom']?><br>
				<?php echo $_SESSION['adresse']?><br>
				<?php echo $_SESSION['ville']?>, <?php echo $_SESSION['province']?>, <?php echo $_SESSION['codepostal']?><br>
				<?php echo $_SESSION['pays']?>
			."</p>
			
					
			____ <br/> 

			Ceci est un mail automatique. Merci de ne pas y repondre."; 
			
		$headers = "MIME-Version: 1.0\r\n"; 
		$headers .= "Content-type: text/html; charset=utf-8\r\n";  
		$headers .= "From: <karineboisvert@hotmail.com >" ; //moi 

		mail($from,$subject1,$message,$headers); //courriel envoyé au client

		 
	$mailSent = true;
		 
	}
		
	 /*
	 * Créer un custom post de type 'contact'  ??? me rappelle plus pourquoi
	 */
	$contact_post = array(
		'post_title' => $nom . ' | ' . $from,
		'post_content' => $message1,
		'post_type' => 'contact',
		'post_status' => 'publish'
	);
	//afficher le message à l'écran
	if (wp_insert_post($contact_post)) echo 'Votre message a bien ete enregistre.<br>';
	else echo 'Erreur d\'enregistrement du message';
}
?>
	<?php if (!empty($_POST['messages'])): ?>
		<?php foreach ($_POST['messages'] as $msg) : ?>
		<?php echo $msg ?><br/>
		<?php endforeach; ?>
		<?php
		endif;
		unset($_POST['messages']);
		?>
		<br>
	   <!--**************le formulaire**********-->   
		<?php if (isset($mailSent) && $mailSent == true) { ?>
 
        <h1 class="post" >Merci, <?= $nom; ?></h1>
        <p class="post" >Votre courriel a ete envoye avec succes. Vous recevrez une reponse sous peu.</p>


	<?php } else { ?>
		<?php if (isset($messages)) { ?>
			<p class="post" >Une erreur est survenue lors de l'envoi du formulaire.</p>

		<?php } ?>
			
			



?>

