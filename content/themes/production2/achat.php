<?php
/*
Template Name: Achat
*/
?>
<?php get_header(); ?>

	<!-- début du contenu de la page achat.php -->

<div class="container">
	<div class="achat-container">
		<h2>Achat</h2>
		<section class="etapes-achat">
		<?php
			include_once("include/cdt-etape1.php");
			include_once("include/cdt-etape2.php");
			// include_once("include/cdt-etape3.php");
			// include_once("include/cdt-etape4.php");
		?>
		</section>
	</div>
</div>

	<!-- fin du contenu de la page achat.php -->

<?php get_footer(); ?>
