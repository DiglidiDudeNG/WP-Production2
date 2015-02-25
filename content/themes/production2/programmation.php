<?php
/*
Template Name: Programmation
*/
?>
<?php get_header(); ?>

	<!-- début du contenu de la page programmation.php -->

	<!-- C'EST ICI QU'ON MET LA VIANDE ;) -->

<div class="container">
	<div class="spectacles-a-venir-container">
		<h2>Programmation</h2>


		<form action="<?php bloginfo('url') ?>/programmation" method="post">
			<select name="selection_mois" id="selection_mois">
				<option value="01" <?php if(isset( $_POST['submit_mois']) ){ 
							if($_POST['selection_mois'] == "01"){
								echo 'selected';
							}}?>
				>Janvier</option>
				<option value="02" <?php if(isset( $_POST['submit_mois']) ){ 
							if($_POST['selection_mois'] == "02"){
								echo 'selected';
							}}?>
				>Février</option>
				<option value="03" <?php if(isset( $_POST['submit_mois']) ){ 
							if($_POST['selection_mois'] == "03"){
								echo 'selected';
							}}?>
				>Mars</option>
				<option value="04" <?php if(isset( $_POST['submit_mois']) ){ 
							if($_POST['selection_mois'] == "04"){
								echo 'selected';
							}}?>
				>Avril</option>
				<option value="05" <?php if(isset( $_POST['submit_mois']) ){ 
							if($_POST['selection_mois'] == "05"){
								echo 'selected';
							}}?>
				>Mai</option>
				<option value="06" <?php if(isset( $_POST['submit_mois']) ){ 
							if($_POST['selection_mois'] == "06"){
								echo 'selected';
							}}?>
				>Juin</option>
				<option value="07" <?php if(isset( $_POST['submit_mois']) ){ 
							if($_POST['selection_mois'] == "7"){
								echo 'selected';
							}}?>
				>Juillet</option>
				<option value="08" <?php if(isset( $_POST['submit_mois']) ){ 
							if($_POST['selection_mois'] == "08"){
								echo 'selected';
							}}?>
				>Août</option>
				<option value="09" <?php if(isset( $_POST['submit_mois']) ){ 
							if($_POST['selection_mois'] == "09"){
								echo 'selected';
							}}?>
				>Septembre</option>
				<option value="10" <?php if(isset( $_POST['submit_mois']) ){ 
							if($_POST['selection_mois'] == "10"){
								echo 'selected';
							}}?>
				>Octobre</option>
				<option value="11" <?php if(isset( $_POST['submit_mois']) ){ 
							if($_POST['selection_mois'] == "11"){
								echo 'selected';
							}}?>
				>Novembre</option>
				<option value="12" <?php if(isset( $_POST['submit_mois']) ){ 
							if($_POST['selection_mois'] == "12"){
								echo 'selected';
							}}?>
				>Décembre</option>
			</select>

			<input type="submit" name="submit_mois" id="submit_mois">
		</form>



		<div class="row">

			<?php

				wp_reset_postdata();

				if(isset( $_POST['submit_mois']) ){

					$month = $_POST['selection_mois'];

					$args = array(
						'posts_per_page'	=> -1,
						'post_type' 		=> 'prestation',
						'order'				=> 'ACS',
						'order_by'			=> 'meta_value',
						'meta_key'       	=> 'rb_prestation_date',
						'meta_query'		=> array(
							array(
								'key'		=> 'rb_prestation_date',
								'value'		=> array('2015-' . $month . '-01', '2015-' . $month . '-31'),
								'type'		=> 'DATE',
								'compare'	=> 'BETWEEN'
							)
						)
					);
				}
				else{

					$args = array(
						'posts_per_page'	=> -1,
						'post_type' 		=> 'prestation',
						'order'				=> 'ACS',
						'order_by'			=> 'meta_value',
						'meta_key'       	=> 'rb_prestation_date'
					);
				}
												
				
				$wp_query_prestations = new WP_Query($args);

				/**
				 * Chargement du template de la loop d'affichage des spectacles.
				 * Les paramètres d'affichage sont définis ci-haut, dépendement de la page chargée
				 */
				include(locate_template("loopprestations.php"));

			?>
		</div>

	</div>
</div>
	<!-- fin du contenu de la page index.php -->

<?php get_footer(); ?>
