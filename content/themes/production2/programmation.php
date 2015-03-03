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
		

		<!-- Liste des mois -->
		<ul>
			<?php

				// Set local français-canada et timezone
				setlocale(LC_ALL, 'frc', 'fr_CA');
				date_default_timezone_set ( 'America/Montreal' );

				// Récupération de la date courante
				$currentDate = date_create();
				$currentDate = date_timestamp_get($currentDate);

				// Récupération du mois de la date courante sous le format "01";
				$moisCourantValeur = strftime('%m', $currentDate);

				// Tableau des mois en français
				$moisFrancaisTab = ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'];

				
				// Loop qui affiche tous les mois à partir du mois de la date courante
				for($i=0; $i<12; $i++){

					// Récupération et transformation en integer de la valeur du mois courant afin de correspondre à l'index du tableau
					$indexTabMoisFrancais = intval($moisCourantValeur-1);

					// Affichage en html
					echo '<li>
							<a href="' . get_bloginfo('url') . '/programmation?selection_mois=' . $moisCourantValeur . '">' . $moisFrancaisTab[$indexTabMoisFrancais] . '</a>
						</li>';


					// Incrémentation de $moisCourantValeur
					$moisCourantValeur++;

					// Si la valeur de $moisCourantValeur dépasse 12, retour à 01
					if($moisCourantValeur > 12) $moisCourantValeur=1;

					// Formatage de $moisCourantValeur sous le format "01"
					if(strlen($moisCourantValeur) < 2) $moisCourantValeur='0'.$moisCourantValeur;

				}
			?>			
		</ul>


		<!-- Liste des catégories -->
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
