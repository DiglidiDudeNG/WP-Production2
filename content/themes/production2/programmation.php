<?php
/*
Template Name: Programmation
*/
?>
<?php get_header(); ?>

	<!-- début du contenu de la page programmation.php -->




	<p>kawabunga</p>
	<p></p>
	<p></p>
	<p></p>

	<!-- C'EST ICI QU'ON MET LA VIANDE ;) -->


	<!-- Affichage des 10 spectacles à venir -->

	<div class="spectacles-a-venir-container">
		<h2>Programmation (ceci est le titre de la section)</h2>



		<form action="<?php bloginfo('url') ?>/programmation">
			<select name="" id="">
				<option value="1">Janvier</option>
				<option value="2">Février</option>
				<option value="3">Mars</option>
				<option value="4">Avril</option>
				<option value="5">Mai</option>
				<option value="6">Juin</option>
				<option value="7">Juillet</option>
				<option value="8">Août</option>
				<option value="9">Septembre</option>
				<option value="10">Octobre</option>
				<option value="11">Novembre</option>
				<option value="12">Décembre</option>
			</select>
		</form>



		<div class="row">

			<?php				
			
				wp_reset_postdata();									
				$args = array(
					'posts_per_page'	=> -1,
					'post_type' 		=> 'prestation',
					'order'				=> 'ACS',
					'order_by'			=> 'meta_value',
					'meta_key'       	=> 'rb_prestation_date'
				);
				$wp_query_prestations = new WP_Query($args);

				/**
				 * Chargement du template de la loop d'affichage des spectacles.
				 * Les paramètres d'affichage sont définis ci-haut, dépendement de la page chargée
				 */
				include(locate_template("loopprestations.php"));

			?>
		</div>

	</div>
									  
 
	


	<!-- fin du contenu de la page index.php -->



<?php get_footer(); ?>
