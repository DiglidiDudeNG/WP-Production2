<?php


	// Récupération du ID de la prestation
	$id_prestation = trim($_GET['id_prestation']);
	$id_prestation = filter_var($id_prestation, FILTER_SANITIZE_STRING);

	// Récupération du ID du spectacle
	$id_spectacle = trim($_GET['id_spectacle']);
	$id_spectacle = filter_var($id_spectacle, FILTER_SANITIZE_STRING);

	// Sauvegarde des ID dans des variables de session
	$_SESSION['id_prestation'] = $id_prestation;
	$_SESSION['id_spectacle'] = $id_spectacle;




	// Query pour avoir les infos du spectacles
	wp_reset_postdata();
	$wp_query_spectacles = new WP_Query(
		array(
			'post_type'			=> 'spectacle',
			'posts_per_page' 	=> -1,
			'p'					=> $_SESSION['id_spectacle']
		)
	);

	$wp_query_spectacles->the_post();

	$spectacle_titre = get_the_title();
	$spectacle_prix = get_post_meta( $post->ID, 'rb_spectacle_prix', true );


	// Query pour avoir les infos de la prestation reliée au spectacle
	wp_reset_postdata();
	$wp_query_prestations = new WP_Query(
		array(
			'post_type'			=> 'prestation',
			'posts_per_page' 	=> 1,
			'p'					=> $_SESSION['id_prestation']
		)
	);



	$wp_query_prestations->the_post();

	$prestation_date = get_post_meta( $post->ID, 'rb_prestation_date', true );
	$prestation_heure = get_post_meta( $post->ID, 'rb_prestation_heure', true );



?>

