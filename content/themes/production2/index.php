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
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name = "viewport" content = "width = device-width, initial-scale=1">
	<title></title>
	<link rel="stylesheet" href="css/bootstrap.min.css" />
	<link rel="stylesheet" href="css/style.css" />
</head>
<body>
	<header class="container-fluid">
	  <div class="container"> 
		<div class="container">
		</div>
	  </div> 
	</header> 

	<section>

	<?php
    	include_once("include/caroussel.php");
    ?>

	</section>

	<script type="text/javascript" src="<?php echo SCRIPTS; ?>/jquery-1.11.1.min.js"></script>
	<script type="text/javascript" src="js/bootstrap.min.js"></script>
	<!-- <script type="text/javascript" src="script/jquery.velocity.min.js"></script> -->
	<script src="js/script.js"></script>
</body>
</html>
=======

<?

	/**
	 * index.php
	 * 
	 * Project: wp-production2
	 * User:    Félix Dion Robidoux
	 * Date:    10/02/2015
	 * Time:    9:28 AM
	 */

	// require_once('header.php');
?>
	<!-- début du contenu de la page index.php -->

	

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

			if(have_posts())
			{
				while(have_posts())
				{
					the_post();

					$prestation_title = "Le titre marche pas";
					$prestation_spectacle_id = get_post_meta( $post->ID, 'rb_prestation_spectacle_id', true );
					$prestation_date = get_post_meta( $post->ID, 'rb_prestation_date', true );
					$prestation_heure = get_post_meta( $post->ID, 'rb_prestation_heure', true );
					// $prestation_permalink = get_permalink();





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
					
						$spectacle_courant_id = $wp_query_spectacles->the_ID();

						echo '<span>' . $prestation_spectacle_id . '</span>';




						if($spectacle_courant_id == $prestation_spectacle_id)
						{
							$prestation_title = $wp_query_spectacles->the_title();
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
							<p class="date"><?php echo $prestation_date; ?></div>
							<p class="heure"><?php echo $prestation_heure; ?></div>
						</a>
					</div>
		<?php
				}
			}
			else echo '<span>Aucun spectacle à afficher</span>';
		?>

	</div>
									  
 
	


	<!-- fin du contenu de la page index.php -->

<?php
	// require_once('footer.php');



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

<?php get_footer(); ?>
>>>>>>> cdt-header
