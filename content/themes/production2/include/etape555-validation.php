<?php

	

	/***********************************************************
	 * Update du nombre de billets dans la BD
	 ***********************************************************/

	$val_etape_5 = true;


	$nb_billets 	= $_SESSION['nb_billets'];
	$id_prestation 	= $_SESSION['id_prestation'];

	$totalBillets_vendus = get_post_meta($id_prestation, 'rb_prestation_billets_vendus', true);
	$totalBillets_vendus += $nb_billets;

	$totalBillets_restants = get_post_meta($id_prestation, 'rb_prestation_nb_billets', true);
	$totalBillets_restants -= $nb_billets;

	update_post_meta($id_prestation, 'rb_prestation_billets_vendus', $totalBillets_vendus);
	update_post_meta($id_prestation, 'rb_prestation_nb_billets', $totalBillets_restants);


?>


		
