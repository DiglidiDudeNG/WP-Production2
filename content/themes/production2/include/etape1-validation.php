<?php


	// Récupération du ID de la prestation
	$id_prestation = trim($_POST['id_prestation']);
	$id_prestation = filter_var($id_prestation, FILTER_SANITIZE_STRING);

	// Récupération du ID du spectacle
	$id_spectacle = trim($_POST['id_spectacle']);
	$id_spectacle = filter_var($id_spectacle, FILTER_SANITIZE_STRING);

	// Sauvegarde des ID dans des variables de session
	$_SESSION['id_prestation'] = $id_prestation;
	$_SESSION['id_spectacle'] = $id_spectacle;




	



?>

