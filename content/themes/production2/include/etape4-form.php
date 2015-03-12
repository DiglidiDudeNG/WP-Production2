<!-- Formulaire resume_commande -->
<section id="resume_commande">
	<div class="col-md-6 col-md-offset-3 etape">
		<div class="rond-etape">4</div>
		<h4>Résumé de la commande</h4>
	</div>
	<!-- POST ou session pour récupérer les infos -->
	<!-- POST ou session pour récupérer les infos???
	Bouton soumettre qui va effectuer l'achat, enlever un billet dans la bd et envoyer un courriel de confirmation et valider php
	une autre page sera nécessaire pour afficher la confirmation ou avec un modal ou en ajax??? -->
	<div class="row bloc-info">
		<!-- COLONNE 1 -->
		<div class="col-md-6">

<!-- test karine j'ai été chercher les infos du etape1-validation.php, à corriger ou mettre un include???-->
<?php
	// Récupération du ID de la prestation
	$id_prestation = trim($_POST['id_prestation']);
	$id_prestation = filter_var($id_prestation, FILTER_SANITIZE_STRING);

	// Récupération du ID du spectacle
	$id_spectacle = trim($_POST['id_spectacle']);
	$id_spectacle = filter_var($id_spectacle, FILTER_SANITIZE_STRING);

	// Sauvegarde des ID dans des variables de session
	$_SESSION['id_prestation'] = $id_prestation;
	$_SESSION['id_spectacle'] = $id_spectacle;
	var_dump ($_SESSION);
	?>



<!-- fin test -->
			
			<h3 style="margin-top: 0px">Informations client</h3>
			<p><?php echo $_SESSION['courriel']?></p><!-- mettre les bonnes variables -->
			<p>
				<?php echo $_SESSION['prenom']?> <?php echo $_SESSION['nom']?><br><!-- mettre les bonnes variables -->
				<?php echo $_SESSION['adresse']?><br><!-- mettre les bonnes variables -->
				<?php echo $_SESSION['ville']?>, <?php echo $_SESSION['province']?>, <?php echo $_SESSION['codepostal']?><br><!-- mettre les bonnes variables -->
				<?php echo $_SESSION['pays']?><!-- mettre les bonnes variables -->
			</p>
			<h3>Paiement</h3>
			<p>Visa XXXX XXXX X234 à récupérer</p><!-- mettre les bonnes variables -->
		</div>
		<div class="col-md-6">
			<div class="table-responsive">
				<table class="table panier-detail panier-detail-resume">
					<thead>
						<tr>
							<th class="panier-item-description-header" colspan="2">Résumé de la commande</th>
						</tr>
					</thead>
					<tbody>
						<tr class="ligne-item">
							<td class="panier-item-description">
								<h3 class="nom-spectacle">CREEDENCE CLEARWATER à venir <?php echo $_SESSION['id_spectacle']?><br><!-- mettre les bonnes variables -->
								<span class="date-spectacle">Vendredi 28 février à 20:00 à venir <?php echo $_SESSION['id_prestation']?></span><br>
								<span><?php echo $_SESSION['nb_billets']?></span></h3>
								<!-- mettre les bonnes variables -->
							</td>
							<td class="panier-item-total">
								<!-- METTRE CONDITION DE PRIX PAR RAPPORT AUX NB DE BILLETS -->
								40.00 $
								<!-- // -->
							</td>
						</tr>
					</tbody>
					<tfoot>
					<tr class="sous-total">
						<td class="label-resume"><strong>Sous-total</strong></td>
						<td><?php echo $_SESSION['sousTotal']?> $</td>
					</tr>
					<tr class="taxes">
						<td class="label-resume"><strong>TVQ 9.975%</strong></td>
						<td>
							<?php echo $_SESSION['spectacle_tvq']?> $
						</td>
					</tr>
					<tr class="taxes">
						<td class="label-resume"><strong>TPS 5.0%</strong></td>
						<td>
							<?php echo $_SESSION['spectacle_tps']?> $
						</td>
					</tr>
					<!-- METTRE CONDITION SI LE CLIENT VEUX PAR LA POSTE -->
					<tr class="shipping">
						<td class="label-resume"><strong>Frais de livraison (+ 2.00 $)</strong></td>
						<td>
							2 $ à calculer
						</td>
					</tr>
					<!-- // -->
					<tr class="total">
						<td class="label-resume label-total">
							<strong>Total</strong>
						</td>
						<td>
							<?php echo $_SESSION['spectacle_gtotal']?> $ +2$ faire la boucle
						</td>
					</tr>
					</tfoot>
				</table>
			</div>
		</div>
	</div>
	<form action="<?php the_permalink(); ?>" id="formsubmit" method="post" onsubmit="return valider_contact(this);">
		<a class="btn btn-parenthese btn-achat" href="">Annuler</a>
		<input type="hidden" name="etape" id="summitted" value="5">
		<input class="btn btn-parenthese btn-achat pull-right" type="submit" value="Commander >">
	</form>
</section>
