
			
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
<!-- case à cocher du courriel -->
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
	
	<div class="adresse-facturation">
		<p>Adresse de facturation</p> 
		<form action="<?php the_permalink(); ?>" id="contactForm" method="post" onsubmit="return valider_contact(this);">
		
			<p><label for="nom"> Nom </label>
				<input type="text" name="nom" id="nom" value="<?php if (isset ($_POST['nom'])){ echo $nom;} ?>" required  />   
			</p>

			<p><label for="prenom"> Prénom </label>
				<input type="text" name="prenom" id="prenom" value="<?php if (isset ($_POST['prenom'])){ echo $prenom;} ?>" required  />  
			</p>
			
			<p><label for="adresse"> Adresse </label>
				<input type="text" name="adresse" id="adresse" value="<?php if (isset ($_POST['adresse'])){ echo $adresse;} ?>" required  />  
			</p>
			
			<p><label for="ville"> Ville </label>
				<input type="text" name="ville" id="ville" value="<?php if (isset ($_POST['ville'])){ echo $ville;} ?>" required  />  
			</p>
			
			<p><label for="codepostal"> Code postal </label>
				<input type="text" name="codepostal" id="codepostal" value="<?php if (isset ($_POST['codepostal'])){ echo $codepostal;} ?>" required  />  
			</p>
			<!-- liste déroulante des provinces -->
			<p><label for="province"> Province </label>	
				<select class="form-control" type="text" name="province" id="province" required >
					<option value="<?php if (isset ($_POST['alberta'])){ echo $alberta;} ?>">Alberta</option>
					<option value="<?php if (isset ($_POST['cb'])){ echo $cb;} ?>">Colombie-Britanique</option>
					<option value="<?php if (isset ($_POST['ipe'])){ echo $ipe;} ?>">Ile-du-Prince-Édouard</option>
					<option value="<?php if (isset ($_POST['man'])){ echo $man;} ?>">Manitoba</option>
					<option value="<?php if (isset ($_POST['nb'])){ echo $nb;} ?>">Nouveau-Brunswick</option>
					<option value="<?php if (isset ($_POST['ne'])){ echo $ne;} ?>">Nouvelle-Écosse</option>
					<option value="<?php if (isset ($_POST['ont'])){ echo $ont;} ?>">Ontario</option>
					<option selected="selected" value="<?php if (isset ($_POST['qc'])){ echo $qc;} ?>">Québec </option>  <!-- sélectionné par défaut -->
					<option value="<?php if (isset ($_POST['sas'])){ echo $sas;} ?>">Saskatchewan</option>
					<option value="<?php if (isset ($_POST['tn'])){ echo $tn;} ?>">Terre-Neuve</option>
					<option value="<?php if (isset ($_POST['tno'])){ echo $tno;} ?>">Territoire de Nord-Ouest</option>
					<option value="<?php if (isset ($_POST['yukon'])){ echo $yukon;} ?>">Yukon</option>
				</select>			
			</p>
			
			<p><label for="pays"> Pays </label>
				<input type="text" name="pays" id="pays" placeholder="Canada" value="<?php if (isset ($_POST['pays'])){ echo $pays;} ?>" required  />  
			</p>
		</div>
	<!-- Div pour mettre adresse de livraison si nécessaire à côté de l'autre adresse ou changer pour courriel ???  -->	
	<div class="adresse-livraison">
		<p>Adresse de livraison</p> 
		<form action="<?php the_permalink(); ?>" id="contactForm" method="post" onsubmit="return valider_contact(this);">
		
			<p><label for="nom"> Nom </label>
				<input type="text" name="nom" id="nom" value="<?php if (isset ($_POST['nom'])){ echo $nom;} ?>" required  />   
			</p>

			<p><label for="prenom"> Prénom </label>
				<input type="text" name="prenom" id="prenom" value="<?php if (isset ($_POST['prenom'])){ echo $prenom;} ?>" required  />  
			</p>
			
			<p><label for="adresse"> Adresse </label>
				<input type="text" name="adresse" id="adresse" value="<?php if (isset ($_POST['adresse'])){ echo $adresse;} ?>" required  />  
			</p>
			
			<p><label for="ville"> Ville </label>
				<input type="text" name="ville" id="ville" value="<?php if (isset ($_POST['ville'])){ echo $ville;} ?>" required  />  
			</p>
			
			<p><label for="codepostal"> Code postal </label>
				<input type="text" name="codepostal" id="codepostal" value="<?php if (isset ($_POST['codepostal'])){ echo $codepostal;} ?>" required  />  
			</p>
			
			<p><label for="province"> Province </label>	
				<select class="form-control" type="text" name="province" id="province" required >
					<option value="<?php if (isset ($_POST['alberta'])){ echo $alberta;} ?>">Alberta</option>
					<option value="<?php if (isset ($_POST['cb'])){ echo $cb;} ?>">Colombie-Britanique</option>
					<option value="<?php if (isset ($_POST['ipe'])){ echo $ipe;} ?>">Ile-du-Prince-Édouard</option>
					<option value="<?php if (isset ($_POST['man'])){ echo $man;} ?>">Manitoba</option>
					<option value="<?php if (isset ($_POST['nb'])){ echo $nb;} ?>">Nouveau-Brunswick</option>
					<option value="<?php if (isset ($_POST['ne'])){ echo $ne;} ?>">Nouvelle-Écosse</option>
					<option value="<?php if (isset ($_POST['ont'])){ echo $ont;} ?>">Ontario</option>
					<option selected="selected" value="<?php if (isset ($_POST['qc'])){ echo $qc;} ?>">Québec </option>  <!-- sélectionné par défaut -->
					<option value="<?php if (isset ($_POST['sas'])){ echo $sas;} ?>">Saskatchewan</option>
					<option value="<?php if (isset ($_POST['tn'])){ echo $tn;} ?>">Terre-Neuve</option>
					<option value="<?php if (isset ($_POST['tno'])){ echo $tno;} ?>">Territoire de Nord-Ouest</option>
					<option value="<?php if (isset ($_POST['yukon'])){ echo $yukon;} ?>">Yukon</option>
				</select>			
			</p>
			
			<p><label for="pays"> Pays </label>
				<input type="text" name="pays" id="pays" placeholder="Canada" value="<?php if (isset ($_POST['pays'])){ echo $pays;} ?>" required  />  
			</p>
		</div>	

	<!-- checkbox pour livraison -->
		<div class="form-group">
			<div class="col-sm-offset-2 col-sm-10">
				<div class="checkbox">
					<label>
						<input type="checkbox"> Envoyer le(s) billets à cette adresse
					</label>
				</div>
			</div>
		</div>
		
	</form>

</section>

<!-- Formulaire paiement -->
<section id="paiement">			
	<h2>Paiement</h2>  
	<!-- choix du type de carte -->
	<label class="radio-inline">
		<input type="radio" name="visa" id="visa" value="visa"> Visa
	</label>
	<label class="radio-inline">
		<input type="radio" name="mastercard" id="mastercard" value="mastercard"> Mastercard
	</label>

	<!-- champs pour entrer les infos de la carte -->
	<form>	
		<p><label for="nomdetenteur"> Nom du détenteur </label>
			<input type="text" name="nom_detenteur" id="nomdetenteur" value="<?php if (isset ($_POST['nomdetenteur'])){ echo $nomdetenteur;} ?>" required  />  
		</p>		
		<p><label for="nocarte"> Numéro de la carte </label>
			<input type="text" name="nocarte" id="nocarte" value="<?php if (isset ($_POST['nocarte'])){ echo $nocarte;} ?>" required  />  
		</p>
				<p><label for="expirationcarte"> Expiration </label>
			<input type="text" name="expirationcarte" id="expirationcarte" value="<?php if (isset ($_POST['expirationcarte'])){ echo $expirationcarte;} ?>" required  />  
		</p>
				<p><label for="verifcarte"> No. de vérification </label>
			<input type="text" name="verifcarte" id="verifcarte" value="<?php if (isset ($_POST['verifcarte'])){ echo $verifcarte;} ?>" required  />  
		</p>
	</form>

</section>

<!-- Début du récapitulatif -->
<section id="confirmation"> 
	<h2>Confirmation</h2> 

<!-- POST ou session pour récupérer les infos -->			
	<p>POST ou session pour récupérer les infos??? </p>		
	<p>Bouton soumettre qui va effectuer l'achat, enlever un billet dans la bd et envoyer un courriel de confirmation et valider php</p>
	<p> une autre page sera nécessaire pour afficher la confirmation ou avec un modal ou en ajax??? </p>

	<form action="<?php the_permalink(); ?>" id="contactForm" method="post" onsubmit="return valider_contact(this);">	
		<input type="hidden" name="submitted" id="submitted" value="true" /><button type="submit" class="btn">Commander</button>
	</form>
</section>