<?php
/*
Template Name: Programmation
*/
?>
<?php get_header(); ?>

	<!-- début du contenu de la page programmation.php -->

	<!-- C'EST ICI QU'ON MET LA VIANDE ;) -->

<div class="container">
	<div class="spectacles-a-venir-container">
		<h2>Programmation</h2>

		<ul>
			<li><a href="<?php bloginfo('url') ?>/programmation?selection_mois=01">Janvier</a></li>
			<li><a href="<?php bloginfo('url') ?>/programmation?selection_mois=02">Février</a></li>
			<li><a href="<?php bloginfo('url') ?>/programmation?selection_mois=03">Mars</a></li>
			<li><a href="<?php bloginfo('url') ?>/programmation?selection_mois=04">Avril</a></li>
			<li><a href="<?php bloginfo('url') ?>/programmation?selection_mois=05">Mai</a></li>
			<li><a href="<?php bloginfo('url') ?>/programmation?selection_mois=06">Juin</a></li>
			<li><a href="<?php bloginfo('url') ?>/programmation?selection_mois=07">Juillet</a></li>
			<li><a href="<?php bloginfo('url') ?>/programmation?selection_mois=08">Août</a></li>
			<li><a href="<?php bloginfo('url') ?>/programmation?selection_mois=09">Septembre</a></li>
			<li><a href="<?php bloginfo('url') ?>/programmation?selection_mois=10">Octobre</a></li>
			<li><a href="<?php bloginfo('url') ?>/programmation?selection_mois=11">Novembre</a></li>
			<li><a href="<?php bloginfo('url') ?>/programmation?selection_mois=12">Décembre</a></li>
		</ul>

		<ul>
		<?php
			$args = array(
				'orderby' => 'name',
				'order' => 'ASC'
			);

			$categories = get_categories($args);

			foreach($categories as $category) { 
		    	echo '<li>
						<a href="' . get_bloginfo('url') . '/programmation?selection_categorie=' . $category->name . '">' . $category->name . '</a>
					</li>';
		    }
		?>


		<!-- <ul>
		
			<li>
				<a href="<?php bloginfo('url') ?>/programmation?selection_categorie=<?php echo $category->name ?>"><?php echo $category->name ?></a>
			</li>
			<li><a href="<?php bloginfo('url') ?>/programmation?selection_categorie=folk">Folk</a></li>
			<li><a href="<?php bloginfo('url') ?>/programmation?selection_categorie=alternatif">Alternatif</a></li> -->
		</ul>

		


		



		<div class="row">

			<?php

				wp_reset_postdata();

				if(isset( $_GET['selection_mois']) ){

					$month = $_GET['selection_mois'];

					$args = array(
						'posts_per_page'	=> -1,
						'post_type' 		=> 'prestation',
						'order'				=> 'ACS',
						'order_by'			=> 'meta_value',
						'meta_key'       	=> 'rb_prestation_date',
						'meta_query'		=> array(
							array(
								'key'		=> 'rb_prestation_date',
								'value'		=> array('2015-' . $month . '-01', '2015-' . $month . '-31'),
								'type'		=> 'DATE',
								'compare'	=> 'BETWEEN'
							)
						)
					);
				}
				else{

					$args = array(
						'posts_per_page'	=> -1,
						'post_type' 		=> 'prestation',
						'order'				=> 'ACS',
						'order_by'			=> 'meta_value',
						'meta_key'       	=> 'rb_prestation_date'
					);
				}
												
				
				$wp_query_prestations = new WP_Query($args);

				/**
				 * Chargement du template de la loop d'affichage des spectacles.
				 * Les paramètres d'affichage sont définis ci-haut, dépendement de la page chargée
				 */
				require(locate_template("loopprestations.php"));

			?>
		</div>

	</div>
</div>
	<!-- fin du contenu de la page index.php -->

<?php get_footer(); ?>
