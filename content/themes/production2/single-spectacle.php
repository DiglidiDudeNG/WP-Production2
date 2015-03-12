
<?php
get_header();
?>
<?php

	the_post();

	$spectacle_id = $post->ID;
	$spectacle_image = get_post_meta( $post->ID, 'rb_spectacle_img_bandeau_url', true);
	$spectacle_titre = get_the_title();
	$spectacle_content = get_the_content();
	$spectacle_prix = get_post_meta( $post->ID, 'rb_spectacle_prix', true);
	$spectacle_fb = get_post_meta( $post->ID, 'rb_spectacle_artiste_facebook_url', true);
	$spectacle_url = get_post_meta( $post->ID, 'rb_spectacle_artiste_site_url', true);
	$spectacle_categorie = get_the_category($post->ID);
	$spectacle_categorie = $spectacle_categorie[0] -> cat_name;



	$args = array(
		'posts_per_page'	=> -1,
		'post_type' 		=> 'prestation',
		'order'				=> 'ACS',
		'order_by'			=>'meta_value',
		'meta_key'			=> 'rb_prestation_date',
		'meta_query'		=> array(
			array(
				'key'			=> 'rb_prestation_spectacle_id',
				'value'			=> $spectacle_id
			)
		)
	);


	wp_reset_postdata();

	$wp_query_prestations = new WP_Query($args);

	if($wp_query_prestations->have_posts())
	{
		$prestation_id = array();
		$prestation_date = array();
		$prestation_heure = array();
		$nb_billets_restant = array();

		while ($wp_query_prestations->have_posts())
		{
				$wp_query_prestations->the_post();


				array_push($prestation_id, $post->ID);
				array_push($prestation_date, get_post_meta( $post->ID, 'rb_prestation_date', true ) );
				array_push($prestation_heure, get_post_meta( $post->ID, 'rb_prestation_heure', true ) );
				array_push($nb_billets_restant, get_post_meta( $post->ID, 'rb_prestation_nb_billets', true ) );

		}
	}


?>



	<div id="contenu-spect">
		<div class="row">
		  <div class="col-xs-12">
			<img class="singleImage" src="<?php echo $spectacle_image; ?>" style="width:100%" alt="photo du groupe"/>
		  </div>
		</div>
			<section class="singleTop">
			 <div class="container">
			  <div class="row">
			    <div class="col-sm-8 col-xs-4">
					<h3 class="singleTitre"><?php echo $spectacle_titre; ?></h3>

					<div class="singlePrestation"><?php echo $spectacle_categorie; ?></div>
					<?php
						$length = count($prestation_date);
						for($i = 0; $i < $length; $i++)
						{

					?>
					<span class="singlePrestation"><?php echo $prestation_date[$i]; ?></span>
					<span class="singlePrestation">à</span>
					<span class="singlePrestation"><?php echo $prestation_heure[$i]; ?></span>
					<br>
					<?php
						}
					?>
		    	</div>
			  </div>
			 </div>
			</section>
			<section class="singleBottom container">
				<div class="row">
					<div class="col-sm-8 col-xs-4">
						<p class="descrip"><?php echo $spectacle_content; ?></p>
					</div>
					<div class="col-sm-4 col-xs-2">
						  <table class="table">
								<thead>
									<tr>
										<th class="tabBillets" colspan="3">Achat de billets</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<th>Date</th>
										<th>Prix</th>
										<th></th>
									</tr>

									<?php

										$length = count($prestation_date);
										for($i = 0; $i < $length; $i++)
										{

									?>
									<tr>
										<td><?php echo $prestation_date[$i]; ?></td>
										<td><?php echo $spectacle_prix; ?> $</td>
										<td>


										<?php

											if ( $nb_billets_restant[$i] > 0 ){
										?>
												<form action="<?php echo bloginfo('url'); ?>/achat" method="post">
													<input type="hidden" name="id_prestation" id="id_prestation<?php echo $i; ?>" value="<?php echo $prestation_id[$i]; ?>">
													<input type="hidden" name="id_spectacle" id="id_spectacle" value="<?php echo $spectacle_id; ?>">
													<input type="hidden" name="etape" id="etape" value="1">
													<input type="submit" class="btn-spectacle-info btn-tab" value="Acheter">
												</form>
										<?php
											}
											else{
										?>
												<button disabled class="btn btn-parenthese btn-left">COMPLET</button>
										<?php
											}
										?>


										</td>
									</tr>
									<?php
										}
									?>
								</tbody>
							</table>
					</div>
				</div>
						<div class="sociaux">
							<a href="<?php echo $spectacle_fb; ?>" target="_blank"><i class="fa fa-facebook"></i></a>
							<a class="siteweb" href="<?php echo $spectacle_url; ?>" target="_blank">site web</a>
						</div>
			</section>
	</div>


<?php
get_footer();
?>