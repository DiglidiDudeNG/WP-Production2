<?php get_header(); ?>
<?php
/**
* index.php
*
* Project: wp-production2
* User:    Félix Dion Robidoux
* Date:    10/02/2015
* Time:    9:28 AM
*/
?>
<!-- début du contenu de la page index.php -->
<?php
	include_once("include/caroussel.php");
?>
<!-- C'EST ICI QU'ON MET LA VIANDE ;) -->
<div class="container">
	<!-- Affichage des 12 spectacles à venir -->
	<div class="spectacles-a-venir-container">
		<h2>Spectacles à venir</h2>
		<div class="row">
			<?php
				wp_reset_postdata();
				$args = array(
						'posts_per_page'	=> 12,
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