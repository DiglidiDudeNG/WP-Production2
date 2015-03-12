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
			<h3 style="margin-top: 0px">Informations client</h3>
			<p>chloedrolettremblay@gmail.com</p><!-- mettre les bonnes variables -->
			<p>
				Chloe Drolet-Tremblay <br><!-- mettre les bonnes variables -->
				992 avenue Casot<br><!-- mettre les bonnes variables -->
				Quebec,Quebec,G1S 2Y1<br><!-- mettre les bonnes variables -->
				Canada<!-- mettre les bonnes variables -->
			</p>
			<h3>Paiement</h3>
			<p>Visa XXXX XXXX X234</p><!-- mettre les bonnes variables -->
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
								<h3 class="nom-spectacle">CREEDENCE CLEARWATER<br><!-- mettre les bonnes variables -->
								<span class="date-spectacle">Vendredi 28 février à 20:00</span><br>
								<span>x2</span></h3>
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
						<td><?php //echo $spectacle_prix ?>$</td>
					</tr>
					<tr class="taxes">
						<td class="label-resume"><strong>TVQ 9.975%</strong></td>
						<td>
							<?php
								//$spectacle_tvq = $spectacle_prix*0.09975;
								//echo round($spectacle_tvq, 2);
							?> $
						</td>
					</tr>
					<tr class="taxes">
						<td class="label-resume"><strong>TPS 5.0%</strong></td>
						<td>
							<?php
								//$spectacle_tps = $spectacle_prix*0.05;
								//echo round($spectacle_tps, 2);
							?> $
						</td>
					</tr>
					<!-- METTRE CONDITION SI LE CLIENT VEUX PAR LA POSTE -->
					<tr class="shipping">
						<td class="label-resume"><strong>Frais de livraison (+ 2.00 $)</strong></td>
						<td>
							2 $
						</td>
					</tr>
					<!-- // -->
					<tr class="total">
						<td class="label-resume label-total">
							<strong>Total</strong>
						</td>
						<td>
							<?php
								//$spectacle_gtotal = $spectacle_prix+$spectacle_tps+$spectacle_tvq;
								//echo round($spectacle_gtotal, 2);
							?> $
						</td>
					</tr>
					</tfoot>
				</table>
			</div>
		</div>
	</div>
	<form action="<?php the_permalink(); ?>" id="formsubmit" method="post" onsubmit="return valider_contact(this);">
		<a class="btn btn-parenthese btn-achat" href="">Annuler</a>
		<input type="hidden" name="summitted" id="summitted" value="true">
		<input class="btn btn-parenthese btn-achat pull-right" type="submit" value="Commander >">
	</form>
</section>