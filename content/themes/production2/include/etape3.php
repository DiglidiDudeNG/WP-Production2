
<!-- Formulaire paiement -->
<section id="paiement">			
	<h2>Paiement</h2>  
	
	<label class="radio-inline">
		<input type="radio" name="visa" id="visa" value="visa"> Visa
	</label>
	<label class="radio-inline">
		<input type="radio" name="mastercard" id="mastercard" value="mastercard"> Mastercard
	</label>


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
