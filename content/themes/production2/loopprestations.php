		<?php

			if($wp_query_prestations->have_posts())
			{
				while($wp_query_prestations->have_posts())
				{
					$wp_query_prestations->the_post();
					
					/** Récupération des infos des prestations */
					$prestation_title = "Aucun titre"; // Placeholder
					$prestation_excerpt = "Aucune description courte"; // Placeholder
					$prestation_spectacle_id = get_post_meta( $post->ID, 'rb_prestation_spectacle_id', true );
					$prestation_date = get_post_meta( $post->ID, 'rb_prestation_date', true );
					$prestation_heure = get_post_meta( $post->ID, 'rb_prestation_heure', true );
					$prestation_permalink = get_permalink();




					/**
					 * Query des spectacles pour afficher les infos des spectacles par rapport à la prestation courante
					 *
					 * @var class WP_Query
					 * @var object  wp_query_spectacles  La query des spectacles
					 * @var string $prestation_title  Le titre du spectacle
					 * @var string $prestation_excerpt  La description courte du spectacle
					 */
					wp_reset_postdata();
					$wp_query_spectacles = new WP_Query(
						array(
							'post_type'			=> 'spectacle',
							'posts_per_page' 	=> -1
						)
					);

					while ($wp_query_spectacles->have_posts())
					{
						$wp_query_spectacles->the_post();
					
						$spectacle_courant_id = $post->ID;


						if($spectacle_courant_id == $prestation_spectacle_id)
						{
							$prestation_title = get_the_title();
							$prestation_excerpt = get_the_excerpt();
						}
						
					}					

					/**
					 * Fin du query du spectacle
					 */
		?>


					<!-- 

						TODO: L'intégration html/css de la div ci-dessous (genre class="col-md-6" ... etc) 

					-->

					<div class="postContainer col-md-4">
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
							<p class="description"><?php echo $prestation_excerpt; ?></p>
						</a>
					</div>
		<?php
				}
			}
			else echo '<span>Aucun spectacle à afficher</span>';
		?>

	