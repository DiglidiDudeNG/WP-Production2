
<?php
get_header();
?>
<?php

	the_post();

	$spectacle_id = $post->ID;
	$spectacle_titre = get_the_title();
	$spectacle_content = get_the_content();
	$spectacle_prix = get_post_meta( $post->ID, 'rb_spectacle_prix', true);
	$spectacle_fb = get_post_meta( $post->ID, 'rb_spectacle_artiste_facebook_url', true);
	$spectacle_url = get_post_meta( $post->ID, 'rb_spectacle_artiste_site_url', true);
	$spectacle_categorie = get_the_category($post->id);
	$spectacle_cat[0] ->cat_name;

	//'meta_query'		=> array(
		//	array(
			//'key'		=> 'rb_prestation_spectacle_id',
		//	'value'		=> array ($spectacle_id)
			//)
		 // )
		  
		  
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

		while ($wp_query_prestations->have_posts())
		{
				$wp_query_prestations->the_post();
				
				
				array_push($prestation_id, $post->ID);
				array_push($prestation_date, get_post_meta( $post->ID, 'rb_prestation_date', true ) );
				array_push($prestation_heure, get_post_meta( $post->ID, 'rb_prestation_heure', true ) );

		}
	}	

	
?>



	<div id="contenu-spect">
		<div class="row">
		  <div class="col-xs-12">	
			<img class="singleImage" src="<?php echo IMAGES; ?>/CCR.jpg" style="width:100%" alt="photo du groupe"/>
		  </div>
		</div>
			<section class="singleTop">
			 <div class="container">
			  <div class="row">	
			    <div class="col-sm-8 col-xs-4"> <!-- .col-xs-6 .col-md-4  col-xs-6 .col-md-4-->
					<h3 class="singleTitre"><?php echo $spectacle_titre; ?></h3>
					<div class="singlePrestation"><?php echo $spectacle_categorie; ?></div>
					<span class="singlePrestation"><?php echo $prestation_date; ?></span> 
					<span class="singlePrestation">à</span>
					<span class="singlePrestation"><?php echo $prestation_heure; ?></span>
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

							
											
									?>
									<tr>
										<td><?php echo $prestation_date; ?></td>
										<td><?php echo $spectacle_prix; ?> $</td>
										<td><a href="#" class="btn-spectacle-info btn-tab">Acheter</a></td> 
									</tr>
									<?php

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