<?php get_header(); ?>
<?php
// <<<<<<< HEAD

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
<!-- Main hero unit for a primary marketing message or call to action -->
<div class="hero-unit">
	<h1>Hello, world!</h1>
	<p>This is a template for a simple marketing or informational website. It includes a large callout called the hero unit and three supporting pieces of content. Use it as a starting point to create something more unique.</p>
	<p><a class="btn btn-primary btn-large">Learn more &raquo;</a></p>
</div>
<!-- Example row of columns -->
<div class="row">
	<div class="span4">
		<h2>Heading</h2>
		<p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. </p>
		<p><a class="btn" href="#">View details &raquo;</a></p>
	</div>
	<div class="span4">
		<h2>Heading</h2>
		<p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. </p>
		<p><a class="btn" href="#">View details &raquo;</a></p>
	</div>
	<div class="span4">
		<h2>Heading</h2>
		<p>Donec sed odio dui. Cras justo odio, dapibus ac facilisis in, egestas eget quam. Vestibulum id ligula porta felis euismod semper. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus.</p>
		<p><a class="btn" href="#">View details &raquo;</a></p>
	</div>
</div>
<?php echo get_template_directory_uri(); ?>

	

	<p>kawabunga</p>

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
>>>>>>> cdt-header
