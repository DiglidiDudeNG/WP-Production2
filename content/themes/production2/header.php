<?php

	// Arguments du menu
	$menuPrincipal = array(
		'theme_location' => 'main',
		'container' => false,
		'container_class' => '', //Ici on ajoutera probablement une classe
		'menu_class' => '', //Ici aussi on ajoutera probablement une classe
		'menu_id' => '',
		'echo' => true,
		'before' => '',
		'after' => '',
		'link_before' => '',
		'link_after' => '',
		'items_wrap' => '%3$s',
		'depth' => 0,
		'walker' => ''
	);
	
?>

<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- <title><?php// bloginfo('name'); ?> | <?php// wp_title(); ?></title> -->

	<!-- Chargement de la feuille de style principale de WordPress -->
	<!-- <link rel="stylesheet" type="text/css" href="<?php// get_stylesheet_uri(); ?>"> -->
	<link rel="stylesheet" href="style.css" />
  	<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css">

	<?php
		// À VÉRIFIER L'UTILITÉ RÉELLE DE CE HOOK
	//	wp_head();
	?>
</head>
<body>
	<header class="container-fluid">
		<div class="container">
			
			<?php
				// Insertion du menu de navigation principal
//				wp_nav_menu($menuPrincipal);
			?>
			<p> Ceci est le header </p>

		</div>
	</header>
	
	<!-- fin header -->

