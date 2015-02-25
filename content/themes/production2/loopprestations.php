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

					// Switch pour le module de recherche
					$rechercheInfructueuse = false;



					/**
					 * Formatage de la date pour convenir au design
					 */

					// Set local français-canada
					setlocale(LC_ALL, 'frc', 'fr_CA');

					// Conversion de la string de date de la BD en format time ('d-m-Y')
					$new_date = strtotime($prestation_date);

					// Chaque partie de la date est placée dans une variable
					// strftime doit être utilisé pour le format en français
					$prestation_jourDeSemaine = strftime("%a", $new_date);
					$prestation_jourDuMois = strftime("%d", $new_date);
					$prestation_mois = strftime("%b", $new_date);

					





					/**
					 * Query des spectacles pour afficher les infos des spectacles par rapport à la prestation courante
					 *
					 * @var class WP_Query
					 * @var object  wp_query_spectacles  La query des spectacles
					 * @var string $prestation_title  Le titre du spectacle
					 * @var string $prestation_excerpt  La description courte du spectacle
					 */
					wp_reset_postdata();

					if(isset($_POST['srch-term'])){
						$searchTerm = trim($_POST['srch-term']);
						$searchTerm = filter_var($searchTerm, FILTER_SANITIZE_STRING);
					}
					else{
						$searchTerm = '';
					}


					$wp_query_spectacles = new WP_Query(
						array(
							'post_type'			=> 'spectacle',
							'posts_per_page' 	=> -1,
							's'					=> $searchTerm
						)
					);

					if($wp_query_spectacles->have_posts())
					{

						while ($wp_query_spectacles->have_posts())
						{
							$wp_query_spectacles->the_post();

							$spectacle_courant_id = $post->ID;


							if($spectacle_courant_id == $prestation_spectacle_id)
							{
								$prestation_title = get_the_title();
								$prestation_excerpt = get_the_excerpt();

								?>

									
									<div class="postContainer col-md-4 col-sm-6">
										<article class="spectacle flip-js">
											<div class="spectacle-front front">
												<img class="spectacle-cover" alt="" src="<?php echo IMAGES; ?>/mini-walkOffTheEarth.jpg">
												<div class="spectacle-info">
													<div class="spectacle-info-name">
														<span class="text"><?php echo $prestation_title; ?></span>
													</div>
												</div>
												<div class="spectacle-info-date">
													<?php echo $prestation_jourDeSemaine; ?> 
													<span class="number"><?php echo $prestation_jourDuMois; ?></span>
													<?php echo $prestation_mois; ?>
												</div>
											</div>
											<div class="spectacle-back back">
												<div class="spectacle-info">
													<div class="spectacle-info-name">
														<span class="text"><?php echo $prestation_title; ?></span>
													</div>
													<div class="spectacle-info-date">
														ven. <span class="number">27</span> fév.
													</div>
													<div class="spectacle-content">
														<span class="spectacle-time"><?php echo $prestation_date; ?> à <?php echo $prestation_heure; ?></span>
														<p class="spectacle-description"><?php echo $prestation_excerpt; ?></p>
														<a href="<?php echo $prestation_permalink; ?>" class="button btn-spectacle-info btn-margin-right">Acheter</a>
														<a href="<?php echo $prestation_permalink; ?>" class="button btn-spectacle-info">En savoir plus</a>
													</div>
												</div>
											</div>
										</article>
									</div>


								<?php
							}

						}

					}
					else $rechercheInfructueuse = true;

					/**
					 * Fin du query du spectacle
					 */
		
				}

				// Si recherche infructueuse
				if($rechercheInfructueuse == true){
				echo '<span>Aucun spectacle ne correspond à votre recherche</span>';
				}
			}

			else echo '<span>Aucun spectacle à afficher</span>';
		?>

