<!-- Formulaire resume_commande -->
<section id="resume_commande">
	<h2>Résumé de la commande</h2>

<!-- POST ou session pour récupérer les infos -->
	<!-- POST ou session pour récupérer les infos???
	Bouton soumettre qui va effectuer l'achat, enlever un billet dans la bd et envoyer un courriel de confirmation et valider php
	 une autre page sera nécessaire pour afficher la confirmation ou avec un modal ou en ajax??? -->

	<div class="row">
		<!-- COLONNE 1 -->
		<div class="col-md-6">
			<h3>Informations client</h3>
			<p>chloedrolettremblay@gmail.com</p>
			<p>
				Chloe Drolet-Tremblay <br>
				992 avenue Casot<br>
				Quebec,Quebec,G1S 2Y1<br>
				Canada
			</p>
			<h3>Paiement</h3>
			<p>Visa XXXX XXXX X234</p>
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
							<h3 class="nom-spectacle">CREEDENCE CLEARWATER<br>
							<span class="date-spectacle">Vendredi 28 février à 20:00</span></h3>
						</td>
						<td class="panier-item-total">
							<!-- METTRE CONDITION DE PRIX PAR RAPPORT AUX NB DE BILLETS -->
							40.00 $
							<!-- // -->
						</td>
					</tr>
				</tbody>
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