<?php

	// Vérification de l'étape d'achat en cours
	if( isset($_GET['etape']) ){

		$etape = trim($_GET['etape']);;
		$etape = filter_var($etape, FILTER_SANITIZE_STRING);

		if( $etape === "1" ){			
			require_once(locate_template("etape1-validation.php"));
		}
		else{
			wp_redirect( home_url() ); exit;		
		}
	}
	elseif( isset($_POST['etape']) ){

		$etape = trim($_POST['etape']);;
		$etape = filter_var($etape, FILTER_SANITIZE_STRING);

		if($etape === "2"){
			require_once(locate_template("etape2-validation.php"));
		}
		elseif($etape === "3"){
			require_once(locate_template("etape3-validation.php"));
		}
		elseif($etape === "4"){
			require_once(locate_template("etape4-validation.php"));
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
	<div class="achat-container">
		<h2>Achat</h2>
	
		<?php
			if( $etape === "1" || $val_etape_2 === false ){
				require_once(locate_template("etape1-form.php"));
			}
			elseif( $val_etape_2 === true || $val_etape_3 === false ){
				require_once(locate_template("etape2-form.php"));
			}
			elseif( $val_etape_3 === true || $val_etape_4 === false ){
				require_once(locate_template("etape3-form.php"));
			}
			elseif( $val_etape_4 === true ){
				require_once(locate_template("etape4-form.php"));
			}
			else{
				echo "Un problème est survenu dans le processus d'achat. Veuillez retourner à la liste de spectacles par l'onglet \"Programmation\"";
			}
		?>

	</div>
</div>

	<!-- fin du contenu de la page achat.php -->

<?php get_footer(); ?>
