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
		<div class="row">
			<div class="col-md-6">
				<!-- PAR COURRIEL -->
				<label for="parCourriel" class="info-condition">
					<input type="radio" name="envoi" id="parCourriel" value="courriel-envoie"/>
					<div><span class="bouton-commentaire">Envoyer les billets par courriel</span></div>
				</label>
				<!-- COURRIEL -->
				<div class="form-group">
					<label for="courriel" class="control-label sr-only">Courriel</label>
					<div class="input-group">
						<span class="input-group-addon">Courriel</span>
						<input class="form-control" type="text" name="courriel" id="courriel" placeholder="Courriel" value="<?php if (isset ($_POST['courriel'])){ echo $courriel;} ?>" required  />
					</div>
				</div>
				<!-- // -->
				<!-- UTILISER LADRESSE DE courriel ecrit plus haut -->
				<label for="sameEmail" class="info-condition">
					<input type="checkbox" name="sameEmail" id="sameEmail" value="sameEmail"/>
					<div><span class="bouton-commentaire">Utiliser l'adresse courriel plus haut</span></div>
				</label>
			</div>
			<div class="col-md-6">
				<!-- PAR LA POSTE -->
				<label class="info-condition" for="parPoste">
					<input type="radio" name="envoi" id="parPoste" value="poste-envoie"/>
					<div><span class="bouton-commentaire">Envoyer les billets par la poste (+ 2.00$)</span></div>
				</label>
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
				<!-- UTILISER LADRESSE DE FACTURATION -->
				<label for="sameAdress" class="info-condition">
					<input type="checkbox" name="sameAdress" id="sameAdress" value="sameAdress"/>
					<div><span class="bouton-commentaire">Utiliser l'adresse de facturation</span></div>
				</label>
			</div>
		</div>
		<input type="hidden" name="etape" id="etape" value="3">
		<input class="btn btn-parenthese btn-achat" type="submit" value="Étape suivante >">
	</form>
</section>