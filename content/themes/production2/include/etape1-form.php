<!-- DONNÉE À PRENDRE -->
<!-- 	<ul>
		<li><?php echo $spectacle_titre ?></li>
		<li><?php echo $spectacle_prix ?>$</li>
		<li><?php echo $prestation_date ?></li>
		<li><?php echo $prestation_heure ?></li>
	</ul>
	<form action="<?php echo bloginfo('url'); ?>/achat" method="post">
		<label for="nb_billets">Nombre de billets : </label>
		<input type="text" name="nb_billets" id="nb_billets" value="2">
		<input type="hidden" name="etape" id="etape" value="2">
		<button type="submit" id="vers_etape_2" name="vers_etape_2">Allez à l'étape 2</button>
	</form>
 -->

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
						<th class="panier-item-delete-header"></th>
					</tr>
				</thead>
				<tbody>
					<tr class="ligne-item">
						<td class="panier-item-image">
							<div class="panier-item-image-vignette">
								<!-- METTRE LA VARIABLE DE L'IMAGE -->
								<img src="<?php echo IMAGES; ?>/mini-walkOffTheEarth.jpg">
								<!-- // -->
							</div>
						</td>
						<td class="panier-item-description">
							<h3 class="nom-spectacle"><?php echo $spectacle_titre ?><br>
							<span class="date-spectacle"><?php echo $prestation_date ?> à <?php echo $prestation_heure ?></span></h3>
						</td>
						<td class="panier-item-prix">
							<?php echo $spectacle_prix ?>$
						</td>
						<td class="panier-item-quantite">
							<input type="number" id="nb_billets" name="nb_billets" value="1">
						</td>
						<td class="panier-item-total">
						<!-- METTRE CONDITION DE PRIX PAR RAPPORT AUX NB DE BILLETS -->
							<?php echo $spectacle_prix ?>$
							<!-- // -->
						</td>
						<td class="panier-item-delete">
							<i class="fa fa-times"></i>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
		<div class="table-responsive">
			<table class="table panier-resume">
				<tbody>
					<tr class="sous-total">
						<td colspan="6"><strong>Sous-total</strong></td>
						<td><?php echo $spectacle_prix ?>$</td>
					</tr>
					<tr class="taxes">
						<td colspan="6"><strong>TVQ 9.975%</strong></td>
						<td>
							<?php 
								$spectacle_tvq = $spectacle_prix*0.09975;
								echo round($spectacle_tvq, 2);
						 	?>$
						</td>
					</tr>
					<tr class="taxes">
						<td colspan="6"><strong>TPS 5.0%</strong></td>
						<td>
							<?php 
								$spectacle_tps = $spectacle_prix*0.05;
								echo round($spectacle_tps, 2);
						 	?>$
						</td>
					</tr>
					<tr class="total">
						<td colspan="6" class="label-total">
							<strong>Total</strong>
						</td>
						<td>
							<?php 
								$spectacle_gtotal = $spectacle_prix+$spectacle_tps+$spectacle_tvq;
								echo round($spectacle_gtotal, 2);
						 	?>$
						</td>
					</tr>
				</tbody>
			</table>
		</div>
		<input type="hidden" name="etape" id="etape" value="2">
		<input class="btn btn-parenthese btn-achat" type="submit" value="Étape suivante >">
	</form>
</section>