		<?php

			if($wp_query_prestations->have_posts())
			{
				while($wp_query_prestations->have_posts())
				{
					$wp_query_prestations->the_post();

					/** 
					 * Récupération des infos des prestations
					 *
					 * @var string  $prestation_title 			Titre de la prestation
					 * @var string  $prestation_excerpt 		Description courte de la prestation
					 * @var string  $prestation_spectacle_id 	ID du spectacle relié à la prestation
					 * @var string  $prestation_date 			Date de la prestation sous format YYYY-MM-DD
					 * @var string  $prestation_heure 			Heure de la prestation sous format HH:mm
					 */
					$prestation_title = "Aucun titre"; // Placeholder
					$prestation_excerpt = "Aucune description courte"; // Placeholder
					$prestation_spectacle_id = get_post_meta( $post->ID, 'rb_prestation_spectacle_id', true );
					$prestation_date = get_post_meta( $post->ID, 'rb_prestation_date', true );
					$prestation_heure = get_post_meta( $post->ID, 'rb_prestation_heure', true );

					$prestation_id = $post->ID;


					// Switch pour le module de recherche
					$rechercheInfructueuse = false;



					/**************************************************
					 * Formatage de la date pour convenir au design
					 **************************************************
					 */
					// Set local français-canada
					setlocale(LC_ALL, 'frc', 'fr_CA');

					// Conversion de la string de date de la BD en format time ('d-m-Y')
					$new_date = strtotime($prestation_date);

					// Chaque partie de la date est placée dans une variable
					// strftime doit être utilisé pour le format en français
					$prestation_jourDeSemaine = strftime("%a", $new_date);
					$prestation_jourDuMois = strftime("%d", $new_date);
					$prestation_mois_court = strftime("%b", $new_date);
					$prestation_mois_full = strftime("%B", $new_date);



					/******************************
					 * Filtre de recherche
					 ******************************
					 */					
					// Si une recherche a été effectuée
					if(isset($_POST['srch-term'])){

						// Récupération de la valeur de recherche
						$searchTerm = trim($_POST['srch-term']);
						$searchTerm = filter_var($searchTerm, FILTER_SANITIZE_STRING);
					}
					// Si pas de recherche
					else{
						// valeur de recherche == string vide afin d'afficher tous les spectacles
						$searchTerm = '';
					}



					/******************************
					 * Filtre de catégorie
					 ******************************
					 */
					// Si un filtre de catégorie a été activé
					if(isset( $_GET['selection_categorie']) ){

						// Récupération de la valeur du filtre de catégorie
						$categorie = trim($_GET['selection_categorie']);
						$categorie = filter_var($categorie, FILTER_SANITIZE_STRING);				
					}
					// Si pas de filtre de catégorie
					else{
						// Valeur == string vide afin d'afficher tous les spectacles
						$categorie = '';
					}



					/**
					 * Query des spectacles pour afficher les infos des spectacles par rapport à la prestation courante
					 *
					 * @var class WP_Query
					 * @var object  wp_query_spectacles  La query des spectacles
					 */
					wp_reset_postdata();
					$wp_query_spectacles = new WP_Query(
						array(
							'post_type'			=> 'spectacle',
							'posts_per_page' 	=> -1,
							's'					=> $searchTerm,
							'category_name'		=> $categorie
						)
					);

					if($wp_query_spectacles->have_posts())
					{						
						while ($wp_query_spectacles->have_posts())
						{
							$wp_query_spectacles->the_post();

							// Récupération du ID du spectacle courant
							$spectacle_courant_id = $post->ID;

							// Si le ID du spectacle courant est égal au ID du spectacle relié à la prestation courante
							if($spectacle_courant_id == $prestation_spectacle_id)
							{
								// Récupération du titre et de la description courte du spectacle courant
								$prestation_title = get_the_title();
								$prestation_excerpt = get_the_excerpt();


								/************************************************************
								 * Regroupement de l'affichage des prestation par mois
								 ************************************************************
								 */
								// Si le mois de la prestation précédente n'existe pas (première prestation à afficher)
								if(!isset($mois_prestation_precedente)){

									// Affichage du mois de la prestation courante
									echo "<h3 class='title-month'>$prestation_mois_full</h3>";
								}
								// Si le mois de la prestation courante n'est pas le même que le mois de la prestation précédente
								elseif($prestation_mois_full !== $mois_prestation_precedente){

									// Fermeture de la Row,
									// Ouverture d'une nouvelle Row,
									// Affichage du mois de la prestation courante
									echo "</div>
										  <div class='row'>
										  	<h3 class='title-month'>$prestation_mois_full</h3>";
								}

								// Récupération du mois de la prestation courante qui agira comme prestation précédente pour la prochaine évaluation
								$mois_prestation_precedente = $prestation_mois_full;

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
													<?php echo $prestation_mois_court; ?>
												</div>
											</div>
											<div class="spectacle-back back">
												<div class="spectacle-info">
													<div class="spectacle-info-name">
														<span class="text"><?php echo $prestation_title; ?></span>
													</div>
													<div class="spectacle-info-date">
														<?php echo $prestation_jourDeSemaine; ?> 
														<span class="number"><?php echo $prestation_jourDuMois; ?></span>
														<?php echo $prestation_mois_court; ?>
													</div>
													<div class="spectacle-content">
														<span class="spectacle-time"><?php echo $prestation_date; ?> à <?php echo $prestation_heure; ?></span>
														<p class="spectacle-description"><?php echo $prestation_excerpt; ?></p>
														<a href="<?php echo bloginfo('url'); ?>/achat?etape=1&id_prestation=<?php echo $prestation_id; ?>&id_spectacle=<?php echo $spectacle_courant_id; ?>" class="button btn-spectacle-info btn-margin-right">Acheter</a>
														<a href="<?php echo the_permalink(); ?>" class="button btn-spectacle-info">En savoir plus</a>
													</div>
												</div>
											</div>
										</article>
									</div>


								<?php
							break;
							}

						}

					}
					// Si la query specatcle ne retourne aucun post, c'est que la recherche n'a donnée aucun résultat
					else $rechercheInfructueuse = true;

					/**
					 * Fin du query du spectacle
					 */
				}

				// Si recherche infructueuse
				if($rechercheInfructueuse == true){
				echo '<p>Aucun spectacle ne correspond à votre recherche</p>';
				}
			}

			// Si Query des prestations ne retourne aucun résultat
			else echo '<p>Aucun spectacle à afficher</p>';
		?>
