<section class="carousel2 container-fluid">
	<!-- ne pas changer le nom du ID sinon les boutons ne fonctionnent plus -->
	<div id="carousel-example-generic" class="slide carousel carousel-fade" data-ride="carousel">
	  <!-- Indicators -->
		<ol class="carousel-indicators">
			<li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
			<li data-target="#carousel-example-generic" data-slide-to="1"></li>
			<li data-target="#carousel-example-generic" data-slide-to="2"></li>
		</ol>

		<!-- Wrapper for slides -->
		<div class="carousel-inner" role="listbox">

		<?php

			$args = array(
				'posts_per_page'	=> 3,
				'post_type' 		=> 'spectacle',
				'category_name'		=> 'vedette'
			);

			wp_reset_postdata();

			$wp_query_spectacle = new WP_Query($args);

			if($wp_query_spectacle->have_posts()){

				// Set local français-canada
				setlocale(LC_ALL, 'frc', 'fr_CA');

				$spectacle_id = array();
				$spectacle_image = array();
				$spectacle_titre = array();
				$spectacle_permalink = array();
				$prestation_date = array();
				$prestation_heure = array();

				while ($wp_query_spectacle->have_posts())
				{
					$wp_query_spectacle->the_post();						
					
					array_push($spectacle_id, $post->ID);
					array_push($spectacle_image, get_post_meta( $post->ID, 'rb_spectacle_img_caroussel_url', true ) );
					array_push($spectacle_titre, get_the_title() );
					array_push($spectacle_permalink, get_the_permalink() );


					$args = array(
						'posts_per_page'	=> 1,
						'post_type' 		=> 'prestation',
						'meta_query'		=> array(
							array(
								'key'			=> 'rb_prestation_spectacle_id',
								'value'			=> $post->ID
							)
						)
					);

					wp_reset_postdata();

					$wp_query_prestation = new WP_Query($args);

					if($wp_query_prestation->have_posts()){

						$wp_query_prestation->the_post();

						$prestation_date_temp = get_post_meta( $post->ID, 'rb_prestation_date', true );
						$prestation_heure_temp = get_post_meta( $post->ID, 'rb_prestation_heure', true );

						// Conversion de la string de date de la BD en format time ('d-m-Y')
						$new_date = strtotime($prestation_date_temp);

						// Chaque partie de la date est placée dans une variable
						// strftime doit être utilisé pour le format en français
						$prestation_jourDuMois = utf8_encode(strftime("%d", $new_date));
						$prestation_mois_full = utf8_encode(strftime("%B", $new_date));


						$prestation_date_temp = $prestation_jourDuMois . ' ' . $prestation_mois_full;


						array_push($prestation_date, $prestation_date_temp);
						array_push($prestation_heure, $prestation_heure_temp);
						
					}
				}
			}

		?>
			
			<div class="item active image-un">
				<img src="<?php echo $spectacle_image[0]; ?>" alt="<?php echo $spectacle_titre[0]; ?>">
				<div class="carousel-caption">
					<h1><?php echo $spectacle_titre[0]; ?></h1>
					<h2><?php echo $prestation_date[0]; ?> à
						<span class="carousel-heure"><?php echo $prestation_heure[0]; ?></span>
					</h2>
					<a href="<?php echo $spectacle_permalink[0]; ?>"><button class="btn-savoir">En savoir plus</button></a>					
				</div>
			</div>

			<div class="item image-deux">
				<img src="<?php echo $spectacle_image[1]; ?>" alt="<?php echo $spectacle_titre[1]; ?>">
				<div class="carousel-caption">
					<h1><?php echo $spectacle_titre[1]; ?></h1>					
					<h2><?php echo $prestation_date[1]; ?> à
						<span class="carousel-heure"><?php echo $prestation_heure[1]; ?></span>
					</h2>
					<a href="<?php echo $spectacle_permalink[1]; ?>"><button class="btn-savoir">En savoir plus</button></a>
				</div>
			</div>
			
			<div class="item image-trois">
				<img src="<?php echo $spectacle_image[2]; ?>" alt="<?php echo $spectacle_titre[2]; ?>">
				<div class="carousel-caption">
					<h1><?php echo $spectacle_titre[2]; ?></h1>
					<h2><?php echo $prestation_date[2]; ?> à
						<span class="carousel-heure"><?php echo $prestation_heure[2]; ?></span>
					</h2>
					<a href="<?php echo $spectacle_permalink[2]; ?>"><button class="btn-savoir">En savoir plus</button></a>
				</div>
			</div>

		</div>
	</div>
</section>