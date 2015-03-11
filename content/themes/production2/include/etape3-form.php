<!-- Formulaire paiement -->
<section id="paiement">
	<h2>Paiement</h2>
	<form action="<?php echo bloginfo('url'); ?>/achat" method="post" class="form-horizontal" id="paiement_form" name="paiement_form">
		<!-- choix du type de carte -->
		<label class="radio-inline" id="choixcarte">
			<input type="radio" name="choixcarte" id="visa" value="visa" /> Visa
			<input type="radio" name="choixcarte" id="mastercard" value="mastercard" /> Mastercard
		</label>

		<!-- champs pour entrer les infos de la carte -->

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


<?php 
	echo '<pre>';
	var_dump($_SESSION);
	echo '</pre>';
?>