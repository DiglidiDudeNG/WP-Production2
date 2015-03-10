<?php

	// Vérification de l'étape d'achat en cours
		if( isset($_POST['etape']) ){

		$etape = trim($_POST['etape']);;
		$etape = filter_var($etape, FILTER_SANITIZE_STRING);

		if($etape === "1"){
			require_once(locate_template("include/etape1-validation.php"));
		}
		elseif($etape === "2"){
			require_once(locate_template("include/etape2-validation.php"));
		}
		elseif($etape === "3"){
			require_once(locate_template("include/etape3-validation.php"));
		}
		elseif($etape === "4"){
			require_once(locate_template("include/etape4-validation.php"));
		}
		else{
			wp_redirect( home_url() ); exit;		
		}
	}	
	else{
		wp_redirect( home_url() ); exit;		
	}

?>

<?php
/*
Template Name: Achat
*/
?>
<?php get_header(); ?>

	<!-- début du contenu de la page achat.php -->

<div class="container">
	<div class="achat-container etapes-achat">
		<h2>Achat</h2>
		<?php
			if( $etape === "1" || $val_etape_2 === false ){
				require_once(locate_template("include/etape1-form.php"));
			}
			elseif( $val_etape_2 === true || $val_etape_3 === false ){
				require_once(locate_template("include/etape2-form.php"));
			}
			elseif( $val_etape_3 === true || $val_etape_4 === false ){
				require_once(locate_template("include/etape3-form.php"));
			}
			elseif( $val_etape_4 === true ){
				require_once(locate_template("include/etape4-form.php"));
			}
			else{
				echo "Un problème est survenu dans le processus d'achat. Veuillez retourner à la liste de spectacles par l'onglet \"Programmation\"";
			}
		?>
<?php 
	// include("include/etape2-form.php");
	// include("include/etape3-form.php");
 ?>
	</div>
</div>



	<!-- fin du contenu de la page achat.php -->

<?php get_footer(); ?>
