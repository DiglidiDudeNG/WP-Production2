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
						<input class="form-control" type="text" name="courriel" id="courriel" placeholder="Courriel" value="<?php if (isset ($_POST['courriel'])){ echo $courriel;} ?>" required  />
					</div>
				</div>
				<!-- NOM -->
				<div class="form-group">
					<label for="nom" class="control-label sr-only">Nom</label>
					<div class="input-group">
						<span class="input-group-addon">Nom</span>
						<input class="form-control" type="text" name="nom" id="nom" placeholder="Nom" value="<?php if (isset ($_POST['nom'])){ echo $nom;} ?>" required  />
					</div>
				</div>
				<!-- Prénom -->
				<div class="form-group">
					<label for="prenom" class="control-label sr-only">Prénom</label>
					<div class="input-group">
						<span class="input-group-addon">Prénom</span>
						<input class="form-control" type="text" name="prenom" id="prenom" placeholder="Prénom" value="<?php if (isset ($_POST['prenom'])){ echo $prenom;} ?>" required  />
					</div>
				</div>
				<!-- ADRESSE -->
				<div class="form-group">
					<label for="adresse" class="control-label sr-only">Adresse</label>
					<div class="input-group">
						<span class="input-group-addon">Adresse</span>
						<input class="form-control" type="text" name="adresse" id="adresse" placeholder="Adresse" value="<?php if (isset ($_POST['adresse'])){ echo $adresse;} ?>" required  />
					</div>
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
						<input class="form-control" type="text" name="codepostal" id="codepostal" placeholder="Code postal" value="<?php if (isset ($_POST['codepostal'])){ echo $codepostal;} ?>" required  />
					</div>
				</div>
				<!-- Ville -->
				<div class="form-group">
					<label for="ville" class="control-label sr-only">Ville</label>
					<div class="input-group">
						<span class="input-group-addon">Ville</span>
						<input class="form-control" type="text" name="ville" id="ville" placeholder="Ville" value="<?php if (isset ($_POST['ville'])){ echo $ville;} ?>" required  />
					</div>
				</div>
				<!-- Province -->
				<div class="form-group">
					<label for="province" class="control-label sr-only">Province</label>
					<div class="input-group">
						<span class="input-group-addon">Province</span>
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
					</div>
				</div>
				<!-- Pays -->
				<div class="form-group">
					<label for="pays" class="control-label sr-only">Pays</label>
					<div class="input-group">
						<span class="input-group-addon">Pays</span>
						<input class="form-control" type="text" name="pays" id="pays" placeholder="Pays" value="<?php if (isset ($_POST['pays'])){ echo $pays;} ?>" required  />
					</div>
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
				<label for="AdresseLivraison" class="info-condition">
					<input type="checkbox" name="AdresseLivraison" id="AdresseLivraison" value="AdresseLivraison"/>
					<div><span class="bouton-commentaire">Utiliser une autre adresse de livraison</span></div>
				</label>

				<!-- NOM -->
				<div class="form-group">
					<label for="noml" class="control-label sr-only">Nom</label>
					<div class="input-group">
						<span class="input-group-addon">Nom</span>
						<input class="form-control" type="text" name="noml" id="noml" placeholder="Nom" value="<?php if (isset ($_POST['noml'])){ echo $noml;} ?>" required  />
					</div>
				</div>
				<!-- Prénom -->
				<div class="form-group">
					<label for="prenoml" class="control-label sr-only">Prénom</label>
					<div class="input-group">
						<span class="input-group-addon">Prénom</span>
						<input class="form-control" type="text" name="prenoml" id="prenoml" placeholder="Prénom" value="<?php if (isset ($_POST['prenoml'])){ echo $prenoml;} ?>" required  />
					</div>
				</div>
				<!-- ADRESSE -->
				<div class="form-group">
					<label for="adressel" class="control-label sr-only">Adresse</label>
					<div class="input-group">
						<span class="input-group-addon">Adresse</span>
						<input class="form-control" type="text" name="adressel" id="adressel" placeholder="Adresse" value="<?php if (isset ($_POST['adressel'])){ echo $adressel;} ?>" required  />
					</div>
				</div>
				<!-- Code postal -->
				<div class="form-group">
					<label for="codepostall" class="control-label sr-only">Code postal</label>
					<div class="input-group">
						<span class="input-group-addon">Code postal</span>
						<input class="form-control" type="text" name="codepostall" id="codepostall" placeholder="Code postal" value="<?php if (isset ($_POST['codepostall'])){ echo $codepostall;} ?>" required  />
					</div>
				</div>
				<!-- Ville -->
				<div class="form-group">
					<label for="villel" class="control-label sr-only">Ville</label>
					<div class="input-group">
						<span class="input-group-addon">Ville</span>
						<input class="form-control" type="text" name="villel" id="villel" placeholder="Ville" value="<?php if (isset ($_POST['villel'])){ echo $villel;} ?>" required  />
					</div>
				</div>
				<!-- Province -->
				<div class="form-group">
					<label for="provincel" class="control-label sr-only">Province</label>
					<div class="input-group">
						<span class="input-group-addon">Province</span>
						<select class="form-control" type="text" name="provincel" id="provincel" required >
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
					</div>
				</div>
				<!-- Pays -->
				<div class="form-group">
					<label for="paysl" class="control-label sr-only">Pays</label>
					<div class="input-group">
						<span class="input-group-addon">Pays</span>
						<input class="form-control" type="text" name="paysl" id="paysl" placeholder="Pays" value="<?php if (isset ($_POST['paysl'])){ echo $paysl;} ?>" required  />
					</div>
				</div>
			</div>
		</div>
		<input type="hidden" name="etape" id="etape" value="3">
		<input class="btn btn-parenthese btn-achat" type="submit" value="Étape suivante >">
	</form>
</section>