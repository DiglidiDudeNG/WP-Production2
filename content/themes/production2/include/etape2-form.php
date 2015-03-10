<?php
	
	/** 
	 * Si les variables de messages d'erreur ne sont pas initialisées,
	 * on les initialise avec des strings vides
	 */
	if( !isset($messageErreurCourriel) ) 		{ $messageErreurCourriel=""; }
	if( !isset($messageErreurNom) ) 			{ $messageErreurNom=""; }
	if( !isset($messageErreurPrenom) ) 			{ $messageErreurPrenom=""; }
	if( !isset($messageErreurAdresse) ) 		{ $messageErreurAdresse=""; }
	if( !isset($messageErreurVille) ) 			{ $messageErreurVille=""; }
	if( !isset($messageErreurCodepostal) ) 		{ $messageErreurCodepostal=""; }
	if( !isset($messageErreurProvince) ) 		{ $messageErreurProvince=""; }
	if( !isset($messageErreurPays) ) 			{ $messageErreurPays=""; }	
	if( !isset($messageErreurEnvoi) ) 			{ $messageErreurEnvoi=""; }


	if( !isset($messageErreurNoml) ) 			{ $messageErreurNoml=""; }
	if( !isset($messageErreurPrenoml) ) 		{ $messageErreurPrenoml=""; }
	if( !isset($messageErreurAdressel) ) 		{ $messageErreurAdressel=""; }
	if( !isset($messageErreurVillel) ) 			{ $messageErreurVillel=""; }
	if( !isset($messageErreurCodepostall) ) 	{ $messageErreurCodepostall=""; }
	if( !isset($messageErreurProvincel) ) 		{ $messageErreurProvincel=""; }
	if( !isset($messageErreurPaysl) ) 			{ $messageErreurPaysl=""; }

?>




<!-- ÉTAPE 2 -->
<section id="information-client">
	<div class="col-md-6 col-md-offset-3 etape">
		<div class="rond-etape">2</div>
		<h4>Information client</h4>
	</div>




	<!-- fomulaire #1 -->
	<!-- partie de l'information du client -->
	<form action="<?php echo bloginfo('url'); ?>/achat" method="post" class="" id="infos_clients_form" name="infos_clients_form" onsubmit="return valider_contact(this);" >
		<div class="row">
			<!-- COLONNE 1 -->
			<div class="col-md-6">
				<!-- COURRIEL -->
				<div class="form-group">
					<label for="courriel" class="control-label sr-only">Courriel</label>
					<div class="input-group">
						<span class="input-group-addon">Courriel</span>
						<input class="form-control" type="email" name="courriel" id="courriel" placeholder="Courriel" value="<?php if (isset ($_POST['courriel'])){ echo $courriel;} ?>" required  />
					</div>
					<span class="erreur messageErreurCourriel"><?php echo $messageErreurCourriel; ?></span>
				</div>
				<!-- NOM -->
				<div class="form-group">
					<label for="nom" class="control-label sr-only">Nom</label>
					<div class="input-group">
						<span class="input-group-addon">Nom</span>
						<input class="form-control" type="text" name="nom" id="nom" placeholder="Nom" value="<?php if (isset ($_POST['nom'])){ echo $nom;} ?>"   />
					</div>
					<span class="erreur messageErreurNom"><?php echo $messageErreurNom; ?></span>
				</div>
				<!-- Prénom -->
				<div class="form-group">
					<label for="prenom" class="control-label sr-only">Prénom</label>
					<div class="input-group">
						<span class="input-group-addon">Prénom</span>
						<input class="form-control" type="text" name="prenom" id="prenom" placeholder="Prénom" value="<?php if (isset ($_POST['prenom'])){ echo $prenom;} ?>"   />
					</div>
					<span class="erreur messageErreurPrenom"><?php echo $messageErreurPrenom; ?></span>
				</div>
				<!-- ADRESSE -->
				<div class="form-group">
					<label for="adresse" class="control-label sr-only">Adresse</label>
					<div class="input-group">
						<span class="input-group-addon">Adresse</span>
						<input class="form-control" type="text" name="adresse" id="adresse" placeholder="Adresse" value="<?php if (isset ($_POST['adresse'])){ echo $adresse;} ?>"   />
					</div>
					<span class="erreur messageErreurAdresse"><?php echo $messageErreurAdresse; ?></span>
				</div>
			</div>
			<!-- // -->
			<!-- COLONNE 2 -->
			<div class="col-md-6">
				<!-- Code postal -->
				<div class="form-group">
					<label for="codepostal" class="control-label sr-only">Code postal</label>
					<div class="input-group">
						<span class="input-group-addon">Code postal</span>
						<input class="form-control" type="text" name="codepostal" id="codepostal" placeholder="Code postal" value="<?php if (isset ($_POST['codepostal'])){ echo $codepostal;} ?>"   />
					</div>
					<span class="erreur messageErreurCodepostal"><?php echo $messageErreurCodepostal; ?></span>
				</div>
				<!-- Ville -->
				<div class="form-group">
					<label for="ville" class="control-label sr-only">Ville</label>
					<div class="input-group">
						<span class="input-group-addon">Ville</span>
						<input class="form-control" type="text" name="ville" id="ville" placeholder="Ville" value="<?php if (isset ($_POST['ville'])){ echo $ville;} ?>"   />
					</div>
					<span class="erreur messageErreurVille"><?php echo $messageErreurVille; ?></span>
				</div>
				<!-- Province -->
				<div class="form-group">
					<label for="province" class="control-label sr-only">Province</label>
					<div class="input-group">
						<span class="input-group-addon">Province</span>
						<select class="form-control" type="text" name="province" id="province"  >
							<option value="alberta">Alberta</option>
							<option value="cb">Colombie-Britanique</option>
							<option value="ipe">Ile-du-Prince-Édouard</option>
							<option value="man">Manitoba</option>
							<option value="nb">Nouveau-Brunswick</option>
							<option value="ne">Nouvelle-Écosse</option>
							<option value="ont">Ontario</option>
							<option selected="selected" value="qc">Québec </option>  <!-- sélectionné par défaut -->
							<option value="sas">Saskatchewan</option>
							<option value="tn">Terre-Neuve</option>
							<option value="tno">Territoire de Nord-Ouest</option>
							<option value="yuk">Yukon</option>
						</select>
					</div>
					<span class="erreur messageErreurProvince"><?php echo $messageErreurProvince; ?></span>
				</div>
				<!-- Pays -->
				<div class="form-group">
					<label for="pays" class="control-label sr-only">Pays</label>
					<div class="input-group">
						<span class="input-group-addon">Pays</span>
						<input class="form-control" type="text" name="pays" id="pays" placeholder="Pays" value="<?php if (isset ($_POST['pays'])){ echo $pays;} ?>"   />
					</div>
					<span class="erreur messageErreurPays"><?php echo $messageErreurPays; ?></span>
				</div>
			</div>
			<!-- // -->
		</div>
		<!-- fomulaire #2 -->
		<div class="row">
			<div class="col-md-6">
				<!-- PAR COURRIEL -->
				<label for="parCourriel" class="info-condition">
					<input type="radio" name="envoi" id="parCourriel" value="courriel-envoie"/>
					<div><span class="bouton-commentaire">Envoyer les billets par courriel</span></div>
				</label>
				<p class="erreur messageErreurEnvoi"><?php echo $messageErreurEnvoi; ?></p>
				<!-- // -->
			</div>
			<div class="col-md-6">
				<!-- PAR LA POSTE -->
				<!-- METTRE LA CONDITION DE FAIRE APPARAITRE LE bouton pour adresse differente -->
				<label class="info-condition" for="parPoste">
					<input type="radio" name="envoi" id="parPoste" value="poste-envoie"/>
					<div><span class="bouton-commentaire">Envoyer les billets par la poste (+ 2.00$)</span></div>
				</label>

				<!-- UTILISER LADRESSE PLUS HAUT -->
				<!-- METTRE LA CONDITION DE FAIRE APPARAITRE LE FORMULAIRE SI LADRESSE EST DIFFÉRENTE DE PLUS HAUT -->

				<div class="adresseLivraisonDifferenteWrapper" style="display: none;">
					<label for="AdresseLivraison" class="info-condition">
						<input type="checkbox" name="AdresseLivraison" id="AdresseLivraison" value="AdresseLivraison"/>
						<div><span class="bouton-commentaire">Utiliser une autre adresse de livraison</span></div>
					</label>
				</div>



				<div class="formLivraisonWrapper" style="display: none;">
					<!-- NOM -->
					<div class="form-group">
						<label for="noml" class="control-label sr-only">Nom</label>
						<div class="input-group">
							<span class="input-group-addon">Nom</span>
							<input class="form-control" type="text" name="noml" id="noml" placeholder="Nom" value="<?php if (isset ($_POST['noml'])){ echo $noml;} ?>"   />
						</div>
						<span class="erreur messageErreurNoml"><?php echo $messageErreurNoml; ?></span>
					</div>
					
					<!-- Prénom -->
					<div class="form-group">
						<label for="prenoml" class="control-label sr-only">Prénom</label>
						<div class="input-group">
							<span class="input-group-addon">Prénom</span>
							<input class="form-control" type="text" name="prenoml" id="prenoml" placeholder="Prénom" value="<?php if (isset ($_POST['prenoml'])){ echo $prenoml;} ?>"   />
						</div>
						<span class="erreur messageErreurPrenoml"><?php echo $messageErreurPrenoml; ?></span> 
					</div>
					<!-- ADRESSE -->
					<div class="form-group">
						<label for="adressel" class="control-label sr-only">Adresse</label>
						<div class="input-group">
							<span class="input-group-addon">Adresse</span>
							<input class="form-control" type="text" name="adressel" id="adressel" placeholder="Adresse" value="<?php if (isset ($_POST['adressel'])){ echo $adressel;} ?>"   />
						</div>
						<span class="erreur messageErreurAdressel"><?php echo $messageErreurAdressel; ?></span>
					</div>
					<!-- Code postal -->
					<div class="form-group">
						<label for="codepostall" class="control-label sr-only">Code postal</label>
						<div class="input-group">
							<span class="input-group-addon">Code postal</span>
							<input class="form-control" type="text" name="codepostall" id="codepostall" placeholder="Code postal" value="<?php if (isset ($_POST['codepostall'])){ echo $codepostall;} ?>"   />
						</div>
						<span class="erreur messageErreurCodepostall"><?php echo $messageErreurCodepostall; ?></span>
					</div>
					<!-- Ville -->
					<div class="form-group">
						<label for="villel" class="control-label sr-only">Ville</label>
						<div class="input-group">
							<span class="input-group-addon">Ville</span>
							<input class="form-control" type="text" name="villel" id="villel" placeholder="Ville" value="<?php if (isset ($_POST['villel'])){ echo $villel;} ?>"   />
						</div>
						<span class="erreur messageErreurVillel"><?php echo $messageErreurVillel; ?></span>
					</div>
					<!-- Province -->
					<div class="form-group">
						<label for="provincel" class="control-label sr-only">Province</label>
						<div class="input-group">
							<span class="input-group-addon">Province</span>
							<select class="form-control" type="text" name="provincel" id="provincel"  >
								<option value="alberta">Alberta</option>
								<option value="cb">Colombie-Britanique</option>
								<option value="ipe">Ile-du-Prince-Édouard</option>
								<option value="man">Manitoba</option>
								<option value="nb">Nouveau-Brunswick</option>
								<option value="ne">Nouvelle-Écosse</option>
								<option value="ont">Ontario</option>
								<option selected="selected" value="qc">Québec </option>  <!-- sélectionné par défaut -->
								<option value="sas">Saskatchewan</option>
								<option value="tn">Terre-Neuve</option>
								<option value="tno">Territoire de Nord-Ouest</option>
								<option value="yuk">Yukon</option>
							</select>
						</div>
						<span class="erreur messageErreurProvincel"><?php echo $messageErreurProvincel; ?></span>
					</div>
					<!-- Pays -->
					<div class="form-group">
						<label for="paysl" class="control-label sr-only">Pays</label>
						<div class="input-group">
							<span class="input-group-addon">Pays</span>
							<input class="form-control" type="text" name="paysl" id="paysl" placeholder="Pays" value="<?php if (isset ($_POST['paysl'])){ echo $paysl;} ?>"   />
						</div>
						<span class="erreur messageErreurPaysl"><?php echo $messageErreurPaysl; ?></span>
					</div>
					<span class="erreur messageErreurPaysl"></span>
				</div>




			</div>
		</div>
		<!-- Mettre l'adresse de départ du site -->
		<a class="btn btn-parenthese btn-achat" href="">Annuler</a>
		<input type="hidden" name="etape" id="etape" value="3">
		<input class="btn btn-parenthese btn-achat pull-right" type="submit" value="Étape suivante >">
	</form>
</section>