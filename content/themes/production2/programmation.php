<?php get_header(); ?>
<?php
/*
Template Name: Programmation
*/
?>


	<!-- début du contenu de la page programmation.php -->




	<p>kawabunga</p>
	<p></p>
	<p></p>
	<p></p>

	<!-- C'EST ICI QU'ON MET LA VIANDE ;) -->


	<!-- Affichage des 10 spectacles à venir -->

	<div class="spectacles-a-venir-container">
		<h2>Spectacles à venir (ceci est le titre de la section)</h2>

		<?php
		
			wp_reset_postdata();									
			$args = array(
				'posts_per_page'	=> 10,
				'post_type' 		=> 'prestation',
				'order'				=> 'ACS',
				'order_by'			=> 'meta_value',
				'meta_key'       	=> 'rb_prestation_date'
			);
			$wp_query_prestations = new WP_Query($args);

			if($wp_query_prestations->have_posts())
			{
				while($wp_query_prestations->have_posts())
				{
					$wp_query_prestations->the_post();
					

					$prestation_title = "Aucun titre";
					$prestation_content = "Aucune description";
					$prestation_spectacle_id = get_post_meta( $post->ID, 'rb_prestation_spectacle_id', true );
					$prestation_date = get_post_meta( $post->ID, 'rb_prestation_date', true );
					$prestation_heure = get_post_meta( $post->ID, 'rb_prestation_heure', true );
					$prestation_permalink = get_permalink();

					




					/**
					 * Query du spectacle
					 */
					wp_reset_postdata();
					$wp_query_spectacles = new WP_Query(
						array(
							'post_type' => 'spectacle',
						)
					);

					while ($wp_query_spectacles->have_posts())
					{
						$wp_query_spectacles->the_post();
					
						$spectacle_courant_id = $post->ID;


						if($spectacle_courant_id == $prestation_spectacle_id)
						{
							$prestation_title = get_the_title();
							$prestation_content = get_the_excerpt();
						}
						
					}					

					/**
					 * Fin du query du spectacle
					 */
		?>
					<div class="postContainer">
						<a href="<?php echo $prestation_permalink; ?>">
							<h3><?php echo $prestation_title; ?></h3>
							<?php
								if(has_post_thumbnail())
								{
									the_post_thumbnail();
								}
							?>
							<p class="date"><?php echo $prestation_date; ?></p>
							<p class="heure"><?php echo $prestation_heure; ?></p>
							<p class="description"><?php echo $prestation_content; ?></p>
						</a>
					</div>
		<?php
				}
			}
			else echo '<span>Aucun spectacle à afficher</span>';
		?>

	</div>
									  
 
	


	<!-- fin du contenu de la page index.php -->



<?php get_footer(); ?>
