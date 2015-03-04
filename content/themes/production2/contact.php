<?php
/*
Template Name: Contact
*/
?>
<?php get_header(); 
?>


<!-- Début de la page contact -->
<section id="contact">
	<div class="container">
		<h2>Contact</h2>
		<div class="row contact-adresse">
			<div class="col-sm-4 col-xsm-6 text-center">
				<i class="fa fa-automobile fa-first"></i>
				<address>
					<p class="contact-titre"><strong>Adresse</strong></p>
					<p>987 avenue Cartier</p>
					<p>Québec (Québec) G1F 5T6</p>
				</address>
			</div>
			
			<div class="col-sm-4 col-xsm-6 text-center">
				<i class="fa fa-phone"></i>
				<p class="contact-titre"><strong>Coordonées</strong></p>
				<p>(418) 123 4567 </p>
				<a href="mailto:info@salleperenthese.com"><p>info@salleperenthese.com</p></a>
			</div>
			
			<div class="col-sm-4 col-xsm-6 text-center">
				<i class="fa fa-clock-o"></i>
				<p class="contact-titre"><strong>Heures d'ouverture</strong></p>
				<p>Lundi au vendredi: 8h à 22h</p>
				<p>Samedi & dimanche: 8h à 23h</p>
			</div>
		</div>
		<div class="google-maps">
			<iframe class="text-center" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1365.495651613675!2d-71.22683106928797!3d46.80447721704898!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x4cb896794d9a648d%3A0x33bec377fab7ba92!2s987+Avenue+Cartier%2C+Qu%C3%A9bec%2C+QC+G1R+2S2!5e0!3m2!1sfr!2sca!4v1425324474900" width="600" height="400" frameborder="0" style="border:0"></iframe>
		</div>		
	</div>
</section>
	<!-- fin du contenu de la page contact.php -->

<?php get_footer(); ?>
