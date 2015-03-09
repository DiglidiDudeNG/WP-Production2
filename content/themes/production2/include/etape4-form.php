<!-- Début du récapitulatif -->
<section id="confirmation"> 
	<h2>Confirmation</h2> 

<!-- POST ou session pour récupérer les infos -->			
	<p>POST ou session pour récupérer les infos??? </p>		
	<p>Bouton soumettre qui va effectuer l'achat, enlever un billet dans la bd et envoyer un courriel de confirmation et valider php</p>
	<p> une autre page sera nécessaire pour afficher la confirmation ou avec un modal ou en ajax??? </p>

	<form action="<?php the_permalink(); ?>" id="formsubmit" method="post" onsubmit="return valider_contact(this);">	
		<input type="hidden" name="submitted" id="submitted" value="true" /><button type="submit" class="btn">Commander</button>
	</form>
</section>