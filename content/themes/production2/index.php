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
		<h2>À venir</h2>

		<?php
			wp_reset_postdata();						
			$args = array(
				'posts_per_page'	=> -1,
				'post_type' 		=> 'spectacle',
			);
			$wp_query = new WP_Query($args);

			if(have_posts())
			{
				while(have_posts())
				{
					the_post();
		?>
					<div class="postContainer">
						<a href="<?php the_permalink(); ?>">
							<h3><?php the_title(); ?></h3>
							<?php
								if(has_post_thumbnail())
								{
									the_post_thumbnail();
								}
							?>
							<div class="date"><?php the_meta(); ?></div>
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
	require_once('footer.php');
?>
>>>>>>> origin/jm-theme-ajout_du_header
