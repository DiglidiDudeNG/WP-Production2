

<!-- Validation php -->

<?php
//Déclaration des variables du formulaire

	$courriel = htmlspecialchars($_POST['mail']);
	$nom = htmlspecialchars($_POST['nom']);
	$prenom = htmlspecialchars($_POST['prenom']);
	$adresse = htmlspecialchars($_POST['adresse']);
	$ville = htmlspecialchars($_POST['ville']);
	$codepostal = htmlspecialchars($_POST['codepostal']);
	$province = htmlspecialchars($_POST['province']);
	$pays = htmlspecialchars($_POST['pays']);
	

	if($_SERVER['REQUEST_METHOD'] == "POST"){
		$messages = array();
		
		if(! isset($_POST['nom']) || ! strlen($_POST['nom'])){
			$messages[] = "Le nom doit être renseigné";
		}
		if(! isset($_POST['mail']) || ! strlen($_POST['mail'])|| (!filter_var($mail, FILTER_VALIDATE_EMAIL))){
			$messages[] ="L'adresse courriel doit être renseignée";
		}
		if(! isset($_POST['commentaire']) || ! strlen($_POST['commentaire'])){
			$messages[] ="Le champ message doit être renseigné";
		}
		if(empty($messages)){
			//message de confirmation pour le client et courriel de rapport de problème 
			$destinataire = $_POST['mail']; 
			$sujet = "Recapitulatif de votre demande d'information"; 
			$msg= "Bonjour ".$_POST['nom'].", 
			Nous avons bien pris en compte votre demande, nous revenons vers vous dans les plus brefs delais.<br/> 
			____ <br/> 

			Ceci est un mail automatique. Merci de ne pas y repondre."; 
			$headers = 'MIME-Version: 1.0' . "\r\n"; 
			$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";  
			$headers .= 'From: UlLi <kboisvert3@gmail.com>'. "\r\n"; 
			mail($destinataire, $sujet, $msg, $headers);
			$to = 'kboisvert3@gmail.com'; 
			$subject = 'Un nouveau message de UlLi : '; 
			$message = 'Nom : ' .$_POST['nom'].'<br />Adresse courriel : '.$_POST['mail'].'<br />Message : '.$_POST['commentaire'].'<br />'.'<n />'; 
			$headers = 'MIME-Version: 1.0' . "\r\n"; 
			$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n"; 
			$headers .= 'From: votre@mail.fr <kboisvert3@gmail.com>' . "\r\n" .'Reply-To: kboisvert3@gmail.com' . "\r\n" .
			'X-Mailer: PHP/' . phpversion(); 
			mail($to, $subject, $message, $headers); 
			$mailSent = true;
		}
		/*
		* Créer un custom post de type 'contact'
		*/
		$contact_post = array(
		'post_title' => $nom . ' | ' . $mail,
		'post_content' => $message,
		'post_type' => 'contact',
		'post_status' => 'publish'
		);
		if (wp_insert_post($contact_post)) echo 'Votre message a bien ete enregistre.<br>';
		else echo 'Erreur d\'enregistrement du message';
	}
?>

<?php 
	if (!empty($_POST['messages'])): 
	foreach ($_POST['messages'] as $msg) : 
	echo $msg ?><br/>
<?php 
	endforeach; 
	endif;
	unset($_POST['messages']);
?>
<br>
<!--**************le formulaire**********-->   
<?php 

//Message si le courriel est envoyé avec succes
	if (isset($mailSent) && $mailSent == true) { ?>
		<h1 class="post" >Merci, <?= $nom; ?></h1>
		<p class="post" >Votre courriel a ete envoye avec succes. Vous recevrez une reponse sous peu.</p>

<?php 
	} 
	else { ?>
	
		<?php 
		
// Message s'il y a une erreur dans l'envoie du courriel
			if (isset($messages)) { ?>
			<p class="post" >Une erreur est survenue lors de l'envoi du formulaire.</p>
		<?php 
			} ?>
			
<!-- Début du formulaire -->
		<section id="information-client"> 
			<h2>Informations client</h2> 

<!-- formulaire courriel -->			
			
			<form class="form-horizontal">
				<div class="form-group">
					<label for="inputEmail3" class="col-sm-2 control-label">Courriel</label>
					<div class="col-sm-10">
						<input type="email" class="form-control" id="inputEmail3" placeholder="Courriel">
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-offset-2 col-sm-10">
						<div class="checkbox">
							<label>
								<input type="checkbox"> Envoyer le(s) billets à cette adresse courriel
							</label>
						</div>
					</div>
				</div>
			</form>

<!-- Formulaire adresse -->
<!-- à mettre dans le fichier css -->
<style type="text/css"> 
  .error{
    padding: 5px 9px;
    border: 1px solid red;
    color: red;
    border-radius: 3px;
  }
 
  .success{
    padding: 5px 9px;
    border: 1px solid green;
    color: green;
    border-radius: 3px;
  }
 
  form span{
    color: red;
  }
</style>
 
<div id="respond">
  <?php echo $response; ?>
  <form action="<?php the_permalink(); ?>" method="post">
    <p><label for="name">Name: <span>*</span> <br><input type="text" name="message_name" value="<?php echo esc_attr($_POST['message_name']); ?>"></label></p>
    <p><label for="message_email">Email: <span>*</span> <br><input type="text" name="message_email" value="<?php echo esc_attr($_POST['message_email']); ?>"></label></p>
    <p><label for="message_text">Message: <span>*</span> <br><textarea type="text" name="message_text"><?php echo esc_textarea($_POST['message_text']); ?></textarea></label></p>
    <p><label for="message_human">Human Verification: <span>*</span> <br><input type="text" style="width: 60px;" name="message_human"> + 3 = 5</label></p>
    <input type="hidden" name="submitted" value="1">
    <p><input type="submit"></p>
  </form>
</div>
			
			<h2>Adresse de facturation</h2> 

			<form action="<?php the_permalink(); ?>" id="contactForm" method="post" onsubmit="return valider_contact(this);">

			<p><label for="nom"> Nom </label>
			<input type="text" name="nom" id="nom" value="<?php if (isset ($_POST['nom'])){ echo $nom;} ?>" required  />   
			</p>

			<p><label for="nom"> Prénom </label>
			<input type="text" name="nom" id="nom" value="<?php if (isset ($_POST['nom'])){ echo $nom;} ?>" required  />  
			</p>
			
			<p><label for="nom"> Adresse </label>
			<input type="text" name="nom" id="nom" value="<?php if (isset ($_POST['nom'])){ echo $nom;} ?>" required  />  
			</p>
			
			<p><label for="nom"> Ville </label>
			<input type="text" name="nom" id="nom" value="<?php if (isset ($_POST['nom'])){ echo $nom;} ?>" required  />  
			</p>
			
			<p><label for="nom"> Code postal </label>
			<input type="text" name="nom" id="nom" value="<?php if (isset ($_POST['nom'])){ echo $nom;} ?>" required  />  
			</p>
			
			<p><label for="nom"> Province </label>
			<input type="text" name="nom" id="nom" value="<?php if (isset ($_POST['nom'])){ echo $nom;} ?>" required  />  
			</p>
			
			<p><label for="nom"> Pays </label>
			<input type="text" name="nom" id="nom" value="<?php if (isset ($_POST['nom'])){ echo $nom;} ?>" required  />  
			</p>
			
			<div class="form-group">
				<div class="col-sm-offset-2 col-sm-10">
					<div class="checkbox">
						<label>
							<input type="checkbox"> Envoyer le(s) billets à cette adresse
						</label>
					</div>
				</div>
			</div>
			
			<input type="hidden" name="submitted" id="submitted" value="true" /><button type="submit" class="btn">Étape suivante</button>

			</form>




		</section>
	<?php } ?>