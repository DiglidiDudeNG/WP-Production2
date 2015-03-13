<?php

	/**********************************************
	 * Query pour avoir les infos du spectacles
	 **********************************************/
	wp_reset_postdata();
	$wp_query_spectacles = new WP_Query(
		array(
			'post_type'			=> 'spectacle',
			'posts_per_page' 	=> -1,
			'p'					=> $_SESSION['id_spectacle']
		)
	);

	$wp_query_spectacles->the_post();

	$spectacle_titre = get_the_title();
	$spectacle_prix = get_post_meta( $post->ID, 'rb_spectacle_prix', true );
	$spectacle_image_mini = get_post_meta( $post->ID, 'rb_spectacle_img_mini_url', true);

	$_SESSION['spectacle_titre'] = $spectacle_titre;




	/*******************************************************************
	 * Query pour avoir les infos de la prestation reliée au spectacle
	 *******************************************************************/
	wp_reset_postdata();
	$wp_query_prestations = new WP_Query(
		array(
			'post_type'			=> 'prestation',
			'posts_per_page' 	=> -1,
			'p'					=> $_SESSION['id_prestation']
		)
	);

	$wp_query_prestations->the_post();

	$prestation_date = get_post_meta( $post->ID, 'rb_prestation_date', true );
	$prestation_heure = get_post_meta( $post->ID, 'rb_prestation_heure', true );
	$nb_billets_restants = get_post_meta( $post->ID, 'rb_prestation_nb_billets', true );

	// Set local français-canada
	setlocale(LC_ALL, 'frc', 'fr_CA');

	// Conversion de la string de date de la BD en format time ('d-m-Y')
	$new_date = strtotime($prestation_date);

	// Chaque partie de la date est placée dans une variable
	// strftime doit être utilisé pour le format en français
	$prestation_jourDeSemaine = utf8_encode(strftime("%A", $new_date));
	$prestation_jourDuMois = utf8_encode(strftime("%d", $new_date));
	$prestation_mois_full = utf8_encode(strftime("%B", $new_date));

	$prestation_date = $prestation_jourDeSemaine . ' ' . $prestation_jourDuMois . ' ' . $prestation_mois_full;

	$_SESSION['prestation_date'] = $prestation_date;
	$_SESSION['prestation_heure'] = $prestation_heure;


?>



<?php

	if( !isset($messageErreurNbBillets) ){
		$messageErreurNbBillets = "";
	}

?>

<!-- PARTIE CHLOE >>>> -->
<section class="commande">
	<!-- ÉTAPE 1 -->
	<div class="col-md-6 col-md-offset-3 etape">
		<div class="rond-etape">1</div>
		<h4>Commande</h4>
	</div>
	<form action="<?php echo bloginfo('url'); ?>/achat" method="post">
		<div class="table-responsive">
			<table class="table panier-detail">
				<thead>
					<tr>
						<th class="panier-item-description-header" colspan="2">Items</th>
						<th class="panier-item-prix-header">Prix</th>
						<th class="panier-item-quantite-header">Quantité</th>
						<th class="panier-item-total-header">Total</th>
					</tr>
				</thead>
				<tbody>
					<tr class="ligne-item">
						<td class="panier-item-image">
							<div class="panier-item-image-vignette">
								<img alt="<?php echo $spectacle_titre ?>" src="<?php echo $spectacle_image_mini ?>">
							</div>
						</td>
						<td class="panier-item-description">
							<h3 class="nom-spectacle"><?php echo $spectacle_titre ?><br>
							<span class="date-spectacle"><?php echo $prestation_date ?> à <?php echo $prestation_heure ?></span></h3>
						</td>
						<td class="panier-item-prix"><?php echo $spectacle_prix ?>$</td>
						<td class="panier-item-quantite">
							<input type="number" id="nb_billets" name="nb_billets" min="1" max="<?php echo $nb_billets_restants; ?>"
								<?php
									if( isset($_POST['nb_billets']) ){
										echo 'value="' . $_POST['nb_billets'] . '"';
									}
									else{
										echo 'value="1"';
									}
								?>
							>
						</td>
						<td class="panier-item-total sous-total-text">
							<?php
								if( isset($_POST['nb_billets']) ){
									$sousTotal = $spectacle_prix * $_POST['nb_billets'];
								}
								else{
									$sousTotal = $spectacle_prix * 1;
								}

								$sousTotal = number_format((float)$sousTotal, 2, '.', '');
								echo $sousTotal;
							?>
								$

						</td>
					</tr>
				</tbody>
			</table>

			<p class="erreur"><?php echo $messageErreurNbBillets; ?></p>

		</div>
		<div class="table-responsive">
			<table class="table panier-resume">
				<tbody>
					<tr class="sous-total">
						<td><strong>Sous-total</strong></td>
						<td class="sous-total-text"><?php echo $sousTotal ?>$</td>
					</tr>
					<tr class="taxes">
						<td><strong>TVQ 9.975%</strong></td>
						<td class="tvq-text">
							<?php
								$spectacle_tvq = $sousTotal*0.09975;
								$spectacle_tvq = number_format((float)$spectacle_tvq, 2, '.', '');
								echo $spectacle_tvq;
							?>$
						</td>
					</tr>
					<tr class="taxes">
						<td><strong>TPS 5.0%</strong></td>
						<td class="tps-text">
							<?php
								$spectacle_tps = $sousTotal*0.05;
								$spectacle_tps = number_format((float)$spectacle_tps, 2, '.', '');
								echo $spectacle_tps;
							?>$
						</td>
					</tr>
					<tr class="total">
						<td class="label-total">
							<strong>Total</strong>
						</td>
						<td class="gtotal-text">
							<?php
								$spectacle_gtotal = $sousTotal+$spectacle_tps+$spectacle_tvq;
								$spectacle_gtotal = number_format((float)$spectacle_gtotal, 2, '.', '');
								echo $spectacle_gtotal;
							?>$
						</td>
					</tr>
				</tbody>
			</table>
		</div>

		<a class="btn btn-parenthese btn-achat-2" href="<?php echo home_url(); ?>">Annuler</a>

		<input type="hidden" name="etape" id="etape" value="2">
		<input type="hidden" name="spectacle_prix" value="<?php echo $spectacle_prix; ?>">
		<input class="btn btn-parenthese btn-achat pull-right" type="submit" value="Étape suivante >">
	</form>
</section>


