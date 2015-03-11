<!-- ÉTAPE 2 -->
<section id="paiement">
	<div class="col-md-6 col-md-offset-3 etape">
		<div class="rond-etape">3</div>
		<h4>Paiement</h4>
	</div>

	<form action="<?php echo bloginfo('url'); ?>/achat" method="post" class="" id="paiement_form" name="paiement_form">
		<div class="row">
			<div class="col-md-6 col-md-offset-3">
				<div class="carte-width">
					<label class="info-condition" for="visa">
						<input type="radio" class="info-condition" for="visa" name="carte" id="visa" value="visa"/>
						<div><span class="bouton-commentaire"><img class="push-card" alt="visa" src="<?php echo IMAGES; ?>/credit-card/visa-icon.svg">Visa</span></div>
					</label>
				</div>
				<div class="carte-width">
					<label class="info-condition" for="master">
						<input type="radio" class="info-condition" for="master" name="carte" id="master" value="master"/>
						<div><span class="bouton-commentaire"><img class="push-card" alt="mastercard" src="<?php echo IMAGES; ?>/credit-card/master-icon.svg">Mastercard</span></div>
					</label>
				</div>
				<span class="erreur messageErreurChoixcarte"><?php echo $messageErreurChoixcarte; ?></span>
				<!-- champs pour entrer les infos de la carte -->
			
				<!-- numéro de la carte -->
				<div class="form-group">
					<label for="nocarte" class="control-label sr-only">Numéro de la carte</label>
					<div class="input-group">
						<span class="input-group-addon">Numéro de la carte</span>
						<input class="form-control" type="text" name="nocarte" class="carte" id="nocarte" placeholder="Numéro de la carte" value="<?php if (isset ($_POST['nocarte'])){ echo $nocarte;} ?>" required  />
					</div>
					<span class="erreur messageErreurNocarte"><?php echo $messageErreurNocarte; ?></span>
				</div>
				<!-- NOM DU DÉTENTEUR -->
				<div class="form-group">
					<label for="nomdetenteur" class="control-label sr-only">Nom du détenteur</label>
					<div class="input-group">
						<span class="input-group-addon">Nom du détenteur</span>
						<input class="form-control" type="text" name="nomdetenteur" class="carte" id="nomdetenteur" placeholder="Nom du détenteur" value="<?php if (isset ($_POST['nomdetenteur'])){ echo $nomdetenteur;} ?>" required  />
					</div>
					<span class="erreur messageErreurNomdetenteur"><?php echo $messageErreurNomdetenteur; ?></span>
				</div>
				<!-- date dexpiration -->
				<div class="form-group">
					<label for="expirationcarte" class="control-label sr-only">Date d'expériration</label>
					<div class="input-group">
						<span class="input-group-addon">Date d'expériration</span>
						<input style="width: 95px" class="form-control" type="text" name="expirationmois" class="carte" id="expirationmois" placeholder="Mois" value="<?php if (isset ($_POST['expirationmois'])){ echo $expirationmois;} ?>" required  />
						<input style="width: 95px" class="form-control" type="text" name="expirationannee" class="carte" id="expirationcarte" placeholder="Année" value="<?php if (isset ($_POST['expirationannee'])){ echo $expirationannee;} ?>" required  />
					</div>
					<span class="erreur messageErreurExpcarte"><?php echo $messageErreurExpcarte; ?></span>
				</div>
				<!-- numéro de vérification -->
				<div class="form-group">
					<label for="verifcarte" class="control-label sr-only">No. de vérification</label>
					<div class="input-group">
						<span class="input-group-addon">No. de vérification</span>
						<input  class="form-control" type="text" name="verifcarte" class="carte" id="verifcarte" placeholder="No. de vérification" value="<?php if (isset ($_POST['verifcarte'])){ echo $verifcarte;} ?>" required  />
					</div>
					<span class="erreur messageErreurNoverif"><?php echo $messageErreurNoverif; ?></span>
				</div>
				<!-- // -->
			</div>
		</div>
		<!-- Mettre l'adresse de départ du site -->
		<a class="btn btn-parenthese btn-achat" href="">Annuler</a>
		<input type="hidden" name="etape" id="etape" value="3">
		<input class="btn btn-parenthese btn-achat pull-right" type="submit" value="Étape suivante >">
	</form>
</section>