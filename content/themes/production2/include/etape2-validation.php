<?php


	// Récupération des ID de la prestation et du spectacle en cours d'achat
	$id_spectacle = $_SESSION['id_spectacle'];
	$id_prestation = $_SESSION['id_prestation'];


	// Récupération et assainissement du nombre de billets entré
	$nb_billets = trim($_POST['nb_billets']);
	$nb_billets = filter_var($nb_billets, FILTER_SANITIZE_STRING);


	wp_reset_postdata();
	$wp_query_prestations = new WP_Query(
		array(
			'post_type'			=> 'prestation',
			'posts_per_page' 	=> -1,
			'p'					=> $_SESSION['id_prestation']
		)
	);

	$wp_query_prestations->the_post();

	// Récupération du nombre de billets restants pour la prestation
	$nb_billets_restants = get_post_meta( $post->ID, 'rb_prestation_nb_billets', true );




	/**********************************
	 * Validation du nombre de billets
	 **********************************/
	if( empty($nb_billets) ){

		$messageErreurNbBillets = "*Champs requis";

		$val_etape_2 = false;
	}
	elseif( !preg_match('/^\d+$/', $nb_billets) ){

		$messageErreurNbBillets = "*Veuillez entrer un nombre de billets valide";

		$val_etape_2 = false;
	}
	elseif( $nb_billets > $nb_billets_restants ){

		$messageErreurNbBillets = "*Il reste seulement " . $nb_billets_restants . " billets pour cette prestation";

		$val_etape_2 = false;
	}
	elseif( $nb_billets >= 50 ){

		$messageErreurNbBillets = "*Veuillez contacter le gérant pour les achats de 50 billets et plus";

		$val_etape_2 = false;
	}
	else{
		// Si tout est valide, on récupère les infos
		$val_etape_2 = true;


		$spectacle_prix = $_POST['spectacle_prix'];	

		$sousTotal = $nb_billets * $spectacle_prix;		
		$sousTotal = number_format((float)$sousTotal, 2, '.', '');

		$spectacle_tvq = $sousTotal*0.09975;
		$spectacle_tvq = number_format((float)$spectacle_tvq, 2, '.', '');

		$spectacle_tps = $sousTotal*0.05;
		$spectacle_tps = number_format((float)$spectacle_tps, 2, '.', '');

		$spectacle_gtotal = $sousTotal + $spectacle_tvq + $spectacle_tps;
		$spectacle_gtotal = number_format((float)$spectacle_gtotal, 2, '.', '');


		$_SESSION['nb_billets'] = $nb_billets;
		$_SESSION['spectacle_prix'] = $spectacle_prix;
		$_SESSION['sousTotal'] = $sousTotal;
		$_SESSION['spectacle_tvq'] = $spectacle_tvq;
		$_SESSION['spectacle_tps'] = $spectacle_tps;
		$_SESSION['spectacle_gtotal'] = $spectacle_gtotal;


	}


?>

