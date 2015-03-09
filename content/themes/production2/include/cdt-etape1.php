<section class="commande">
	<!-- ÉTAPE 1 -->
	<div class="col-md-6 col-md-offset-3 etape">
		<div class="rond-etape">1</div>
		<h4>Commande</h4>
	</div>
	<form action="#" method="post">
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
								<img src="<?php echo IMAGES; ?>/mini-walkOffTheEarth.jpg">
							</div>
						</td>
						<td class="panier-item-description">
							<h3 class="nom-spectacle">Nom de l'artiste<br>
							<span class="date-spectacle">Vendredi 12 février 2015 à 20:00</span></h3>
						</td>
						<td class="panier-item-prix">
							17,50 $
						</td>
						<td class="panier-item-quantite">
							<input type="number" name="qte0" value="">
						</td>
						<td class="panier-item-total">
							52,50 $
						</td>
						<td class="panier-item-delete">
							<i class="fa fa-times"></i>
						</td>
					</tr>
				</tbody>
			</table>
			<table class="table panier-resume">
				<tbody>
					<tr class="sous-total">
						<td colspan="4"><strong>Sous-total</strong></td>
						<td>14,50</td>
					</tr>
					<tr class="taxes">
						<td colspan="4"><strong>TVQ 9.975%</strong></td>
						<td>2,00$</td>
					</tr>
					<tr class="taxes">
						<td colspan="4"><strong>TPS 5.0%</strong></td>
						<td>2,00$</td>
					</tr>
					<tr class="total">
						<td colspan="4" class="label-total">
							<strong>Total</strong>
						</td>
						<td>16,67$</td>
					</tr>
				</tbody>
			</table>
		</div>
	</form>
</section>