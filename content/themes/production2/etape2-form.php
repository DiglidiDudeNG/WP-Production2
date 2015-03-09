


<!-- Début du formulaire -->
<section id="information-client"> 
	<h2>Informations client</h2> 

<!-- formulaire courriel -->			
	
	<form class="form-horizontal" action="" method="post">
		<div class="form-group">
			<label for="courriel" class="col-sm-2 control-label">Courriel</label>
			<div class="col-sm-10">
				<input type="email" class="form-control" id="courriel" placeholder="Courriel">
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
		<form action="<?php the_permalink(); ?>" id="facturationform" method="post" onsubmit="return valider_contact(this);">
		
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
		<form action="<?php the_permalink(); ?>" id="livraisonform" method="post" onsubmit="return valider_contact(this);">
		
			<p><label for="noml"> Nom </label>
				<input type="text" name="noml" id="noml" value="<?php if (isset ($_POST['noml'])){ echo $noml;} ?>" required  />   
			</p>

			<p><label for="prenoml"> Prénom </label>
				<input type="text" name="prenoml" id="prenoml" value="<?php if (isset ($_POST['prenoml'])){ echo $prenoml;} ?>" required  />  
			</p>
			
			<p><label for="adressel"> Adresse </label>
				<input type="text" name="adressel" id="adressel" value="<?php if (isset ($_POST['adressel'])){ echo $adressel;} ?>" required  />  
			</p>
			
			<p><label for="villel"> Ville </label>
				<input type="text" name="villel" id="villel" value="<?php if (isset ($_POST['villel'])){ echo $villel;} ?>" required  />  
			</p>
			
			<p><label for="codepostall"> Code postal </label>
				<input type="text" name="codepostall" id="codepostall" value="<?php if (isset ($_POST['codepostall'])){ echo $codepostall;} ?>" required  />  
			</p>
			
			<p><label for="provincel"> Province </label>	
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
			</p>
			
			<p><label for="paysl"> Pays </label>
				<input type="text" name="paysl" id="paysl" placeholder="Canada" value="<?php if (isset ($_POST['paysl'])){ echo $paysl;} ?>" required  />  
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