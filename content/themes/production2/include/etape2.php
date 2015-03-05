
			
<!-- D�but du formulaire -->
<section id="information-client"> 
	<h2>Informations client</h2> 

<!-- formulaire courriel -->			
	
	<form class="form-horizontal">
		<div class="form-group">
		
			<p><label for="nom"> Nom </label>
				<input type="text" name="nom" id="nom" value="<?php if (isset ($_POST['nom'])){ echo $nom;} ?>" required  />   
			</p>

			<p><label for="prenom"> Pr�nom </label>
				<input type="text" name="prenom" id="prenom" value="<?php if (isset ($_POST['prenom'])){ echo $prenom;} ?>" required  />  
			</p>
		
			<label for="inputEmail3" class="col-sm-2 control-label">Courriel</label>
			<div class="col-sm-10">
				<input type="email" class="form-control" id="inputEmail3" placeholder="Courriel">
			</div>
		</div>
		<div class="form-group">
			<div class="col-sm-offset-2 col-sm-10">
				<div class="checkbox">
					<label>
						<input type="checkbox"> Envoyer le(s) billets � cette adresse courriel
					</label>
				</div>
			</div>
		</div>
	</form>

<!-- Formulaire adresse -->
	
	<h2>Adresse de facturation</h2> 

	<form action="<?php the_permalink(); ?>" id="contactForm" method="post" onsubmit="return valider_contact(this);">
		
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
				<option value="<?php if (isset ($_POST['ipe'])){ echo $ipe;} ?>">Ile-du-Prince-�douard</option>
				<option value="<?php if (isset ($_POST['man'])){ echo $man;} ?>">Manitoba</option>
				<option value="<?php if (isset ($_POST['nb'])){ echo $nb;} ?>">Nouveau-Brunswick</option>
				<option value="<?php if (isset ($_POST['ne'])){ echo $ne;} ?>">Nouvelle-�cosse</option>
				<option value="<?php if (isset ($_POST['ont'])){ echo $ont;} ?>">Ontario</option>
				<option selected="selected" value="<?php if (isset ($_POST['qc'])){ echo $qc;} ?>">Qu�bec </option>  <!-- s�lectionn� par d�faut -->
				<option value="<?php if (isset ($_POST['sas'])){ echo $sas;} ?>">Saskatchewan</option>
				<option value="<?php if (isset ($_POST['tn'])){ echo $tn;} ?>">Terre-Neuve</option>
				<option value="<?php if (isset ($_POST['tno'])){ echo $tno;} ?>">Territoire de Nord-Ouest</option>
				<option value="<?php if (isset ($_POST['yukon'])){ echo $yukon;} ?>">Yukon</option>
			</select>			
		</p>
		
		<p><label for="pays"> Pays </label>
			<input type="text" name="pays" id="pays" placeholder="Canada" value="<?php if (isset ($_POST['pays'])){ echo $pays;} ?>" required  />  
		</p>
		
		<div class="form-group">
			<div class="col-sm-offset-2 col-sm-10">
				<div class="checkbox">
					<label>
						<input type="checkbox"> Envoyer le(s) billets � cette adresse
					</label>
				</div>
			</div>
		</div>
		
		<input type="hidden" name="submitted" id="submitted" value="true" /><button type="submit" class="btn">�tape suivante</button>

	</form>




</section>
