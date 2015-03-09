<?php


	/**********************************************
	 * Query pour avoir les infos du spectacles
	 **********************************************/
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





	/*******************************************************************
	 * Query pour avoir les infos de la prestation reliée au spectacle
	 *******************************************************************/
	wp_reset_postdata();
	$wp_query_prestations = new WP_Query(
		array(
			'post_type'			=> 'prestation',
			'posts_per_page' 	=> -1,
			'p'					=> $_SESSION['id_prestation']
		)
	);

	$wp_query_prestations->the_post();

	$prestation_date = get_post_meta( $post->ID, 'rb_prestation_date', true );
	$prestation_heure = get_post_meta( $post->ID, 'rb_prestation_heure', true );

?>



<?php
	
	if( !isset($messageErreurNbBillets) ){
		$messageErreurNbBillets = "";
	}

?>







	<ul>
		<li><?php echo $spectacle_titre ?></li>
		<li><?php echo $spectacle_prix ?>$</li>
		<li><?php echo $prestation_date ?></li>
		<li><?php echo $prestation_heure ?></li>
	</ul>


	<span class="erreur"><?php echo $messageErreurNbBillets; ?></span>




	<form action="<?php echo bloginfo('url'); ?>/achat" method="post">
		<label for="nb_billets">Nombre de billets : </label>
		<input type="text" name="nb_billets" id="nb_billets" value="2">
		<input type="hidden" name="etape" id="etape" value="2">
		<button type="submit" id="vers_etape_2" name="vers_etape_2">Allez à l'étape 2</button>
	</form>

	