<!-- Formulaire resume_commande -->
<section id="resume_commande">
	<div class="col-md-6 col-md-offset-3 etape">
		<div class="rond-etape">4</div>
		<h4>Résumé de la commande</h4>
	</div>
	<!-- 
	Bouton soumettre qui va effectuer l'achat, enlever un billet dans la bd et envoyer un courriel de confirmation et valider php
	une autre page sera nécessaire pour afficher la confirmation ou avec un modal ou en ajax??? -->
	<div class="row bloc-info">
		<!-- COLONNE 1 -->
		<div class="col-md-6">


			
			<h3 style="margin-top: 0px">Informations client</h3>
			<p>
				<?php echo $prenom ?> <?php echo $nom ?><br>
				<?php echo $courriel ?>
			</p>
			<h3>Paiement</h3>
			<p>Visa XXXX XXXX XXXX <?php echo $finCarte; ?></p>
			<h3>Mode de livraison</h3>
			<p><?php echo $modeDeLivraison; ?></p>
			<h3>Adresse de livraison</h3>
			<?php
				if( $modeDeLivraison == "Envoi postal" ){
			?>
					<p>
						<?php echo $prenoml ?> <?php echo $noml ?><br>
						<?php echo $adressel ?><br>
						<?php echo $villel ?>, <?php echo $provincel ?>, <?php echo $codepostall ?><br>
						<?php echo $paysl ?>
					</p>
			<?php
				}
				else{
			?>
					<p><?php echo $courriel; ?></p>
			<?php
				}
			?>
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
								<h3 class="nom-spectacle"><?php echo $spectacle_titre ?><br>
								<span class="date-spectacle"><?php echo $prestation_date ?> à <?php echo $prestation_heure?></span><br>
								<span>Billets : <?php echo $nb_billets?></span></h3>
								
							</td>
							<td class="panier-item-total">
								<?php echo $spectacle_prix ?> $
							</td>
						</tr>
					</tbody>
					<tfoot>
					<tr class="sous-total">
						<td class="label-resume"><strong>Sous-total</strong></td>
						<td><?php echo $sousTotal?> $</td>
					</tr>
					<tr class="taxes">
						<td class="label-resume"><strong>TVQ 9.975%</strong></td>
						<td>
							<?php echo $spectacle_tvq?> $
						</td>
					</tr>
					<tr class="taxes">
						<td class="label-resume"><strong>TPS 5.0%</strong></td>
						<td>
							<?php echo $spectacle_tps?> $
						</td>
					</tr>					
					<tr class="shipping">
						<td class="label-resume"><strong>Frais de livraison</strong></td>
						<td>
							<?php echo $fraisLivraison; ?> $
						</td>
					</tr>					
					<tr class="total">
						<td class="label-resume label-total">
							<strong>Total</strong>
						</td>
						<td>
							<?php echo $spectacle_gtotal?> $
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
